<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;
use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\Util\Utils;
use zamnuts\EANAPIClient\Util\XMLUtils;

/**
 * @property-read string $rootTagName
 * @property-read SimpleXMLElement $xml
 */
abstract class EANAbstractSupportModel extends ObjectBase  implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'AbstractSupportModel';
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array();
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array();
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	public function __construct() {
		$this->xml = new SimpleXMLElement('<'.static::$ROOT.'/>');
	}
	
	/**
	 * @return string
	 */
	public static function getRootTagName() {
		return static::$ROOT;
	}
	
	protected function get__rootTagName() {
		return static::getRootTagName();
	}
	
	/**
	 * @return SimpleXMLElement
	 */
	protected function get__xml() {
		return clone $this->xml;
	}
	
	/**
	 * @return string
	 */
	public function asXML() {
		return XMLUtils::SXEasXML($this->xml);
	}
	
	/**
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		if ( isset(static::$propertyMap) && is_array(static::$propertyMap) ) {
			foreach ( static::$propertyMap as $property => $type ) {
				$this->$property = null;
				$tagName = $property;
				if ( !Utils::isStringValueScalar($type,true) ) {
					if ( is_subclass_of($type,'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANAbstractSupportModel') ) {
						$tagName = $type::$ROOT;
					}
				}
				if ( isset($xml->$tagName) ) {
					$this->setInstanceProperty($type,$property,$xml->$tagName);
				}
			}
		}
		if ( isset(static::$attributeMap) && is_array(static::$propertyMap) ) {
			$attrs = $xml->attributes();
			foreach ( static::$attributeMap as $attribute => $type ) {
				$this->$attribute = null;
				if ( isset($attrs->$attribute) ) {
					$this->setInstanceProperty($type,$attribute,$attrs->$attribute);
				}
			}
		}
	}
	
	/**
	 * For use internally by loadXML.
	 * @param string $type
	 * @param string $property
	 * @param mixed $value
	 * @return boolean
	 */
	protected function setInstanceProperty($type,$property,$value) {
		if ( method_exists($this,'set__'.$property) ) {
			call_user_func(array($this,'set__'.$property),$value);
			return true;
		} else if ( property_exists($this,$property) ) {
			if ( Utils::isStringValueScalar($type,true) ) {
				$this->$property = Utils::castScalar($type,$value);
				return true;
			} else if ( class_exists($type) && is_subclass_of($type,'zamnuts\\EANAPIClient\\Common\\SupportModels\\IEANSupportModel') ) {
				$this->$property = new $type();
				$this->$property->loadXML($value);
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Refreshes the XML object (SimpleXMLElement) of the class based on its registered properties. 
	 * This syncronizes the underlying XML structure with the class' property structure for use in API requests. 
	 */
	public function refreshXML() {
		$this->xml = new SimpleXMLElement('<'.static::$ROOT.' />');
		if ( isset(static::$propertyMap) && is_array(static::$propertyMap) ) {
			foreach ( static::$propertyMap as $property => $type ) {
				if ( !isset($this->$property) ) {
					continue;
				}
				if ( Utils::isStringValueScalar($type,true) ) {
					if ( stripos($type,'bool') !== false ) {
						$this->xml->$property = $this->$property?'true':'false';
					} else if ( method_exists($this,'get__'.$property) ) {
						$userFuncResult = call_user_func(array($this,'get__'.$property));
						if ( $userFuncResult !== null ) {
							$this->xml->$property = (string) $userFuncResult;
						}
					} else {
						$this->xml->$property = (string) $this->$property;
					}
				} else if ( is_subclass_of($type,'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANAbstractSupportModel') ) {
					if ( method_exists($this->$property,'refreshXML') ) {
						$this->$property->refreshXML();
					}
					$this->xml->$property = $this->$property->xml;
				} else if ( $type === 'DateTime' && $this->$property instanceof DateTime ) {
					$this->xml->$property = $this->$property->format('m/d/Y');
				}
			}
		}
	}
	
}
