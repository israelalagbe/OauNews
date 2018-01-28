<?php
/**
* Asset Class for loading assets
*/
//Could be link
class Asset
{
	
	function __construct()
	{
		$this->path_name="asset/";
	}
	/*
	Add the method name to the asset path;
	*/
	function __call( $methodName, $arguments ) {
		$file=@$arguments[0];//The file name to add to the path
		return $this->path($methodName.'/'.$file);
	}
	function cssa($arg){
		$this->path();
		/*if(is_array($arg)){

		}
		else 
			$result=$this->path($arg);
		$result=sprintf("")*/
		return $result;
	}
	function path($name=null){
		return $this->base_url()."/".$this->path_name.$name;
	}
	function url($name=null){
		return $this->base_url().$name;
	}
	private function scheme(){
		if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
				$uri = 'https://';
			} else {
				$uri = 'http://';
			}
			return $uri;
	}
	function base_url(){
		//scheme http
		//host localhost
		//then the path to the dir
		$port=$_SERVER["SERVER_PORT"]==80?'':':'.$_SERVER["SERVER_PORT"];
		return $this->scheme().$_SERVER["HTTP_HOST"].$port.dirname($_SERVER['SCRIPT_NAME']);
	}
	function relativeUrl($path){
		return $_SERVER['REQUEST_URI']."/{$path}";
	}
}