<?php namespace HC;

/**
 * Rating information of a hotel
 */
class HotelRating extends BaseModel implements BaseInterface {
	
	/**
	 * Average ratings over all categories	
	 * @var HotelCategoryRating
	 */
	protected $averageRating;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $foodRating;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $hotelRating;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $locationRating;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $recommendation;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $roomRating;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $serviceRating;
	
	/**
	 * Average ratings over all categories
	 * @var HotelCategoryRating
	 */
	protected $sportRating;
	 
	public static function fromArray($array) {
	    $instance = new self();
	    if (!empty($array)) foreach ($array as $key => $value)  $instance->{$key} = HotelCategoryRating::fromArray($value);
	    return $instance;
	}
}