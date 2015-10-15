<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;

/**
 * @property-read EANError $error If an error was reported by the API, this will be populated. Make sure to test for it first with isset.
 */
class EANResponsePing extends EANAbstractSupportModel implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'ResponsePing';
	
	/**
	 * @var string
	 */
	public $customerSessionId;
	
	/**
	 * @var string
	 */
	public $echo;
	
	/**
	 * @var int
	 */
	public $serverInstance;
	
	/**
	 * @var int
	 */
	public $serverTimestamp;
	
	/**
	 * @var DateTime
	 */
	public $serverTime;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'echo' => 'string',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
		
	/**
	 * @param EANResponsePing $supportModel
	 * @return EANResponsePing
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	/**
	 * TODO: asXML
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::asXML()
	 */
	public function asXML() {
		parent::asXML();
	}
			
}
