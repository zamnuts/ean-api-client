<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANHotelImage[] $images
 */
class EANHotelImages extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelImages';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelImage';
	
	/**
	 * @param EANHotelImages $supportModel
	 * @return EANHotelImages
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANHotelImage[]
	 */
	protected function get__images() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelImage $hotelImage
	 * @return boolean
	 */
	public function addImage(EANHotelImage $hotelImage) {
		return $this->addItem($hotelImage);
	}
	
	/**
	 * @param EANHotelImage $hotelImage
	 * @return boolean
	 */
	public function removeImage(EANHotelImage $hotelImage) {
		return $this->removeItem($hotelImage);
	}
	
}
