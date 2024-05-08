<?php
class SupportTitle extends IPlugin{
	public function install(){}
	public function uninstall(){}
	public function addFunctionBlade($args){
		$tmpArr= $args['tmpArr'];
		$tmpArr['HEADER'] = '<?php $seo = new \SupportTitle\Classes\MetaSeo(isset($dataitem)?$dataitem:NULL,isset($masteritem)?$masteritem:NULL,isset($datatable)?$datatable:NULL); echo $seo->show(); ?>';
		return ['tmpArr'=>$tmpArr];
	}
}