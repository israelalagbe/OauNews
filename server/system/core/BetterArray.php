<?php
class BetterArray extends ArrayObject{
	
	function __set($index,$value){
		if(is_callable($value)) {
			$this->offsetSet($index,$value->bindTo($this));
		} else {
			$this->offsetSet($index,$value);
		}
	}
	function __get($index){
		return $this->offsetGet($index);
	}
	function search($val){
		return array_search($val,(array)$this);
	}
	function push($val){
		$this->append($val);
	}
	function __call($methodName,$args){
		$functionName="array_".$methodName;
		
		if(is_callable($func=@$this->offsetGet($methodName))){
			return call_user_func_array($func,$args);
		}
		else if (is_callable($functionName)	) {
			$obj=$this->getArrayCopy();
			$result=call_user_func_array($functionName,array_merge(	[&$obj],$args));
			$this->exchangeArray($obj);
			return $result;
			//call_user_method_array(	, obj, params)
		}
		else throw new BadMethodCallException("Call to undefined method BetterArray::{$methodName}");
	}
	function __toString(){
		ob_start();
		var_dump((array)$this);
		return ob_get_clean();
	}
}