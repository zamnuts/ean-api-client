<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property EANPaymentType[] $types
 * @property EANError $error
 */
class EANResponseHotelPayment extends EANAbstractGroup implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelPaymentResponse';
	
	/**
	 * @var string
	 */
	protected static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANPaymentType';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public $customerSessionId;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'types' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANPaymentType',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseHotelPayment $supportModel
	 * @return EANResponseHotelPayment
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANPaymentType[]
	 */
	protected function get__types() {
		return $this->items;
	}
	
	/**
	 * @param EANPaymentType $type
	 * @return boolean
	 */
	public function addPaymentType(EANPaymentType $type) {
		return $this->addItem($type);
	}
	
	/**
	 * @param EANPaymentType $type
	 * @return boolean
	 */
	public function removePaymentType(EANPaymentType $type) {
		return $this->removeItem($type);
	}
	
	// Error
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	/**
	 * TODO: get__xml
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::get__xml()
	 */
	protected function get__xml() {
		return $this->xml;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractGroup::loadXML()
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		parent::loadXML($xml);
	}
	
}
