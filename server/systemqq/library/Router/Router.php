<?php
//Laod the libary without calling the constructor
App::load()->library('Router\Bramus\Router\Router',[],false);
class Router{
	private $router;
	function __construct(){
		$this->router=new Bramus\Router\Router();
	}
	public function match($methods, $pattern, $fn){
		//Check if it is a controller
		//Controllers are passed as strings
		if(is_string($fn)){
			//All controllers must have @ to seperate Classname from method
			//e.g ClassName@Method
			if(!strpos($fn,'@'))
				throw new Exception("@ not found in parameter 3 for Router");
			//Split  ClassName@Method into two
			$splited=explode('@',$fn);
			//The custom function to pass
			//The reason for custom function is so that exception can be handled properly
			$fn= function() use ($splited) {
				//Load the controller object
				$controller=App::load()->controller($splited[0]);
				//Call the controller against the argument from anonymous function
				call_user_func_array([$controller,$splited[1]], func_get_args());
			};
		}
		$this -> router -> match($methods, $pattern,$fn);
	}
	/*
	 *Run the application and executes callback after running the application
	 *@param name string
	 */
	public function run($callback = null) {
		$this -> router -> run($callback);
	}
	public function __call( $methodName, $arguments ) {
		//All the supported http methods
		$supportedMethods=["get","post","put","delete","options","patch"];
		//All supported function
		$supportedFunction=["mount","before","set404"];
		//Check if the called method match the http method
		if(in_array($methodName,$supportedMethods)){
			//Uses match method to process the http method
			//Uppercase letter can only be uses
			$this->match(strtoupper($methodName),$arguments[0],$arguments[1]);
		}
		//Check if the method called is supported
		else if(in_array($methodName,$supportedFunction)){
			//Calls the Router class against the argument
			call_user_func_array([$this->router,$methodName],$arguments );
		}
		else
			throw new Exception("Method Router::{$methodName} not found");
		
	}
}

?>