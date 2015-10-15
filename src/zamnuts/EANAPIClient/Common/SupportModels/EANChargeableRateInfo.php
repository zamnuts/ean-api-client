<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property-read EANNightlyRatesPerRoom $nightlyRates
 * @property-read EANSurcharges $surcharges
 */
class EANChargeableRateInfo extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'ChargeableRateInfo';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var EANNightlyRatesPerRoom
	 */
	protected $nightlyRatesPerRoom;
	
	/**
	 * @var EANSurcharges
	 */
	protected $surcharges;
	
	/**
	 * @var float
	 */
	public $averageBaseRate;
	
	/**
	 * @var float
	 */
	public $averageRate;
	
	/**
	 * @var float
	 */
	public $commissionableUsdTotal;
	
	/**
	 * @var string
	 */
	public $currencyCode;
	
	/**
	 * @var float
	 */
	public $maxNightlyRate;

	/**
	 * @var float
	 */
	public $nightlyRateTotal;
	
	/**
	 * @var float
	 */
	public $grossProfitOffline;
		
	/**
	 * @var float
	 */
	public $grossProfitOnline;
	
	/**
	 * @var float
	 */
	public $surchargeTotal;
	
	/**
	 * @var float
	 */
	public $total;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'nightlyRatesPerRoom' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANNightlyRatesPerRoom',
		'surcharges' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANSurcharges',
	);
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'averageBaseRate' => 'float',
		'averageRate' => 'float',
		'commissionableUsdTotal' => 'float',
		'currencyCode' => 'string',
		'maxNightlyRate' => 'float',
		'nightlyRateTotal' => 'float',
		'grossProfitOffline' => 'float',
		'grossProfitOnline' => 'float',
		'surchargeTotal' => 'float',
		'total' => 'float'
	);
	
	/**
	 * @param EANChargeableRateInfo $supportModel
	 * @return EANChargeableRateInfo
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__nightlyRates() {
		if ( isset($this->nightlyRatesPerRoom) ) {
			return clone $this->nightlyRatesPerRoom;
		}
		return null;
	}
	
	/**
	 * @param EANNightlyRate $nightlyRate
	 * @return boolean
	 */
	public function addNightlyRate(EANNightlyRate $nightlyRate) {
		return $this->nightlyRatesPerRoom->addNightlyRate($nightlyRate);
	}
	
	/**
	 * @param EANNightlyRate $nightlyRate
	 * @return boolean
	 */
	public function removeNightlyRate(EANNightlyRate $nightlyRate) {
		return $this->nightlyRatesPerRoom->removeNightlyRate($nightlyRate);
	}
	
	protected function get__surcharges() {
		if ( isset($this->surcharges) ) {
			return $this->surcharges;
		}
		return null;
	}
	
	/**
	 * @param EANSurcharge $surcharge
	 * @return boolean
	 */
	public function addSurcharge(EANSurcharge $surcharge) {
		return $this->surcharges->addSurcharge($surcharge);
	}
	
	/**
	 * @param EANSurcharge $surcharge
	 * @return boolean
	 */
	public function removeSurcharge(EANSurcharge $surcharge) {
		return $this->surcharges->removeSurcharge($surcharge);
	}
	
	/**
	 * TODO: asXML
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::asXML()
	 */
	public function asXML() {
		return '';
	}
		
}
