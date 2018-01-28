<?php
App::load()->library('Validator',[],true);
class PostValidator extends Validator {
	function __construct() {
		$this -> set_rule(array('required', 'title', 'Title Field is required'));
		$this -> set_rule(array('required', 'content', 'Content Field is required'));
		//$this -> errors = $this -> validate($_POST);
	}
	function get_fields(){
		return $_POST;
	}
}
?>