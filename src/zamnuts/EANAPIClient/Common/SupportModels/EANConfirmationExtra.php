<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read string $name
 * @property-read string $value
 */
class EANConfirmationExtra extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'ConfirmationExtra';
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var string
	 */
	protected $value;
		
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'name' => 'string',
		'value' => 'string'
	);
	
	/**
	 * @param EANConfirmationExtra $supportModel
	 * @return EANConfirmationExtra
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__name() {
		return $this->name;
	}
	
	protected function get__value() {
		return $this->value;
	}
		
}
