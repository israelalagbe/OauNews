<?php
/**
 * dynClass - replacement for stdClass
 * 
 * same as stdClass except you can add lambda function.
 * when a lambda "property" is "get"ed the function will be executed
 * and the result returned as the value of the property.
 * properties may also be called. Non-lambdas simply return the given
 * value. lambdas are executed as above, but in this case, parameters
 * may be passed.
 **/
class dynClass extends stdClass
{
	private $properties; //contained for all properties and "methods"
	
/**
 * __construct
 * 
 * @param array $arr	optionally an associative array of values
 * 						may be passed to initialise the objec. This is
 * 						an extension to stdClass behaviour	
 * @throws	Exception	if anything is passed that is not an array
 **/
	function __construct($arr=array())	{
		if(is_array ($arr))		{
			foreach($arr as $propname=>$elem)
			{
				if(is_callable($elem)) {
					$this->properties->$propname = $elem->bindTo($this->properties);
				} else {
					$this->properties->$propname = $elem;
				}
			}
		} else {
			throw new Exception('dynClass may only be initialised with array');
		}
	}
	
/**
 * __set set a property/method
 * 
 * If a property with an existing name is specified its value is
 * replaced
 * 
 * @param string $varnam	the name of the property or method
 * @param mixed	 $varvalue	any type
 **/
	
	function __set($varname, $varvalue)	{
		
		if(is_callable($varvalue)) {
			$this->properties->$varname = $varvalue->bindTo($this);
		} else {
			$this->properties->$varname = $varvalue;
		}
	}
	
/**
 * __get get a property or execute a method
 * 
 * Note that only lambdas that expect no parameters can be executed 
 * with __get
 * 
 * @param string $varname	The property to be retrieved or method
 * 							to be executed
 * @return mixed			the value of the property or the value
 * 							returned by the lambda function
 **/
	function __get($varname) {
		if (!isset( $this->properties->$varname )) {
			return null;
		} elseif (is_callable( $this->properties->$varname )) {
			return call_user_func($this->properties->$varname);
		} else {
			return $this->properties->$varname;
		}
	}
	
/**
 * __call get a property or execute a method
 *  
 * @param string $varname	The property to be retrieved or method
 * 							to be executed
 * @param array  $args		The arguments to be passed to the function
 * 							when called. If $varname is not a function
 * 							this parameter is ignored.
 * @return mixed			the value of the property or the value
 * 							returned by the lambda function
 **/
	function __call($varname, $args) {
		if (!isset($this->properties->$varname)) {
			return null;
		} elseif (is_callable($this->properties->$varname)) {
			return call_user_func_array($this->properties->$varname, $args);
		} else {
			return $this->properties->$varname;
		}
	}
	
/**
 * __isset Check if a property has been set
 * 
 * @param string $varname	The name of th property/method to check
 * @return boolean			True if it exists, false otherwise
 **/	
	function __isset($varname)	{
		return (isset($this->properties->$varname));
	}

/**
 * __unset Remove the specified property
 * 
 * @param string $varname	The naem of the property/ethod to remove
 **/
	function __unset($varname)  {
		unset ($this->properties->$varname);
	}
	
/**
 * __debugInfo make it respond sensibly to var_dump()
 ***/	
	function __debugInfo()	{
		return (array) $this->properties;
	}
}

