<?php
class JsonField extends IPlugin{
	public function install(){
		$this->publishFile("theme/js/script.js");
	}
	public function uninstall(){
		$this->removeFile();
	}
	public function injectAdminEditJs(){
		echo '<script type="text/javascript" src="'.$this->urlFile("theme/js/script.js").'"></script>';

		return true;
	}
}