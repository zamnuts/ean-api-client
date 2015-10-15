<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

class EANReservationAddress extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'AddressInfo';
	
	/**
	 * @var string
	 */
	public $address1;
	
	/**
	 * @var string
	 */
	public $address2;
	
	/**
	 * @var string
	 */
	public $address3;
	
	/**
	 * @var string
	 */
	public $city;
	
	/**
	 * @var string
	 */
	public $stateProvinceCode;
	
	/**
	 * @var string
	 */
	public $countryCode;
	
	/**
	 * @var string
	 */
	public $postalCode;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'address1' => 'string',
		'address2' => 'string',
		'address3' => 'string',
		'city' => 'string',
		'stateProvinceCode' => 'string',
		'countryCode' => 'string',
		'postalCode' => 'string'
	);
	
	/**
	 * @param EANReservationAddress $supportModel
	 * @return EANReservationAddress
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
}
