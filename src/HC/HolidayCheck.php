<?php namespace HC;

use LSS\XML2Array;

/**
 * HolidayCheck (HC) XML-API V2 (vesrion 2) parser.
 * 
 * www.HolidayCheck.com is a free travel information website. 
 * Community members and other users write and share hotel reviews and upload travel pictures and videos. 
 * This information helps other people plan and organize their holidays.
 * 
 * HolidayCheck provides XML API, which can be used to put hotel ratings/reviews on your own website. This is a parser for HC API.
 * 
 * @author Gregor Flajs <gregor.flajs@ors.si>
 *
 */
class HolidayCheck {
	
	const url = 'https://api.holidaycheck.com/v2';
	
	/**
	 * API Url
	 * @var string
	 */
	private $api_url;
	
	/**
	 * Partner token (api-key)
	 * @var string
	 */
	private $partner_token;
	
	
	/**
	 * Create an instance and set API credentials
	 * 
	 * @param string $partner_token
	 */
	public function __construct($partner_token = '') {
		$this->setApiUrl(self::url);
		$this->setPartnerToken($partner_token);
	}
	
	/**
	 * Construct API url
	 * 
	 * @param string $action	
	 * 		API action (hotel/hotelreview/hotelrating)
	 * @param array $filters
	 * 		API filters (see HC documentation)
	 * @param string $sort
	 * 		sorting column name (ex: 'averageRating:desc')
	 * @param int $limit
	 * 		limit for the pagination (default: no limit)
	 * @param int $offset
	 * 		offset for the pagination (default: 0)
	 * @return string
	 */
	protected function _makeUrl($action, $filters, $sort = '', $limit = 0, $offset = 0) {
		$url = $this->api_url.'/'.$action.'?partner_token='.$this->partner_token;
		if (!empty($filters))
		{
			$url .= '&filter=';
			foreach ($filters as $key => $val) $url .= $key.':'.$val.',';
		}
		if (!empty($sort)) 		$url .= '&sort='.$sort;
		if (!empty($limit)) 	$url .= '&limit='.$limit;
		if (!empty($offset)) 	$url .= '&offset='.$offset;
		
		return $url;
	}
	
	/**
	 * Post request with Curl.
	 * @param string $url
	 * @param string $request
	 * @param int $timeOut
	 *
	 * @return string|bool
	 *	FALSE is returned if Curl failed
	 */
	protected function _curlPost($url, $timeOut = 60) {
	     
	    if($ch = curl_init()) {
			//curl_setopt($ch, CURLOPT_HTTPHEADER, 0);
	         
	        if($timeOut != -1) {
	            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeOut/2)	;
	            curl_setopt($ch,CURLOPT_TIMEOUT,$timeOut);
	        }
	         
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	        curl_setopt($ch, CURLOPT_BUFFERSIZE, 1024);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_VERBOSE, 0);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	         
	        $content = curl_exec($ch);
	         
	        curl_close($ch);
	         
	         
	        return $content;
	    }
	    else return false;
	}

	/**
	 * Parse XML using XML2Array and return an array.
	 * @return array
	 */
	protected function _parseXml($xml) {
		try {
			$array = XML2Array::createArray($xml);
		}
		catch (\Exception $e) {
			// If $xml is empty of invalid, a createArray() will throw an exception
			return array();
		}
		return $array;
	}
	
	/**
	 * Set API url
	 * 
	 * @param string $api_url
	 * @return $this
	 */
	public function setApiUrl($api_url) {
		$this->api_url = $api_url;
		return $this;
	}
	
	/**
	 * Set partner token
	 * 
	 * @param string $partner_token
	 * @return $this
	 */
	public function setPartnerToken($partner_token) {
		$this->partner_token = $partner_token;
		return $this;
	}
	
	/**
	 * Return HC ratings and geo location from Giata ID.
	 * 
	 * @param string $giata_id
	 * @return Hotel|null
	 */
	public function getHotelFromGiata($giata_id) {
		$hotels = $this->hotels(array('giataId' => $giata_id));
		return !empty($hotels) ? $hotels[0] : null;
	}
	
	/**
	 * Returns detailed information about a hotel
	 *
	 * @param array $filters
	 * 		check HC documentation for all possible filters
	 * @return Hotel|null
	 */
	public function hotel($hotel_id, $filters = array()) {
	    $url = $this->_makeUrl('hotel/'.$hotel_id, $filters);
	    $xml = $this->_curlPost( $url );
	
	    $array = $this->_parseXml($xml);
	
	    // only one item
	    if (!empty($array['hotel'])) {
	        return Hotel::fromArray($array['hotel']);
	    }
	
	    return null;
	}
	
	/**
	 * Returns a list of hotels with all informations for each hotel, depending on $filter.
	 * 
	 * @param array $filters
	 * 		check HC documentation for all possible filters
	 * @return Hotel[]
	 */
	public function hotels($filters = array(), $sort = '', $limit = '', $offset = 0) {
		$url = $this->_makeUrl('hotel', $filters, $sort, $limit, $offset);
		$xml = $this->_curlPost( $url );
		
		$array = $this->_parseXml($xml);
		$hotels = $list = array();
		
		// only one item
		if (!empty($array['list']['items']['hotel']['id'])) {
			$list = array($array['list']['items']['hotel']);
		}
		// more then one item
		elseif (!empty($array['list']['items']['hotel'][0])) {
			$list = $array['list']['items']['hotel'];
		}
		
		foreach ($list as $hotel) {
			$hotels[]= Hotel::fromArray($hotel);
		}
		
		return $hotels;
	}

	/**
	 * Returns ratings in different categories for a hotel
	 * 
	 * @param int $hotel_id
	 * 		holiday check unique hotel id
	 * @param array $filters
	 * 		check HC documentation for all possible filters
	 * @return HotelRating
	 */
	public function hotelRatings($hotel_id, $filters = array()) {
		$url = $this->_makeUrl('hotelrating/'.$hotel_id, $filters);
		$xml = $this->_curlPost( $url );
		
		$array = $this->_parseXml($xml);
		
		if (!empty($array['hotelrating'])) {
			return HotelRating::fromArray($array['hotelrating']);
		}
		return null;
	}
	
	/**
	 * Returns information about one hotel review only status 1.
	 * 
	 * @param int $id
	 * 		holiday check unique hotel review id
	 * @param array $filters
	 * 		check HC documentation for all possible filters
	 * @param boolean $restricted
	 * 		if true then method will return hotel reviews of a MhcUser with independent status.
	 * @return HotelReview
	 */
	public function hotelReview($id, $filters = array(), $restricted = false) {
		if ($restricted)
	    	$url = $this->_makeUrl('hotelreview/restricted/'.$id, $filters);
		else
			$url = $this->_makeUrl('hotelreview/'.$id, $filters);
		
	    $xml = $this->_curlPost( $url );
	
    	$array = $this->_parseXml($xml);
	
	    // only one item
	    if (!empty($array['hotelReview'])) {
	        return HotelReview::fromArray($array['hotelReview']);
	    }
	
	    return null;
	}
	
	/**
	 * Returns reviews for a hotel
	 *
	 * @param int $hotel_id
	 * 		holiday check unique hotel id. If $hotel_id is empty then this method will return all HC reviews.
	 * 		You can also use $filters (hotelid => 16) to search for specific hotel reviews.
	 * @param array $filters
	 * 		check HC documentation for all possible filters
	 * @return HotelReview[]
	 */
	public function hotelReviews($hotel_id=0, $filters = array(), $restricted = false, $sort = '', $limit = '', $offset = 0) {
		
		if (!empty($hotel_id))
			$filters += array('hotelid' => $hotel_id);
		
		if ($restricted)
			$url = $this->_makeUrl('hotelreview/restricted', $filters, $sort, $limit, $offset);
		else
			$url = $this->_makeUrl('hotelreview', $filters, $sort, $limit, $offset);
		
		$xml = $this->_curlPost( $url );
		
		$array = $this->_parseXml($xml);
		$reviews = $list = array();
		
		// only one item
		if (!empty($array['list']['items']['hotelReview']['id'])) {
		    $list = array($array['list']['items']['hotelReview']);
		}
		// more then one item
		elseif (!empty($array['list']['items']['hotelReview'][0])) {
		    $list = $array['list']['items']['hotelReview'];
		}
		
		foreach ($list as $review) {
		    $reviews[]= HotelReview::fromArray($review);
		}
		
		return $reviews;
	}
	
}

