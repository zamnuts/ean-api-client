<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;
use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $customerSessionId
 * @property int $itineraryId
 * @property string[] $confirmationNumbers
 * @property boolean $processedWithConfirmation
 * @property string $errorText
 * @property string $hotelReplyText
 * @property string $supplierType
 * @property string $reservationStatusCode
 * @property boolean $existingItinerary
 * @property int $numberOfRoomsBooked
 * @property string $drivingDirections
 * @property string $checkInInstructions
 * @property DateTime $arrivalDate
 * @property DateTime $departureDate
 * @property string $hotelName
 * @property string $hotelAddress
 * @property string $hotelCity
 * @property string $hotelStateProvinceCode
 * @property string $hotelCountryCode
 * @property string $hotelPostalCode
 * @property string $roomDescription
 * @property int $rateOccupancyPerRoom
 * @property EANRoomGroup $roomGroup
 * @property EANRateInfos $rateInfos
 * @property EANError $error
 */
class EANResponseRoomReservation extends EANAbstractSupportModel implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomReservationResponse';
	
	/**
	 * Confirmed
	 * @var string
	 */
	const STATUS_CF = 'CF';
	
	/**
	 * Cancelled
	 * @var string
	 */
	const STATUS_CX = 'CX';
	
	/**
	 * Unconfirmed. Cancel these bookings and message them as "inventory unavailable" to the customer. EAN may continue to try to process the booking if left alone.
	 * @var string
	 */
	const STATUS_UC = 'UC';
	
	/**
	 * Pending Supplier. Agent will follow up with customer when confirmation number is available.
	 * @var string
	 */
	const STATUS_PS = 'PS';
	
	/**
	 * Error. Agent attention needed. Agent will follow up.
	 * @var string
	 */
	const STATUS_ER = 'ER';
	
	/**
	 * Deleted Itinerary. Usually a test or failed booking.
	 * @var string
	 */
	const STATUS_DT = 'DT';
	
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
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	protected $customerSessionId;
	
	/**
	 * @var int
	 */
	protected $itineraryId;
	
	/**
	 * @var string[]
	 */
	protected $confirmationNumbers;
	
	/**
	 * @var boolean
	 */
	protected $processedWithConfirmation;
	
	/**
	 * @var string
	 */
	protected $errorText;
	
	/**
	 * @var string
	 */
	protected $hotelReplyText;
	
	/**
	 * @var string
	 */
	protected $supplierType;
	
	/**
	 * @var string
	 */
	protected $reservationStatusCode;
	
	/**
	 * @var boolean
	 */
	protected $existingItinerary;
	
	/**
	 * @var int
	 */
	protected $numberOfRoomsBooked;
	
	/**
	 * @var string
	 */
	protected $drivingDirections;
	
	/**
	 * @var string
	 */
	protected $checkInInstructions;
	
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
	protected $hotelName;
	
	/**
	 * @var string
	 */
	protected $hotelAddress;
	
	/**
	 * @var string
	 */
	protected $hotelCity;
	
	/**
	 * @var string
	 */
	protected $hotelStateProvinceCode;
	
	/**
	 * @var string
	 */
	protected $hotelCountryCode;
	
	/**
	 * @var string
	 */
	protected $hotelPostalCode;
	
	/**
	 * @var string
	 */
	protected $roomDescription;
	
	/**
	 * @var int
	 */
	protected $rateOccupancyPerRoom;
	
	/**
	 * @var EANRoomGroup
	 */
	protected $roomGroup;
	
	/**
	 * @var EANRateInfos
	 */
	protected $rateInfos;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'itineraryId' => 'int',
		'confirmationNumbers' => 'array',
		'processedWithConfirmation' => 'boolean',
		'errorText' => 'string',
		'hotelReplyText' => 'string',
		'supplierType' => 'string',
		'reservationStatusCode' => 'string',
		'existingItinerary' => 'boolean',
		'numberOfRoomsBooked' => 'int',
		'drivingDirections' => 'string',
		'checkInInstructions' => 'string',
		'arrivalDate' => 'DateTime',
		'departureDate' => 'DateTime',
		'hotelName' => 'string',
		'hotelAddress' => 'string',
		'hotelCity' => 'string',
		'hotelStateProvinceCode' => 'string',
		'hotelCountryCode' => 'string',
		'hotelPostalCode' => 'string',
		'roomDescription' => 'string',
		'rateOccupancyPerRoom' => 'int',
		'roomGroup' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomGroup',
		'rateInfos' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRateInfos',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseRoomReservation $supportModel
	 * @return EANResponseRoomReservation
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * Checks if the given 3-letter value is a valid supplier type.
	 * @param string $value
	 * @return boolean
	 */
	public static function isSupplierType($value) {
		return defined('static::SUPPLIER_'.$value) && constant('static::SUPPLIER_'.$value) === $value;
	}
	
	/**
	 * Checks if the given status is a valid constant's value.
	 * @param string $value
	 * @return boolean
	 */
	public static function isStatus($value) {
		return defined('static::STATUS_'.$value) && constant('static::STATUS_'.$value) === $value;
	}
	
	protected function get__customerSessionId() {
		return $this->customerSessionId;
	}
	
	protected function get__itineraryId() {
		return $this->itineraryId;
	}
	
	protected function get__confirmationNumbers() {
		return $this->confirmationNumbers;
	}
	
	protected function set__confirmationNumbers($mixed) {
		if ( !isset($this->confirmationNumbers) || !is_array($this->confirmationNumbers) ) {
			$this->confirmationNumbers = array();
		}
		if ( Utils::isIterable($mixed) ) {
			foreach ( $mixed as $value ) {
				$value = (string) $value;
				if ( $value ) {
					array_push($this->confirmationNumbers,$value);
				}
			}
		} else {
			array_push($this->confirmationNumbers,(string) $mixed);
		}
	}
	
	protected function get__processedWithConfirmation() {
		return $this->processedWithConfirmation;
	}
	
	protected function set__processedWithConfirmation($value) {
		$this->processedWithConfirmation = Utils::anyToBoolean($value);
	}
	
	protected function get__errorText() {
		return $this->errorText;
	}
	
	protected function get__hotelReplyText() {
		return $this->hotelReplyText;
	}
	
	protected function get__supplierType() {
		return $this->supplierType;
	}
	
	protected function set__supplierType($value) {
		$value = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $value)),0,256);
		if ( static::isSupplierType($value) ) {
			$this->supplierType = $value;
		}
	}
	
	protected function get__reservationStatusCode() {
		return $this->reservationStatusCode;
	}
	
	protected function set__reservationStatusCode($value) {
		$value = strtoupper((string) $value);
		if ( static::isStatus($value) ) {
			$this->reservationStatusCode = $value;
		}
	}
	
	protected function get__existingItinerary() {
		return $this->existingItinerary;
	}
	
	protected function set__existingItinerary($value) {
		$this->existingItinerary = Utils::anyToBoolean($value);
	}
	
	protected function get__numberOfRoomsBooked() {
		return $this->numberOfRoomsBooked;
	}
	
	protected function get__drivingDirections() {
		return $this->drivingDirections;
	}
	
	protected function get__checkInInstructions() {
		return $this->checkInInstructions;
	}
	
	protected function get__arrivalDate() {
		if ( isset($this->arrivalDate) ) {
			return clone $this->arrivalDate;
		}
		return null;
	}
	
	protected function set__arrivalDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->arrivalDate = new DateTime($date);
	}
	
	protected function get__departureDate() {
		if ( isset($this->departureDate) ) {
			return clone $this->departureDate;
		}
		return null;
	}
	
	protected function set__departureDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->departureDate = new DateTime($date);
	}
	
	protected function get__hotelName() {
		return $this->hotelName;
	}
	
	protected function get__hotelAddress() {
		return $this->hotelAddress;
	}
	
	protected function get__hotelCity() {
		return $this->hotelCity;
	}
	
	protected function get__hotelStateProvinceCode() {
		return $this->hotelStateProvinceCode;
	}
	
	protected function get__hotelCountryCode() {
		return $this->hotelCountryCode;
	}
	
	protected function get__hotelPostalCode() {
		return $this->hotelPostalCode;
	}
	
	protected function get__roomDescription() {
		return $this->roomDescription;
	}
	
	protected function get__rateOccupancyPerRoom() {
		return $this->rateOccupancyPerRoom;
	}
	
	protected function get__roomGroup() {
		if ( isset($this->roomGroup) ) {
			return clone $this->roomGroup;
		}
		return null;
	}
	
	protected function get__rateInfos() {
		if ( isset($this->rateInfos) ) {
			return clone $this->rateInfos;
		}
		return null;
	}
	
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	/**
	 * TODO: get__xml
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::get__xml()
	 */
	protected function get__xml() {
		return $this->xml;
	}
	
	/**
	 * TODO: asXML
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::asXML()
	 */
	public function asXML() {
		return parent::asXML();
	}
	
}
