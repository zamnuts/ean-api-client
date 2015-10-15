<?php

namespace zamnuts\EANAPIClient\Query;

use \SimpleXMLElement;
use \Exception;
use \Curl\Curl;
use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\EANFacade;
use zamnuts\EANAPIClient\Util\Utils;
use zamnuts\EANAPIClient\Util\XMLUtils;
use zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel;

/**
 * @property-read SimpleXMLElement $xmlResponse Read-only.
 * @property-read SimpleXMLElement $xmlRequest Read-only.
 * @property-read mixed[] $params Read-only.
 * @property-read Exception $lastError Read-only.
 */
abstract class EANAbstractQuery extends ObjectBase {
	
	/**
	 * @var int EAN's minorRev this implementation is compatible with.
	 */
	const MINOR_REVISION = 27;
	
	/**
	 * @var string EAN's endpoint version
	 */
	const ENDPOINT_VERSION = 'v3';
	
	/**
	 * @var string EAN's hotel endpoint URI
	 */
	const ENDPOINT = 'https://api.eancdn.com/ean-services/rs/hotel/';
	
	/**
	 * EAN's api method to use.
	 * @var string
	 */
	protected static $API_METHOD = 'abstract';
	
	/**
	 * The root tag for this query.
	 * @var string
	 */
	protected static $ROOT = 'AbstractQuery';
	
	/**
	 * The full namespaced path to the class that handles the response. 
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANAbstractSupportModel';
	
	/**
	 * The HTTP method to use for the query. One of EANFacade::HTTP_METHOD_GET or EANFacade::HTTP_METHOD_POST.
	 * @var string
	 */
	protected static $HTTP_METHOD = EANFacade::HTTP_METHOD_GET;
		
	/**
	 * @var mixed[]
	 */
	protected $params;
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xmlRequest;
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xmlResponse;
	
	/**
	 * @var Exception
	 */
	protected $lastError;
	
	/**
	 * @var EANAbstractSupportModel
	 */
	protected $response;

	/**
	 * @var Curl
	 */
	protected $curl;
		
	public function __construct() {
		$this->xmlRequest = new SimpleXMLElement('<'.static::$ROOT.' />');
	}
	
	/**
	 * This is internally called right before `execute`. 
	 * Typically used to prepare the `xmlRequest` object. 
	 * @return void
	 */
	abstract protected function prepareRequest();
	
	/**
	 * This is internally called right after `execute`. 
	 * Typically used to prepare the class state with the `xmlResult` object. 
	 * @return void
	 */
	protected function prepareResponse() {
		if ( isset($this->response) ) {
			return;
		}
		if ( isset($this->xmlResponse) && is_subclass_of(static::$RESPONSE_CLASS,self::$RESPONSE_CLASS) ) {
			$this->response = new static::$RESPONSE_CLASS();
			$this->response->loadXML($this->xmlResponse);
		}
	}
	
	/**
	 * @return boolean
	 */
	public function execute() {
		$this->curl = new Curl();
		$this->curl->setOpt(CURLOPT_ENCODING,'gzip');
		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER,false);
		$this->curl->setOpt(CURLOPT_HTTPHEADER,array('Accept: application/xml'));
		$this->prepareRequest();
		if ( !$this->xmlRequest ) {
			$this->lastError = new Exception('Request XML is not defined.');
			return false;
		}
		if ( !isset(static::$API_METHOD) || !static::$API_METHOD ) {
			$this->lastError = new Exception('API method is not defined.');
			return false;
		}
		$url = rtrim(static::ENDPOINT,'/').'/'.static::ENDPOINT_VERSION.'/'.static::$API_METHOD;
		$data = array();
		if ( static::$HTTP_METHOD === EANFacade::HTTP_METHOD_POST ) {
			$data['xml'] = XMLUtils::SXEasXML($this->xmlRequest);
			$url .= '?'.Utils::httpBuildQuery3986($this->params);
		} else {
			$data = array_merge(
					$this->params,
					array(
						'xml' => XMLUtils::SXEasXML($this->xmlRequest)
					)
				);
		}
		if ( static::$HTTP_METHOD === EANFacade::HTTP_METHOD_GET ) {
			$this->curl->get($url,$data);
			$this->curl->close();
		} else if ( static::$HTTP_METHOD === EANFacade::HTTP_METHOD_POST ) {
			$this->curl->post($url,$data);
			$this->curl->close();
		} else {
			$this->lastError = new Exception('Invalid method for API call.');
			return false;
		}
		if ( $this->curl->error ) {
			$this->lastError = new Exception($this->curl->errorMessage);
			return false;
		}
		try {
			if ( $this->curl->response instanceof SimpleXMLElement ) {
				$this->xmlResponse = $this->curl->response;
			} else {
				$this->xmlResponse = new SimpleXMLElement($this->curl->response);
			}
		} catch ( Exception $e ) {
			$this->lastError = $e;
			return false;
		}
		$this->lastError = null;
		$this->prepareResponse();
		return true;
	}
	
	/**
	 * @return SimpleXMLElement
	 */
	protected function get__xmlRequest() {
		if ( isset($this->xmlRequest) ) {
			return clone $this->xmlRequest;
		}
		return null;
	}
	
	/**
	 * @return SimpleXMLElement
	 */
	protected function get__xmlResponse() {
		if ( isset($this->xmlResponse) ) {
			return clone $this->xmlResponse;
		}
		return null;
	}
	
	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function setParam($name,$value) {
		$this->params[$name] = $value;
	}
	
	/**
	 * Returns null if not found, otherwise the value.
	 * @param string $name
	 * @return mixed
	 */
	public function getParam($name) {
		if ( isset($this->params[$name]) ) {
			return null;
		}
		return $this->params[$name];
	}
	
	/**
	 * @return mixed[]
	 */
	protected function get__params() {
		return $this->params;
	}
	
	/**
	 * @return Exception
	 */
	protected function get__lastError() {
		return $this->lastError;
	}
	
}
