<?php
class Controller extends BaseController{
	public function __construct(){
		parent::__construct();
		$this->routes=array('/'=>'all_news');
	}
	function all_news(){
		echo json_encode("ddd");
	}
}
?>