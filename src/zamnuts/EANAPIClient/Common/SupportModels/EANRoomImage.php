<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property string $url
 */
class EANRoomImage extends EANAbstractSupportModel implements IEANSupportModel {

	/**
	 * @var string
	 */
	protected static $ROOT = 'RoomImage';
	
	/**
	 * @var string
	 */
	public static $THUMBNAIL_URL_PREFIX = 'http://images.travelnow.com'; // no trailing slash needed
	
	/**
	 * @var string
	 */
	protected $url;
		
	public static $propertyMap = array(
		'url' => 'string'
	);
	
	/**
	 * @param EANRoomImage $supportModel
	 * @return EANRoomImage
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
		
	protected function get__url() {
		return $this->url;
	}
	
	protected function set__url($value) {
		$this->url = $this->supplementUrlPrefix(trim(Utils::htmlEntitiesDecode($value)));
	}
	
	private function supplementUrlPrefix($url) {
		$parsed = parse_url($url);
		if ( isset($parsed['path']) ) {
			return rtrim(static::$THUMBNAIL_URL_PREFIX,'/').'/'.ltrim($parsed['path'],'/').(isset($parsed['query'])?'?'.$parsed['query']:'');
		}
		return null;
	}
		
}
