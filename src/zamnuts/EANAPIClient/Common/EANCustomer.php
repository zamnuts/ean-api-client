<?php

namespace zamnuts\EANAPIClient\Common;

use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property-read string $customerSessionId
 * @property-read string $customerIpAddress
 * @property-read string $customerUserAgent
 */
class EANCustomer extends ObjectBase {
	
	/**
	 * @var string
	 */
	private $customerSessionId;
	
	/**
	 * @var string
	 */
	private $customerIpAddress;
	
	/**
	 * @var string
	 */
	private $customerUserAgent;
	
	/**
	 * @param string $customerSessionId
	 * @param string $customerIpAddress
	 * @param string $customerUserAgent
	 */
	public function __construct($customerSessionId='auto',$customerIpAddress='auto',$customerUserAgent='auto') {
		$this->customerSessionId = (string) $customerSessionId;
		$this->customerIpAddress = (string) $customerIpAddress;
		$this->customerUserAgent = (string) $customerUserAgent;
		
		if ( !$this->customerIpAddress || 'auto' === strtolower($this->customerIpAddress) ) {
			$this->customerIpAddress = Utils::getIP();
		}
		
		if ( !$this->customerUserAgent || 'auto' === strtolower($this->customerUserAgent) ) {
			$this->customerUserAgent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
		}
		
		if ( !$this->customerSessionId || 'auto' === strtolower($this->customerSessionId) ) {
			$this->customerSessionId = session_id();
			if ( !$this->customerSessionId ) { // hopefully we never have to get here
				$arr = array();
				$arr[] = $this->customerUserAgent;
				$arr[] = isset($_SERVER['HTTP_ACCEPT'])?$_SERVER['HTTP_ACCEPT']:'';
				$arr[] = isset($_SERVER['HTTP_ACCEPT_ENCODING'])?$_SERVER['HTTP_ACCEPT_ENCODING']:'';
				$arr[] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:'';
				$arr[] = $this->customerIpAddress;
				$arr[] = isset($_SERVER['REMOTE_PORT'])?$_SERVER['REMOTE_PORT']:'';
				$arr[] = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';
				$arr[] = isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:'';
				$arr[] = isset($_SERVER['SERVER_PORT'])?$_SERVER['SERVER_PORT']:'';
				$this->customerSessionId = hash('sha256',implode($arr,'-')); // attempt to footprint the specific user (best guess)
			}
		}
	}
	
	/**
	 * @return string
	 */
	protected function get__customerSessionId() {
		return $this->customerSessionId;
	}
	
	/**
	 * @return string
	 */
	protected function get__customerIpAddress() {
		return $this->customerIpAddress;
	}
	
	/**
	 * @return string
	 */
	protected function get__customerUserAgent() {
		return $this->customerUserAgent;
	}
	
}
