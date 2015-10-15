<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * @property EANHotelSummary[] $hotels
 */
class EANHotelListSummaries extends EANAbstractGroup {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'HotelList';
	
	/**
	 * @var string
	 */
	protected static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANHotelSummary';
	
	/**
	 * @var int
	 */
	public $activePropertyCount;
	
	/**
	 * @var string[]
	 */
	protected static $attributeMap = array(
		'activePropertyCount' => 'int'
	);
	
	/**
	 * @param EANRoomGroup $supportModel
	 * @return EANRoomGroup
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	/**
	 * @return EANHotelSummary[]
	 */
	protected function get__hotels() {
		return $this->items;
	}
	
	/**
	 * @param EANHotelSummary $hotelSummary
	 * @return boolean
	 */
	public function addHotel(EANHotelSummary $hotelSummary) {
		return $this->addItem($hotelSummary);
	}
	
	/**
	 * @param EANHotelSummary $hotelSummary
	 * @return boolean
	 */
	public function removeHotel(EANHotelSummary $hotelSummary) {
		return $this->removeItem($hotelSummary);
	}
	
	/**
	 * 
	 * @param array[int] $amenityMasks An array of amenity masks to filter.
	 * @return EANHotelSummary[]
	 */
	public function filterHotelsByAmenities($amenityMasks) {
		$result = array();
		foreach ( $this->items as $hotel ) {
			$hotel = EANHotelSummary::cast($hotel);
			$isMissingAmenity = false;
			foreach ( $amenityMasks as $mask ) {
				if ( !($hotel->amenityMask & $mask) ) {
					$isMissingAmenity = true;
				}
			}
			if ( !$isMissingAmenity ) {
				array_push($result,$hotel);
			}
		}
		return $result;
	}
	
}
