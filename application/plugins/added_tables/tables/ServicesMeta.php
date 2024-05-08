<?php
class ServicesMeta{
	protected $table = "services";
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
		$dttable->addField("id","int","id");$dttable->addField("name","varchar(255)","Tên bài viết");$dttable->addField("slug","varchar(255)","Slug");$dttable->addField("short_content","text(65535)","Mô tả ngắn");$dttable->addField("content","text(65535)","Nội dung");$dttable->addField("img","text(65535)","Hình ảnh");$dttable->addField("lib_img","text(65535)","Thư viện ảnh");$dttable->addField("parent","varchar(255)","Danh mục bài viết");$dttable->addField("create_time","bigint","Thời gian tạo");$dttable->addField("act","tinyint","Kích hoạt");$dttable->addField("hot","tinyint","Nổi bật");$dttable->addField("ord","int","Sắp xếp");$dttable->addField("tag","varchar(255)","Tag");$dttable->addField("count","int","Số lượt xem");$dttable->addField("publish_by","varchar(255)","Đăng bởi");$dttable->addField("s_title","varchar(255)","Tiêu đề SEO");$dttable->addField("s_des","varchar(255)","Mô tả SEO");$dttable->addField("s_key","varchar(255)","Từ khóa SEO");$dttable->addField("home","tinyint","Hiển thị trang chủ");$dttable->addField("update_time","bigint","Ngày sửa");$dttable->addField("nofollow","varchar(255)","Donofollow");$dttable->addField("custom_wp","text(65535)","Custom wp");$dttable->addField("noindex","tinyint","Noindex");
		$dttable->build();
	}
	private function removeTable(){
		$dttable = new DBTable($this->table);
		$dttable->dropTable();
	}
	private function createModule(){
		$m = new DBTech5sModule($this->table);
		$m->insertGroupModule('Dịch vụ',"view/".$this->table,53,'icon-camera',2);
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
				"note"=>"Dịch vụ",
				"note_en"=>"Services",
				"map_table"=>$this->table,
				"table_parent"=>"services_categories",
				"table_child"=>"",
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