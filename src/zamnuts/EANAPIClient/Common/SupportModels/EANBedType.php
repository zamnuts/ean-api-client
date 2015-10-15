<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property int $id
 * @property string $description
 */
class EANBedType extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'BedType';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var int
	 */
	protected $id;
	
	/**
	 * @var string
	 */
	protected $description;
	
	public static $propertyMap = array(
		'description' => 'string'
	);
	
	public static $attributeMap = array(
		'id' => 'int'
	);
	
	/**
	 * @param EANBedType $supportModel
	 * @return EANBedType
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}

	protected function get__id() {
		return $this->id;
	}
	
	protected function set__id($value) {
		$this->id = (int) $value;
		$this->refreshXML();
	}
	
	protected function get__description() {
		return $this->description;
	}
	
	protected function set__description($value) {
		$this->description = Utils::htmlEntitiesDecode($value);
		$this->refreshXML();
	}
	
	public function refreshXML() {
		unset($this->xml['id']);
		if ( isset($this->id) ) {
			$this->xml['id'] = (string) $this->id;
		}
		unset($this->xml->description);
		if ( isset($this->description) ) {
			$this->xml->description = (string) $this->description;
		}
	}
	
}
