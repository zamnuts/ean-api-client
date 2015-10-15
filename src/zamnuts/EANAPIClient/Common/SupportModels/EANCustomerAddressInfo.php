<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property string $city
 * @property string $stateProvinceCode
 * @property string $countryCode
 * @property string $postalCode
 * @property string $isPrimary
 * @property string $type
 */
class EANCustomerAddressInfo extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'CustomerAddresses';
	
	/**
	 * @var string
	 */
	protected $address1;
	
	/**
	 * @var string
	 */
	protected $address2;
	
	/**
	 * @var string
	 */
	protected $address3;
	
	/**
	 * @var string
	 */
	protected $city;
	
	/**
	 * @var string
	 */
	protected $stateProvinceCode;
	
	/**
	 * @var string
	 */
	protected $countryCode;
	
	/**
	 * @var string
	 */
	protected $postalCode;
	
	/**
	 * @var boolean
	 */
	protected $isPrimary;
	
	/**
	 * @var int
	 */
	protected $type;
	
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
		'postalCode' => 'string',
		'isPrimary' => 'boolean',
		'type' => 'int'
	);
	
	/**
	 * @param EANCustomerInfo $supportModel
	 * @return EANCustomerInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__address1() {
		return $this->address1;
	}
	
	protected function get__address2() {
		return $this->address2;
	}
	
	protected function get__address3() {
		return $this->address3;
	}
	
	protected function get__city() {
		return $this->city;
	}
	
	protected function get__stateProvinceCode() {
		return $this->stateProvinceCode;
	}
	
	protected function get__countryCode() {
		return $this->countryCode;
	}
	
	protected function get__postalCode() {
		return $this->postalCode;
	}
	
	protected function get__isPrimary() {
		return $this->isPrimary;
	}
	
	protected function get__type() {
		return $this->type;
	}
	
}
