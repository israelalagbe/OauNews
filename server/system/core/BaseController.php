<?php
class BaseController {
	function __construct() {
		$this->requestMethod=$_SERVER['REQUEST_METHOD'];

		$this->post=new BetterArray($_POST);
		$this->get=new BetterArray($_GET);
	}
	function redirect($url){
		App::router()->redirect($url);
	}
}
?>