<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $presentationMessage
 * @property string $verboseMessage
 * @property string[] $errorAttributes
 * @property-read EANServerInfo $serverInfo
 * @see http://developer.ean.com/docs/error-handling/hotel-v3-exception-details/
 */
class EANError extends EANAbstractSupportModel implements IEANSupportModel {
	
	public static $SERVICE_NAME = 'The service';
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'EanWsError';
	
	/**
	 * @var string
	 */
	const HANDLING_UNKNOWN = 'UNKNOWN';
	
	/**
	 * @var string
	 */
	const HANDLING_RECOVERABLE = 'RECOVERABLE';
	
	/**
	 * @var string
	 */
	const HANDLING_UNRECOVERABLE = 'UNRECOVERABLE';
	
	/**
	 * @var string
	 */
	const HANDLING_AGENT_ATTENTION = 'AGENT_ATTENTION';
	
	/**
	 * @var string
	 */
	const CATEGORY_UNKNOWN = 'UNKNOWN';
	
	/**
	 * @var string
	 */
	const CATEGORY_EXCEPTION = 'EXCEPTION';
	
	/**
	 * @var string
	 */
	const CATEGORY_CREDITCARD = 'CREDITCARD';
	
	/**
	 * @var string
	 */
	const CATEGORY_DATA_VALIDATION = 'DATA_VALIDATION';
	
	/**
	 * @var string
	 */
	const CATEGORY_AUTHENTICATION = 'AUTHENTICATION';
	
	/**
	 * @var string
	 */
	const CATEGORY_UNABLE_TO_PROCESS_REQUEST = 'UNABLE_TO_PROCESS_REQUEST';
	
	/**
	 * @var string
	 */
	const CATEGORY_INVALID_PROPERTY_ID = 'INVALID_PROPERTY_ID';
	
	/**
	 * @var string
	 */
	const CATEGORY_RESULT_NULL = 'RESULT_NULL';
	
	/**
	 * @var string
	 */
	const CATEGORY_PROCESS_FAIL = 'PROCESS_FAIL';
	
	/**
	 * @var string
	 */
	const CATEGORY_SOLD_OUT = 'SOLD_OUT';
	
	/**
	 * @var string
	 */
	const CATEGORY_RESTRICTED_CHECKIN = 'RESTRICTED_CHECKIN';
	
	/**
	 * @var string
	 */
	const CATEGORY_ONEROOM = 'ONEROOM';
	
	/**
	 * @var string
	 */
	const CATEGORY_SUPPLIER_COMMUNICATION = 'SUPPLIER_COMMUNICATION';
	
	/**
	 * @var string
	 */
	const CATEGORY_DATA_PARSE_RESULT = 'DATA_PARSE_RESULT';
	
	/**
	 * @var string
	 */
	const CATEGORY_CORPORATE_RATE = 'CORPORATE_RATE';
	
	/**
	 * @var string
	 */
	const CATEGORY_RES_NOT_FOUND = 'RES_NOT_FOUND';
	
	/**
	 * @var string
	 */
	const CATEGORY_RES_CANCELLED = 'RES_CANCELLED';
	
	/**
	 * @var string
	 */
	const CATEGORY_HRN_QUOTE_KEY_FAILURE = 'HRN_QUOTE_KEY_FAILURE';
	
	/**
	 * @var string
	 */
	const CATEGORY_HRN_QUOTE_KEY_INVALID = 'HRN_QUOTE_KEY_INVALID';
	
	/**
	 * @var string
	 */
	const CATEGORY_SYS_OFFLINE = 'SYS_OFFLINE';
	
	/**
	 * @var string
	 */
	const CATEGORY_SUPPLIER_INITITIALIZATION = 'SUPPLIER_INITITIALIZATION';
	
	/**
	 * @var string
	 */
	const CATEGORY_SUPPLIER_ROUTER_EXCEPTION = 'SUPPLIER_ROUTER_EXCEPTION';
	
	/**
	 * @var string
	 */
	const CATEGORY_EJB_CREATE_EXCEPTION = 'EJB_CREATE_EXCEPTION';
	
	/**
	 * @var string
	 */
	const CATEGORY_FINDER_EXCEPTION = 'FINDER_EXCEPTION';
	
	/**
	 * @var string
	 */
	const CATEGORY_BML_FAIL = 'BML_FAIL';
	
	/**
	 * @var string
	 */
	const CATEGORY_PRICE_MISMATCH = 'PRICE_MISMATCH';
	
	/**
	 * @var string
	 */
	const CATEGORY_CSV_FAIL = 'CSV_FAIL';
	
	/**
	 * @var string
	 */
	const CATEGORY_PAYER_AUTH_REQUIRED = 'PAYER_AUTH_REQUIRED';
	
	/**
	 * @var string
	 */
	const CATEGORY_PAYER_AUTH_FAILED = 'PAYER_AUTH_FAILED';
	
	/**
	 * @var string
	 */
	const CATEGORY_ITINERARY_ALREADY_BOOKED = 'ITINERARY_ALREADY_BOOKED';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	public $itineraryId;
	
	/**
	 * @var string
	 */
	public $handling;
	
	/**
	 * @var string
	 */
	public $category;
	
	/**
	 * @var int
	 */
	public $exceptionConditionId;
	
	/**
	 * @var string
	 */
	protected $presentationMessage;
	
	/**
	 * @var string
	 */
	protected $verboseMessage;
	
	/**
	 * @var EANServerInfo
	 */
	protected $serverInfo;
	
	/**
	 * @var mixed[]
	 */
	protected $errorAttributes;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'itineraryId' => 'int',
		'handling' => 'string',
		'category' => 'string',
		'exceptionConditionId' => 'int',
		'presentationMessage' => 'string',
		'verboseMessage' => 'string',
		'serverInfo' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANServerInfo'
	);
	
	/**
	 * @param EANError $supportModel
	 * @return EANError
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__presentationMessage() {
		return $this->presentationMessage;
	}
	
	protected function set__presentationMessage($value) {
		$this->presentationMessage = str_replace('TravelNow.com',static::$SERVICE_NAME,Utils::htmlEntitiesDecode($value));
	}
	
	protected function get__verboseMessage() {
		return $this->verboseMessage;
	}
	
	protected function set__verboseMessage($value) {
		$this->verboseMessage = Utils::htmlEntitiesDecode($value);
	}
	
	protected function get__errorAttributes() {
		return $this->errorAttributes;
	}
	
	protected function get__serverInfo() {
		if ( isset($this->serverInfo) ) {
			return $this->serverInfo;
		}
		return null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::loadXML()
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		parent::loadXML($xml);
		if ( isset($xml->ErrorAttributes->errorAttributesMap) && isset($xml->ErrorAttributes->errorAttributesMap->entry)) {
			foreach ( $xml->ErrorAttributes->errorAttributesMap->entry as $entry ) {
				if ( isset($entry->key,$entry->value,$this->errorAttributes[$entry->key]) ) {
					$this->errorAttributes[$entry->key] = $entry->value;
				}
			}
		} else if ( isset($xml->ErrorAttributes) ) {
			foreach ( $xml->ErrorAttributes as $key => $value ) {
				$this->errorAttributes[$key] = $value;
			}
		}
	}
	
}
