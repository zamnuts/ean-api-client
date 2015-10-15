<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property-read string $customerSessionId
 * @property-read EANHotelSummary $hotel
 * @property-read EANHotelDetails $details
 * @property-read EANSuppliers $suppliers
 * @property-read EANRoomTypes $roomTypes
 * @property-read EANPropertyAmenities $propertyAmenities
 * @property-read EANHotelImages $images
 * @property-read EANError $error
 */
class EANResponseHotelInformation extends EANAbstractSupportModel implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelInformationResponse';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	protected $customerSessionId;
	
	/**
	 * @var EANHotelSummary
	 */
	protected $hotel;
	
	/**
	 * @var EANHotelDetails
	 */
	protected $details;
	
	/**
	 * @var EANSuppliers
	 */
	protected $suppliers;
	
	/**
	 * @var EANRoomTypes
	 */
	protected $roomTypes;
	
	/**
	 * @var EANPropertyAmenities
	 */
	protected $propertyAmenities;
	
	/**
	 * @var EANHotelImages
	 */
	protected $images;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'hotel' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelSummary',
		'details' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelDetails',
		'suppliers' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANSuppliers',
		'roomTypes' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANRoomTypes',
		'propertyAmenities' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANPropertyAmenities',
		'images' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelImages',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseHotelInformation $supportModel
	 * @return EANResponseHotelInformation
	 */
	public static function cast($supportModel) {
		return $supportModel;
		}
	
	protected function get__customerSessionId() {
		return $this->customerSessionId;
	}
			
	protected function get__hotel() {
		if ( isset($this->hotel) ) {
			return clone $this->hotel;
		}
		return null;
	}
			
	protected function get__details() {
		if ( isset($this->details) ) {
			return clone $this->details;
		}
		return null;
	}
			
	protected function get__suppliers() {
		if ( isset($this->suppliers) ) {
			return clone $this->suppliers;
		}
		return null;
	}
			
	protected function get__roomTypes() {
		if ( isset($this->roomTypes) ) {
			return clone $this->roomTypes;
		}
		return null;
	}
			
	protected function get__propertyAmenities() {
		if ( isset($this->propertyAmenities) ) {
			return clone $this->propertyAmenities;
		}
		return null;
	}
			
	protected function get__images() {
		if ( isset($this->images) ) {
			return clone $this->images;
		}
		return null;
	}
			
	protected function get__error() {
		if ( isset($this->error) ) {
			return clone $this->error;
		}
		return null;
	}
	
	/**
	 * TODO: get__xml
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::get__xml()
	 */
	protected function get__xml() {
		return $this->xml;
	}
	
	/**
	 * TODO: asXML
	 * (non-PHPdoc)
	 * @see \zamnuts\EANAPIClient\Common\SupportModels\EANAbstractSupportModel::asXML()
	 */
	public function asXML() {
		return parent::asXML();
	}
	
}
