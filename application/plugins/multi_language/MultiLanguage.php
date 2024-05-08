<?php

use MultiLanguage\Classes\LanguageProvider;
use MultiLanguage\Classes\DBMaker;
use MultiLanguage\Classes\DBLangHelper;

require_once 'helper.php';
class MultiLanguage extends IPlugin
{
	protected $defaultLanguage = 'vi';
	protected $config;
	protected $acceptTables = [];
	protected $noAcceptTables = [];
	protected $allTables = [];
	protected $excerptTables = ['nuy_routes'];
	public $hasAdmin = true;
	public function __construct()
	{
		parent::__construct();

		$this->config = $this->getConfigPlugins();
		$this->_getListTableAccepts();
		$this->defaultLanguage = pgetDefaultLanguage();
	}
	private function _getListTableAccepts()
	{
		$this->acceptTables = [];
		$tables = isset($this->config['tables']) ? $this->config['tables'] : [];
		foreach ($tables as $k => $conf) {
			if (in_array($k, $this->excerptTables)) continue;
			if ($conf['value'] == 1) {
				array_push($this->acceptTables, $k);
			} else {
				array_push($this->noAcceptTables, $k);
			}
			array_push($this->allTables, $k);
		}
		$default = isset($this->config['languages']['default']) ? $this->config['languages']['default'] : 'en';
		$list = isset($this->config['languages']['list']) ? $this->config['languages']['list'] : [];
		LanguageProvider::instance()->setDefaultLanguage($default);
		LanguageProvider::instance()->setLanguages($list);
		return $this->acceptTables;
	}
	public function install()
	{
		$this->publishFile("theme/js/script.js");
		$this->defaultLanguage = LanguageProvider::instance()->getDefaultLanguage();
		DBMaker::instance()->addColumnNuyRoutes($this->defaultLanguage);
	}
	public function uninstall()
	{
		$this->removeFile();
		$this->defaultLanguage = LanguageProvider::instance()->getDefaultLanguage();
		DBMaker::instance()->dropTable($this->allTables, $this->defaultLanguage);
		DBMaker::instance()->removeColumnNuyRoutes();
	}
	public function initVindex()
	{
		require_once 'helper.php';
		$vindex = &get_instance();
		$login = $this;

		$vindex::macro('changePLanguage', function ($itemRoutes) use ($login) {
			$login->changePLanguage();
		});
	}
	private function _getUrlReferer()
	{
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	}
	private function _getTargetLink($slug)
	{
	}
	public function changePLanguage()
	{
		$lang = $this->CI->uri->segment(2, '');
		if (!LanguageProvider::instance()->validateLang($lang)) {
			$lang = LanguageProvider::instance()->getDefaultLanguage();
		}
		LanguageProvider::instance()->setLanguage($lang);
		$uri = $this->defaultLanguage == $lang ? '' : $lang;
		$referer = $this->_getUrlReferer();
		if ($referer == '') {
			redirect(base_url($uri));
		} else {
			$path = parse_url($referer, PHP_URL_PATH);
			$query = parse_url($referer, PHP_URL_QUERY);
			$paths = explode('/', $path);
			if (count($paths) > 1) {
				$beforeLang = $paths[1];
				if (LanguageProvider::instance()->validateLang($beforeLang)) {
					$paths[1] = $uri;
				} else {
					$beforeLang = $this->defaultLanguage;
					$paths = array_merge(array_slice($paths, 0, 1), [$uri], array_slice($paths, 1));
				}
				if (count($paths) > 2) {
					$targetObject = DBLangHelper::instance()->getTargetLink($paths[2], $beforeLang, $lang);
					if (count($targetObject) > 0) {
						$paths[2] = $targetObject['slug'];
					}
				}
			}
			$url = implode('/', $paths) . (strlen($query) > 0 ? '?' . $query : '');
			$url = rtrim($url, '/');
			redirect(base_url($url));
		}
	}
	public function init($args)
	{
		$tag = $args['tag'];
		$tag = urldecode($tag);
		$params = $args['params'];
		$tmplang = $this->CI->uri->segment(1, '');

		$isValidLangFromUri = true;
		if (!LanguageProvider::instance()->validateLang($tmplang)) {
			$tmplang = LanguageProvider::instance()->getDefaultLanguage();
			$isValidLangFromUri = false;
		}
		LanguageProvider::instance()->setLanguage($tmplang);
		if ($tag == '/') {
			return true;
		}
		if ($isValidLangFromUri) {
			if (count($params) > 0) {
				$tag = array_shift($params);
				$tag = urldecode($tag);
				return ['tag' => $tag, 'params' => $params];
			} else {
				echo $this->CI->index();
				die;
			}
		}
		return ['tag' => $tag];
	}
	public function catch404($args)
	{
		$uri = $args['uri'];
		$uris = explode('/', $uri);
		if (count($uris) > 1) {
			$tmplang = array_shift($uris);
			if (!LanguageProvider::instance()->validateLang($tmplang)) {
				return true;
			}
			$uri = implode('/', $uris);
			return ['uri' => $uri];
		}
		return true;
	}
	public function getSetting($args)
	{
		$result = $args['result'];
		$key = $args['key'];
		$set = $args['set'];
		$lang = pGetLanguage();
		$defLang = pgetDefaultLanguage();
		$add = (isNull($lang) ? $defLang : $lang) . "_";
		$result = "";
		$key = strtoupper($key);
		if (array_key_exists($key, $set)) {
			$fieldLang = @$set[$key]['lang'] ? $set[$key]['lang'] : $defLang;
			$fieldLang = explode(',', $fieldLang);
			if (!in_array($lang, $fieldLang)) {
				$lang = $defLang;
				$add = $defLang . "_";
			}
			$result = $set[$key][$add . "value"];
		} else {
			$result = $key;
		}
		return ['result' => $result];
	}
	public function initEchor($args)
	{
		$arr = $args['arr'];
		$key = $args['key'];
		$lang = LanguageProvider::instance()->getLanguage();
		if (($this->defaultLanguage != $lang) && ($key == 'slug' || $key == 'link_static')) {
			$arr[$key] = $lang . '/' . $arr[$key];
		}
		return ['arr' => $arr];
	}
	public function customLinkPage($args)
	{
		$link = $args['link'];
		if ($link == '') {
			return \VthSupport\Classes\UrlHelper::exactLink('');
		}
		\Container::setData('pages_data', function () {
			$this->CI->db->select('pobject,id,slug,plang');
			$pages = $this->CI->db->get('pages')->result_array();
			$results  = [];
			foreach ($pages as $k => $page) {
				$key = $page['pobject'] == 0 ? $page['id'] : $page['pobject'];
				$results[$key][] = $page;
			}
			return $results;
		});
		$results = \Container::getBy('pages_data');
		$currentPageByLink = 0;
		foreach ($results as $k => $pages) {
			foreach ($pages as $kp => $page) {
				if ($page['slug'] == $link) {
					$currentPageByLink = $k;
					break;
				}
			}
		}
		$link = '';
		if ($currentPageByLink > 0) {
			$lang = LanguageProvider::instance()->getLanguage();
			$listTargetObject = $results[$currentPageByLink];
			foreach ($listTargetObject as $keytarget => $target) {
				if ($target['plang'] == $lang) {
					$link = $target['slug'];
					break;
				}
			}
		}
		return ['link' => \VthSupport\Classes\UrlHelper::exactLink($link)];
	}
	public function customLinkTable($args)
	{
		$link = $args['link'];
		$lang = $args['lang'];
		$table = $args['table'];
		if ($link == '') {
			return \VthSupport\Classes\UrlHelper::exactLink('');
		}
		$this->CI->db->select('pobject,id,slug,plang');
		$this->CI->db->where('plang', $lang);
		$this->CI->db->where('slug', $link);
		$pages = $this->CI->db->get($table)->result_array();
		if (count($pages) > 0) {
			$page = $pages[0];
			$id = $page['pobject'] == 0 ? $page['id'] : $page['pobject'];
			$lang = LanguageProvider::instance()->getLanguage();
			$this->CI->db->select('pobject,id,slug,plang');
			$this->CI->db->where('plang', $lang);
			$this->CI->db->where('pobject', $id);
			$pages = $this->CI->db->get($table)->result_array();
			if (count($pages) > 0) {
				$link = $pages[0]['slug'];
			}
		}
		return ['link' => \VthSupport\Classes\UrlHelper::exactLink($link)];
	}
	public function getLang($args)
	{
		$lang = LanguageProvider::instance()->getLanguage();

		return ['lang' => $lang];
	}
	public function managerMultiLanguage($args)
	{
		$table = $args['table'];
		$action = $args['act'];
		$code = $args['code'];
		if ($code === 'multi_language') {
			$post = $this->CI->input->post();
			if (count($post) > 0) {
				$config = isset($post['config']) ? $post['config'] : '';
				$this->CI->Admindao->updateData(
					['config' => $config],
					'sys_plugins',
					array(
						array('key' => 'name', 'compare' => '=', 'value' => "'multi_language'")
					)
				);
			}
			$config = [];
			$plugins = $this->CI->Admindao->getDataInTable('', 'sys_plugins', array(
				array('key' => 'name', 'compare' => '=', 'value' => 'multi_language')
			), '', '');
			if (count($plugins) > 0) {
				$config = json_decode($plugins[0]['config'], true);
				$this->config = @$config ? $config : [];
				$this->_getListTableAccepts();
				DBMaker::instance()->createColumnLang($this->noAcceptTables, $this->acceptTables, LanguageProvider::instance()->getDefaultLanguage());
				$this->alterConfigLanguageTable();
			}
			$link = 'Techsystem/extra?action=' . base64_encode('table=pro&action=view&code=multi_language');
			$data['content'] = 'multi_language.admin_config';
			$data['link'] = $link;
			$data['config'] = $config;
			$this->CI->load->view('template', $data);
		}
		return true;
	}
	private function alterConfigLanguageTable()
	{
		$langs = LanguageProvider::instance()->getLanguages();
		foreach ($langs as $k => $lang) {
			$columns = [['key' => $lang . '_value', 'note' => 'Thông tin ' . $lang, 'type' => 'text', 'default' => '']];
			\VthSupport\Classes\DBMaker::instance()->addColumn('configs', $columns, false);
			\VthSupport\Classes\DBMaker::instance()->addColumn('languages', $columns, false);
		}
		$this->CI->db->where_in('type', ['TEXT', 'TEXTAREA', 'EDITOR']);
		$this->CI->db->update('configs', ['lang' => implode(',', $langs)]);
		$this->CI->db->update('nuy_table', ['ext' => implode(',', $langs)], ['name' => 'configs']);
	}
	public function editContent($args)
	{
		$table = $args['table'];
		$action = $args['act'];
		$code = $args['code'];
		if ($code === 'multi_language_edit') {
			$get = $this->CI->input->get();
			$id = isset($get['id']) ? (int)$get['id'] : 0;
			$return = isset($get['return']) ? $get['return'] : '';
			$lang = isset($get['lang']) ? $get['lang'] : '';
			$url = 'Techsystem/edit/%s/%s?return=%s';
			if ($id == 0 || $lang == '') {
				redirect($return);
			}
			list($originId, $targetId) = DBLangHelper::instance()->getTargetLangObject($table, $id, $lang);
			if ($targetId == 0) {
				$url = 'Techsystem/copy/%s/%s?lang=%s&originId=%s&return=%s';
				$url = sprintf($url, $table, $originId, $lang, $originId, $return);
			} else {
				$url = sprintf($url, $table, $targetId, $return);
			}
			redirect($url);
		}
		return true;
	}
	public function ajaxLanguageFlag($args)
	{
		$action = $args['act'];
		$code = $args['code'];
		if ($code === 'ajax_language_flag') {
			$get = $this->CI->input->get();
			$id = isset($get['id']) ? (int)$get['id'] : 0;
			$clang = isset($get['lang']) ? $get['lang'] : '';
			$return = isset($get['return']) ? $get['return'] : '';
			$table = isset($get['table']) ? $get['table'] : '';
			$langs = \MultiLanguage\Classes\LanguageProvider::instance()->getLanguages();
			$flags = \MultiLanguage\Classes\LanguageProvider::instance()->flags();
			$tickicon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAABXElEQVRIS7WUOU7DQBSG/zd2REWPQgscACpEwyIjgRASNheAUCG4CwXQslSIIpKb2CmwXcMJKLhDqG3PoIniAN5iT+wpR6Pve/M2QsuHWuajUcGWfby4EIU9z3JuksAbE0h4JwqHBGwK4DawnGspaUTwF/6bcrr3zcHV3IJ8+EQjxN1cgjI4B+caaRfKgipwzxw8KAmqwpWKPAtOoF5guY+ZNt19PVoWWmwT45feyfA9bwDrwqc/mMADACsc+NYY309LVOBjgWEb3TjSAwGsJlFLiQ5hvFnuh7xThY8FO/0DHwLbmZRwPhKkGWFH/0wmNP1GtiIJOg9O3aeinUZ7/cO1KBY+Y+jmScDYF4ANFfi0BqWSnNCqRJ7poqoSCWfEznzTea6y6v8N2ixJXXjuoBVJVOCFk5yWqMJLV0UiAeNLdXKerkvpspOSGHw9MN2XKgXNe6O0TevIWhf8AATd5n2g7pqQAAAAAElFTkSuQmCC';
			$results = [];

			foreach ($langs as $k => $lang) :
				if (array_key_exists($lang, $flags)) {
					$flag = array_key_exists($lang, $flags) ? sprintf('<img style="height:18px;" src="%s"/>', $flags[$lang]['flag']) : $lang;
					$results[] = ['lang' => $lang, 'active' => $clang == $lang ? 1 : 0, 'html' => $flag, 'link' => 'Techsystem/extra?action=' . base64_encode('table=' . $table . '&action=view&code=multi_language_edit') . '=&table=' . $table . '&id=' . $id . '&lang=' . $lang . '&return=' . $return];
				}
			endforeach;
			echo json_encode($results);
		}
		return true;
	}
	public function accessGetDataDetail($args)
	{
		$options = $args['options'];
		$lang = LanguageProvider::instance()->getLanguage();
		$where = $options['where'];
		$where = !is_array($where) ? [] : $where;
		$table = $options['table'];
		$originTable = str_replace('`', '', $table);
		if (in_array($table, $this->acceptTables)) {
			array_push($where, ['key' => 'plang', 'compare' => '=', 'value' => $lang]);
			$options['where'] = $where;
			return ['options' => $options];
		}
		return true;
	}
	public function accessGetNum($args)
	{
		$lang = LanguageProvider::instance()->getLanguage();
		$where = $args['where'];
		$where = !is_array($where) ? [] : $where;
		$table = $args['table'];
		$originTable = str_replace('`', '', $table);
		if (in_array($table, $this->acceptTables)) {
			array_push($where, ['key' => 'plang', 'compare' => '=', 'value' => $lang]);
			return ['where' => $where];
		}
		return true;
	}
	public function changeBaseAllItem($args)
	{
		$lang = LanguageProvider::instance()->getLanguage();
		$config = $args['config'];
		if ($this->defaultLanguage != $lang) {
			$config['uri_segment'] = 3;
			$config['base_url'] = \VthSupport\Classes\UrlHelper::exactLink(str_replace(base_url(), "", $config['base_url']));
			return ['config' => $config];
		}
		return true;
	}
	public function changePaginationPage($args)
	{
		$lang = LanguageProvider::instance()->getLanguage();
		$config = $args['config'];
		if ($this->defaultLanguage != $lang) {
			$config['uri_segment'] = 3;
			$config['base_url'] = \VthSupport\Classes\UrlHelper::exactLink(str_replace(base_url(), "", $config['base_url']));
			return ['config' => $config];
		}
		return true;
	}
	public function changeBaseUrl($args)
	{
		$uri = $args['uri'];
		$uri = ltrim($uri, '/');
		$paths = explode('/', $uri);
		if (count($paths) > 0) {
			$path = $paths[0];
			if (LanguageProvider::instance()->validateLang($path)) {
				return true;
			} else {
				$lang = LanguageProvider::instance()->getLanguage();
				$uriLang = $this->defaultLanguage == $lang ? '' : $lang;
				$uri = $uriLang . '/' . $uri;
				return ['uri' => $uri];
			}
		}
		return true;
	}
	public function changeGetRelated($args)
	{
		$table = $args['table'];
		$sql = $args['sql'];
		$rawTable = str_replace('`', '', $table);
		if (in_array($rawTable, $this->acceptTables)) {
			$lang = LanguageProvider::instance()->getLanguage();
			$sql = str_replace('id != ?', sprintf('id != ? and plang=\'%s\'', $lang), $sql);
			return ['sql' => $sql];
		}
		return true;
	}
	public function injectPrintMenu($args)
	{
		$where = $args['where'];
		$input = $args['input'];
		$table = $args['table'];
		$field = $args['field'];
		if (in_array('menu', $this->acceptTables)) {
			$lang = LanguageProvider::instance()->getLanguage();
			array_push($where, ['key' => 'plang', 'value' => "'" . $lang . "'"]);
			return ['where' => $where];
		}
		return true;
	}
	public function injectExactLink($args)
	{
		$link = $args['link'];
		$lang = LanguageProvider::instance()->getLanguage();
		$defaultLanguage = pgetDefaultLanguage();
		if ($lang != $defaultLanguage) {
			return ['link' => $lang . (strlen($link) > 0 ? "/" . $link : '')];
		}
		return true;
	}
	public function injectActiveMenu($args)
	{
		$uri = $args['uri'];
		$lang = LanguageProvider::instance()->getLanguage();
		$defaultLanguage = pgetDefaultLanguage();
		if ($lang != $defaultLanguage) {
			$uri = $this->CI->uri->segment(2, '');
			return ['uri' => $uri];
		}
		return true;
	}
	public function injectBeforeEchor($args)
	{
		$arr = $args['arr'];
		$key = $args['key'];
		if ($key == 'slug' || $key == 'link_static') {
			$value = array_key_exists($key, $arr) ? $arr[$key] : '';
			$result = \VthSupport\Classes\UrlHelper::exactLink($value);
			return ['result' => $result];
		}
		// $lang = LanguageProvider::instance()->getLanguage();
		// $defaultLanguage = pgetDefaultLanguage();
		// if($lang!=$defaultLanguage){
		// 	if($key=='slug' || $key == 'link_static'){
		// 		$value = array_key_exists($key, $arr)?$arr[$key]:'';
		//            $result = !isNull($value)?$lang.'/'.$value:$lang;
		//            return ['result'=>$result];
		//        }

		// }
		return true;
	}
	/*System*/
	public function doUpdateRoutes($args)
	{
		$table = $args['table'];
		$dataUpload = $args['dataUpload'];
		$data = $args['data'];
		if (in_array($table, $this->acceptTables)) {
			$data['plang'] = $dataUpload['plang'];
			return ['data' => $data];
		}
		return true;
	}
	public function deleteAdmin($args)
	{
		$table = $args['table'];
		$datawhere = $args['datawhere'];
		if (in_array($table, $this->acceptTables)) {
			$id = isset($datawhere[0]['id']) ? (int)$datawhere[0]['id'] : 0;
			$this->_deleteRecords($table, [$id]);
		}
		return true;
	}
	private function _deleteRecords($table, $ids)
	{
		$this->CI->db->where_in('id', $ids);
		$results = $this->CI->db->get($table)->result_array();
		$pobjects = [];
		foreach ($results as $k => $result) {
			$pobject = $result['pobject'] == 0 ? $result['id'] : $result['pobject'];
			array_push($pobjects, $pobject);
		}
		$sql = "delete from $table where pobject in ? or id in ?";
		$this->CI->db->query($sql, [$pobjects, $pobjects]);
	}
	public function deleteAdminAll($args)
	{
		$table = $args['table'];
		$ids = $args['ids'];
		if (in_array($table, $this->acceptTables)) {
			$this->_deleteRecords($table, $ids);
		}
		return true;
	}
	public function doGetRoutes($args)
	{
		$table = $args['table'];
		$where = $args['where'];
		if (in_array($table, $this->acceptTables)) {
			$lang = LanguageProvider::instance()->getLanguage();
			$where['plang'] = $lang;
			return ['where' => $where];
		}
		return true;
	}
	public function injectAdminJs($args)
	{
		$table = $args['table'];
		$type = $args['type'];
		if (is_array($table) && count($table) > 0) {
			$table = $table[0]['name'];
			if (in_array($table, $this->acceptTables) && $type == 'edit') {
				echo '<script defer type="text/javascript" src="' . $this->urlFile("theme/js/script.js") . '"></script>';
			}
			if (in_array($table, $this->acceptTables) && ($type == 'view' || $type == "")) {

				echo '<script>var defaultLanguageFrontend = "' . pgetDefaultLanguage() . '";</script>';
				echo '<script defer type="text/javascript" src="' . $this->urlFile("theme/js/scriptview.js") . '"></script>';
			}
		}
	}
	public function changeViewLink($args)
	{
		$table = $args["table"];
		if (in_array($table, $this->acceptTables)) {
			$tmp = 'Techsystem/search/' . $table . '?nuytype_name=text&search_name=&nuytype_plang=multi_language.lang&search_plang=' . $this->defaultLanguage . '&order_by=id&ord=DESC&submit=Lọc';
			redirect($tmp);
		}
		return true;
	}
	public function changeRecursiveTable($args)
	{
		$where = $args['where'];
		$table = $args['table'];
		$uri = $this->CI->uri->uri_string();
		$ctable = $this->CI->uri->segment(3, 0);
		$type = $this->CI->uri->segment(2, 0);


		if (in_array($ctable, $this->acceptTables) && in_array($table, $this->acceptTables) && $type == 'edit') {
			if (!is_array($where)) return true;
			$id = (int) $this->CI->uri->segment(4, 0);
			$this->CI->db->select('plang');
			$this->CI->db->where('id', $id);
			$results = $this->CI->db->get($ctable, 1, 0)->result_array();
			if (count($results) > 0) {
				$plang = $results[0]['plang'];
				if (!is_array($where)) $where = [];
				$where['plang'] = "'" . $plang . "'";
				return ['where' => $where];
			}
		} else if (in_array($ctable, $this->acceptTables) && $type == 'search') {
			$get = $this->CI->input->get();
			$plang = isset($get['search_plang']) ? $get['search_plang'] : $this->defaultLanguage;
			if (!is_array($where)) $where = [];
			$where['plang'] = "'" . $plang . "'";
			return ['where' => $where];
		} else if (in_array($ctable, $this->acceptTables) && in_array($table, $this->acceptTables) && $type == 'insert') {
			$plang = $this->defaultLanguage;
			if (!is_array($where)) $where = [];
			$where['plang'] = "'" . $plang . "'";
			return ['where' => $where];
		} else if (in_array($ctable, $this->acceptTables) && in_array($table, $this->acceptTables) && $type == 'copy') {
			$get = $this->CI->input->get();
			$plang = isset($get['lang']) ? $get['lang'] : $this->defaultLanguage;
			if (!is_array($where)) $where = [];
			$where['plang'] = "'" . $plang . "'";
			return ['where' => $where];
		}
		return true;
	}
}
