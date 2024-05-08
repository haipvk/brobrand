<?php

namespace MultiLanguage\Classes;

use VthSupport\Classes\DBMaker as DBM;

class DBMaker{

	use \VthSupport\Traits\Singleton;

	protected $CI;



	public function __construct(){

		$this->CI= &get_instance();

	}

	public function addColumnNuyRoutes($defautLang){

		$table= 'nuy_routes';

		$columns = [['key'=>'plang','note'=>'Ngôn ngữ','type'=>'varchar(20)','default'=>$defautLang]];

		DBM::instance()->addColumn($table,$columns,false);

	}

	public function removeColumnNuyRoutes(){

		$table= 'nuy_routes';

		$columnName ='plang';

		DBM::instance()->removeColumn($table,$columnName);

	}

	public function createColumnLang ($noAcceptTables,$tables,$defautLang){

		foreach ($tables as $k => $table) {

			$sql = "select * from information_schema.`COLUMNS` where table_name = ? and column_name = ?";

			$arr = $this->CI->db->query($sql,[$table,'plang'])->result_array();

			if(count($arr)==0){



				$columns = [['key'=>'plang','note'=>'Ngôn ngữ','type'=>'varchar(20)','default'=>$defautLang]];

				DBM::instance()->addColumn($table,$columns,false);





				$columns = [['key'=>'pobject','note'=>'Bản ghi ngôn ngữ gốc','type'=>'int','default'=>'0']];

				DBM::instance()->addColumn($table,$columns,false);

				DBM::instance()->addIndex($table,'plang');

				DBM::instance()->addIndex($table,'pobject');



				$sql = "update %s set pobject = id";

				$sql = sprintf($sql,$table);

				$this->CI->db->query($sql);



				$this->CI->db->where('name',$table);

				$q = $this->CI->db->get('nuy_table');

				$results = $q->result_array();

				if(count($results)>0){

					$sql = "INSERT INTO `nuy_detail_table`(`name`, `required`, `note`, `length`, `type`, `create_time`, `update_time`, `link`, `view`, `editable`, `simple_searchable`, `searchable`, `quickpost`, `is_upload`, `parent`, `default_data`, `region`, `help`, `ord`, `act`, `referer`, `note_en`) VALUES ('plang', 0, 'Ngôn ngữ', 255, 'MULTI_LANGUAGE.LANG', 1450256645, 1450256645, '%s', 1, 0, 1, 0, 0, 0, %s, NULL, 1, 'Ngôn ngữ', 2, 1, '', NULL);";

					$sql = sprintf($sql,$table,$results[0]['id']);

					$this->CI->db->query($sql);

				}

			}

		}

		$this->dropTable($noAcceptTables,$defautLang);

		

		

	}

	public function dropTable($tables,$defautLang){

		foreach ($tables as $k => $table) {

			$sql = "select * from information_schema.`COLUMNS` where table_name = ? and column_name = ?";

			$arr = $this->CI->db->query($sql,[$table,'plang'])->result_array();

			if(count($arr)==1){

				$sql ="DELETE from %s where plang <> ?";

				$sql = sprintf($sql,$table);

				$this->CI->db->query($sql,$defautLang);





				$sql = "ALTER TABLE %s 

				DROP COLUMN `plang`";

				$sql = sprintf($sql,$table);

				$this->CI->db->query($sql);

				

			

			}

			DBM::instance()->removeColumn($table,'pobject');

			$sql = "DELETE from nuy_detail_table where link = ? and name = 'plang'";

			$this->CI->db->query($sql,$table);

			//remove Alldata;



		}

	}

}