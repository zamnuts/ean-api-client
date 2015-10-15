<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANConfirmationExtra[] $extra
 */
class EANConfirmationExtras extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'ConfirmationExtras';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANConfirmationExtra';
	
	/**
	 * @param EANRateInfos $supportModel
	 * @return EANRateInfos
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANConfirmationExtra[]
	 */
	protected function get__extra() {
		return $this->items;
	}
	
	/**
	 * @param EANConfirmationExtra $extra
	 * @return boolean
	 */
	public function addExtra(EANConfirmationExtra $extra) {
		return $this->addItem($extra);
	}
	
	/**
	 * @param EANConfirmationExtra $extra
	 * @return boolean
	 */
	public function removeExtra(EANConfirmationExtra $extra) {
		return $this->removeItem($extra);
	}
	
}
