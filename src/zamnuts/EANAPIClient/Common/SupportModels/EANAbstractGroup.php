<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\XMLUtils;

/**
 * TODO update refreshXML method to use EANAbstractSupportModel::refreshXML
 * @property-read string $childTagName Read-only.
 * @property-read string $childClass Read-only.
 * @property-read EANAbstractGroup[] $items Read-only.
 * @property-read int $length Read-only.
 */
abstract class EANAbstractGroup extends EANAbstractSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'AbstractGroup';
	
	/**
	 * @var string
	 */
	protected static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANAbstractSupportModel';
	
	/**
	 * 
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var EANAbstractSupportModel[]
	 */
	protected $items;
	
	/**
	 * @param EANAbstractGroup $supportModel
	 * @return EANAbstractGroup
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	public function __construct() {
		$this->items = array();
		$this->refreshXML();
	}
	
	/**
	 * @return string
	 */
	protected function get__childTagName() {
		$childClass = static::$CHILD_CLASS;
		if ( class_exists($childClass) && is_subclass_of($childClass,'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANAbstractSupportModel') ) {
			return $childClass::getRootTagName();
		}
		return null;
	}
	
	/**
	 * @return string
	 */
	protected function get__childClass() {
		return static::$CHILD_CLASS;
	}
	
	/**
	 * @return EANAbstractSupportModel[]
	 */
	protected function get__items() {
		return $this->items;
	}
	
	/**
	 * @return int
	 */
	protected function get__length() {
		return count($this->items);
	}
	
	/**
	 * @param EANAbstractSupportModel $item
	 * @return boolean
	 */
	public function addItem(EANAbstractSupportModel $item) {
		$childClass = static::$CHILD_CLASS;
		if ( $item instanceof $childClass ) {
			array_push($this->items,clone $item);
			$this->refreshXML();
			return true;
		}
		return false;
	}
	
	/**
	 * @param int $i
	 * @return boolean
	 */
	public function removeItemByIndex($i) {
		if ( isset($this->items[$i]) ) {
			unset($this->items[$i]);
			$this->items = array_values($this->items);
			$this->refreshXML();
			return true;
		}
		return false;
	}
	
	/**
	 * @param EANAbstractSupportModel $item
	 * @return boolean
	 */
	public function removeItem(EANAbstractSupportModel $item) {
		$childClass = static::$CHILD_CLASS;
		if ( $item instanceof $childClass ) {
			foreach ( $this->items as $subjectKey => $subjectItem ) {
				if ( $item->asXML() === $subjectItem->asXML() ) {
					return $this->removeItemByIndex($subjectKey);
				}
			}
		}
		return false;
	}

	/**
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		parent::loadXML($xml);
		$this->items = array();
		$childTag = $this->get__childTagName();
		if ( isset($childTag) && $childTag && isset($xml->$childTag) ) {
			foreach ( $xml->$childTag as $xmlChild ) {
				$item = new static::$CHILD_CLASS();
				$item->loadXML($xmlChild);
				$this->addItem($item);
			}
		}
		$this->refreshXML();
	}
	
	public function refreshXML() {
		$this->xml = new SimpleXMLElement('<'.static::$ROOT.' />');
		if ( isset(static::$attributeMap) && is_array(static::$attributeMap) ) {
			foreach ( static::$attributeMap as $attribute => $type ) {
				$this->xml->addAttribute($attribute,(string) $this->$attribute);
			}
		}
		foreach ( $this->items as $item ) {
			/* @var $item EANAbstractSupportModel */
			if ( method_exists($item,'refreshXML') ) {
				$item->refreshXML();
			}
			XMLUtils::appendSXE($this->xml,$item->xml);
		}
	}
	
}
