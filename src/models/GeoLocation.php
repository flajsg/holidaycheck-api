<?php namespace HC; 

/**
 * Informations about the position of an item
 */
class GeoLocation extends BaseModel implements BaseInterface {
	
	/**
	 * The latitude between -90 and 90	
	 * @var float
	 */
	protected $latitude;
	
	/**
	 * The longitude between -180 and 180	
	 * @var float
	 */
	protected $longitude;
	
	public static function fromArray($array) {
		$instance = new self();
		if (!empty($array)) foreach ($array as $key => $value)  $instance->{$key} = $value;
		return $instance;
	}
}