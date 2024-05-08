<?php

spl_autoload_register(function($class){

	if(file_exists(__dir__."/tables/$class.php")){

		require_once __dir__."/tables/$class.php";

	}

});

class AddedTables extends IPlugin

{

	public $CI;



	// public $block;

	// public $services_categories;

	// public $services;

	// public $block;

	// public $project;

	// public $carreer;
	// public $faqs;
	// public $about_us;
	public $Tags_newsMeta;


	



	public function __construct() {

		$this->CI = &get_instance();

			// $this->services_categories = Services_categoriesMeta::get_instance();

			// $this->services = ServicesMeta::get_instance();

			// $this->block = BlockMeta::get_instance();

			// $this->project = ProjectMeta::get_instance();

			// $this->carreer = CarreerMeta::get_instance();
			// $this->carreer = FaqsMeta::get_instance();
			// $this->about_us = About_usMeta::get_instance();
			$this->Tags_newsMeta = Tags_newsMeta::get_instance();

	}

	public function install() {

			// $this->services_categories->install();

			// $this->services->install();

			// $this->block->install();

			// $this->project->install();

			// $this->carreer->install();
			// $this->faqs->install();
			// $this->about_us->install();
			$this->Tags_newsMeta->install();



	}

	public function uninstall() {

		// $this->services_categories->uninstall();

		// $this->services->uninstall();

		// $this->block->uninstall();

		// $this->project->uninstall();

		// $this->carreer->uninstall();
		// $this->faqs->uninstall();
		// $this->about_us->uninstall();
		$this->Tags_newsMeta->uninstall();

	}

}