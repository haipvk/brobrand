<?php
require_once(PLUGIN_PATH."/multi_language/classes/LanguageProvider.php");
function pGetLanguage(){
	return \MultiLanguage\Classes\LanguageProvider::instance()->getLanguage();
}
function pGetLanguages(){
	return \MultiLanguage\Classes\LanguageProvider::instance()->getLanguages();
}
function pFlags(){
	return \MultiLanguage\Classes\LanguageProvider::instance()->flags();
}
function pChangeLanguageUrl($lang){
	$CI = &get_instance();
	$defLang = pgetDefaultLanguage();
	$uri = $lang ==$defLang?'':$lang;
	$currentUrl= current_url();
	$path = str_replace(base_url($lang), '', $currentUrl);
	$path = str_replace(base_url(), '', $path);
	$path = $path ==''?'/':'/'.$path;
	$query = http_build_query($CI->input->get());
	$paths = explode('/', $path);
	if(count($paths)>1){
		$beforeLang = $paths[1];
		if(\MultiLanguage\Classes\LanguageProvider::instance()->validateLang($beforeLang)){
			$paths[1] = $uri;
		}
		else{
			$beforeLang = $defLang;
			$paths = array_merge(array_slice($paths, 0, 1), [$uri], array_slice($paths, 1));
		}
		if(count($paths)>2){
			$targetObject = \MultiLanguage\Classes\DBLangHelper::instance()->getTargetLink($paths[2],$beforeLang,$lang);
			if(count($targetObject)>0){
				$paths[2] = $targetObject['slug'];
			}
		}
	}
	$url = implode('/', $paths).(strlen($query)>0?'?'.$query:'');
	$url = rtrim($url,'/');
	return base_url($url);
}
function pgetDefaultLanguage(){
	return \MultiLanguage\Classes\LanguageProvider::instance()->getDefaultLanguage();
}
function isDefaultLanguage(){
	return pgetDefaultLanguage()==pGetLanguage();
}
function phomeUrl($url=''){
	$langLink = isDefaultLanguage()?'':pGetLanguage();
	return base_url($langLink.(strlen($url)>0?'/'.$url:''));
}