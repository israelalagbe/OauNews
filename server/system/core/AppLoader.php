<?php
class AppLoader{
	private $classes=[
	"model"=>"app/model/",
	"controller"=>"app/controller/",
	"library"=>[
		"system/library/",
		"app/library/"
		],
	"config"=>"app/config/"
	];
	static private $includes=[];
	public function model($path,array $args=[]){
		$path=str_replace('\\','/',$path);
		//Set the target as the model
		$target=$this->classes['model'].$path.'.php';
		//Get a class name from the path
		$className=$this->get_class_name_from_path($path);
		if(static::in_cache($path)){
			return static::cache($path,null);
		}
		if(realPathExist($target))
				require_once $target;
		else if(strtolower(realPathExist($target)))
			irequire_once($target);
		else
			throw new Exception("File {$className}.php Not Found");
		if(class_exists($className)){
				//Create a new class from argument 1 if it exists
				$rm=new ReflectionClass($className);
				return static::cache($path,$rm->newInstanceArgs($args));
		}
		else
			throw new Exception("Model {$className} Not Found");
		
	}
	public function controller($path,array $args=[]){
		$path=str_replace('\\','/',$path);
		//The complete path to the class
		$target=$this->classes['controller'].$path.'.php';
		//Get a single class name from the path
		$className=$this->get_class_name_from_path($path);
		//Check if the class exist before including again
		if(static::in_cache($path)){
			return static::cache($path,null);
		}
		if(realPathExist($target))
				require_once $target;
		else if(strtolower(realPathExist($target)))
			irequire_once($target);
		else
			throw new Exception("File {$className}.php Not Found");
		if(class_exists($className)){
				//Create a new class from argument 1 if it exists
				$rm=new ReflectionClass($className);
				return static::cache($path,$rm->newInstanceArgs($args));
		}
		else
			throw new Exception("Controller {$className} Not Found");
		
	}
	public function library($path,$args=[]){
		$path=str_replace('\\','/',$path);
		//Get a single class name from the path
		$className=$this->get_class_name_from_path($path);
		//The complete path to the class
		//Path to system and path to app
		$sys_path=$this->classes['library'][0].$path.'.php';
		$app_path=$this->classes['library'][1].$path.'.php';
		if(realPathExist($sys_path))
			require_once($sys_path);
		else if(realPathExist($app_path))
			require_once($app_path);
		else if(realPathExist(strtolower($sys_path)))
			irequire_once($sys_path);
		else if(realPathExist(strtolower($app_path)))
			irequire_once($app_path);
		else
			throw new Exception("File {$path}.php Not Found");

		if(class_exists($className)&&$args!==false){
				//Create a new class from argument 1 if it exists
				$rm=new ReflectionClass($className);
				return $rm->newInstanceArgs($args);
		}
		else if($args===false)
			return;
		else
			throw new Exception("Library {$path} Not Found");
		
	}
	public function delete_me($path,array $args=[]){
		$path=str_replace('\\','/',$path);
		//The complete path to config
		$target=$this->classes['config'].$path.'.php';
		if(realPathExist($target))
				return static::cache($target,irequire_once($target));
		else
			throw new Exception("File {$path}.php Not Found");
	}
	/*
	Stores includes in a cache so it just returns the include data from the first include 
	@param $key string The key of the map
	@param $val mixed  The data from the includes
	@return mixed
	*/
	private static function cache($key,$val){
		$key=strtolower($key);
		if(array_key_exists($key,static::$includes))
			return static::$includes[$key];
		else
			return static::$includes[$key]=$val;
	}
	/*
	Check if the key exist in cache 
	@param $key string The key to search for
	@return boolean
	*/
	private static function in_cache($key){
		$key=strtolower($key);
		return array_key_exists($key,static::$includes);
	}
	/*
	Extract the class name from the path given
	@param $path string
	@return string
	*/
	private function get_class_name_from_path($path){
		$pathArr=$this->path_to_string($path);
		$pathArrLen=count($pathArr);
		return $pathArr[$pathArrLen-1];
	}
	
	private function path_to_string($path){
		return explode('/',$path);
	}
	public function __call( $methodName, $arguments ) {
		if ( array_key_exists( $methodName, $this->classes ) ) {
			$target=$this->classes[$methodName].$arguments[0].'.php';
			if(realPathExist($target))
				return static::cache($target,require_once($target));
			else if(realPathExist(strtolower($target)))
				return static::cache($target,irequire_once($target));
			else
				throw new Exception("File {$target} Not Found");
		}
		else 
			throw new Exception("Method {$methodName} doesn't exist");
			/*$Name=$arguments[0];
			$methodName=str_replace('\\','/',$methodName);
			$splitedMethod=explode('/',$arguments[0]);
			$splitedMethodLen=count($splitedMethod);
			$methodPath=$this->classes[$splitedMethod[$splitedMethodLen-1]];
			switch($methodName){
				case "model":{
					$args=@$arguments[1];
					if(realPathExist($modelName.'.php')){
						echo "exists";
					}
				}
			}*/
			//array_unshift( $arguments, $this->data);
			//call_user_func_array([$this -> controller,$method,], func_get_args());
			/*$className=$arguments[0];
			$className=str_replace('\\','/',$className);
			$splitedClass=explode('/',$arguments[0]);
			$splitedClassLen=count($splitedClass);
			
			
			//The file we are looking for
			$target=APP_DIR.$this->classes[$methodName].$arguments[0].'.php';
			//If file exists then include the file
			$rm=new ReflectionClass($arguments[0]);
			
			return $rm->newInstanceArgs($args);*/
			///$name=$this->classes[$methodName].$arguments[0];
			//new $name();
			/*
			$target=APP_DIR.$this->classes[$methodName].$arguments[0].'.php';
			if(realPathExist($target))
				require_once $target;
			if(class_exists($arguments[0])){
				//Create a new class from argument 1 if it exists
				$args=[];
				if(@$arguments[1])
					$args=@$arguments[1];
				$rm=new ReflectionClass($arguments[0]);
				$rm->newInstanceArgs($args);
				//print_r(get_class_methods($rm));
			}*/
/*		} else 
			throw new Exception("Path {$methodName} doesn't exist");*/
	
	}
}

?>