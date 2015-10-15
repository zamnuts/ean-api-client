<?php

namespace zamnuts\EANAPIClient\Query;

use zamnuts\EANAPIClient\Common\SupportModels\EANResponsePing;

/**
 * @property-read EANResponsePing $response
 */
class EANPing extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'ping';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'PingRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponsePing';
	
	/**
	 * @var string
	 */
	public $echo;
	
	/**
	 * @var EANResponsePing
	 */
	protected $response;
	
	/**
	 * @param string $echo
	 */
	public function __construct($echo='Hello World') {
		parent::__construct();
		$this->echo = (string) $echo;
		$this->xmlRequest->addChild('echo',$this->echo);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Query\EANAbstractQuery::prepareRequest()
	 */
	protected function prepareRequest() {
		$this->xmlRequest->echo = $this->echo;
	}
	
	/**
	 * @return EANResponsePing
	 */
	protected function get__response() {
		if ( isset($this->response) ) {
			return clone $this->response;
		}
		return null;
	}
	
}
