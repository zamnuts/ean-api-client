<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property-read string $customerSessionId
 * @property-read string $cancellationNumber
 * @property-read EANError $error
 */
class EANResponseHotelRoomCancellation extends EANAbstractSupportModel implements IEANResponse {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelRoomCancellationResponse';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	protected $customerSessionId;
	
	/**
	 * @var string
	 */
	protected $cancellationNumber;
	
	/**
	 * @var EANError
	 */
	protected $error;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'customerSessionId' => 'string',
		'cancellationNumber' => 'string',
		'error' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANError'
	);
	
	/**
	 * @param EANResponseHotelRoomCancellation $supportModel
	 * @return EANResponseHotelRoomCancellation
	 */
	public static function cast($supportModel) {
		return $supportModel;
		}
	
	protected function get__customerSessionId() {
		return $this->customerSessionId;
	}
	
	protected function get__cancellationNumber() {
		return $this->cancellationNumber;
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
