<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \DateTime;

/**
 * @property int $itineraryId
 * @property string $affiliateId
 * @property string $affiliateCustomerId
 * @property DateTime $creationDate
 * @property DateTime $itineraryStartDate
 * @property DateTime $itineraryEndDate
 * @property-read EANCustomerInfo $customer
 * @property EANHotelConfirmation[] $confirmations
 */
class EANItinerary extends EANAbstractGroup implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'Itinerary';
	
	/**
	 * @var string
	 */
	public static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelConfirmation';
	
	/**
	 * @var int
	 */
	protected $itineraryId;
	
	/**
	 * @var string
	 */
	protected $affiliateId;
	
	/**
	 * @var string
	 */
	protected $affiliateCustomerId;
	
	/**
	 * @var DateTime
	 */
	protected $creationDate;
	
	/**
	 * @var DateTime
	 */
	protected $itineraryStartDate;
	
	/**
	 * @var DateTime
	 */
	protected $itineraryEndDate;
	
	/**
	 * @var EANCustomerInfo
	 */
	protected $customer;
	
	/**
	 * @var string[]
	 */
	protected static $propertyMap = array(
		'itineraryId' => 'int',
		'affiliateId' => 'string',
		'affiliateCustomerId' => 'string',
		'creationDate' => 'DateTime',
		'itineraryStartDate' => 'DateTime',
		'itineraryEndDate' => 'DateTime',
		'customer' => 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANCustomerInfo'
	);
	
	/**
	 * @param EANItinerary $supportModel
	 * @return EANItinerary
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	protected function get__itineraryId() {
		return $this->itineraryId;
	}
	
	protected function get__affiliateId() {
		return $this->affiliateId;
	}
	
	protected function get__affiliateCustomerId() {
		return $this->affiliateCustomerId;
	}
	
	protected function get__creationDate() {
		return clone $this->creationDate;
	}
	
	protected function set__creationDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->creationDate = new DateTime($date);
	}
	
	protected function get__itineraryStartDate() {
		return clone $this->itineraryStartDate;
	}
	
	protected function set__itineraryStartDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->itineraryStartDate = new DateTime($date);
	}
	
	protected function get__itineraryEndDate() {
		return clone $this->itineraryEndDate;
	}
	
	protected function set__itineraryEndDate($date) {
		if ( $date instanceof DateTime ) {
			$date = $date->format(DateTime::ISO8601);
		}
		$this->itineraryEndDate = new DateTime($date);
	}
	
	protected function get__customer() {
		if ( isset($this->customer) ) {
			return clone $this->customer;
		}
		return null;
	}
	
	/**
	 * @return EANHotelConfirmation[]
	 */
	protected function get__confirmations() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelConfirmation $hotelConfirmation
	 * @return boolean
	 */
	public function addConfirmation(EANHotelConfirmation $hotelConfirmation) {
		return $this->addItem($hotelConfirmation);
	}
	
	/**
	 * @param EANHotelConfirmation $hotelConfirmation
	 * @return boolean
	 */
	public function removeConfirmation(EANHotelConfirmation $hotelConfirmation) {
		return $this->removeItem($hotelConfirmation);
	}
	
}
