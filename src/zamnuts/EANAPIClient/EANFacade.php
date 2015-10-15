<?php

namespace zamnuts\EANAPIClient;

use \DateTime;
use \IntlDateFormatter;
use \NumberFormatter;
use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\EANConfig;
use zamnuts\EANAPIClient\Common\EANAccount;
use zamnuts\EANAPIClient\Common\EANCustomer;
use zamnuts\EANAPIClient\Common\EANLocale;
use zamnuts\EANAPIClient\Query\EANAbstractQuery;

/**
 * There is typically a need for only a single instance of EANFacade.
 * It will consolidate the account, locale and customer information
 * and prepare the query with the data, alleviating some of the legwork
 * and coordination.
 * All query objects (of type EANAbstractQuery) should be funneled through
 * this class' `query` method which returns true on success or false on failure.
 * After a successful query, retrieve the results via the EANAbstractQuery
 * object's internal methods/properties, not through this facade.
 */
class EANFacade extends ObjectBase {

	const HTTP_METHOD_GET	= 'HTTP_METHOD_GET';
	const HTTP_METHOD_POST	= 'HTTP_METHOD_POST';

	/**
	 * @var EANAccount
	 */
	public $account;
	
	/**
	 * @var EANLocale
	 */
	public $locale;
	
	/**
	 * @var EANCustomer
	 */
	public $customer;
	
	/**
	 * @param EANConfig $c
	 */
	public function __construct(EANConfig $c) {
		 $this->account		= new EANAccount($c->cid,$c->apiKey,$c->apiSecret,$c->devMode);
		 $this->locale		= new EANLocale($c->locale,$c->currency);
		 $this->customer	= new EANCustomer($c->sessionId,$c->userIP,$c->userAgent);
	}
	
	/**
	 * Run all queries through the facade. On success use $query internal
	 * methods/properties to access the result data set. On failure, use $query
	 * lastError property to get the error. EANFacade does not provide means to
	 * access the result data.
	 * @param EANAbstractQuery $query
	 * @return boolean
	 */
	public function query(EANAbstractQuery $query) {
		$query->setParam('apiKey',$this->account->apiKey);
		$query->setParam('sig',$this->account->generateSignature());
		$query->setParam('cid',$this->account->cid);
		$query->setParam('minorRev',$query::MINOR_REVISION);
		$query->setParam('locale',$this->locale->locale);
		$query->setParam('currencyCode',$this->locale->currency);
		$query->setParam('customerSessionId', $this->customer->customerSessionId);
		$query->setParam('customerIpAddress', $this->customer->customerIpAddress);
		$query->setParam('customerUserAgent', $this->customer->customerUserAgent);
		return $query->execute();
	}
	
	/**
	 * Format currency (float) based on the current locale.
	 * @param float $float
	 * @param EANLocale $locale Optional
	 * @return string
	 */
	public function formatCurrency($float,$locale=null) {
		if ( !isset($locale) ) {
			$locale = $this->locale;
		}
		if ( !($locale instanceof  EANLocale) ) {
			$locale = $this->locale;
		}
		$fmt = new NumberFormatter($locale->locale,NumberFormatter::CURRENCY);
		return $fmt->formatCurrency($float,$locale->currency);
	}
	
	/**
	 * Format a DateTime object in the current locale with the given format. 
	 * Note that the format does NOT use that PHP date function's format specification, 
	 * but ISO format codes instead, e.g.: instead of 'D' use 'EEE'.
	 * @see http://framework.zend.com/manual/1.12/en/zend.date.constants.html#zend.date.constants.selfdefinedformats
	 * @param DateTime $dateTime
	 * @param string $format
	 * @return string
	 */
	public function formatDateTime(DateTime $dateTime,$format) {
		$timezone = $dateTime->getTimezone();
		if ( version_compare(PHP_VERSION,'5.5.0','<') ) {
			$timezone = $timezone->getName();
		}
		$df = new IntlDateFormatter(
				$this->locale->locale,
				IntlDateFormatter::NONE,
				IntlDateFormatter::NONE,
				$timezone,
				IntlDateFormatter::GREGORIAN,
				$format
			);
		if ( $df ) {
			return $df->format($dateTime);
		}
		return null;
	}

}
