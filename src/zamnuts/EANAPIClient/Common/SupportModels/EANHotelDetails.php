<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\XMLUtils;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $checkInTime
 * @property string $checkOutTime
 * @property string $propertyInformation
 * @property string $areaInformation
 * @property string $propertyDescription
 * @property string $hotelPolicy
 * @property string $roomInformation
 * @property string $drivingDirections
 * @property string $checkInInstructions
 * @property string $roomFeesDescription
 * @property string $mandatoryFeesDescription
 * @property string $locationDescription
 * @property string $diningDescription
 * @property string $amenitiesDescription
 * @property string $businessAmenitiesDescription
 * @property string $roomDetailDescription
 * @property string $extraPersonCharge
 * @property string $guaranteePolicy
 * @property string $depositPolicy
 * @property string $guaranteeCreditCardsAccepted
 * @property string $depositCreditCardsAccepted
 * @property string $nationalRatingsDescription
 * @property string $knowBeforeYouGoDescription
 * @property string $renovationsDescription 
 */
class EANHotelDetails extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelDetails';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public $nativeCurrencyCode;
	
	/**
	 * @var int
	 */
	public $numberOfRooms;
	
	/**
	 * @var int
	 */
	public $numberOfFloors;
	
	/**
	 * @var string
	 */
	protected $checkInTime;
	
	/**
	 * @var string
	 */
	protected $checkOutTime;
	
	/**
	 * @var string
	 */
	protected $propertyInformation;

	/**
	 * @var string
	 */
	protected $areaInformation;
	
	/**
	 * @var string
	 */
	protected $propertyDescription;
	
	/**
	 * @var string
	 */
	protected $drivingDirections;
	
	/**
	 * @var string
	 */
	protected $checkInInstructions;
	
	/**
	 * @var string
	 */
	protected $roomFeesDescription;
	
	/**
	 * @var string
	 */
	protected $mandatoryFeesDescription;
	
	/**
	 * @var string
	 */
	protected $locationDescription;
	
	/**
	 * @var string
	 */
	protected $diningDescription;
	
	/**
	 * @var string
	 */
	protected $amenitiesDescription;
	
	/**
	 * @var string
	 */
	protected $businessAmenitiesDescription;
	
	/**
	 * @var string
	 */
	protected $roomDetailDescription;
	
	/**
	 * @var string
	 */
	protected $extraPersonCharge;
	
	/**
	 * @var string
	 */
	protected $guaranteePolicy;
	
	/**
	 * @var string
	 */
	protected $depositPolicy;
	
	/**
	 * @var string
	 */
	protected $guaranteeCreditCardsAccepted;
	
	/**
	 * @var string
	 */
	protected $depositCreditCardsAccepted;
	
	/**
	 * @var string
	 */
	protected $nationalRatingsDescription;
	
	/**
	 * @var string
	 */
	protected $knowBeforeYouGoDescription;
	
	/**
	 * @var string
	 */
	protected $renovationsDescription;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'nativeCurrencyCode' => 'string',
		'numberOfRooms' => 'int',
		'numberOfFloors' => 'int',
		'checkInTime' => 'string',
		'checkOutTime' => 'string',
		'propertyInformation' => 'string',
		'areaInformation' => 'string',
		'propertyDescription' => 'string',
		'hotelPolicy' => 'string',
		'roomInformation' => 'string',
		'drivingDirections' => 'string',
		'checkInInstructions' => 'string',
		'roomFeesDescription' => 'string',
		'mandatoryFeesDescription' => 'string',
		'locationDescription' => 'string',
		'diningDescription' => 'string',
		'amenitiesDescription' => 'string',
		'businessAmenitiesDescription' => 'string',
		'roomDetailDescription' => 'string',
		'extraPersonCharge' => 'string',
		'guaranteePolicy' => 'string',
		'depositPolicy' => 'string',
		'guaranteeCreditCardsAccepted' => 'string',
		'depositCreditCardsAccepted' => 'string',
		'nationalRatingsDescription' => 'string',
		'knowBeforeYouGoDescription' => 'string',
		'renovationsDescription' => 'string'
	);
	
	/**
	 * @param EANHotelDetails $supportModel
	 * @return EANHotelDetails
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}	
	
	protected function get__checkInTime() {
		return $this->checkInTime;
	}
	
	protected function set__checkInTime($value) {
		$this->checkInTime = trim(Utils::htmlEntitiesDecode($value));
	}
	
	protected function get__checkOutTime() {
		return $this->checkOutTime;
	}
	
	protected function set__checkOutTime($value) {
		$this->checkOutTime = trim(Utils::htmlEntitiesDecode($value));
	}
	
	protected function get__propertyInformation() {
		return $this->propertyInformation;
	}
	
	protected function set__propertyInformation($value) {
		$this->propertyInformation = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__areaInformation() {
		return $this->areaInformation;
	}
	
	protected function set__areaInformation($value) {
		$this->areaInformation = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__propertyDescription() {
		return $this->propertyDescription;
	}
	
	protected function set__propertyDescription($value) {
		$this->propertyDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__hotelPolicy() {
		return $this->hotelPolicy;
	}
	
	protected function set__hotelPolicy($value) {
		$this->hotelPolicy = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__roomInformation() {
		return $this->propertyDescription;
	}
	
	protected function set__roomInformation($value) {
		$this->propertyDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__drivingDirections() {
		return $this->drivingDirections;
	}
	
	protected function set__drivingDirections($value) {
		$this->drivingDirections = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__checkInInstructions() {
		return $this->checkInInstructions;
	}
	
	protected function set__checkInInstructions($value) {
		$this->checkInInstructions = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__roomFeesDescription() {
		return $this->roomFeesDescription;
	}
	
	protected function set__roomFeesDescription($value) {
		$this->roomFeesDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__mandatoryFeesDescription() {
		return $this->mandatoryFeesDescription;
	}
	
	protected function set__mandatoryFeesDescription($value) {
		$this->mandatoryFeesDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__locationDescription() {
		return $this->locationDescription;
	}
	
	protected function set__locationDescription($value) {
		$this->locationDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__diningDescription() {
		return $this->diningDescription;
	}
	
	protected function set__diningDescription($value) {
		$this->diningDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__amenitiesDescription() {
		return $this->amenitiesDescription;
	}
	
	protected function set__amenitiesDescription($value) {
		$this->amenitiesDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__businessAmenitiesDescription() {
		return $this->businessAmenitiesDescription;
	}
	
	protected function set__businessAmenitiesDescription($value) {
		$this->businessAmenitiesDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__roomDetailDescription() {
		return $this->roomDetailDescription;
	}
	
	protected function set__roomDetailDescription($value) {
		$this->roomDetailDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__extraPersonCharge() {
		return $this->extraPersonCharge;
	}
	
	protected function set__extraPersonCharge($value) {
		$this->extraPersonCharge = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__guaranteePolicy() {
		return $this->guaranteePolicy;
	}
	
	protected function set__guaranteePolicy($value) {
		$this->guaranteePolicy = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__depositPolicy() {
		return $this->depositPolicy;
	}
	
	protected function set__depositPolicy($value) {
		$this->depositPolicy = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__guaranteeCreditCardsAccepted() {
		return $this->guaranteeCreditCardsAccepted;
	}
	
	protected function set__guaranteeCreditCardsAccepted($value) {
		$this->guaranteeCreditCardsAccepted = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__depositCreditCardsAccepted() {
		return $this->depositCreditCardsAccepted;
	}
	
	protected function set__depositCreditCardsAccepted($value) {
		$this->depositCreditCardsAccepted = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__nationalRatingsDescription() {
		return $this->nationalRatingsDescription;
	}
	
	protected function set__nationalRatingsDescription($value) {
		$this->nationalRatingsDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__knowBeforeYouGoDescription() {
		return $this->knowBeforeYouGoDescription;
	}
	
	protected function set__knowBeforeYouGoDescription($value) {
		$this->knowBeforeYouGoDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__renovationsDescription() {
		return $this->renovationsDescription;
	}
	
	protected function set__renovationsDescription($value) {
		$this->renovationsDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
}
