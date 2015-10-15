<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;
use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\XMLUtils;

/**
 * @property DateTime $arrivalDate
 * @property DateTime $departureDate
 * @property string $checkInInstructions
 * @property EANHotelRoom[] $rooms
 * @property EANError $error
 */
class EANResponseRoomAvailability extends EANAbstractGroup implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomAvailabilityResponse';
	
	/**
	 * @var string
	 */
	protected static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelRoom';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public $customerSessionId;
	
	/**
	 * @var int
	 */
	public $hotelId;
	
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
	public $hotelName;
	
	/**
	 * @var string
	 */
	public $hotelAddress;
	
	/**
	 * @var string
	 */
	public $hotelCity;
	
	/**
	 * @var string
	 */
	public $hotelStateProvince;
	
	/**
	 * @var string
	 */
	public $hotelCountry;
	
	/**
	 * @var int
	 */
	public $numberOfRoomsRequested;
	
	/**
	 * @var string
	 */
	protected $checkInInstructions;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'hotelId' => 'int',
		'arrivalDate' => 'DateTime',
		'departureDate' => 'DateTime',
		'hotelName' => 'string',
		'hotelAddress' => 'string',
		'hotelCity' => 'string',
		'hotelStateProvince' => 'string',
		'hotelCountry' => 'string',
		'numberOfRoomsRequested' => 'int',
		'checkInInstructions' => 'string',
		'rooms' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelRoom',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseRoomAvailability $supportModel
	 * @return EANResponseRoomAvailability
	 */
	public static function cast($supportModel) {
		return $supportModel;
		}
	
	// Arrival Date
	protected function get__arrivalDate() {
		return clone $this->arrivalDate;
	}
	
	protected function set__arrivalDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->arrivalDate = new DateTime($date);
	}
	
	// Departure Date
	protected function get__departureDate() {
		return clone $this->departureDate;
	}
	
	protected function set__departureDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->departureDate = new DateTime($date);
	}
	
	// Check-In Instructions
	protected function get__checkInInstructions() {
		return $this->checkInInstructions;
	}
	
	protected function set__checkInInstructions($value) {
		$this->checkInInstructions = XMLUtils::tidyPartialHTMLToString($value,true);
	}
		
	// Error
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	// Rooms
	/**
	 * @return EANHotelRoom[]
	 */
	protected function get__rooms() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelRoom $room
	 * @return boolean
	 */
	public function addRoom(EANHotelRoom $room) {
		return $this->addItem($room);
	}
	
	/**
	 * @param EANHotelRoom $room
	 * @return boolean
	 */
	public function removeRoom(EANHotelRoom $room) {
		return $this->removeItem($room);
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
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractGroup::loadXML()
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		parent::loadXML($xml);
	}
	
}
