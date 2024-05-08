<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Container{
	private static $data = [];

	public static function getBy($key,$def=[]){
		if(array_key_exists($key, static::$data)){
			return static::$data[$key];
		}
		return $def;
	}
	public static function getSubItem($key,$subkey,$grandkey,$def=[]){
		$item = static::getBy($key);
		if(array_key_exists($subkey, $item)){
			$tmp = $item[$subkey];
			return array_key_exists($grandkey, $tmp)?$tmp[$grandkey]:"";
		}
		return $def;
	}
	public static function setData($key,$callback){
		if(!array_key_exists($key, static::$data)){
			static::$data[$key] = $callback();
		}
	}
	public static function groupBy($array, $key) {
	    $return = array();
	    foreach($array as $val) {
	    	if(array_key_exists($key, $val)){
	        	$return[$val[$key]][] = $val;
	    	}
	    }
	    return $return;
	}
}