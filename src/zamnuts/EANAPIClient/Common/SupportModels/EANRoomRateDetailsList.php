<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANRoomRateDetails[] $roomRateDetails
 */
class EANRoomRateDetailsList extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomRateDetailsList';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomRateDetails';
	
	/**
	 * @param EANRoomRateDetailsList $supportModel
	 * @return EANRoomRateDetailsList
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANRoomRateDetails[]
	 */
	protected function get__roomRateDetails() {
		return $this->items;
	}
	
	/**
	 * @param EANRoomRateDetails $roomRateDetails
	 * @return boolean
	 */
	public function addRoomRateDetails(EANRoomRateDetails $roomRateDetails) {
		return $this->addItem($roomRateDetails);
	}
	
	/**
	 * @param EANRoomRateDetails $roomRateDetails
	 * @return boolean
	 */
	public function removeRoomRateDetails(EANRoomRateDetails $roomRateDetails) {
		return $this->removeItem($roomRateDetails);
	}
	
}
