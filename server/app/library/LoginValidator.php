<?php
App::load()->library('Validator',false);
class LoginValidator extends Validator{
	function __construct(){
		$this -> set_rule(array('required', 'username', 'username is required'));
		$this -> set_rule(array('required', 'password', 'password Field is required'));
	}
	public function get_fields(){
		return $_POST;
	}
}


?>