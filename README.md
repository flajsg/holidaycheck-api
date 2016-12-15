# holidaycheck-api
This is a simple PHP parser for HolidayCheck XML api, that already has a predefined model clases.

www.HolidayCheck.com is a free travel information website. 
Community members and other users write and share hotel reviews and upload travel pictures and videos. 
This information helps other people plan and organize their holidays.

In order to use this API, you will need Partner Token from HolidayCheck, which will be provided to you once you have signed a contract with HC.

## Dependencies

This parser uses ``curl`` to send API requests and ``openlss/lib-array2xml`` for converting XML to array.

## Basic Usage

First create an instance:

  $hc = new \HC\HolidayCheck($partner_token);

Get detailed information about a hotel (using holiday check unique hotel id):

```php
	$hotel = $hc->hotel(49415);

	// output:
	Array
  	(
	    [id] => 49415
	    [uuid] => 4e19fc5c-2279-36f0-b4ff-69fd37b3e7df
	    [name] => Hotel Veniqui
	    [recommendation] => 100.0
	    [averageRating] => 4.5
	    [countReviews] => 11
	    [geoLocation] => Array
	      (
	        [latitude] => 41.77302721395887
	        [longitude] => 9.392623901367188
	      )
	  
	    [hcRateUrl] => https://secure.holidaycheck.com/wcf/hotelreview/rate/4e19fc5c-2279-36f0-b4ff-69fd37b3e7df
	    [hcReviewsUrl] => http://www.holidaycheck.com/hr/4e19fc5c-2279-36f0-b4ff-69fd37b3e7df
    	[hcUrl] => http://www.holidaycheck.com/hi/4e19fc5c-2279-36f0-b4ff-69fd37b3e7df
	)
```

A list of hotels

	$hotels = $hc->hotels(array(), '', 10);

A list of hotel ratings:

	$ratings = $hc->hotelRatings(16);

A list of hotel reviews:

	$ratings = $hc->hotelReviews(16, array(), false, 'entryDate', 10);	
	
A single review (using holiday check unique hotel review id):


```php
	$review = $hc->hotelReview(2159596);
  
  	// output
  	Array
	(
	    [age] => 31-35
	    [firstName] => Tobias
	    [hcSourceUrl] => https://www.holidaycheck.de/hrd/1aa4c4ad-f9ea-3367-a163-8a3a6884d450/57b4a3e9-0384-3150-b1ef-4ec5dba12312
	    [hcUrl] => http://www.holidaycheck.com/hr/1aa4c4ad-f9ea-3367-a163-8a3a6884d450/-/review/57b4a3e9-0384-3150-b1ef-4ec5dba12312
	    [hotelId] => 70434
	    [hotelName] => Dana Beach Resort
	    [id] => 2159596
	    [language] => en
	    [originalLanguage] => de
	    [ratingFood] => 5.3
	    [ratingHotel] => 5.7
	    [ratingLocation] => 5.3
	    [ratingRoom] => 4.5
	    [ratingService] => 5.3
	    [ratingSport] => 5.0
	    [text] => The six block can not recommend the first floor, since the sounds of the departing Fleugzeuge (3.15
	    [textHotel] => 
	    [title] => Not the quietest Hotel
	    [traveledWith] => single
	    [travelReason] => beach
	    [uuid] => 57b4a3e9-0384-3150-b1ef-4ec5dba12312
	)
```
