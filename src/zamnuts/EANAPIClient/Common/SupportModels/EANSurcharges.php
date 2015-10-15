<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANSurcharge[] $surcharges
 */
class EANSurcharges extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Surcharges';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANSurcharge';
	
	/**
	 * @param EANSurcharges $supportModel
	 * @return EANSurcharges
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANSurcharge[]
	 */
	protected function get__surcharges() {
		return $this->items;
	}
	
	/**
	 * @param EANSurcharge $surcharge
	 * @return boolean
	 */
	public function addSurcharge(EANSurcharge $surcharge) {
		return $this->addItem($surcharge);
	}
	
	/**
	 * @param EANSurcharge $surcharge
	 * @return boolean
	 */
	public function removeSurcharge(EANSurcharge $surcharge) {
		return $this->removeItem($surcharge);
	}
	
}
