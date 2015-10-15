<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

/**
 * 
 * @property EANLandmarkSummary[] $hotels
 */
class EANLandmarkListSummaries extends EANAbstractGroup {

	/**
	 * @var string
	 */
	protected static $ROOT = 'LocationInfos';
	
	/**
	 * @var string
	 */
	protected static $CHILD_CLASS = 'zamnuts\\EANAPIClient\\Common\\SupportModels\\EANLandmarkSummary';
	
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
	 * @return EANLandmarkSummary[]
	 */
	protected function get__hotels() {
		return $this->items;
	}
	
	/**
	 * @param EANLandmarkSummary $hotelSummary
	 * @return boolean
	 */
	public function addHotel(EANLandmarkSummary $hotelSummary) {
		return $this->addItem($hotelSummary);
	}
	
	/**
	 * @param EANLandmarkSummary $hotelSummary
	 * @return boolean
	 */
	public function removeHotel(EANLandmarkSummary $hotelSummary) {
		return $this->removeItem($hotelSummary);
	}
	
	/**
	 * 
	 * @param int[] $amenityMasks An array of amenity masks to filter.
	 * @return EANLandmarkSummary[]
	 */
	public function filterHotelsByAmenities($amenityMasks) {
		$result = array();
		foreach ( $this->items as $hotel ) {
			$hotel = EANLandmarkSummary::cast($hotel);
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
