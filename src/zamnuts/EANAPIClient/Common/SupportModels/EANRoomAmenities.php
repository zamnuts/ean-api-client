<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANRoomAmenity[] $amenities
 */
class EANRoomAmenities extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'roomAmenities';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomAmenity';
	
	/**
	 * @param EANRoomAmenities $supportModel
	 * @return EANRoomAmenities
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANRoomAmenity[]
	 */
	protected function get__amenities() {
		return $this->items;
	}
	
	/**
	 * @param EANRoomAmenity $roomAmenity
	 * @return boolean
	 */
	public function addRoomAmenity(EANRoomAmenity $roomAmenity) {
		return $this->addItem($roomAmenity);
	}
	
	/**
	 * @param EANRoomAmenity $roomAmenity
	 * @return boolean
	 */
	public function removeRoomAmenity(EANRoomAmenity $roomAmenity) {
		return $this->removeItem($roomAmenity);
	}
	
}
