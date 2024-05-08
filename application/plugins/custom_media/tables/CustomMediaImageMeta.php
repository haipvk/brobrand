<?php
namespace CustomMedia\Tables;
class CustomMediaImageMeta{
	use \VthSupport\Traits\Singleton;
	protected $table = 'custom_media_images';
	public function install(){
		$this->addTable();
	}
	public function uninstall(){
		$this->removeTable();
	}
	private function addTable(){
		$dttable = new \DBTable($this->table);
		$dttable->dropTable();
		$dttable->addField("id","int","id");
		$dttable->addField("name","varchar(255)","Tên");
		$dttable->addField("act","tinyint","Kích hoạt");
		$dttable->addField("media_id","int","Media id");
		$dttable->addField("create_time","varchar(30)","Ngày tạo");
		$dttable->addField("update_time","varchar(30)","Ngày cập nhật");
		$dttable->build();
	}
	private function removeTable(){
		$dttable = new \DBTable($this->table);
		$dttable->dropTable();
	}
}