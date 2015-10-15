<?php

require_once '../vendor/autoload.php';

use zamnuts\EANAPIClient\EANFacade;
use zamnuts\EANAPIClient\EANConfig;
use zamnuts\EANAPIClient\Query\EANHotelList;
use zamnuts\EANAPIClient\Query\HotelListSearch\EANHLSearchDestinationString;

// need session ID for EAN API, this can technically be anything, but this is best practice
session_start();

// config for EANFacade
$config = new EANConfig();
$config->apiKey		= ''; // CHANGEME
$config->apiSecret	= ''; // CHANGEME
$config->cid		= 0; // CHANGEME
$config->sessionId	= session_id(); // this happens automatically, but just for example
$config->devMode	= true; // switch to "false" in prod

// this is the gateway into the EAN API, all query structures are executed through this profile
$ean = new EANFacade($config); // just need one of these for all queries to use

// let's perform a free-text hotel search
$search = new EANHLSearchDestinationString('New York, NY'); // search by string
$hotels = new EANHotelList($search); // search for hotels using the particular search method
$hotels->numberOfResults = 4; // limit to 4 results
$hotels->arrivalDate = new DateTime('now + 3day'); // must specify date range...
$hotels->departureDate = new DateTime('now + 6day'); // otherwise entire hotel list is returned for query
$ean->query($hotels); // execute the query

if ( $hotels->lastError ) {
	exit($hotels->lastError->getMessage()); // got a low-level error
}
// var_dump($hotels->response); // inspect the result, this specific response is an EANResponseHotelList
foreach ( $hotels->response->hotelList->hotels as $hotel ) {
	echo $hotel->name.': '.$hotel->lowRate.'-'.$hotel->highRate.' '.$hotel->rateCurrencyCode."\n";
}
/*
 * OUTPUTS SOMETHING LIKE:
 * New York Marriott Marquis: 299-399 USD
 * Park Central New York: 245-427.78 USD
 * Manhattan NYC-an Affinia hotel: 167.2-429 USD
 * Wyndham New Yorker: 159.2-299 USD
 */


// now let's get page 2
$hotels2 = new EANHotelList($search);
$hotels2->cacheKey = $hotels->response->cacheKey; // just send the cacheKey
$hotels2->cacheLocation = $hotels->response->cacheLocation; // and cacheLocation from the previous request
$ean->query($hotels2); // this works like a pointer, each subsequent request on the cache params will yield the next page
if ( $hotels2->lastError ) {
	exit($hotels->lastError->getMessage());
}
echo '---- PAGE 2 ----'."\n";
foreach ( $hotels2->response->hotelList->hotels as $hotel ) {
	echo $hotel->name.': '.$hotel->lowRate.'-'.$hotel->highRate.' '.$hotel->rateCurrencyCode."\n";
}
