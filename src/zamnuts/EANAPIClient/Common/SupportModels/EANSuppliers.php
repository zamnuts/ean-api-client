<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANSupplier[] $suppliers
 */
class EANSuppliers extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Suppliers';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANSupplier';
	
	/**
	 * @param EANSuppliers $supportModel
	 * @return EANSuppliers
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANSupplier[]
	 */
	protected function get__suppliers() {
		return $this->items;
	}
	
	/**
	 * @param EANSupplier $supplier
	 * @return boolean
	 */
	public function addSupplier(EANSupplier $supplier) {
		return $this->addItem($supplier);
	}
	
	/**
	 * @param EANSupplier $supplier
	 * @return boolean
	 */
	public function removeSupplier(EANSupplier $supplier) {
		return $this->removeItem($supplier);
	}
	
}
