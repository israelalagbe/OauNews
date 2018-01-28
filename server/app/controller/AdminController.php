<?php
class AdminController extends BaseController{
    function __construct(){   
        parent::__construct();
        //$this->load()->library("hello")
        //$this->hello->create();
        $this->validator=App::load()->library('PostValidator');
        $this->tpl=App::load()->library('Template');
    }
	function login(){
        //$tpl->add_data	(['postImage'=>"alagnbe"]);
        $validator=$this->validator;
        if (@$this->post->login) {
            $username=$this->post->username;
            $password=$this->post->password;
            if ($username=="admin" and $password=="pass") {
                 $this->redirect('/admin/new');
            }
        }
        $this->tpl->add_data(['formError'=>$validator->validate(),'post'=>$_POST]);        
		$this->tpl->render('login.html');
    }
    function new(){
        $this->tpl=App::load()->library('Template',["app/template","app/cache"]);
        $this->tpl->render('new.html');
    }
    function edit(){
    	$tpl=App::load()->library('Template');
		$tpl->render('form.html1');
    }
}