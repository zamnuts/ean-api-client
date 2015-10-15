<?php

namespace zamnuts\EANAPIClient\Common;

use zamnuts\EANAPIClient\Util\ObjectBase;

/**
 * @property-read string $cid
 * @property-read string $cidActual
 * @property-read string $apiKey
 * @property-read string $apiSecret
 * @property boolean $isBeta
 * @see http://developer.ean.com/docs/common/
 */
class EANAccount extends ObjectBase {
	
	/**
	 * @var int
	 */
	const CID_BETA = 55505;
	
	/**
	 * @var boolean
	 */
	private $isBeta = false;
	
	/**
	 * @var int
	 */
	private $cid;
	
	/**
	 * @var string
	 */
	private $apiKey;
	
	/**
	 * @var string
	 */
	private $apiSecret;
	
	/**
	 * @param int $cid
	 * @param string $apiKey
	 * @param string $apiSecret
	 * @param boolean $isBeta
	 */
	public function __construct($cid,$apiKey,$apiSecret,$isBeta=false) {
		$this->cid = (int) $cid;
		$this->apiKey = (string) $apiKey;
		$this->apiSecret = (string) $apiSecret;
		$this->isBeta = (boolean) $isBeta;
	}
	
	/**
	 * @return int
	 */
	protected function get__cid() {
		if ( $this->isBeta ) {
			return (int) self::CID_BETA;
		} else {
			return $this->cid;
		}
	}
	
	/**
	 * @return int
	 */
	protected function get__cidActual() {
		return $this->cid;
	}
	
	/**
	 * @return string
	 */
	protected function get__apiKey() {
		return $this->apiKey;
	}
	
	/**
	 * @return string
	 */
	protected function get__apiSecret() {
		return $this->apiSecret;
	}
	
	/**
	 * @return boolean
	 */
	protected function get__isBeta() {
		return $this->isBeta;
	}
	
	/**
	 * @param boolean $value
	 */
	protected function set__isBeta($value) {
		$this->isBeta = (boolean) $value;
	}
	
	public function generateSignature($timestamp=null) {
		if ( !$timestamp ) {
			$timestamp = time();
		}
		$gmDate = gmdate('U',$timestamp);
		return md5($this->get__apiKey().$this->get__apiSecret().$gmDate);
	}
	
}
