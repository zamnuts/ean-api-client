<?php

namespace zamnuts\EANAPIClient\Query;

use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelRoomCancellation;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelInformation;

/**
 * @property int $itineraryId The EAN itinerary ID provided at the time of the reservation.
 * @property string $email The email address that was provided at the time of the reservation.
 * @property string $confirmationNumber The confirmation number for the room to be cancelled.
 * @property string $reason Optional reason code (use one of the REASON_* constants).
 * @property EANResponseHotelInformation $response Yea, the response. OK?
 */
class EANHotelRoomCancellation extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'cancel';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomCancellationRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseHotelRoomCancellation';
	
	/**
	 * Hotel asked me to cancel
	 * @var string
	 */
	const REASON_HOC = 'HOC';
	
	/**
	 * Change of plans
	 * @var string
	 */
	const REASON_COP = 'COP';
	
	/**
	 * Found a better price
	 * @var string
	 */
	const REASON_FBP = 'FBP';
	
	/**
	 * Found a better hotel
	 * @var string
	 */
	const REASON_FBH = 'FBH';
	
	/**
	 * Decided to cancel my plans
	 * @var string
	 */
	const REASON_CNL = 'CNL';
	
	/**
	 * Rather not say
	 * @var string
	 */
	const REASON_NSY = 'NSY';
	
	/**
	 * Other
	 * @var string
	 */
	const REASON_OTH = 'OTH';
	
	/**
	 * Reason constant to reason literal lookup table (English by default).
	 * @var mixed[string]
	 */
	public static $REASON_TABLE = array(
		'HOC' => 'Hotel asked me to cancel',
		'COP' => 'Change of plans',
		'FBP' => 'Found a better price',
		'FBH' => 'Found a better hotel',
		'CNL' => 'Decided to cancel my plans',
		'NSY' => 'Rather not say',
		'OTH' => 'Other'
	);
	
	/**
	 * @var int
	 */
	protected $itineraryId;
	
	/**
	 * @var string
	 */
	protected $email;
	
	/**
	 * @var string
	 */
	protected $confirmationNumber;
	
	/**
	 * @var string
	 */
	protected $reason;
	
	/**
	 * @var EANResponseHotelRoomCancellation
	 */
	protected $response;
	
	protected static $propertyMap = array(
		'itineraryId' => 'int',
		'email' => 'string',
		'confirmationNumber' => 'string',
		'reason' => 'string'
	);
	
	protected function prepareRequest() {
		foreach ( self::$propertyMap as $property => $type ) {
			if ( !isset($this->$property) ) {
				continue;
			}
			switch ( $type ) {
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
	 * @return EANResponseHotelRoomCancellation
	 */
	protected function get__response() {
		if ( isset($this->response) ) {
			return clone $this->response;
		}
		return null;
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
	
	protected function get__email() {
		return $this->email;
	}
	
	protected function set__email($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->email = $value;
		}
	}
	
	protected function get__confirmationNumber() {
		return $this->confirmationNumber;
	}
	
	protected function set__confirmationNumber($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->confirmationNumber = $value;
		}
	}
	
	protected function get__reason() {
		return $this->reason;
	}

	protected function set__reason($value) {
		$value = strtoupper((string) $value);
		if ( $this->isReason($value) ) {
			$this->reason = $value;
		}
	}
	
	/**
	 * Checks if the given reason is a valid constant's value.
	 * @param string $reason
	 * @return boolean
	 */
	public function isReason($reason) {
		return defined('static::REASON_'.$reason) && constant('REASON_'.$reason) === $reason;
	}
	
}
