<?php
namespace core;
class Template{
	var $data;
	function __construct($fname,array $data=array()){
		$this->data=$data;
		//Load the file template
		$this->load($fname);
		
	}
	//Dinamically get the value when accessed from file template 
	public function __get( $propertyName ) {
		if ( array_key_exists( $propertyName, $this->data ) ) {
			return $this->data[$propertyName];
		} else {
			return null;
		}
	}
	public function __call( $methodName, $arguments ) {
		if ( array_key_exists( $methodName, $this->data ) ) {
			//array_unshift( $arguments, $this->data);
			return call_user_func_array( $this->data[$methodName], $arguments );
		} else {
			die ( "<p>Method $methodName doesn’t exist</p>");
		}
	}
	public function load($name){
		if(file_exists("templates/{$name}.html"))
			require_once "templates/{$name}.html";
		else die("Can't load library: \""."templates/{$name}.html");
	}
}
?>