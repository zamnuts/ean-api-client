<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

interface IEANSupportModel {
	
	/**
	 * @param IEANSupportModel $supportModel
	 * @return IEANSupportModel
	 */
	public static function cast($supportModel);
	
	/**
	 * @return string
	 */
	public function asXML();
	
	/**
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml);
	
}
