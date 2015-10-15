<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $amount
 */
class EANDeposit extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'Deposit';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	protected $amount;
	
	public static $attributeMap = array(
		'amount' => 'string'
	);
	
	/**
	 * @param EANBedType $supportModel
	 * @return EANBedType
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__amount() {
		return $this->amount;
	}
	
	protected function set__amount($value) {
		$this->amount = Utils::htmlEntitiesDecode($value);
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
