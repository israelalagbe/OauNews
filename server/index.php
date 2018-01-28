<?php

define('DS', DIRECTORY_SEPARATOR); //The directory seperator
define("SYS_DIR","system".DS);//The system directory
define("APP_DIR","app".DS);//The application directory
define('ROOT', dirname(__FILE__));//The path to index.html

define('CORE_DIR',SYS_DIR.DS.'core');//The directory to teh core forlder
require_once SYS_DIR.DS."autoload.php";//Load the autoload file
App::run();//Run the application

?>
