<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

class EANHotelFeeBreakdown extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelFeeBreakdown';
	
	/**
	 * @var string
	 */
	public $unit;
	
	/**
	 * @var string
	 */
	public $frequency;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'unit' => 'string',
		'frequency' => 'string'
	);
	
	/**
	 * @param EANHotelFeeBreakdown $supportModel
	 * @return EANHotelFeeBreakdown
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
}
