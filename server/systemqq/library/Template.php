<?php
/*
    $loader = new Twig_Loader_Filesystem('/path/to/templates');
    $twig = new Twig_Environment($loader, array(
        'cache' => '/path/to/compilation_cache',
    ));

    echo $twig->render('index.html', array('name' => 'Fabien'));
*/
class Template{
	function __construct($path="app/template",$cache=null){
		App::load()->library('twig/vendor/autoload',false);
		$this->data=[];
		$loader = new Twig_Loader_Filesystem($path);
		$config=[];
		if($cache)
				$config=['cache' => $cache];
		$this->twig = new Twig_Environment($loader, $config);
	}
	function add_data(array $data){
		$this->data=array_merge($this->data,$data);
	}
	function set_data(array $data){
		$this->data=$data;
	}
	function render($fname,$return=FALSE){
		$result=$this->twig->render($fname, $this->data);
		if($return)
			return $result;
		else
			echo $result;
	}

}