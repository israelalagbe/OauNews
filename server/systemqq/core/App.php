<?php

class App{
	//@class Loader Loader class instance
	private static $loader;
	//@class Router Router class instance
	private static $router;
	private static function init(){
		
	}
	public static function load(){
		return static::$loader;
	}
	public static function router(){
		return static::$router;
	}
	private static function test(){
		static::load()->model("path/PagesModel");
		static::load()->controller("path/PagesController");
		static::load()->library("Router/Router");
		if(class_exists('Router'))
			echo "Library Router Loaded";
		static::load()->library('path/AppLibrary');
		static::load()->config('route');
		echo "Route Loaded";
		$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "Page Not Found";
	});
	}
	private function test1(){
		$router=App::router();
		$router->match('GET','hell',"Path/PagesController@hello");
		$router->get('hello',function(){
			echo "<br>From anonymous function<br>";
		});
		$router->run(function(){
			//This will be loaded last
			echo "App running";
		});
	}
	private function test2(){
		$router=App::router();
		$router->before('GET','hell',function(){
			echo "<br>This will be before anything<br>";
		});
		$router->mount('hell',function(){
			echo "<br>This mouted as the base of hello<br>";
		});
		$router->set404(function(){
			echo "<br>This the 404 handler<br>";
		});
		$router->run(function(){
			//This will be loaded last
			echo "App running";
		});
	}
	public static function run(){
		//Load loader class from system core
		static::$loader=new AppLoader();
		static::$router=static::load()->library("Router/Router");
		App::load()->config('route',false);
	}
	
}
?>