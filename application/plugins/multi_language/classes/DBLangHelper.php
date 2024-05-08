<?php

namespace MultiLanguage\Classes;

class DBLangHelper{

	use \VthSupport\Traits\Singleton;

	protected $CI;



	public function __construct(){

		$this->CI= &get_instance();

	}

	public function getTargetLangObject($table,$currentId,$targetLang){

		$this->CI->db->where("id",$currentId);

		$results = $this->CI->db->get($table)->result_array();

		if(count($results)>0){

			$result = $results[0];

			$originId = 0;

			if(!isset($result['pobject']) || $result['pobject']==0){

				$originId= $result['id'];

			}

			else{

				$originId= $result['pobject'];

			}

			$sql ="select * from $table where plang=? and (pobject=? or (pobject=0 and id = ?))";

			$results = $this->CI->db->query($sql,[$targetLang,$originId,$originId])->result_array();





			// $this->CI->db->where("pobject",$originId);

			// $this->CI->db->where("plang",$targetLang);

			// $results = $this->CI->db->get($table)->result_array();

			if(count($results)>0){

				$result = $results[0];

				return [$originId,$result['id']];

			}

			return [$originId,0];

		}

		return [0,0];

	}

	private function _getDataFromSlug($currentSlug){

		$key = sprintf('multi_language_%s',$currentSlug);

		\Container::setData($key,function() use ($currentSlug){

			// $this->CI->db->select('tag_id,table');

			$this->CI->db->where('link',$currentSlug);

			$this->CI->db->where('is_static',0);

			$tmp = $this->CI->db->get('nuy_routes')->result_array();

            $tmp = \Container::groupBy($tmp,'plang');

            return $tmp;

            

		}); 

		$results = \Container::getBy($key);

		return $results;

	}

	private function _getDataTableId($table,$id){

		$key = sprintf('multi_language_table_id_%s_%s',$table,$id);

		\Container::setData($key,function() use ($id,$table){

			$this->CI->db->select('id,pobject');

			$this->CI->db->where('id',$id);

			return $this->CI->db->get($table)->result_array();

		}); 

		$results = \Container::getBy($key);

		return $results;

	}

	private function _getObjectAllLangs($table,$pobject,$targetLang){

		$key = sprintf('multi_language_table_pobject_%s_%s',$table,$pobject);

		\Container::setData($key,function() use ($pobject,$targetLang,$table){

			$sql ="select id,name,slug,plang from $table where pobject=? or (pobject=0 and id = ?)";

			$results=  $this->CI->db->query($sql,[$pobject,$pobject])->result_array();

			$results = \Container::groupBy($results,'plang');

			return $results;

		}); 

		$results = \Container::getBy($key);

		return array_key_exists($targetLang, $results)?$results[$targetLang]:[];

	}

	public function getTargetLink($currentSlug,$currentLang,$targetLang){

		if(!class_exists('Container')){

			require_once APPPATH.'modules/Techsystem/controllers/Container.php';

		}

		$results = $this->_getDataFromSlug($currentSlug);

		$results = array_key_exists($currentLang, $results)?$results[$currentLang]:[];

		

		if(count($results)>0){

			$id = $results[0]['tag_id'];

			$table = $results[0]['table'];

			$results = $this->_getDataTableId($table,$id);

			if(count($results)>0){

				$pobject = $results[0]['pobject'];

				if($pobject==0){

					$pobject = $results[0]['id'];

				}

				$results = $this->_getObjectAllLangs($table,$pobject,$targetLang);

				if(count($results)>0){

					return $results[0];

				}



			}



		}

		return [];

	}

}