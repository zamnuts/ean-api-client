<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property-read float $refundAmount
 * @property-read string $currencyCode
 */
class EANGenericRefund extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'GenericRefund';
	
	/**
	 * @var float
	 */
	protected $refundAmount;
	
	/**
	 * @var string
	 */
	protected $currencyCode;
		
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'refundAmount' => 'float',
		'currencyCode' => 'string'
	);
	
	/**
	 * @param EANGenericRefund $supportModel
	 * @return EANGenericRefund
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__refundAmount() {
		return $this->refundAmount;
	}
	
	protected function get__currencyCode() {
		return $this->currencyCode;
	}
		
}
