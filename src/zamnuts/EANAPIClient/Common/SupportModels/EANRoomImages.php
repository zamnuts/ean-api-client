<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANRoomImage[] $images
 */
class EANRoomImages extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomImages';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomImage';
	
	/**
	 * @param EANRoomImages $supportModel
	 * @return EANRoomImages
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANRoomImage[]
	 */
	protected function get__images() {
		return $this->items;
	}
	
	/**
	 * @param EANRoomImage $roomImage
	 * @return boolean
	 */
	public function addImage(EANRoomImage $roomImage) {
		return $this->addItem($roomImage);
	}
	
	/**
	 * @param EANRoomImage $roomImage
	 * @return boolean
	 */
	public function removeImage(EANRoomImage $roomImage) {
		return $this->removeItem($roomImage);
	}
	
}
