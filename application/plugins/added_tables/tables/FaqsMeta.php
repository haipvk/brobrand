<?php
class FaqsMeta{
	protected $table = "faqs";
	protected static $instance;
	private function __construct(){}
	public static function get_instance(){
		if(self::$instance){
			return self::$instance;
		}
		else return $instance = new self;
	}
	public function install(){
		$this->addTable();
		$this->createModule();
		$this->createTableInfo();
	}
	public function uninstall(){
		$this->removeTable();
		$this->removeModule();
		$this->removeTableInfo();
	}

	private function addTable(){
		$dttable = new DBTable($this->table);
		$dttable->addField("id","int","id");$dttable->addField("name","varchar(255)","name");$dttable->addField("act","int","act");$dttable->addField("ord","int","ord");$dttable->addField("faqs","text(65535)","faqs");$dttable->addField("content","varchar(255)","content");$dttable->addField("short_content","varchar(255)","short_content");$dttable->addField("create_time","int","create_time");$dttable->addField("update_time","int","update_time");
		$dttable->build();
	}
	private function removeTable(){
		$dttable = new DBTable($this->table);
		$dttable->dropTable();
	}
	private function createModule(){
		$m = new DBTech5sModule($this->table);
		$m->insertGroupModule('faqs',"view/".$this->table,32,'icon-camera',2);
	}
	private function removeModule(){
		$m = new DBTech5sModule($this->table);
		$m->removeModule();
	}
	private function createTableInfo(){
		$m = new DBTech5sTable($this->table);
		$pid = $m->insertNuyTable(
			[
				"name"=>$this->table,
				"note"=>"faqs",
				"note_en"=>"Faqs",
				"map_table"=>$this->table,
				"table_parent"=>"",
				"table_child"=>"",
			]
		);
		$columns = $m->getAllColumns();
		foreach ($columns as $k => $column) {
			if($column['name']=="parent"){
				$column["type"]= "select";
				$column["default_data"] = $m->getDefaultData($column,"",0);
			}
			if($column['name']=="name"){
				$column["referer"] = $m->getRefererSlug();
			}
			$m->insertNuyDetailTable($column,$pid);
		}

	}
	private function removeTableInfo(){
		$m = new DBTech5sTable($this->table);
		$m->removeTable();
	}
}