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
		$this->config=App::load()->config('template');
		$asset=App::load()->library('Asset');
		$this->data=['asset'=>$asset];
		$loader = new Twig_Loader_Filesystem($this->config['template']['path']);
		$config=[];
		if($this->config['cache']['enabled'])
			$config=['cache'=>$this->config['cache']['path']];
		
				//$config=['cache' =>'app/cache'];
		$this->twig = new Twig_Environment($loader, $config);
		/*$filter = new Twig_Filter('asset', function ($string) {
        	return $string."Custom";
    	});
		$this->twig->addFilter($filter);*/
	}
	function add_data(array $data){
		$this->data=array_merge($this->data,$data);
	}
	function set_data(array $data){
		$this->data=$data;
	}
	function render($fname,$print=TRUE){
		$result=$this->twig->render($fname, $this->data);
		if($print)
			echo $result;
		else
			return $result;
			
	}

}