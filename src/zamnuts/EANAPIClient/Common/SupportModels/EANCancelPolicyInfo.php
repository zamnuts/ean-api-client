<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $timeZoneDescription
 */
class EANCancelPolicyInfo extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'CancelPolicyInfo';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	public $versionId;
	
	/**
	 * @var string
	 */
	public $cancelTime;
	
	/**
	 * @var int
	 */
	public $startWindowHours;
	
	/**
	 * @var int
	 */
	public $nightCount;
	
	/**
	 * @var string
	 */
	public $currencyCode;
	
	/**
	 * @var string
	 */
	protected $timeZoneDescription;
	
	/**
	 * @var string[]
	 */
	public static $propertyMap = array(
		'versionId' => 'int',
		'cancelTime' => 'string',
		'startWindowHours' => 'int',
		'nightCount' => 'int',
		'currencyCode' => 'string',
		'timeZoneDescription' => 'string'
	);
	
	/**
	 * @param EANCancelPolicyInfo $supportModel
	 * @return EANCancelPolicyInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__timeZoneDescription() {
		return $this->timeZoneDescription;
	}
	
	protected function set__timeZoneDescription($value) {
		$this->timeZoneDescription = Utils::htmlEntitiesDecode($value);
	}
	
	/**
	 * TODO: asXML
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::asXML()
	 */
	public function asXML() {
		return '';
	}
	
}
