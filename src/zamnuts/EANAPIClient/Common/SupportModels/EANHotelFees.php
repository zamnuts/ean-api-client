<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANHotelFee[] $hotelFees
 */
class EANHotelFees extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelFees';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelFee';
	
	/**
	 * @param EANHotelFees $supportModel
	 * @return EANHotelFees
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANHotelFee[]
	 */
	protected function get__hotelFees() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelFee $hotelFee
	 * @return boolean
	 */
	public function addHotelFee(EANHotelFee $hotelFee) {
		return $this->addItem($hotelFee);
	}
	
	/**
	 * @param EANHotelFee $hotelFee
	 * @return boolean
	 */
	public function removeHotelFee(EANHotelFee $hotelFee) {
		return $this->removeItem($hotelFee);
	}
	
}
