<?php
App::load()->library('validator/validation',false);
class Validator {
	private $rules = array();
	/*
	 *Set the validation rule
	 *@param $rule=array(rule,field name,error message)
	 *Lenght of array rule must be 3
	 *return void
	 */
	function set_rule(array $rule) {
		if (count($rule) != 3)
			die("Error while setting validation rule: Lenght of data in rules array must be equal to 3");
		$rule = implode(",", $rule);
		array_push($this -> rules, $rule);
	}

	/*
	 *Validates the rules against the fields
	 *e.g $this->validate();
	 *@return array();
	 */
	function validate() {
		$errors = validateFields($this->get_fields(), $this -> rules);
		return $errors;
	}

}
?>