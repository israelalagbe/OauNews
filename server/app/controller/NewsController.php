<?php
class NewsController{
	private $newsLimit=4;
	public function news(){
		$newsModel=App::load()->model('NewsModel');
		if(isset($_GET['limit']))
			$this->newsLimit=(int)$_GET['limit'];
		$result=$newsModel->getNews($this->newsLimit);
		echo json_encode($result);
	}
	public function after($id){
		$newsModel=App::load()->model('NewsModel');
		if(isset($_GET['limit']))
			$this->newsLimit=(int)$_GET['limit'];
		echo json_encode($newsModel->getNewsAfterId($id,$this->newsLimit));

	}
}