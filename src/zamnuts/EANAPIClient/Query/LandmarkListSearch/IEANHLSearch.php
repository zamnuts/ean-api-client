<?php

namespace zamnuts\EANAPIClient\Query\LandmarkListSearch;

interface IEANHLSearch {
	
	/**
	 * Checks if this class' properties are valid for use. 
	 * @return boolean
	 */
	public function isValid();
	
	/**
	 * Fetch an associative array containing prepared KVPs 
	 * that can be used for rendering.
	 * @return array
	 */
	public function renderPreparedArray();
	
}
