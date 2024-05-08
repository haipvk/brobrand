<?php
class PageHelper extends IPlugin{
	protected $CI;
	public function __construct(){
		parent::__construct();
		$this->CI = &get_instance();
	}
	public function install(){
		
	}
	public function uninstall(){
		
	}
	
	public function initVindex(){
		require_once 'helper.php';
	}
	public function insertStyle(){
		
	}
	public function insertScript(){
		
	}
}