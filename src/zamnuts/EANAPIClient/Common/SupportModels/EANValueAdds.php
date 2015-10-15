<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANValueAdd[] $valueAdds
 */
class EANValueAdds extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'ValueAdds';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANValueAdd';
	
	/**
	 * @param EANValueAdds $supportModel
	 * @return EANValueAdds
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANValueAdd[]
	 */
	protected function get__valueAdds() {
		return $this->items;
	}
	
	/**
	 * @param EANValueAdd $valueAdd
	 * @return boolean
	 */
	public function addValueAdd(EANValueAdd $valueAdd) {
		return $this->addItem($valueAdd);
	}
	
	/**
	 * @param EANValueAdd $valueAdd
	 * @return boolean
	 */
	public function removeValueAdd(EANValueAdd $valueAdd) {
		return $this->removeItem($valueAdd);
	}
	
}
