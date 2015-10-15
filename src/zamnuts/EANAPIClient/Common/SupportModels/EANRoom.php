<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property int $adultCount A number always gte 1
 * @property-read int $numChildren
 * @property-read int[] $childrenAgesArray
 * @property string $childrenAges
 * @property string $smokingPreference
 */
class EANRoom extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Room';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	protected $adultCount;
	
	/**
	 * @var int[]
	 */
	protected $childrenAges;
	
	/**
	 * @var string
	 */
	public $rateKey;
	
	/**
	 * @var string
	 */
	public $firstName;
	
	/**
	 * @var string
	 */
	public $lastName;
	
	/**
	 * @var string
	 */
	public $bedTypeId;
	
	/**
	 * @var string
	 */
	public $bedTypeDescription;
	
	/**
	 * @var int
	 */
	public $numberOfBeds;
	
	/**
	 * @var string
	 */
	protected $smokingPreference;
	
	/**
	 * Notice: This is different than the typical static::$propertyMap since 
	 * the object/method structure of this model is unconventional compared to 
	 * other classes within the SupportModels package. The xml loading/building 
	 * is very specific to this class' data structure.
	 * @var string[]
	 * @see EANRoom::loadXML
	 * @see EANRoom::refreshXML
	 */
	private static $partialPropertyMap = array(
		'rateKey' => 'string',
		'firstName' => 'string',
		'lastName' => 'string',
		'bedTypeId' => 'string',
		'bedTypeDescription' => 'string',
		'numberOfBeds' => 'int',
		'smokingPreference' => 'string'
	);
	
	/**
	 * @param EANRoom $supportModel
	 * @return EANRoom
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @param int $adultCount Number of adults. Must be at least 1.
	 * @param int[] $childrenAges An array of integers representing the childrens' ages.
	 */
	public function __construct($adultCount=1,$childrenAges=null) {
		parent::__construct();
		$this->set__adultCount($adultCount?$adultCount:1);
		$this->childrenAges = array();
		if ( isset($childrenAges) && is_array($childrenAges) ) {
			foreach ( $childrenAges as $age ) {
				$this->addChild($age);
			}
		}
		$this->refreshXML();
	}
	
	/**
	 * @return int The number of adults after the addition.
	 */
	public function addAdult() {
		$this->adultCount++;
		$this->refreshXML();
		return $this->adultCount;
	}
	
	/**
	 * Must be at least 1 adult (can't remove the last one).
	 * @return int The number of adults after the removal.
	 */
	public function removeAdult() {
		$this->adultCount--;
		if ( $this->adultCount < 1 ) {
			$this->adultCount = 1;
		}
		$this->refreshXML();
		return $this->adultCount;
	}
	
	/**
	 * @return int
	 */
	protected function get__adultCount() {
		return $this->adultCount;
	}
	
	/**
	 * @param int $value
	 */
	protected function set__adultCount($value) {
		$value = (int) $value;
		if ( $value < 1 ) {
			$value = 1;
		}
		$this->adultCount = $value;
		$this->refreshXML();
	}
	
	/**
	 * @param int $age
	 * @return int Total number of children.
	 */
	public function addChild($age) {
		$age = (int) $age;
		if ( $age < 0 ) {
			$age = 0;
		}
		array_push($this->childrenAges,$age);
		$this->refreshXML();
		return $this->get__numChildren();
	}
	
	/**
	 * @param int $age
	 * @return boolean
	 */
	public function removeChild($age) {
		$age = (int) $age;
		if ( $age < 0 ) {
			$age = 0;
		}
		$childrenAges = $this->get__childrenAgesArray();
		foreach ( $childrenAges as $subjectKey => $subjectAge ) {
			if ( $age === $subjectAge ) {
				return $this->removeChildByIndex($subjectKey);
			}
		}
		return false;
	}
	
	/**
	 * @param int $index
	 * @return boolean
	 */
	public function removeChildByIndex($index) {
		if ( isset($this->childrenAges[$index]) ) {
			unset($this->childrenAges[$index]);
			$this->childrenAges = array_values($this->childrenAges);
			$this->refreshXML();
			return true;
		}
		return false;
	}
	
	/**
	 * @return int
	 */
	protected function get__numChildren() {
		return count($this->childrenAges);
	}
	
	/**
	 * @return int[]
	 */
	protected function get__childrenAgesArray() {
		return $this->childrenAges;
	}
	
	/**
	 * @return string
	 */
	protected function get__childrenAges() {
		if ( isset($this->childrenAges) ) {
			return implode(',',$this->childrenAges);
		}
		return null;
	}
	
	protected function get__smokingPreference() {
		return $this->smokingPreference;
	}
	
	protected function set__smokingPreference($value) {
		$value = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $value)),0,256);
		$constStr = __NAMESPACE__.'\\EANSmokingPreferencesTable::SMOKING_PREFERENCE_'.$value;
		if ( defined($constStr) ) {
			$this->smokingPreference = $value;
		}
	}
	
	protected function get__xml() {
		return $this->xml;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::loadXML()
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml) {
		$this->childrenAges = array();
		if ( isset($xml->numberOfAdults) ) {
			$this->set__adultCount((int) $xml->numberOfAdults);
		}
		if ( isset($xml->childAges) ) {
			$children = explode(',',$xml->childAges);
			foreach ( $children as $child ) {
				$this->addChild($child);
			}
		}
		if ( isset($xml->numberOfChildren) ) {
			$diff = intval($xml->numberOfChildren,10) - count($this->childrenAges);
			for ( $i = 0; $i < $diff; $i++ ) {
				$this->addChild(0);
			}
		}
		foreach ( self::$partialPropertyMap as $property => $type ) {
			$this->$property = null;
			if ( isset($xml->$property) && Utils::isStringValueScalar($type,false) ) {
				$this->$property = Utils::castScalar($type,$xml->$property);
			}
		}
		$this->refreshXML();
	}

	public function refreshXML() {
		if ( isset($this->adultCount) ) {
			$this->xml->numberOfAdults = (string) $this->adultCount;
		}
		if ( isset($this->childrenAges) && is_array($this->childrenAges) ) {
			$numChildrenAges = count($this->childrenAges);
			$this->xml->numberOfChildren = (string) $numChildrenAges;
			if ( $numChildrenAges ) {
				$list = implode(',',$this->childrenAges);
				$this->xml->childAges = $list;
			}
		}
		foreach ( self::$partialPropertyMap as $property => $type ) {
			if ( isset($this->$property) && Utils::isStringValueScalar($type,false) ) {
				$this->xml->$property = (string) $this->$property;
			}
		}
	}
	
}
