<?php

namespace zamnuts\EANAPIClient\Query;

use zamnuts\EANAPIClient\Util\Utils;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelInformation;
use zamnuts\EANAPIClient\Query\HotelItinerary\EANItineraryQueryObject;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelItinerary;

/**
 * @property int $itineraryId
 * @property string $affiliateConfirmationId
 * @property string $email
 * @property string $lastName
 * @property string $creditCardNumber
 * @property boolean $resendConfirmationEmail
 * @property EANItineraryQueryObject $itineraryQuery
 * @property string $confirmationExtras A comma-delimited string of registered extras.
 * @property string[] $confirmationExtrasArray An array of registered extras.
 * @property EANResponseHotelItinerary $response Yea, the response. OK?
 */
class EANHotelItinerary extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'itin';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelItineraryRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseHotelItinerary';
	
	/**
	 * @var int
	 */
	protected $itineraryId;
	
	/**
	 * @var string
	 */
	protected $affiliateConfirmationId;
	
	/**
	 * @var string
	 */
	protected $email;
	
	/**
	 * @var string
	 */
	protected $lastName;
	
	/**
	 * @var string
	 */
	protected $creditCardNumber;
	
	/**
	 * @var string[]
	 */
	protected $confirmationExtras;
	
	/** 
	 * @var boolean
	 */
	protected $resendConfirmationEmail;
	
	/**
	 * @var EANItineraryQueryObject
	 */
	protected $itineraryQuery;
	
	/**
	 * @var EANResponseHotelItinerary
	 */
	protected $response;
	
	protected static $propertyMap = array(
		'itineraryId' => 'int',
		'affiliateConfirmationId' => 'string',
		'email' => 'string',
		'lastName' => 'string',
		'creditCardNumber' => 'string',
		'confirmationExtras' => 'string',
		'resendConfirmationEmail' => 'boolean',
		'itineraryQuery' => 'EANItineraryQueryObject'
	);
	
	/**
	 * @param string $itineraryId
	 * @param string $email
	 */
	public function __construct($itineraryId=null,$email=null) {
		parent::__construct();
			if ( isset($itineraryId) ) {
			$this->set__itineraryId($itineraryId);
		}
			if ( isset($email) ) {
			$this->set__email($email);
		}
	}
	
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
				case 'EANItineraryQueryObject':
					$propObject = ucfirst($property);
					$subProps = $this->$propObject->getRequestArray();
					foreach ( $subProps as $subProp => $value ) {
						$this->xmlRequest->$propObject->$subProp = (string) $value;
					}
					break;
			}
		}
	}
	
	
	/**
	 * @return EANResponseHotelInformation
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
	
	protected function get__affiliateConfirmationId() {
		return $this->affiliateConfirmationId;
	}
	
	protected function set__affiliateConfirmationId($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->affiliateConfirmationId = $value;
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
	
	protected function get__lastName() {
		return $this->lastName;
	}
	
	protected function set__lastName($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->lastName = $value;
		}
	}
	
	protected function get__creditCardNumber() {
		return $this->creditCardNumber;
	}
	
	protected function set__creditCardNumber($value) {
		$value = (string) $value;
		if ( $value ) {
			$this->creditCardNumber = $value;
		}
	}
	
	protected function get__resendConfirmationEmail() {
		return $this->resendConfirmationEmail;
	}
	
	protected function set__resendConfirmationEmail($value) {
		$this->resendConfirmationEmail = Utils::anyToBoolean($value);
	}
	
	public function get__itineraryQuery() {
		if ( isset($this->itineraryQuery) ) {
			return $this->itineraryQuery;
		}
		return new EANItineraryQueryObject();
	}
	
	public function set__itineraryQuery($value) {
		if ( $value instanceof EANItineraryQueryObject ) {
			$this->itineraryQuery = $value;
		}
	}
	
	// Confirmation Extras
	protected function get__confirmationExtras() {
		return implode(',',$this->get__confirmationExtrasArray());
	}

	protected function set__confirmationExtras($value) {
		$value = (string) $value;
		$array = explode(',',$value);
		foreach ( $array as $option ) {
			$this->includeConfirmationExtra($option);
		}
	}
	
	protected function get__confirmationExtrasArray() {
		return $this->confirmationExtras;
	}
	
	protected function set__confirmationExtrasArray($value) {
		foreach ( $value as $extra ) {
			$this->includeConfirmationExtra($extra);
		}
	}
	
	/**
	 * Clears all confirmation extras.
	 * @return array Returns an array of the old confirmation extras that were defined before they were removed.
	 */
	public function clearConfirmationExtras() {
		$old = array();
		if ( isset($this->confirmationExtras) && is_array($this->confirmationExtras) ) {
			$old = $this->confirmationExtras;
		}
		$this->confirmationExtras = array();
		return $old;
	}
	
	/**
	 * Note: If the default option exists, it is removed.
	 * @param string $extra
	 * @see http://developer.ean.com/general-info/confirmation-extras/
	 */
	public function includeConfirmationExtra($extra) {
		$extra = strtoupper((string) $extra);
		array_push($this->confirmationExtras,$extra);
		$this->confirmationExtras = array_unique($this->confirmationExtras,SORT_STRING);
	}
	
	/**
	 * @param string $extra
	 * @see http://developer.ean.com/general-info/confirmation-extras/
	 */
	public function excludeConfirmationExtra($extra) {
		$extra = strtoupper((string) $extra);
		$keys = array_keys($this->confirmationExtras,$extra,true);
		foreach ( $keys as $key ) {
			unset($this->confirmationExtras[$key]);
		}
		$this->confirmationExtras = array_values($this->confirmationExtras);
	}
	
}
