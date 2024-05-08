<?php
require_once PLUGIN_PATH . "/page_all/vendor/autoload.php";

use GeoIp2\Database\Reader;

class PageAll extends IPlugin
{
	protected $CI;
	protected $linkWorks = "works";
	protected $linkAjaxWorks = "ajax-works";
	protected $linkAjaxProject = "project";
	protected $linkAjaxCarreer = "carreer";
	public function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
		$this->changeLangRegion();
	}
	public function install()
	{
		$this->addRoutes("Vindex/works", $this->linkWorks);
		$this->addRoutes("Vindex/ajaxWorks", $this->linkAjaxWorks);
		$this->addRoutes("Vindex/loadProject", $this->linkAjaxProject);
		$this->addRoutes("Vindex/loadCarreer", $this->linkAjaxCarreer);
	}
	public function uninstall()
	{
		$this->removeRoutes($this->linkWorks);
		$this->removeRoutes($this->linkAjaxWorks);
		$this->removeRoutes($this->linkAjaxProject);
		$this->removeRoutes($this->linkAjaxCarreer);
		$this->removeFile();
	}

	public function initVindex()
	{
		$vindex = &get_instance();
		$page = $this;
		$vindex::macro("works", function ($itemRoutes) use ($page) {
			$page->works($itemRoutes);
		});
		$vindex::macro("ajaxWorks", function ($itemRoutes) use ($page) {
			$page->ajaxWorks($itemRoutes);
		});
		$vindex::macro("loadProject", function ($itemRoutes) use ($page) {
			$page->loadProject($itemRoutes);
		});
		$vindex::macro("loadCarreer", function ($itemRoutes) use ($page) {
			$page->loadCarreer($itemRoutes);
		});
	}
	function get_client_ip()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	public function getRegionByIP($ip)
	{
		$reader = new Reader(PLUGIN_PATH . '/page_all/GeoLite2-Country.mmdb');
		$record = $reader->country($ip);
		return $record;
	}
	public function changeLangRegion()
	{
		$ip = $this->get_client_ip();
		$currentLang = $this->CI->uri->segment(1);
		$urlNoLang = $this->CI->uri->segment(2);
		$region = $this->getRegionByIP($ip);
		$region = isset($region->country->names['en']) && $region->country->names['en'] == "Vietnam" ? 'vi' : 'en';
		if ($currentLang != $region && $region != "vi") {
			$changeUrl = $urlNoLang . $region;
			redirect($changeUrl);
		}
	}
	public function _beforeShow($args)
	{
		$itemRoutes = $args["itemRoutes"];
		$itemTable = $args["itemTable"];
		$data = $args["data"];
		$list_data = isset($args['data']['list_data']) ? $args['data']['list_data'] : [];
		if ($itemRoutes['table'] == 'project') {
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

				$itemRoutes['controller'] = 'project.ajaxview';

				return ["itemRoutes" => $itemRoutes];
			}
		}
		if ($itemRoutes['table'] == 'carreer') {
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

				$itemRoutes['controller'] = 'carreer.ajax';

				return ["itemRoutes" => $itemRoutes];
			}
		}
		if (count($list_data) > 0) {
			$listDataOrder = array_reverse($list_data);
			$data['list_data'] = $listDataOrder;
			return ["data" => $data];
		}
		return true;
	}
	public function _getSegment()
	{
		$hasLang = $this->hasMultiLanguage();
		$currentLang = pGetLanguage();
		$defaultLang = pgetDefaultLanguage();
		$segment = $currentLang == $defaultLang ? 2 : 3;
		$pp = (int)$this->CI->uri->segment($segment, 0);
		$allVariable = get_defined_vars();
		return $allVariable;
	}
	public function _setPagination($perpage = 6, $itemRoutes, $table, $where, $segment)
	{
		$perpage = $perpage;
		$config['base_url'] = VthSupport\Classes\UrlHelper::exactLink($itemRoutes['link']);
		$config['per_page'] = $perpage;
		$config['total_rows'] = $this->CI->Dindex->getNumDataDetail($table, $where);
		$config['uri_segment'] = $segment;
		$config['reuse_query_string'] = true;
		$allVariable = get_defined_vars();
		return $allVariable;
	}
	public function loadCarreer($itemRoutes)
	{
		$get = $this->CI->input->get();
		if (@$get) {
			$table = 'carreer';
			$id = isset($get) ? addslashes($get['id']) : '';
			if ($id == '') return false;
			$where = [['key' => 'act', 'compare' => '=', 'value' => 1]];
			array_push($where, ['key' => 'id', 'compare' => '=', 'value' => $id]);
			$list_data = $this->CI->Dindex->getDataDetail(array(
				'table' => $table,
				'where' => $where
			));
			$data['dataitem'] = $list_data[0];
			echo $this->CI->blade->view()->make('carreer.ajax', $data)->render();
		}
	}
	public function loadProject($itemRoutes)
	{
		$get = $this->CI->input->get();
		if (@$get) {
			$table = 'project';
			$id = isset($get) ? addslashes($get['id']) : '';
			if ($id == '') return false;
			$where = [['key' => 'act', 'compare' => '=', 'value' => 1]];
			array_push($where, ['key' => 'id', 'compare' => '=', 'value' => $id]);
			$list_data = $this->CI->Dindex->getDataDetail(array(
				'table' => $table,
				'where' => $where
			));
			$data['dataitem'] = $list_data[0];
			echo $this->CI->blade->view()->make('project.view', $data)->render();
		}
	}
	function works($itemRoutes)
	{
		$table = 'project';

		$configSegment = $this->_getSegment();
		extract($configSegment);
		$where = [['key' => 'act', 'compare' => '=', 'value' => 1]];

		$configPagination = $this->_setPagination(24, $itemRoutes, $table, $where, $segment);
		extract($configPagination);

		$limit = $pp . "," . $config['per_page'];

		$data['list_data'] = $this->CI->Dindex->getDataDetail(array(
			'table' => $table,
			'limit' => $limit,
			'where' => $where,
			'order' => 'ord desc'
		));
		$data['pp'] = $pp;
		$config['base_url'] = \VthSupport\Classes\UrlHelper::exactLink('ajax-works');
		$this->CI->pagination->initialize($config);
		$data['dataitem']['s_title'] = $itemRoutes['title_seo'];
		$data['dataitem']['s_des'] = $itemRoutes['des_seo'];
		$data['dataitem']['s_key'] = $itemRoutes['key_seo'];
		$data['dataitem']['name'] = 'Works';
		echo $this->CI->blade->view()->make('works.view', $data)->render();
	}
	function ajaxWorks($itemRoutes)
	{
		$post = $this->CI->input->get();
		if (@$post) {
			$id = isset($post) && isset($post['id']) ? addslashes($post['id']) : 0;
			$industries = isset($post) && isset($post['industries']) ? addslashes($post['industries']) : 0;
			$table = 'project';
			$configSegment = $this->_getSegment();
			extract($configSegment);

			$where = [['key' => 'act', 'compare' => '=', 'value' => 1]];
			if ($id != 0) {
				array_push($where, ['key' => 'FIND_IN_SET(' . $id . ',parent)', 'compare' => '>', 'value' => 0]);
			}
			if ($industries != 0) {
				array_push($where, ['key' => 'FIND_IN_SET(' . $industries . ',parent_2)', 'compare' => '>', 'value' => 0]);
			}
			$configPagination = $this->_setPagination(24, $itemRoutes, $table, $where, $segment);
			extract($configPagination);

			$limit = $pp . "," . $config['per_page'];
			$data['pp'] = $pp;
			$data['list_data'] = $this->CI->Dindex->getDataDetail(array(
				'table' => $table,
				'limit' => $limit,
				'where' => $where,
				'order' => 'ord desc'
			));
			$this->CI->pagination->initialize($config);
			$data['dataitem']['s_des'] = $itemRoutes['des_seo'];
			$data['dataitem']['s_key'] = $itemRoutes['key_seo'];
			$data['dataitem']['s_key'] = $itemRoutes['title_seo'];
			$data['dataitem']['name'] = 'Works';
			echo $this->CI->blade->view()->make('works.grid-work', $data)->render();
		}
	}
	private function hasMultiLanguage()
	{
		return class_exists('MultiLanguage');
	}
}
