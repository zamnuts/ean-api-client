<?php

namespace zamnuts\EANAPIClient\Query;
use zamnuts\EANAPIClient\Common\SupportModels\EANResponseHotelPayment;

/**
 * @property int $hotelId The EAN ID of the hotel.
 * @property string $supplierType
 * @property string $rateType
 * @property EANResponseHotelPayment $response Yea, the response. OK?
 */
class EANPaymentTypes extends EANAbstractQuery {
	
	/**
	 * @var string
	 */
	protected static $API_METHOD = 'paymentInfo';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelPaymentRequest';
	
	/**
	 * @var string
	 */
	protected static $RESPONSE_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANResponseHotelPayment';
	
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
	 * Standard pre-pay Expedia property.
	 * @var string
	 */
	const RATE_TYPE_MERCHANTSTANDARD = 'MerchantStandard';
	
	/**
	 * Post-payed third-party property.
	 * @var string
	 */
	const RATE_TYPE_DIRECTAGENCY = 'DirectAgency';
	
	/**
	 * @var int
	 */
	protected $hotelId;
		
	/**
	 * @var string
	 */
	protected $supplierType;
	
	/**
	 * @var string
	 */
	protected $rateType;
	
	/**
	 * @var EANResponseHotelPayment
	 */
	protected $response;
	
	protected static $propertyMap = array(
		'hotelId' => 'int',
		'supplierType' => 'string',
		'rateType' => 'string'
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
				case 'int':
				case 'float':
				case 'string':
					if ( method_exists($this,'get__'.$property) ) {
						$this->xmlRequest->$property = $this->{'get__'.$property}();
					} else {
						$this->xmlRequest->$property = (string) $this->$property;
					}
					break;
			}
		}
	}
	
	/**
	 * @return EANResponseHotelPayment
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
	
	// Supplier Type
	protected function get__supplierType() {
		return $this->supplierType;
	}
	
	protected function set__supplierType($value) {
		$value = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $value)),0,256);
		$constStr = 'self::SUPPLIER_TYPE_'.$value;
		if ( defined($constStr) ) {
			$this->supplierType = constant($constStr);
		} else {
			$this->supplierType = null;
		}
	}
	
	// Rate Type
	protected function get__rateType() {
		return $this->rateType;
	}
	
	protected function set__rateType($value) {
		$value = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $value)),0,256);
		$constStr = 'self::RATE_TYPE_'.$value;
		if ( defined($constStr) ) {
			$this->rateType = constant($constStr);
		} else {
			$this->rateType = null;
		}
	}
	
}
