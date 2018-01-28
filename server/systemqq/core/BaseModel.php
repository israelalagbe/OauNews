<?php
App::load()->library('pixie/vendor/autoload',false);
class BaseModel{
	private static $supportedMethods=[];
	function __construct(){
		$config=App::load()->config('database');
		new \Pixie\Connection('mysql', $config, '_BaseModel');
	}
	/*public function __call($methodName,$args){
		echo "calling";
		return forward_static_call_array(['_BaseModel','table'],$args);
	}*/
	static function table($name){
		return _BaseModel::table($name);
	}
	static function transaction($closure){
		return _BaseModel::transaction($closure);
	}
	static function registerEvent(){
		return forward_static_call_array(['_BaseModel','registerEvent'],func_get_args());
	}
	static function removeEvent(){
		return forward_static_call_array(['_BaseModel','removeEvent'],func_get_args());
	}
}
?>