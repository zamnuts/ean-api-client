<?php

namespace zamnuts\EANAPIClient\Query;

use \DateTime;
use zamnuts\EANAPIClient\Util\Utils;
use zamnuts\EANAPIClient\Util\XMLUtils;
use zamnuts\EANAPIClient\EANFacade;
use zamnuts\EANAPIClient\Common\SupportModels\EANReservationAddress;
use zamnuts\EANAPIClient\Common\SupportModels\EANReservationInfo;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseRoomReservation;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoom;
use zamnuts\EANAPIClient\Common\SupportModels\EANRoomGroup;

/**
 * @property int $hotelId
 * @property DateTime $arrivalDate
 * @property DateTime $departureDate
 * @property string $supplierType
 * @property string $rateKey
 * @property string $roomTypeCode
 * @property string $rateCode
 * @property EANRoomGroup $roomGroup
 * @property string $affiliateConfirmationId
 * @property string $affiliateCustomerId
 * @property string $frequentGuestNumber
 * @property int $itineraryId
 * @property float $chargeableRate
 * @property string $specialInformation
 * @property boolean $sendReservationEmail
 * @property EANReservationInfo $reservationInfo
 * @property EANReservationAddress $addressInfo
 */
class EANRoomReservation extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'res';
	
	/**
	 * @var int
	 */
	protected static $HTTP_METHOD = EANFacade::HTTP_METHOD_POST;
		
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomReservationRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseRoomReservation';
		
	/**
	 * Supplier Type: Expedia Collect
	 * @var string
	 */
	const SUPPLIER_TYPE_E = 'E';
	
	/**
	 * Supplier Type: Venere (Hotel Collect)
	 * @var string
	 */
	const SUPPLIER_TYPE_V = 'V';
	
	/**
	 * Supplier Type: Sabre (Hotel Collect)
	 * @var string
	 */
	const SUPPLIER_TYPE_S = 'S';
	
	/**
	 * Supplier Type: Worldspan (Hotel Collect)
	 * @var string
	 */
	const SUPPLIER_TYPE_W = 'W';
	
	/**
	 * @var int
	 */
	protected $hotelId;
	
	/**
	 * @var DateTime
	 */
	protected $arrivalDate;
	
	/**
	 * @var DateTime
	 */
	protected $departureDate;
	
	/**
	 * @var string
	 */
	protected $supplierType;
	
	/**
	 * @var string
	 */
	protected $rateKey;
	
	/**
	 * @var string
	 */
	protected $roomTypeCode;
	
	/**
	 * @var string
	 */
	protected $rateCode;
	
	/**
	 * @var EANRoomGroup
	 */
	protected $roomGroup;
	
	/**
	 * @var string
	 */
	protected $affiliateConfirmationId;
	
	/**
	 * @var string
	 */
	protected $affiliateCustomerId;
	
	/**
	 * @var string
	 */
	protected $frequentGuestNumber;
	
	/**
	 * @var int
	 */
	protected $itineraryId;
	
	/**
	 * @var float
	 */
	protected $chargeableRate;
	
	/**
	 * @var string
	 */
	protected $specialInformation;
	
	/**
	 * @var boolean
	 */
	protected $sendReservationEmail = false;
	
	/**
	 * @var EANReservationInfo
	 */
	protected $reservationInfo;
	
	/**
	 * @var EANReservationAddress
	 */
	protected $addressInfo;
	
	/**
	 * @var EANResponseRoomReservation
	 */
	protected $response;
	
	protected static $propertyMap = array(
		'hotelId' => 'int',
		'arrivalDate' => 'DateTime',
		'departureDate' => 'DateTime',
		'supplierType' => 'string',
		'rateKey' => 'string',
		'roomTypeCode' => 'string',
		'rateCode' => 'string',
		'roomGroup' => 'EANRoomGroup',
		'affiliateConfirmationId' => 'string',
		'affiliateCustomerId' => 'string',
		'frequentGuestNumber' => 'string',
		'itineraryId' => 'int',
		'chargeableRate' => 'float',
		'specialInformation' => 'string',
		'sendReservationEmail' => 'boolean',
		'reservationInfo' => 'EANReservationInfo',
		'addressInfo' => 'EANReservationAddress',
	);
	
	public function __construct($hotelId=null) {
		parent::__construct();
		if ( isset($hotelId) ) {
			$this->set__hotelId($hotelId);
		}
	}
	
	protected function prepareRequest() {
		foreach ( self::$propertyMap as $property => $type ) {
			if ( !isset($this->$property) ) {
				continue;
			}
			switch ( $type ) {
				case 'DateTime':
					$this->xmlRequest->$property = $this->$property->format('m/d/Y');
					break;
				case 'EANReservationAddress':
				case 'EANReservationInfo':
				case 'EANRoomGroup':
					$this->$property->refreshXML();
					XMLUtils::appendSXE($this->xmlRequest,$this->$property->xml);
					break;
				case 'int':
				case 'float':
				case 'string':
					if ( method_exists($this,'get__'.$property) ) {
						$this->xmlRequest->$property = $this->{'get__'.$property}();
					} else {
						$this->xmlRequest->$property = (string) $this->$property;
					}
					break;
				case 'boolean':
					$this->xmlRequest->$property = $this->$property?'true':'false';
					break;
			}
		}
	}
	
	
	/**
	 * @return EANResponseRoomReservation
	 */
	protected function get__response() {
		if ( isset($this->response) ) {
			return clone $this->response;
		}
		return null;
	}
	
	// Hotel ID
	protected function get__hotelId() {
		return $this->hotelId;
	}
	
	protected function set__hotelId($value) {
		$this->hotelId = (int) $value;
	}
	
	// Arrival Date
	protected function get__arrivalDate() {
		return $this->arrivalDate;
	}
	
	protected function set__arrivalDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->arrivalDate = new DateTime($date);
	}
	
	// Departure Date
	protected function get__departureDate() {
		return $this->departureDate;
	}
	
	protected function set__departureDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->departureDate = new DateTime($date);
	}
	
	// Supplier Type
	protected function get__supplierType() {
		return $this->supplierType;
	}
	
	protected function set__supplierType($value) {
		$value = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $value)),0,256);
		$constStr = 'self::SUPPLIER_TYPE_'.$value;
		if ( defined($constStr) ) {
			$this->supplierType = constant($constStr);
		}
	}
	
	// Rate Key
	protected function get__rateKey() {
		return $this->rateKey;
	}
	
	protected function set__rateKey($value) {
		if ( isset($value) ) {
			$value = (string) $value;
			if ( strlen($value) ) {
				$this->rateKey = (string) $value;
			}
		}
	}
	
	// Room Group
	protected function get__roomGroup() {
		return $this->roomGroup;
	}
	
	protected function set__roomGroup(EANRoomGroup $value) {
		if ( $value instanceof EANRoomGroup ) {
			$this->roomGroup = clone $value;
		}
	}
	
	/**
	 * @param EANRoom $room
	 * @return boolean
	 */
	public function addRoom(EANRoom $room) {
		if ( $room instanceof EANRoom ) {
			if ( !isset($this->roomGroup) || !($this->roomGroup instanceof EANRoomGroup) ) {
				$this->roomGroup = new EANRoomGroup();
			}
			return $this->roomGroup->addRoom($room);
		}
		return false;
	}
	
	/**
	 * @param EANRoom $room
	 * @return boolean
	 */
	public function removeRoom(EANRoom $room) {
		if ( $room instanceof EANRoom ) {
			return $this->roomGroup->removeRoom($room);
		}
		return false;
	}
	
	/**
	 * @param int $i
	 * @return boolean
	 */
	public function removeRoomByIndex($i) {
		return $this->roomGroup->removeRoomByIndex($i);
	}
	
	// Room Type Code
	protected function get__roomTypecode() {
		return $this->roomTypeCode;
	}
	
	protected function set__roomTypeCode($value) {
		if ( isset($value) ) {
			$value = (string) $value;
			if ( strlen($value) ) {
				$this->roomTypeCode = (string) $value;
			}
		}
	}
	
	// Rate Code
	protected function get__rateCode() {
		return $this->rateCode;
	}
	
	protected function set__rateCode($value) {
		if ( isset($value) ) {
			$value = (string) $value;
			if ( strlen($value) ) {
				$this->rateCode = (string) $value;
			}
		}
	}
	
	protected function get__affiliateConfirmationId() {
		return $this->affiliateConfirmationId;
	}
	
	protected function set__affiliateConfirmationId($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->affiliateConfirmationId = $value;
		}
	}
	
	protected function get__affiliateCustomerId() {
		return $this->affiliateCustomerId;
	}
	
	protected function set__affiliateCustomerId($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->affiliateCustomerId = $value;
		}
	}
	
	protected function get__frequentGuestNumber() {
		return $this->frequentGuestNumber;
	}
	
	protected function set__frequentGuestNumber($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->frequentGuestNumber = $value;
		}
	}
	
	protected function get__itineraryId() {
		return $this->itineraryId;
	}
	
	protected function set__itineraryId($value) {
		$value = (int) $value;
		if ( $value ) {
			$this->itineraryId = $value;
		}
	}
	
	protected function get__chargeableRate() {
		return $this->chargeableRate;
	}
	
	protected function set__chargeableRate($value) {
		$value = (float) $value;
		if ( $value ) {
			$this->chargeableRate = $value;
		}
	}
	
	protected function get__specialInformation() {
		return $this->specialInformation;
	}
	
	protected function set__specialInformation($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->specialInformation = $value;
		}
	}
	
	protected function get__sendReservationEmail() {
		return $this->sendReservationEmail;
	}
	
	protected function set__sendReservationEmail($value) {
		$this->sendReservationEmail = Utils::anyToBoolean($value);
	}
	
	protected function get__reservationInfo() {
		return $this->reservationInfo;
	}
	
	protected function set__reservationInfo($value) {
		if ( $value instanceof EANReservationInfo ) {
			$this->reservationInfo = $value;
		}
	}
	
	protected function get__addressInfo() {
		return $this->addressInfo;
	}
	
	protected function set__addressInfo($value) {
		if ( $value instanceof EANReservationAddress ) {
			$this->addressInfo = $value;
		}
	}
	
}
