<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;

/**
 * @property int $supplierId
 * @property string $chainCode
 * @property string $creditCardType
 * @property DateTime $arrivalDate
 * @property DateTime $departureDate
 * @property string $confirmationNumber
 * @property string $cancellationNumber
 * @property int $numberOfAdults
 * @property int $numberOfChildren
 * @property string $affiliateConfirmationId
 * @property string $smokingPreference
 * @property string $supplierPropertyId
 * @property string $roomType
 * @property string $rateType
 * @property string $rateDescription
 * @property string $roomDescription
 * @property string $status
 * @property string $locale
 * @property int $nights
 * @property EANGenericRefund $genericRefund
 * @property EANRateInfos $rateInfos
 * @property EANReservationGuest $reservationGuest
 * @property EANConfirmationExtras $confirmationExtras
 * @property EANHotelConfirmationDetails[] $details
 */
class EANHotelConfirmation extends EANAbstractGroup implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelConfirmation';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelConfirmationDetails';
	
	/**
	 * Expedia Collect hotels
	 * @var int
	 */
	const SUPPLIER_ECH = 2;
	
	/**
	 * Sabre hotels
	 * @var int
	 */
	const SUPPLIER_SBH = 3;
	
	/**
	 * Expedia Collect condos
	 * @var int
	 */
	const SUPPLIER_ECC = 9;
	
	/**
	 * Worldspan hotels
	 * @var int
	 */
	const SUPPLIER_WSH = 10;
	
	/**
	 * Expedia.com properties
	 * @var int
	 */
	const SUPPLIER_ECP = 13;
	
	/**
	 * Venere.com properties
	 * @var int
	 */
	const SUPPLIER_VCP = 14;
	
	/**
	 * List of possible SUPPLIER_* const values.
	 * @var int[]
	 */
	public static $supplierTypes = array(
		'ECH' => 2,
		'SBH' => 3,
		'ECC' => 9,
		'WSH' => 10,
		'ECP' => 13,
		'VCP' => 14
	);
	
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
	 * @var int
	 */
	protected $supplierId;
	
	/**
	 * @var string
	 */
	protected $chainCode;
	
	/**
	 * @var string
	 */
	protected $creditCardType;
	
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
	protected $confirmationNumber;
	
	/**
	 * @var string
	 */
	protected $cancellationNumber;
	
	/**
	 * @var int
	 */
	protected $numberOfAdults;
	
	/**
	 * @var int
	 */
	protected $numberOfChildren;
	
	/**
	 * @var string
	 */
	protected $affiliateConfirmationId;
	
	/**
	 * @var string
	 */
	protected $smokingPreference;
	
	/**
	 * @var string
	 */
	protected $supplierPropertyId;
	
	/**
	 * @var string
	 */
	protected $roomType;
	
	/**
	 * @var string
	 */
	protected $rateType;
	
	/**
	 * @var string
	 */
	protected $rateDescription;
	
	/**
	 * @var string
	 */
	protected $roomDescription;
	
	/**
	 * @var string
	 */
	protected $status;
	
	/**
	 * @var string
	 */
	protected $locale;
	
	/**
	 * @var int
	 */
	protected $nights;
	
	/**
	 * @var EANGenericRefund
	 */
	protected $genericRefund;
	
	/**
	 * @var EANRateInfos
	 */
	protected $rateInfos;
	
	/**
	 * @var EANReservationGuest
	 */
	protected $reservationGuest;
	
	/**
	 * @var EANConfirmationExtras
	 */
	protected $confirmationExtras;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'supplierId' => 'int',
		'chainCode' => 'string',
		'creditCardType' => 'string',
		'arrivalDate' => 'DateTime',
		'departureDate' => 'DateTime',
		'confirmationNumber' => 'string',
		'cancellationNumber' => 'string',
		'numberOfAdults' => 'int',
		'numberOfChildren' => 'int',
		'affiliateConfirmationId' => 'string',
		'smokingPreference' => 'string',
		'supplierPropertyId' => 'string',
		'roomType' => 'string',
		'rateType' => 'string',
		'rateDescription' => 'string',
		'roomDescription' => 'string',
		'status' => 'string',
		'locale' => 'string',
		'nights' => 'int',
		'genericRefund' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANGenericRefund',
		'rateInfos' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRateInfos',
		'reservationGuest' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANReservationGuest',
		'confirmationExtras' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANConfirmationExtras'
	);
	
	/**
	 * @param EANHotelConfirmation $supportModel
	 * @return EANHotelConfirmation
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
	 * Look up a supplier type 3-letter value by a given supplier ID.
	 * @param int $value
	 * @return string
	 */
	public static function lookupSupplierTypeById($value) {
		$keys = array_keys(static::$supplierTypes,(int) $value,true);
		if ( isset($keys[0]) && static::isSupplierType($keys[0]) ) {
			return $keys[0];
		}
		return null;
	}
	
	/**
	 * Checks if the given status is a valid constant's value.
	 * @param string $value
	 * @return boolean
	 */
	public static function isStatus($value) {
		return defined('static::STATUS_'.$value) && constant('static::STATUS_'.$value) === $value;
	}
	
	protected function get__supplierId() {
		return $this->supplierId;
	}
	
	protected function set__supplierId($value) {
		if ( is_numeric($value) ) {
			$this->supplierId = static::lookupSupplierTypeById($value);
		} else {
			$value = strtoupper((string) $value);
			if ( static::isSupplierType($value) ) {
				$this->supplierId = $value;
			}
		}
	}
	
	protected function get__chainCode() {
		return $this->chainCode;
	}
	
	protected function get__creditCardType() {
		return $this->creditCardType;
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
	
	protected function get__confirmationNumber() {
		return $this->confirmationNumber;
	}
	
	protected function get__cancellationNumber() {
		return $this->cancellationNumber;
	}
	
	protected function get__numberOfAdults() {
		return $this->numberOfAdults;
	}
	
	protected function get__numberOfChildren() {
		return $this->numberOfChildren;
	}
	
	protected function get__affiliateConfirmationId() {
		return $this->affiliateConfirmationId;
	}
	
	protected function get__smokingPreference() {
		return $this->smokingPreference;
	}
	
	protected function set__smokingPreference($value) {
		$value = strtoupper((string) $value);
		if ( $value === 'N' ) {
			$value = 'NS';
		} else if ( $value === 'Y' ) {
			$value = 'S';
		}
		$this->smokingPreference = $value;
	}
	
	protected function get__supplierPropertyId() {
		return $this->supplierPropertyId;
	}
	
	protected function get__roomType() {
		return $this->roomType;
	}
	
	protected function get__rateType() {
		return $this->rateType;
	}
	
	protected function get__rateDescription() {
		return $this->rateDescription;
	}
	
	protected function get__roomDescription() {
		return $this->roomDescription;
	}
	
	protected function get__status() {
		return $this->status;
	}
	
	protected function set__status($value) {
		$value = strtoupper((string) $value);
		if ( static::isStatus($value) ) {
			$this->status = $value;
		}
	}
	
	protected function get__locale() {
		return $this->locale;
	}
	
	protected function get__nights() {
		return $this->nights;
	}
	
	protected function get__genericRefund() {
		if ( isset($this->genericRefund) ) {
			return clone $this->genericRefund;
		}
		return null;
	}
	
	protected function get__rateInfos() {
		if ( isset($this->rateInfos) ) {
			return clone $this->rateInfos;
		}
		return null;
	}
	
	protected function get__reservationGuest() {
		if ( isset($this->reservationGuest) ) {
			return clone $this->reservationGuest;
		}
		return null;
	}
	
	protected function get__confirmationExtras() {
		if ( isset($this->confirmationExtras) ) {
			return clone $this->confirmationExtras;
		}
		return null;
	}
	
	/**
	 * @return EANHotelConfirmationDetails[]
	 */
	protected function get__details() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelConfirmationDetails $details
	 * @return boolean
	 */
	public function addDetails(EANHotelConfirmationDetails $details) {
		return $this->addItem($details);
	}
	
	/**
	 * @param EANHotelConfirmationDetails $details
	 * @return boolean
	 */
	public function removeDetails(EANHotelConfirmationDetails $details) {
		return $this->removeItem($details);
	}
	
}
