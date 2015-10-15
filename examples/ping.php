<?php

require_once '../vendor/autoload.php';

use zamnuts\EANAPIClient\EANFacade;
use zamnuts\EANAPIClient\EANConfig;
use zamnuts\EANAPIClient\Query\EANPing;

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

$ping = new EANPing();
$ping->echo = 'Hello World'; // send this data
$ean->query($ping);

// due to the nature of the EAN API's ping request,
// the "echo" parameter should be the same in the response as the request
echo $ping->response->echo."\n"; // got this data back

echo ($ping->response->echo === $ping->echo ? 'MATCH' : 'INVALID')."\n";
