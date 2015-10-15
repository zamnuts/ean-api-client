<?php

namespace zamnuts\EANAPIClient;

// some structure with defaults
class EANConfig {

	/**
	 * @var int
	 */
	public $cid = 0;

	/**
	 * @var string
	 */
	public $apiKey = '';

	/**
	 * @var string
	 */
	public $apiSecret = '';

	/**
	 * @var string
	 */
	public $locale = 'en_US';

	/**
	 * @var string
	 */
	public $currency = 'USD';

	/**
	 * @var int
	 */
	public $sessionId = 'auto';

	/**
	 * @var string
	 */
	public $userIP = 'auto';

	/**
	 * @var string
	 */
	public $userAgent = 'auto';

	/**
	 * @var bool
	 */
	public $devMode = true;

}
