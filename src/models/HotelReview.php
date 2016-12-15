<?php namespace HC;


/**
 * Hotel review information
 */
class HotelReview extends BaseModel implements BaseInterface {
	
	/**
	 * Age range of user "14-18" "19-25" "26-30" "31-35" "36-40" "41-45" "46-50" "51-55" "56-60" "61-65" "66-70" "70 >"	
	 * @var string
	 */
	protected $age;
	
	/**
	 * First name of the user	
	 * @var string
	 */
	protected $firstName;
	
	/**
	 * Link to the HolidayCheck page which the user used e.g. if review is written from Swiss user -> www.holidaycheck.ch	
	 * @var string
	 */
	protected $hcSourceUrl;
	
	/**
	 * Link to the HolidayCheck page	
	 * @var string
	 */
	protected $hcUrl;
	
	/**
	 * Hotel Id	
	 * @var int
	 */
	protected $hotelId;
	
	/**
	 * Name of the hotel	
	 * @var string
	 */
	protected $hotelName;
	
	/**
	 * Hotel review Id	
	 * @var int
	 */
	protected $id;
	
	/**
	 * Language of this review	
	 * @var string
	 */
	protected $language;
	
	/**
	 * Original Language of this review	
	 * @var string
	 */
	protected $originalLanguage;
	
	/**
	 * General rating of the food	
	 * @var float
	 */
	protected $ratingFood;
	
	/**
	 * General rating of the hotel section	
	 * @var float
	 */
	protected $ratingHotel;
	
	/**
	 * General rating of the location	
	 * @var float
	 */
	protected $ratingLocation;
	
	/**
	 * General rating of the room	
	 * @var float
	 */
	protected $ratingRoom;
	
	/**
	 * General rating of the service	
	 * @var float
	 */
	protected $ratingService;
	
	/**
	 * General rating of the sport	
	 * @var float
	 */
	protected $ratingSport;
	
	/**
	 * Text of the hotel review	
	 * @var string
	 */
	protected $text;
	
	/**
	 * Review of the hotel	
	 * @var string
	 */
	protected $textHotel;
	
	/**
	 * Title of the hotel review	
	 * @var string
	 */
	protected $title;
	
	/**
	 * User traveled with "single" "couple" "family" "friends"	
	 * @var string
	 */
	protected $traveledWith;
	
	/**
	 * Reason for travel "beach" "business" "city" "hiking/wellness" "winter" "other"	
	 * @var string
	 */
	protected $travelReason;
	
	/**
	 * Hotel review UUID	
	 * @var string
	 */
	protected $uuid;
	
	public static function fromArray($array) {
	    $instance = new self();
	    if (!empty($array)) foreach ($array as $key => $value)  $instance->{$key} = $value;
	    return $instance;
	}
}