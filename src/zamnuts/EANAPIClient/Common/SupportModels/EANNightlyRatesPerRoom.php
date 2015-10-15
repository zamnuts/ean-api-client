<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANNightlyRate[] $nightlyRates
 */
class EANNightlyRatesPerRoom extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'NightlyRatesPerRoom';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANNightlyRate';
	
	/**
	 * @param EANNightlyRatesPerRoom $supportModel
	 * @return EANNightlyRatesPerRoom
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANNightlyRate[]
	 */
	protected function get__nightlyRates() {
		return $this->items;
	}
	
	/**
	 * @param EANNightlyRate $nightlyRate
	 * @return boolean
	 */
	public function addNightlyRate(EANNightlyRate $nightlyRate) {
		return $this->addItem($nightlyRate);
	}
	
	/**
	 * @param EANNightlyRate $nightlyRate
	 * @return boolean
	 */
	public function removeNightlyRate(EANNightlyRate $nightlyRate) {
		return $this->removeItem($nightlyRate);
	}
	
}
