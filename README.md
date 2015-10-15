# Expedia Affiliate Network API Client

This is a comprehensive library for working with v3 r27 of the EAN API. An affiliate account is required to actually
use any of this successfully (even in developer mode). Read more about it in the
[EAN Developer Documentation](http://developer.ean.com/docs/). This structured library attempts to provide
precise request and response parameters for each query type. This is especially helpful when code-hinting is
available via an IDE of some sort; it should speed up integration and leave out guess-work during maintenance.

## Current State of This Lib

Not going to lie here... it is in need of a good inventory and audit. At the time of this writing, this has been
sitting on the shelf collecting dust for a while now. 

- It was at one point successfully functioning in a production environment.
- The phpdocs are mostly complete for public members.
- _Most_, but not all, request/response types are accounted for; one that I know of that is incomplete is
`LocationInfoRequest` within [Geo Functions](http://developer.ean.com/docs/geo-functions) (just b/c the project this
was intended for didn't use it), but the rest should be functional.
- No unit tests exist whatsoever, oops. Written tests with stubs and fixtures would be nice, yes?
- Some of the "behind-the-scenes" methods are half baked; the original intention was for two-way request/response
processing and rendering. This never came to fruition, but there are remnants, and some of them work.
- Only supports r27 of the API, while the latest at the time of this writing is v30.

## Usage and Examples
See `examples/*.php` for hotel list search example and general usage.

To get started, you'll need an EAN API key and secret. Only one `EANConfig` and `EANFacade` is required at a time.
`EANConfig` is used as a model to feed the API configuration into `EANFacade`. `EANFacade` applies the general
configurations to each query request, e.g. `EANFacade->query(EANAbstractQuery)`. Anything in `EANAPIClient\Query`
can be instantiated and passed into the facade's query method, at which point the `response` property of the
`EANAbstractQuery` object will contain the results. Any instance of `EANAbstractQuery` is stateful, so if repeat
and/or subsequent queries must be performed (especially of the same type), a new one should be instantiated, and then
passed into the same `EANFacade` instance's `query` method.

Ping Example
```php
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
```

Will output:
```plain
Hello World
MATCH
```

## License
BSD-3-Clause, see `LICENSE` file for full text. (c) 2015 Andrew Zammit <zammit.andrew@gmail.com>
