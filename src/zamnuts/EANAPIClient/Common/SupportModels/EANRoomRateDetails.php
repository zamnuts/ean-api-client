<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property-read EANRateInfos $rateInfos
 * @property-read EANValueAdds $valueAdds
 * @property-read EANBedTypes $bedTypes
 * @property string $roomDescription
 * @property boolean $propertyAvailable
 * @property boolean $propertyRestricted
 */
class EANRoomRateDetails extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	* @var string
	*/
	protected static $ROOT = 'RoomRateDetails';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @see $roomDescription
	 * @var string
	 */
	public $roomTypeCode;
	
	/**
	 * @var int
	 */
	public $rateCode;
	
	/**
	 * @var int
	 */
	public $maxRoomOccupancy;
	
	/**
	 * @var int
	 */
	public $quotedRoomOccupancy;
	
	/**
	 * @var int
	 */
	public $minGuestAge;
	
	/**
	 * @see $roomTypeCode
	 * @var string
	 */
	protected $roomDescription;
	
	/**
	 * Do not use, EAN internal only.
	 * @var boolean
	 */
	protected $propertyAvailable;
	
	/**
	 * Do not use, EAN internal only.
	 * @var boolean
	 */
	protected $propertyRestricted;
	
	/**
	 * Use this when looking up by hotelid.
	 * @var int
	 */
	public $expediaPropertyId;
	
	/**
	 * @var EANRateInfos
	 */
	protected $rateInfos;
	
	/**
	 * @var EANValueAdds
	 */
	protected $valueAdds;
	
	/**
	 * @var EANBedTypes
	 */
	protected $bedTypes;
	
	/**
	 * @var string[]
	 */
	protected $smokingPreferences;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'roomTypeCode' => 'int',
		'rateCode' => 'int',
		'maxRoomOccupancy' => 'int',
		'quotedRoomOccupancy' => 'int',
		'minGuestAge' => 'int',
		'roomDescription' => 'string',
		'propertyAvailable' => 'boolean',
		'propertyRestricted' => 'boolean',
		'expediaPropertyId' => 'int',
		'smokingPreferences' => 'string',
		'rateInfos' => 'zamnuts\\EANAPIClient\\Common\SupportModels\\EANRateInfos',
		'valueAdds' => 'zamnuts\\EANAPIClient\\Common\SupportModels\\EANValueAdds',
		'bedTypes' => 'zamnuts\\EANAPIClient\\Common\SupportModels\\EANBedTypes'
	);
	
	/**
	 * @param EANRoomRateDetails $supportModel
	 * @return EANRoomRateDetails
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__roomDescription() {
		return $this->roomDescription;
	}
	
	protected function set__roomDescription($value) {
		$this->roomDescription = Utils::htmlEntitiesDecode($value);
	}

	protected function get__propertyAvailable() {
		return $this->propertyAvailable;
	}
	
	protected function set__propertyAvailable($value) {
		$this->propertyAvailable = Utils::anyToBoolean($value);
	}

	protected function get__propertyRestricted() {
		return $this->propertyRestricted;
	}
	
	protected function set__propertyRestricted($value) {
		$this->propertyRestricted = Utils::anyToBoolean($value);
	}
	
	protected function get__rateInfos() {
		return clone $this->rateInfos;
	}
	
	/*
	protected function set__rateInfos(EANRateInfos $rateInfos) {
		$this->rateInfos = $rateInfos;
	}
	*/
	
	protected function get__valueAdds() {
		return clone $this->valueAdds;
	}
	
	/*
	protected function set__valueAdds(EANValueAdds $valueAdds) {
		$this->valueAdds = $valueAdds;
	}
	*/
	
	protected function get__bedTypes() {
		return clone $this->bedTypes;
	}
	
	/*
	protected function set__bedTypes(EANBedTypes $bedTypes) {
		$this->bedTypes = $bedTypes;
	}
	*/
	
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
	
	private function initSpecifiedArray($property,$overwrite=false) {
		if ( $overwrite || !isset($this->$property) || !is_array($this->$property) ) {
			$this->$property = array();
		}
	}
	
}
