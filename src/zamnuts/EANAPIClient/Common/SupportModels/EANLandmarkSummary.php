<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property-read string[] $amenities Built using $amenitiesMaskMap against $amenityMask, a list of amenity strings.
 * @property string $name
 * @property string $deepLink
 * @property boolean $hotelInDestination
 * @property string $locationDescription This is HTML (I'm assuming? unconfirmed).
 * @property string $shortDescription This is HTML.
 * @property string $supplierType Corresponds to EANResponseHotelList::SUPPLIER_TYPE_* constants.
 * @property string $thumbNailUrl Absolute URL to a downloadable thumbnail URL.
 * @property-read EANRoomRateDetails $roomRateDetailsList
 */
class EANLandmarkSummary extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'LocationInfo';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	public static $THUMBNAIL_URL_PREFIX = 'http://images.travelnow.com'; // no trailing slash needed
	
	/**
	 * @var string[]
	 */
	public static $amenitiesMaskMap = array(
		'1' => 'Business Center',
		'2' => 'Fitness Center',
		'4' => 'Hot Tub On-site',
		'8' => 'Internet Access Available',
		'16' => 'Kids\' Activities',
		'32' => 'Kitchen or Kitchenette',
		'64' => 'Pets Allowed',
		'128' => 'Pool',
		'256' => 'Restaurant On-site',
		'512' => 'Spa On-site',
		'1024' => 'Whirlpool Bath Available',
		'2048' => 'Breakfast',
		'4096' => 'Babysitting',
		'8192' => 'Jacuzzi',
		'16384' => 'Parking',
		'32768' => 'Room Service ',
		'65536' => 'Accessible Path of Travel',
		'131072' => 'Accessible Bathroom',
		'262144' => 'Roll-in Shower',
		'524288' => 'Handicapped Parking',
		'1048576' => 'In-room Accessibility ',
		'2097152' => 'Accessibility Equipment for the Deaf',
		'4194304' => 'Braille or Raised Signage',
		'8388608' => 'Free Airport Shuttle',
		'16777216' => 'Indoor Pool',
		'33554432' => 'Outdoor Pool',
		'67108864' => 'Extended Parking',
		'134217728' => 'Free Parking',
	);
	
	public $destinationId;
	public $active;
	public $type;
	public $countryCode;
	public $countryName;
	public $description;
	public $geoAccuracy;
	public $locationInDestination;
	
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'destinationId' => 'string',
		'active' => 'boolean',
		'type' => 'int',
		'countryCode' => 'string',
		'countryName' => 'string',
		'description' => 'string',
		'geoAccuracy' => 'int',
		'locationInDestination' => 'boolean',
	);
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'order' => 'int',
		'ubsScore' => 'int'
	);
	
	/**
	 * @param EANAbstractSupportModel $supportModel
	 * @return EANHotelSummary
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}	
	
	public function __construct() {
		parent::__construct();
	}
	
	protected function get__name() {
		return $this->name;
	}
	
	protected function set__name($value) {
		$this->name = Utils::htmlEntitiesDecode($value);
	}
	
	protected function get__active() {
		return $this->active;
	}
	
	protected function set__active($value) {
		$this->active = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__type() {
		return $this->type;
	}
	
	protected function set__type($value) {
		$this->type = Utils::htmlEntitiesDecode((int) $value);
	}
	
	protected function get__countryCode() {
		return $this->countryCode;
	}
	
	protected function set__countryCode($value) {
		$this->countryCode = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__countryName() {
		return $this->countryName;
	}
	
	protected function set__countryName($value) {
		$this->countryName = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__geoAccuracy() {
		return $this->geoAccuracy;
	}
	
	protected function set__geoAccuracy($value) {
		$this->geoAccuracy = Utils::htmlEntitiesDecode((int) $value);
	}
	
	protected function get__description() {
		return $this->description;
	}
	
	protected function set__description($value) {
		$this->description = Utils::htmlEntitiesDecode((string) $value);
	}
	
	protected function get__locationInDestination() {
		return $this->locationInDestination;
	}
	
	protected function set__locationInDestination($value) {
		$this->locationInDestination = Utils::anyToBoolean($value);
	}
	
}
