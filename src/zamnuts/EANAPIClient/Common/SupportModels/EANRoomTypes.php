<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANRoomType[] $roomTypes
 */
class EANRoomTypes extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomTypes';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomType';
	
	/**
	 * @param EANRoomTypes $supportModel
	 * @return EANRoomTypes
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANRoomType[]
	 */
	protected function get__roomTypes() {
		return $this->items;
	}
	
	/**
	 * @param EANRoomType $roomType
	 * @return boolean
	 */
	public function addRoomType(EANRoomType $roomType) {
		return $this->addItem($roomType);
	}
	
	/**
	 * @param EANRoomType $roomType
	 * @return boolean
	 */
	public function removeRoomType(EANRoomType $roomType) {
		return $this->removeItem($roomType);
	}
	
}
