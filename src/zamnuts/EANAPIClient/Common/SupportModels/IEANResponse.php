<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

interface IEANResponse {
	
	/**
	 * @param SimpleXMLElement $xml
	 */
	public function loadXML(SimpleXMLElement $xml);
	
}
