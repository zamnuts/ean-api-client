<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read string $firstName
 * @property-read string $lastName
 */
class EANReservationGuest extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'ReservationGuest';
	
	/**
	 * @var string
	 */
	protected $firstName;
	
	/**
	 * @var string
	 */
	protected $lastName;
		
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'firstName' => 'string',
		'lastName' => 'string'
	);
	
	/**
	 * @param EANReservationGuest $supportModel
	 * @return EANReservationGuest
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__firstName() {
		return $this->firstName;
	}
	
	protected function get__lastName() {
		return $this->lastName;
	}
		
}
