<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * 
 * @property EANCancelPolicyInfo[] $cancelPolicies
 */
class EANCancelPolicyInfoList extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'CancelPolicyInfoList';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANCancelPolicyInfo';
	
	/**
	 * @param EANCancelPolicyInfoList $supportModel
	 * @return EANCancelPolicyInfoList
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANCancelPolicyInfo[]
	 */
	protected function get__cancelPolicies() {
		return $this->items;
	}
	
	/**
	 * @param EANCancelPolicyInfo $cancelPolicy
	 * @return boolean
	 */
	public function addCancelPolicy(EANCancelPolicyInfo $cancelPolicy) {
		return $this->addItem($cancelPolicy);
	}
	
	/**
	 * @param EANCancelPolicyInfo $cancelPolicy
	 * @return boolean
	 */
	public function removeCancelPolicy(EANCancelPolicyInfo $cancelPolicy) {
		return $this->removeItem($cancelPolicy);
	}
	
}
