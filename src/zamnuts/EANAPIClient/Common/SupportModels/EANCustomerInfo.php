<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $homePhone
 * @property string $workPhone
 * @property string $extension
 * @property string $faxPhone
 * @property-read EANCustomerAddressInfo $address
 */
class EANCustomerInfo extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Customer';
	
	/**
	 * @var string
	 */
	protected $email;
	
	/**
	 * @var string
	 */
	protected $firstName;
	
	/**
	 * @var string
	 */
	protected $lastName;
	
	/**
	 * @var string
	 */
	protected $homePhone;
	
	/**
	 * @var string
	 */
	protected $workPhone;
	
	/**
	 * @var string
	 */
	protected $extension;
	
	/**
	 * @var string
	 */
	protected $faxPhone;
	
	/**
	 * @var EANCustomerAddressInfo
	 */
	protected $address;
	
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
		'address' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANCustomerAddressInfo',
	);
	
	/**
	 * @param EANCustomerInfo $supportModel
	 * @return EANCustomerInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__email() {
		return $this->email;
	}
	
	protected function get__firstName() {
		return $this->firstName;
	}
	
	protected function get__lastName() {
		return $this->lastName;
	}
	
	protected function get__homePhone() {
		return $this->homePhone;
	}
	
	protected function get__workPhone() {
		return $this->workPhone;
	}
	
	protected function get__extension() {
		return $this->extension;
	}
	
	protected function get__faxPhone() {
		return $this->faxPhone;
	}
	
	protected function get__address() {
		if ( isset($this->address) ) {
			return clone $this->address;
		}
		return null;
	}
	
}
