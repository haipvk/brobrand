<?php
function adminIsLogged(){
	$CI = &get_instance();
	return $CI->session->has_userdata('userdata');
}
function isAdminServer(){
	$CI = &get_instance();
	return ($CI->session->has_userdata('user_from_sv') && $CI->session->userdata('user_from_sv')==1) || ENVIRONMENT == "development";
}
function adminLogout(){
	$CI = &get_instance();
	$CI->session->unset_userdata("userdata");
	$CI->session->unset_userdata("user_from_sv");
	pluginLogout();
}
function setAdminUser($data){
	$CI = &get_instance();
	$CI->session->set_userdata("userdata",$data);
}
function setAdminServer($data){
	$CI = &get_instance();
	$CI->session->set_userdata("user_from_sv",$data);
}
function getAdminUser(){
	if(adminIsLogged()){
		$CI = &get_instance();
		return $CI->session->userdata("userdata");
	}
	return [];
}
function getAdminUserId(){
	$user = getAdminUser();
	if(array_key_exists("user", $user)){
		return $user["user"]["id"];
	}
	return 0;
}


function setPluginUser($user){
	$CI = &get_instance();
	$CI->session->set_userdata("plugin_user",$user);
}
function getPluginUser(){
	if(isPluginLogged()){
		$CI = &get_instance();
		return $CI->session->userdata("plugin_user");
	}
	return [];
}
function isPluginLogged(){
	$CI = &get_instance();
	return $CI->session->has_userdata('plugin_user');
}
function pluginLogout(){
	$CI = &get_instance();
	return $CI->session->unset_userdata('plugin_user');
}