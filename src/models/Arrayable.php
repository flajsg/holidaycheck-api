<?php namespace HC; 

interface Arrayable {

	/**
	 * Get the instance as an array.
	 * @return array
	 */
	public function toArray();
}

interface BaseInterface {
	
	/**
	 * Create instance from an array of attributes.
	 * @return self
	 */
	public static function fromArray($attributes);
	
}