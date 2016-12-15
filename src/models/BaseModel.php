<?php namespace HC;

class BaseModel implements Arrayable {
	
	public function __set($name, $value) {
	    if (property_exists($this, $name))
	        $this->{$name} = $value;
	}
	
	public function __get($name) {
	    if (property_exists($this, $name))
	        return $this->{$name};
	}
	
	public function toArray() {
		$array = array();
		foreach (get_object_vars($this) as $key => $value) {
			if ($value instanceof Arrayable) 
				$array[$key]= $value->toArray();
			else
				$array[$key]= $value;
		}
		return $array;
	}
}