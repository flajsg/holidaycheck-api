<?php namespace HC;

/**
 * Represents ratings in the specified category
 */
class HotelCategoryRating extends BaseModel implements BaseInterface {
	
	/**
	 * Rating from couples	
	 * @var float
	 */
	protected $couple;
	
	/**
	 * Rating from people who travelled with their familiy	
	 * @var float
	 */
	protected $family;
	
	/**
	 * Rating form people who travelled with friends	
	 * @var float
	 */
	protected $friends;
	
	/**
	 * Rating from all sources	
	 * @var float
	 */
	protected $overall;
	
	/**
	 * Rating form singles	
	 * @var float
	 */
	protected $single;
	
	public static function fromArray($array) {
	    $instance = new self();
	    if (!empty($array)) foreach ($array as $key => $value)  $instance->{$key} = $value;
	    return $instance;
	}
}