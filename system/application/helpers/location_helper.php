<?php

function zipCodeLookup($zip)
{
	//load XML library for parsing the xml file from google
	$CI =& get_instance();
	$CI->load->library('xml');
	
	//prep the variable to return
	$cityState = array('city' => 'error', 'state' => 'error');
	
	//google API Key ABQIAAAA74NimFRqv_JthUpwMyHNEhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxRzImG_Y9TEAkDWKfM0ATg7v99lRw
	$url = 'http://maps.google.com/maps/api/geocode/xml?address='.$zip.'&sensor=false';
	
	$CI->xml->load($url);
	$xmlArray = $CI->xml->parse();
	
	//if the zipcode exists, grab the city and state names
	if($xmlArray['GeocodeResponse'][0]['status'][0] == 'OK')
	{
		$location = $xmlArray['GeocodeResponse'][0]['result'][0]['formatted_address'][0];
		
		$comma = strpos($location, ',');
		$cityState['city'] = substr($location, 0, $comma);
		$cityState['state'] = substr($location, $comma + 2, 2);
	}
	
	
	return $cityState;
}

?>