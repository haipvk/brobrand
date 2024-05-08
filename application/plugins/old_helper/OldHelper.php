<?php
class OldHelper extends IPlugin{
	protected $config;
	public function __construct(){
		parent::__construct();
		$this->config= $this->getConfigPlugins();
	}
	public function install(){
	}
	public function uninstall(){
	}
	public function initVindex(){
		require_once 'helper.php';
		return true;
	}
}