<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

class EANSmokingPreferencesTable {
	
	/**
	 * Non-smoking preferred.
	 * @var string
	 */
	const SMOKING_PREFERENCE_NS = 'NS';
	
	/**
	 * Smoking preferred.
	 * @var string
	 */
	const SMOKING_PREFERENCE_S = 'S';
	
	/**
	 * Either non-smoking or smoking preferred. No preference.
	 * @var string
	 */
	const SMOKING_PREFERENCE_E = 'E';
	
	/**
	 * Smoking preference ID to formal language map, default is in English.
	 * @var string[]
	 */
	public static $TABLE = array(
		'NS' => 'Non-Smoking',
		'S' => 'Smoking',
		'E' => 'No Preference'
	);
	
}
