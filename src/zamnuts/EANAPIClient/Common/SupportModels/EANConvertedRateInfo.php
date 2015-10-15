<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read EANNightlyRatesPerRoom $nightlyRates
 * @property-read EANSurcharges $surcharges
 */
class EANConvertedRateInfo extends EANChargeableRateInfo {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'ConvertedRateInfo';
	
}
