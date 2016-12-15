<?php 

use HC\HolidayCheck;

/**
 * Unit test for testing HolidayCheck API calls.
 *
 * @author Gregor Flajs
 *
 */
class HolidayCheckTest extends PHPUnit_Framework_TestCase
{
	
	public function loadConfig() {
		$base_dir = dirname(__FILE__)."\n";
		return include $base_dir.'/../src/config/config.php';	
	}

	/**
	 * Create and return parser
	 * @return \HC\HolidayCheck
	 */
	public function getInstance() {
		$config = $this->loadConfig();
	    return new HolidayCheck($config['partner_token']);
	}
	
	public function testHotelFromId() {
		
		$hc = $this->getInstance();
		
		$hotel = $hc->hotel(49415);
		
		$this->assertTrue(!empty($hotel));
	}
	
	public function testHotelFromGiata() {
		
		$hc = $this->getInstance();
		
		$hotel = $hc->getHotelFromGiata(396);
		
		$this->assertTrue(!empty($hotel));
	}
	
	public function testHotels() {
	
	    $hc = $this->getInstance();
	
	    $hotels = $hc->hotels(array(), '', 10);
	
	    $this->assertTrue(!empty($hotels));
	}
	
	public function testHotelRatings() {
		
		$hc = $this->getInstance();
		
		$hotel_ratings = $hc->hotelRatings(16);
		
		$this->assertTrue(!empty($hotel_ratings));
	}
	
	public function testHotelReviews() {
		
		$hc = $this->getInstance();
		
		$hotel_reviews = $hc->hotelReviews(16, array(), false, 'entryDate', 10);
		
		$this->assertTrue(!empty($hotel_reviews));
	}
	
	public function testHotelReview() {
		
		$hc = $this->getInstance();
		
		$hotel_review = $hc->hotelReview(2159596);
		
		$this->assertTrue(!empty($hotel_review));
	}
}
?>

