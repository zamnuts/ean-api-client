<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANRoom[] $rooms
 */
class EANRoomGroup extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomGroup';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoom';
	
	/**
	 * @param EANRoomGroup $supportModel
	 * @return EANRoomGroup
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANRoom[]
	 */
	protected function get__rooms() {
		return $this->items;
	}
	
	/**
	 * @param EANRoom $room
	 * @return boolean
	 */
	public function addRoom(EANRoom $room) {
		return $this->addItem($room);
	}
	
	/**
	 * @param EANRoom $room
	 * @return boolean
	 */
	public function removeRoom(EANRoom $room) {
		return $this->removeItem($room);
	}

	/**
	 * @param int $i
	 * @return bool
	 */
	public function removeRoomByIndex($i) {
		return $this->removeItemByIndex($i);
	}
	
}
