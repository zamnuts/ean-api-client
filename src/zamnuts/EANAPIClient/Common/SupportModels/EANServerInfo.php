<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;
use \SimpleXMLElement;

/**
 * @property-read DateTime $serverTime
 */
class EANServerInfo extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'ServerInfo';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	public $instance;
	
	/**
	 * @var int
	 */
	public $timestamp;
	
	/**
	 * @var DateTime
	 */
	protected $serverTime;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'instance' => 'int',
		'timestamp' => 'int',
		'serverTime' => 'string'
	);
	
	/**
	 * @param EANServerInfo $supportModel
	 * @return EANServerInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__serverTime() {
		if ( isset($this->serverTime) ) {
			return clone $this->serverTime;
		}
		return null;
	}
	
	protected function set__serverTime($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->serverTime = new DateTime($date);
	}
	
}
