<?php
define('DEBUG',true);
if (defined('DEBUG')) {
	# code...
	function realPathExist($path){
	$path=str_replace("\\", "/", $path);
	$real= realpath($path);
	$pathlen=strlen($path);
	$correctCasePath= substr($real, strlen($real)-$pathlen);
	$correctCasePath=str_replace("\\", "/", $correctCasePath);
	/*for ($i=0; $i <strlen($path) ; $i++) { 
		# code...
		$a=$correctCasePath[$i];
		$b=$path[$i];
		echo "{$a}:{$b}-";
	}*/
	return $correctCasePath==$path;
	/*$dir=dirname($path);
	echo realpath($dir);
	$all=(array_diff( scandir($dir),['.','..']));
	return glob($path)[0];*/
}
}
else{
  function realPathExist($path){
  	return file_exists($path);
  }
}

function irequire_once($path){
	if(realPathExist($path))
		return require_once $path;
	return require_once strtolower($path);
}

spl_autoload_register(function($className){
	//$app_folders=["model","controller","helper","library","config"];
	$className=str_replace('\\','/',$className);
	if(realPathExist("system/core/{$className}.php")){
		irequire_once("system/core/{$className}.php");
	}
	/*else if(realPathExist("system/{$className}.php")){
		require_once "app/{$className}.php";
	}
	else if(realPathExist("app/{$className}.php")){
		require_once "app\\{$className}.php";
	}*/
	/*foreach($app_folders as $val){
		if(realPathExist("app/{$val}/{$className}.php")){
			require_once "app/{$val}/{$className}.php";
		}
	}*/
});

?>