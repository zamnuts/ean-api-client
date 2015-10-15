<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

class EANNightlyRate extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'NightlyRate';
	
	/**
	 * @var float
	 */
	public $baseRate;
	
	/**
	 * @var float
	 */
	public $rate;
	
	/**
	 * @var boolean
	 */
	public $promo;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'baseRate' => 'float',
		'rate' => 'float',
		'promo' => 'boolean'
	);
	
	/**
	 * @param EANNightlyRate $supportModel
	 * @return EANNightlyRate
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
}
