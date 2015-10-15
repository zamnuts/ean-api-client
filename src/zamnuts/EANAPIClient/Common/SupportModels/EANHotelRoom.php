<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\XMLUtils;

/**
 * @property string $policy
 * @property string $rateCode
 * @property string $roomTypeCode
 * @property string $rateDescription
 * @property string $roomTypeDescription
 * @property string $supplierType
 * @property string $otherInformation
 * @property boolean $immediateChargeRequired
 * @property string $propertyId
 * @property string $smokingPreferences
 * @property-read string[] $smokingPreferencesArray
 * @property int $minGuestAge
 * @property int $quotedOccupancy
 * @property int $rateOccupancyPerRoom
 * @property-read EANBedTypes $bedTypes
 * @property-read EANValueAdds $valueAdds
 * @property-read EANRoomImages $images
 * @property-read EANRoomType $roomType
 * @property-read EANRateInfos $rateInfos
 */
class EANHotelRoom extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomResponse';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	protected $policy;
	
	/**
	 * @var string
	 */
	public $rateCode;
	
	/**
	 * @var string
	 */
	public $roomTypeCode;
	
	/**
	 * @var string
	 */
	protected $rateDescription;
	
	/**
	 * @var string
	 */
	protected $roomTypeDescription;

	/**
	 * @var string
	 */
	protected $supplierType;
	
	/**
	 * @var string
	 */
	protected $otherInformation;
	
	/**
	 * @var boolean
	 */
	public $immediateChargeRequired;
	
	/**
	 * @var string
	 */
	public $propertyId;
	
	/**
	 * @var string[]
	 */
	protected $smokingPreferences;
	
	/**
	 * @var int
	 */
	public $minGuestAge;
	
	/**
	 * @var int
	 */
	public $quotedOccupancy;
	
	/**
	 * @var int
	 */
	public $rateOccupancyPerRoom;
	
	/**
	 * @var EANBedTypes
	 */
	protected $bedTypes;
	
	/**
	 * @var EANValueAdds
	 */
	protected $valueAdds;
	
	/**
	 * @var EANRoomImages
	 */
	protected $images;
	
	/**
	 * @var EANRoomType
	 */
	protected $roomType;
	
	/**
	 * @var EANRateInfos
	 */
	protected $rateInfos;
		
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'policy' => 'string',
		'rateCode' => 'string',
		'roomTypeCode' => 'string',
		'rateDescription' => 'string',
		'roomTypeDescription' => 'string',
		'supplierType' => 'string',
		'otherInformation' => 'string',
		'immediateChargeRequired' => 'boolean',
		'propertyId' => 'string',
		'smokingPreferences' => 'string',
		'minGuestAge' => 'int',
		'quotedOccupancy' => 'int',
		'rateOccupancyPerRoom' => 'int',
		'bedTypes' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANBedTypes',
		'valueAdds' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANValueAdds',
		'images' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomImages',
		'roomType' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomType',
		'rateInfos' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRateInfos'
	);
	
	/**
	 * @param EANHotelRoom $supportModel
	 * @return EANHotelRoom
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}	
	
	protected function get__supplierType() {
		return $this->supplierType;
	}
	
	protected function set__supplierType($value) {
		$this->supplierType = strtoupper((string) $value);		
	}
	
	protected function get__rateDescription() {
		return $this->rateDescription;
	}
	
	protected function set__rateDescription($value) {
		$this->rateDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__roomTypeDescription() {
		return $this->roomTypeDescription;
	}
	
	protected function set__roomTypeDescription($value) {
		$this->roomTypeDescription = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__policy() {
		return $this->policy;
	}
	
	protected function set__policy($value) {
		$this->policy = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	protected function get__otherInformation() {
		return $this->otherInformation;
	}
	
	protected function set__otherInformation($value) {
		$this->otherInformation = XMLUtils::tidyPartialHTMLToString($value);
	}
	
	// Smoking Preferences
	protected function get__smokingPreferences() {
		return implode(',',$this->get__smokingPreferencesArray());
	}
	
	protected function get__smokingPreferencesArray() {
		$this->initSpecifiedArray('smokingPreferences');
		return $this->smokingPreferences;
	}
	
	protected function set__smokingPreferences($value) {
		$value = (string) $value;
		$array = explode(',',$value);
		foreach ( $array as $preference ) {
			$this->addSmokingPreference($preference);
		}
	}
	
	/**
	 * Add a smoking preference using one of the SMOKING_PREFERENCE_* constants.
	 * @param string $preference
	 * @return boolean
	 */
	public function addSmokingPreference($preference) {
		$this->initSpecifiedArray('smokingPreferences');
		$preference = substr(preg_replace('/[^A-Z]/i','',strtoupper((string) $preference)),0,256);
		$constStr = __NAMESPACE__.'\\EANSmokingPreferencesTable::SMOKING_PREFERENCE_'.$preference;
		if ( defined($constStr) ) {
			array_push($this->smokingPreferences,constant($constStr));
			$this->smokingPreferences = array_unique($this->smokingPreferences);
			return true;
		}
		return false;
	}
	
	/**
	 * Remove a smoking preference. Use a SMOKING_PREFERENCE_* constant.
	 * @param string $preference
	 * @return boolean
	 */
	public function removeSmokingPreference($preference) {
		$preference = strtoupper((string) $preference);
		if ( $preference && isset($this->smokingPreferences) && is_array($this->smokingPreferences) ) {
			foreach ( $this->smokingPreferences as $key => $subjectPreference ) {
				if ( $preference === $subjectPreference ) {
					unset($this->smokingPreferences[$key]);
					$this->smokingPreferences = array_values($this->smokingPreferences);
					return true;
				}
			}
		}
		return false;
	}
	
	protected function get__bedTypes() {
		if ( isset($this->bedTypes) ) {
			return clone $this->bedTypes;
		}
		return null;
	}
		
	protected function get__valueAdds() {
		if ( isset($this->valueAdds) ) {
			return clone $this->valueAdds;
		}
		return null;
	}
		
	protected function get__images() {
		if ( isset($this->images) ) {
			return clone $this->images;
		}
		return null;
	}
		
	protected function get__roomType() {
		if ( isset($this->roomType) ) {
			return clone $this->roomType;
		}
		return null;
	}
		
	protected function get__rateInfos() {
		if ( isset($this->rateInfos) ) {
			return clone $this->rateInfos;
		}
		return null;
	}
	
	private function initSpecifiedArray($property,$overwrite=false) {
		if ( $overwrite || !isset($this->$property) || !is_array($this->$property) ) {
			$this->$property = array();
		}
	}
	
}
