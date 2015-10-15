<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANHotelFeeBreakdown[] $hotelFeeBreakdown
 */
class EANHotelFee extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelFee';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelFeeBreakdown';
	
	/**
	 * @var string
	 */
	public $description;
	
	/**
	 * @var int
	 */
	public $amount;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'description' => 'string',
		'amount' => 'float'
	);
	
	/**
	 * @param EANHotelFee $supportModel
	 * @return EANHotelFee
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANHotelFeeBreakdown[]
	 */
	protected function get__hotelFeeBreakdown() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelFeeBreakdown $hotelFeeBreakdown
	 * @return boolean
	 */
	public function addHotelFeeBreakdown(EANHotelFeeBreakdown $hotelFeeBreakdown) {
		return $this->addItem($hotelFeeBreakdown);
	}
	
	/**
	 * @param EANHotelFeeBreakdown $hotelFeeBreakdown
	 * @return boolean
	 */
	public function removeHotelFeeBreakdown(EANHotelFeeBreakdown $hotelFeeBreakdown) {
		return $this->removeItem($hotelFeeBreakdown);
	}
	
	/**
	 * Get the interpreted string value for $description.
	 * @return string
	 */
	public function descriptionAsFormal() {
		if ( isset($this->description) ) {
			return implode(' ',preg_split('/(?=[A-Z])/',$this->description,-1,PREG_SPLIT_NO_EMPTY));
		}
		return '';
	}
	
}
