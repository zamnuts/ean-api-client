<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;

/**
 * @property string $creditCardType
 * @property string $creditCardNumber
 * @property string $creditCardIdentifier
 * @property string $creditCardExpirationMonth
 * @property string $creditCardExpirationYear
 */
class EANReservationInfo extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'ReservationInfo';
	
	/**
	 * @var string
	 */
	public $email;
	
	/**
	 * @var string
	 */
	public $firstName;
	
	/**
	 * @var string
	 */
	public $lastName;
	
	/**
	 * @var string
	 */
	public $homePhone;
	
	/**
	 * @var string
	 */
	public $workPhone;
	
	/**
	 * @var string
	 */
	public $extension;
	
	/**
	 * @var string
	 */
	public $faxPhone;
	
	/**
	 * @var string
	 */
	public $companyName;
	
	/**
	 * @var string
	 */
	protected $creditCardType;
	
	/**
	 * @var string
	 */
	protected $creditCardNumber;
	
	/**
	 * @var string
	 */
	protected $creditCardIdentifier;
	
	/**
	 * @var string
	 */
	protected $creditCardExpirationMonth;
	
	/**
	 * @var string
	 */
	protected $creditCardExpirationYear;
	
	// TODO implement $emailItineraryAddresses see http://developer.ean.com/docs/book-reservation/#emailItineraryList
	//public $emailItineraryAddresses;
	
	/**
	 * @var string
	 */
	public $creditCardPasHttpUserAgent;
	
	/**
	 * @var string
	 */
	public $creditCardPasHttpAccept;
	
	/**
	 * @var string
	 */
	public $creditCardPasPaRes;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'email' => 'string',
		'firstName' => 'string',
		'lastName' => 'string',
		'homePhone' => 'string',
		'workPhone' => 'string',
		'extension' => 'string',
		'faxPhone' => 'string',
		'companyName' => 'string',
		'creditCardType' => 'string',
		'creditCardNumber' => 'string',
		'creditCardIdentifier' => 'string',
		'creditCardExpirationMonth' => 'string',
		'creditCardExpirationYear' => 'string',
		//'emailItineraryAddresses' => 'string',
		'creditCardPasHttpUserAgent' => 'string',
		'creditCardPasHttpAccept' => 'string',
		'creditCardPasPaRes' => 'string'
	);
	
	/**
	 * @param EANReservationInfo $supportModel
	 * @return EANReservationInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__creditCardType() {
		return $this->creditCardType;
	}
	
	protected function set__creditCardType($value) {
		$value = strtoupper((string) $value);
		if ( $value ) {
			$this->creditCardType = $value;
		}
	}
	
	protected function get__creditCardNumber() {
		return $this->creditCardNumber;
	}
	
	protected function set__creditCardNumber($value) {
		$value = preg_replace('/[^0-9]/','',(string) $value);
		if ( $value ) {
			$this->creditCardNumber = $value;
		}
	}
	
	protected function get__creditCardIdentifier() {
		return $this->creditCardIdentifier;
	}
	
	protected function set__creditCardIdentifier($value) {
		$value = preg_replace('/[^0-9]/','',(string) $value);
		if ( $value ) {
			$this->creditCardIdentifier = $value;
		}
	}
	
	protected function get__creditCardExpirationMonth() {
		return $this->creditCardExpirationMonth;
	}
	
	protected function set__creditCardExpirationMonth($value) {
		$value = preg_replace('/[^0-9]/','',(string) $value);
		$date = DateTime::createFromFormat('m',$value);
		if ( $date ) {
			$this->creditCardExpirationMonth = $date->format('m');
		}
	}
	
	protected function get__creditCardExpirationYear() {
		return $this->creditCardExpirationYear;
	}
	
	protected function set__creditCardExpirationYear($value) {
		$value = preg_replace('/[^0-9]/','',(string) $value);
		$date = DateTime::createFromFormat('Y',$value);
		if ( $date ) {
			$this->creditCardExpirationYear = $date->format('Y');
		}
	}
	
}
