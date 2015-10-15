<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

class EANSupplier extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Supplier';
	
	/**
	 * @var int
	 */
	public $id;
	
	/**
	 * @var string
	 */
	public $chainCode;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'id' => 'int',
		'chainCode' => 'string'
	);
	
	/**
	 * @param EANSupplier $supportModel
	 * @return EANSupplier
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
}
