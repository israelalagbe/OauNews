<?php
function irequire_once($path){
	if(file_exists($path))
		return require_once $path;
	return require_once strtolower($path);
}
spl_autoload_register(function($className){
	//$app_folders=["model","controller","helper","library","config"];
	$className=str_replace('\\','/',$className);
	if(file_exists("system/core/{$className}.php")){
		irequire_once("system/core/{$className}.php");
	}
	/*else if(file_exists("system/{$className}.php")){
		require_once "app/{$className}.php";
	}
	else if(file_exists("app/{$className}.php")){
		require_once "app\\{$className}.php";
	}*/
	/*foreach($app_folders as $val){
		if(file_exists("app/{$val}/{$className}.php")){
			require_once "app/{$val}/{$className}.php";
		}
	}*/
});

?>