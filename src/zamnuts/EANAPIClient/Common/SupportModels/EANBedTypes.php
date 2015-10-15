<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANBedType[] $bedTypes
 */
class EANBedTypes extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'BedTypes';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANBedType';
	
	/**
	 * @param EANBedTypes $supportModel
	 * @return EANBedTypes
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANBedType[]
	 */
	protected function get__bedTypes() {
		return $this->items;
	}
	
	/**
	 * @param EANBedType $bedType
	 * @return boolean
	 */
	public function addBedType(EANBedType $bedType) {
		return $this->addItem($bedType);
	}
	
	/**
	 * @param EANBedType $bedType
	 * @return boolean
	 */
	public function removeBedType(EANBedType $bedType) {
		return $this->removeItem($bedType);
	}
	
}
