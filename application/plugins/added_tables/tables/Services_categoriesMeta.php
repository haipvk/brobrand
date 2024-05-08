<?php
class Services_categoriesMeta{
	protected $table = "services_categories";
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
		$dttable->addField("id","int","Mã");$dttable->addField("name","varchar(255)","Tên");$dttable->addField("slug","varchar(255)","Slug");$dttable->addField("img","text(65535)","Hình ảnh");$dttable->addField("short_content","text(65535)","Mô tả ngắn");$dttable->addField("content","text(65535)","Nội dung");$dttable->addField("create_time","bigint","Thời gian tạo");$dttable->addField("ord","int","Sắp xếp");$dttable->addField("parent","int","Danh mục cha");$dttable->addField("act","tinyint","Kích hoạt");$dttable->addField("hot","tinyint","Nổi bật");$dttable->addField("s_title","varchar(255)","Tiêu đề SEO");$dttable->addField("s_des","varchar(255)","Mô tả SEO");$dttable->addField("s_key","varchar(255)","Từ khóa SEO");$dttable->addField("count","int","Số lượng xem");$dttable->addField("home","tinyint","Hiển thị trang chủ");$dttable->addField("update_time","bigint","Ngày sửa");$dttable->addField("nofollow","tinyint","Nofollow");$dttable->addField("noindex","tinyint","No index");
		$dttable->build();
	}
	private function removeTable(){
		$dttable = new DBTable($this->table);
		$dttable->dropTable();
	}
	private function createModule(){
		$m = new DBTech5sModule($this->table);
		$m->insertGroupModule('Danh mục dịch vụ',"view/".$this->table,53,'icon-camera',2);
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
				"note"=>"Danh mục dịch vụ",
				"note_en"=>"ServicesCategories",
				"map_table"=>$this->table,
				"table_parent"=>"services_categories",
				"table_child"=>"services",
			]
		);
		$columns = $m->getAllColumns();
		foreach ($columns as $k => $column) {
			if($column['name']=="parent"){
				$column["type"]= "select";
				$column["default_data"] = $m->getDefaultData($column,"services_categories",0);
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