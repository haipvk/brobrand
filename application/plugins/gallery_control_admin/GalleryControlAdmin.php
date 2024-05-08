<?php
class GalleryControlAdmin extends IPlugin{
	public function install(){
		$this->publishFile("theme/js/script.js");
		$this->publishFile("theme/js/jquery.contextMenu.min.js");
		$this->publishFile("theme/js/jquery-ui.min.js");
		$this->publishFile("theme/images/no-image.svg");
		$this->publishFile("theme/css/jquery.contextMenu.min.css");
	}
	public function uninstall(){
		$this->removeFile();
	}
	public function injectAdminEditJs(){
		echo '<link type="text/css" rel="stylesheet" href="'.$this->urlFile("theme/css/jquery.contextMenu.min.css").'">';
		echo '<script type="text/javascript" src="'.$this->urlFile("theme/js/jquery.contextMenu.min.js").'"></script>';
		echo '<script type="text/javascript" src="'.$this->urlFile("theme/js/jquery-ui.min.js").'"></script>';
		echo '<script type="text/javascript" src="'.$this->urlFile("theme/js/script.js").'"></script>';

		return true;
	}
}