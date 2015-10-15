<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANRateInfo[] $rateInfo
 */
class EANRateInfos extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'RateInfos';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRateInfo';
	
	/**
	 * @param EANRateInfos $supportModel
	 * @return EANRateInfos
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANRateInfo[]
	 */
	protected function get__rateInfo() {
		return $this->items;
	}
	
	/**
	 * @param EANRateInfo $rateInfo
	 * @return boolean
	 */
	public function addRateInfo(EANRateInfo $rateInfo) {
		return $this->addItem($rateInfo);
	}
	
	/**
	 * @param EANRateInfo $rateInfo
	 * @return boolean
	 */
	public function removeRateInfo(EANRateInfo $rateInfo) {
		return $this->removeItem($rateInfo);
	}
	
}
