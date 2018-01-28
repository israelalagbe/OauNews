<?php
//Include the template class
//require_once 'templates/template.php';
//require_once 'lib/dynClass.class.php';
use core\Template;
App::load_core('template');
App::load_library('dynClass/dynClass.class');
class View{
	function __construct($name,array $data=array()){
		$this->data=$data;
		$this->name=$name;
		$this->init();
		
	}
	function render($return=FALSE){
		ob_start();
		new Template($this->name,$this->data);
		if($return)
			return ob_get_clean();
		else
			ob_flush();
	}
	function set_data(array $data){
		$this->data=array_merge($this->data,$data);
	}
	function init(){
		$this->data['Link']=@new dynClass(
			array(
			'parent_this'=>$this,
			'js'=>function($fname=null){
				echo "<script type='text/javascript' src='".$this->parent_this->data['static_url']($fname)."'> </script>";
			},
			'css'=>function($fname=null){
				echo "<link rel='stylesheet' href='".$this->parent_this->data['static_url']($fname)."' />";
			},
			'a'=>function($fname=null){
				echo $this->parent_this->data['tag']('a');
			}
			
		)
		);
		//Generates tags like <a></a> and value is the inner html and attr are tag attribute 
		$this->data['tag']=function($name=null,$value='',array $attr=array()){
			$temp='';
			//Generates the tag attributes
			foreach($attr as $key=>$val)
				$temp.=" $key='{$val}'";
			return "<{$name}{$temp}>{$value}</{$name}>";
		};
		//Create html opening tag
		$this->data['open_tag']=function($name=null,array $attr=array()){
			$temp='';
			//Generates the tag attributes
			foreach($attr as $key=>$val)
				$temp.=" $key='{$val}'";
			return "<{$name}{$temp}>";
		};
		//Creates html closing tag
		$this->data['close_tag']=function($name=null){
			return "</{$name}>";
		};
			//Generates tags like <img />
		$this->data['r_tag']=function($name=null,array $attr=array()){
			$temp='';
			//Generates the tag attributes
			foreach($attr as $key=>$value){
				$temp.=" $key='{$value}'";
			}
			return "<{$name}{$temp} />";
			};
		$this->data['escape']=function($val){
			return htmlspecialchars($val);
		};
		$this->data['scheme']=function(){
			if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
				$uri = 'https://';
			} else {
				$uri = 'http://';
			}
			return $uri;
		};		
		$this->data['base_url']=function(){
			//scheme http
			//host localhost
			//then the path to the dir
			$port=$_SERVER["SERVER_PORT"]==80?'':':'.$_SERVER["SERVER_PORT"];
			return $this->data['scheme']().$_SERVER["HTTP_HOST"].$port.dirname($_SERVER['SCRIPT_NAME']);
		};
		$this->data['static_url']=function($file){
			//Get the path to the static url of the file
			return $this->data['base_url']()."/{$file}";
		};
		$this->data['relative_url']=function($file){
			//Get the path to the relative url of the file
			return $_SERVER['REQUEST_URI']."/{$file}";
		};
	}
}



?>