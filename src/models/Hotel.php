<?php namespace HC;

/**
 * Hotel information
 */
class Hotel extends BaseModel implements BaseInterface{
	
	/**
	 * Hotel id		
	 * @var int
	 */
	protected $id;
	
	/**
	 * Hotel UUID	
	 * @var string
	 */
	protected $uuid;
	
	/**
	 * Name of the hotel	
	 * @var string
	 */
	protected $name;
	
	/**
	 * Average recommendation rate of all non-archived active hotel reviews, between 0 and 100	
	 * @var float
	 */
	protected $recommendation;
	
	/**
	 * Average rating of all non-archived active hotel reviews, aka suns, between 1 and 6	
	 * @var float
	 */
	protected $averageRating;
	
	/**
	 * Total amount of reviews of the hotel	
	 * @var int
	 */
	protected $countReviews;
	
	/**
	 * Position of the hotel
	 * @var GeoLocation
	 */
	protected $geoLocation;
	
	/**
	 * Url to the HolidayCheck "rate a hotel" page	
	 * @var string
	 */
	protected $hcRateUrl;
	
	/**
	 * Url to the HolidayCheck hotel reviews page	
	 * @var string
	 */
	protected $hcReviewsUrl;
	
	/**
	 * Url to the HolidayCheck hotel overview page	
	 * @var string
	 */
	protected $hcUrl;
	
	public static function fromArray($array) {
		$instance = new self();
		if (!empty($array)) foreach ($array as $key => $value) {
			switch ($key) {
				case 'geoLocation':
					$instance->{$key} = GeoLocation::fromArray($value);
				default:
					$instance->{$key} = $value;
			}
		}
		return $instance;
	}
}