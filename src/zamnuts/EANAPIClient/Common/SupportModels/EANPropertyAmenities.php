<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANPropertyAmenity[] $amenities
 */
class EANPropertyAmenities extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'PropertyAmenities';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANPropertyAmenity';
	
	/**
	 * @param EANPropertyAmenities $supportModel
	 * @return EANPropertyAmenities
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANPropertyAmenity[]
	 */
	protected function get__amenities() {
		return $this->items;
	}
	
	/**
	 * @param EANPropertyAmenity $propertyAmenity
	 * @return boolean
	 */
	public function addPropertyAmenity(EANPropertyAmenity $propertyAmenity) {
		return $this->addItem($propertyAmenity);
	}
	
	/**
	 * @param EANPropertyAmenity $propertyAmenity
	 * @return boolean
	 */
	public function removePropertyAmenity(EANPropertyAmenity $propertyAmenity) {
		return $this->removeItem($propertyAmenity);
	}
	
}
