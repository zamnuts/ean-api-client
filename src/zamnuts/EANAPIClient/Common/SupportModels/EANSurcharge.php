<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

class EANSurcharge extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Surcharge';
	
	/**
	 * @var string
	 */
	public $type;
	
	/**
	 * @var float
	 */
	public $amount;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'type' => 'string',
		'amount' => 'float'
	);
	
	/**
	 * @param EANSurcharge $supportModel
	 * @return EANSurcharge
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * Get the interpreted string value for $type.
	 * @return string
	 */
	public function typeAsFormal() {
		if ( isset($this->type) ) {
			return implode(' ',preg_split('/(?=[A-Z])/',$this->type,-1,PREG_SPLIT_NO_EMPTY));
		}
		return '';
	}
	
}
