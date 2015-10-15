<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $description
 */
class EANValueAdd extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'ValueAdd';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	public $id;
	
	/**
	 * @var string
	 */
	protected $description;
	
	public static $valueAddsMap = array(
		'1' => 'All Meals',
		'2' => 'Continental Breakfast',
		'4' => 'Full Breakfast',
		'8' => 'English Breakfast',
		'16' => 'Free Lunch',
		'32' => 'Free Dinner',
		'64' => 'Food/Beverage Credit',
		'128' => 'Free Parking',
		'256' => 'Free Airport Parking',
		'512' => 'All-Inclusive',
		'1024' => 'Free High-Speed Internet',
		'2048' => 'Free Wireless Internet',
		'4096' => 'Continental Breakfast for 2',
		'8192' => 'Breakfast for 2',
		'16384' => 'Free Valet Parking',
		'32768' => 'Free Airport Shuttle',
		'65536' => 'Free Room Upgrade',
		'131072' => 'Resort Credit Included',
		'262144' => 'Welcome Gift Upon Arrival',
		'524288' => 'Spa Credit',
		'1048576' => 'Golf Credit',
		'2097152' => 'VIP Line Access to Nightclub(s)',
		'4194304' => '2-for-1 Buffet',
		'8388608' => 'Free Ski Lift Ticket & Rental',
		'16777216' => 'Breakfast Buffet',
		'33554432' => 'Half Board',
		'67108864' => 'Full Board',
		'134217728' => 'Full Kitchen',
		'268435456' => 'Slot Play',
		'536870912' => 'Casino Credit',
		'1073741824' => 'Match Play'
	);
	
	public static $propertyMap = array(
		'description' => 'string'
	);
	
	public static $attributeMap = array(
		'id' => 'int'
	);
	
	/**
	 * @param EANValueAdd $supportModel
	 * @return EANValueAdd
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__description() {
		return $this->description;
	}
	
	protected function set__description($value) {
		$this->description = Utils::htmlEntitiesDecode($value);
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
