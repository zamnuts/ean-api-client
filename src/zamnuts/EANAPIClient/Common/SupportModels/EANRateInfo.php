<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;
use zamnuts\EANAPIClient\Util\XMLUtils;

/**
 * @property-read EANRoomGroup $roomGroup
 * @property-read EANChargeableRateInfo $chargeableRateInfo
 * @property-read EANConvertedRateInfo $convertedRateInfo
 * @property-read EANCancelPolicyInfoList $cancelPolicyInfoList
 * @property-read EANHotelFees $hotelFees
 * @property-read boolean $isPrepaid Aligns with "rateType", whether the rate is pre-paid via EAN or post-paid at the hotel.
 * @property string $cancellationPolicy Set as html entity encoded.  Retrieved as decoded.
 * @property string $rateType Set as html entity encoded.  Retrieved as decoded.
 * @property string $promoDescription Set as html entity encoded.  Retrieved as decoded.
 * @property string $promoType Set as html entity encoded.  Retrieved as decoded.
 * @property string $promoDetailText Set as html entity encoded. Retrieved as decoded.
 * @property float $taxRate
 * @property boolean $guaranteeRequired
 * @property boolean $depositRequired
 * @property-read EANDeposit $deposit Must display if returned. Returns only for Hotel Collect properties.
 * @property boolean $online
 * @property string $ratePlanType
 */
class EANRateInfo extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'RateInfo';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var boolean
	 */
	public $priceBreakdown;
	
	/**
	 * @var boolean
	 */
	public $promo;
	
	/**
	 * @var boolean
	 */
	public $rateChange;

	/**
	 * @var EANRoomGroup
	 */
	protected $roomGroup;
	
	/**
	 * @var EANChargeableRateInfo
	 */
	protected $chargeableRateInfo;
	
	/**
	 * @var EANConvertedRateInfo
	 */
	protected $convertedRateInfo;
	
	/**
	 * @var string
	 */
	protected $cancellationPolicy;
	
	/**
	 * @var EANCancelPolicyInfoList
	 */
	protected $cancelPolicyInfoList;
	
	/**
	 * @var boolean
	 */
	public $nonRefundable;
	
	/**
	 * @var EANHotelFees
	 */
	protected $hotelFees;
	
	/**
	 * @var string
	 */
	protected $rateType;
	
	/**
	 * @var float
	 */
	public $taxRate;
	
	/**
	 * @var int
	 */
	public $promoId;
	
	/**
	 * @var string
	 */
	protected $promoDescription;
	
	/**
	 * @var string
	 */
	protected $promoDetailText;
	
	/**
	 * @var string
	 */
	protected $promoType;
	
	/**
	 * @var boolean
	 */
	protected $guaranteeRequired;
	
	/**
	 * @var boolean
	 */
	protected $depositRequired;
	
	/**
	 * @var EANDeposit
	 */
	protected $deposit;
	
	/**
	 * The number of bookable rooms remaining at the property.  
	 * Use this value to create rules for urgency messaging to alert users to low availability on busy travel dates or at popular properties. 
	 * If the value returns as 0, it does not indicate a lack of rooms at the property. 
	 * The rules needed to calculate the value were simply not met - this value does not indicate absolute availability. 
	 * @var int
	 */
	public $currentAllotment;
	
	/**
	 * @var boolean
	 */
	public $online;
	
	/**
	 * @var string
	 */
	public $ratePlanType;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'roomGroup' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomGroup',
		'chargeableRateInfo' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANChargeableRateInfo',
		'convertedRateInfo' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANConvertedRateInfo',
		'cancellationPolicy' => 'string',
		'cancelPolicyInfoList' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANCancelPolicyInfoList',
		'nonRefundable' => 'boolean',
		'hotelFees' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelFees',
		'rateType' => 'string',
		'promoId' => 'int',
		'promoDescription' => 'string',
		'promoType' => 'string',
		'promoDetailText' => 'string',
		'currentAllotment' => 'int',
		'taxRate' => 'float',
		'guaranteeRequired' => 'boolean',
		'depositRequired' => 'boolean',
		'deposit' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANDeposit',
		'online' => 'boolean',
		'ratePlanType' => 'string'
	);
	
	/**
	 * @var string[]
	*/
	protected static $attributeMap = array(
		'priceBreakdown' => 'boolean',
		'promo' => 'boolean',
		'rateChange' => 'boolean'
	);
		
	/**
	 * @param EANRateInfo $supportModel
	 * @return EANRateInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__roomGroup() {
		if ( isset($this->roomGroup) ) {
			return clone $this->roomGroup;
		}
		return null;
	}
	
	protected function get__chargeableRateInfo() {
		if ( isset($this->chargeableRateInfo) ) {
			return clone $this->chargeableRateInfo;
		}
		return null;
	}
	
	protected function get__convertedRateInfo() {
		if ( isset($this->convertedRateInfo) ) {
			return clone $this->convertedRateInfo;
		}
		return null;
	}
	
	protected function get__cancelPolicyInfoList() {
		if ( isset($this->cancelPolicyInfoList) ) {
			return clone $this->cancelPolicyInfoList;
		}
		return null;
	}
	
	protected function get__hotelFees() {
		if ( isset($this->hotelFees) ) {
			return clone $this->hotelFees;
		}
		return null;
	}
	
	protected function get__cancellationPolicy() {
		return $this->cancellationPolicy;
	}
	
	protected function set__cancellationPolicy($value) {
		$this->cancellationPolicy = XMLUtils::tidyPartialHTMLToString($value,true);
	}
	
	protected function get__rateType() {
		return $this->rateType;
	}
	
	protected function set__rateType($value) {
		$this->rateType = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__isPrepaid() {
		return $this->rateType === 'MerchantStandard';
	}
	
	protected function get__promoDescription() {
		return $this->promoDescription;
	}
	
	protected function set__promoDescription($value) {
		$this->promoDescription = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__promoType() {
		return $this->promoType;
	}
	
	protected function set__promoType($value) {
		$this->promoType = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__promoDetailText() {
		return $this->promoDetailText;
	}
	
	protected function set__promoDetailText($value) {
		$this->promoDetailText = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__guaranteeRequired() {
		return $this->guaranteeRequired;
	}
	
	protected function set__guaranteeRequired($value) {
		$this->guaranteeRequired = Utils::anyToBoolean($value);
	}
	
	protected function get__depositRequired() {
		return $this->depositRequired;
	}
	
	protected function set__depositRequired($value) {
		$this->depositRequired = Utils::anyToBoolean($value);
	}
	
	protected function get__deposit() {
		if ( isset($this->deposit) ) {
			return clone $this->deposit;
		}
		return null;
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
