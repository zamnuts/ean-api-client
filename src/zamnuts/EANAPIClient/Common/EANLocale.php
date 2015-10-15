<?php

namespace zamnuts\EANAPIClient\Common;

use \Locale;
use \NumberFormatter;
use zamnuts\EANAPIClient\Util\ObjectBase;
use zamnuts\EANAPIClient\Util\Utils;

/**
 * @property-read string $locale
 * @property-read string $currency
 * @property-read string[] $supportedLocales
 * @property-read string[] $supportedCurrencies
 * @property-read string[] $unsupportedAmexCurrencies
 * @property-read string[] $localeToCurrencyTable
 * @property-read string $currencySymbol
 * @see http://developer.ean.com/general-info/hotel-language-options/
 * @see http://developer.ean.com/general-info/hotel-currency-options/
 * @see http://developer.ean.com/docs/common/
 */
class EANLocale extends ObjectBase {
	
	// supported EAN locales
	protected static $LOCALES = array(
		'US' => 'en_US',
		'GB' => 'en_GB',
		'SA' => 'ar_SA',
		'CZ' => 'cs_CZ',
		'DK' => 'da_DK',
		'DE' => 'de_DE',
		'GR' => 'el_GR',
		'ES' => 'es_ES',
		'MX' => 'es_MX',
		'EE' => 'et_EE',
		'FI' => 'fi_FI',
		'FR' => 'fr_FR',
		'HU' => 'hu_HU',
		'HR' => 'hr_HR',
		'ID' => 'in_ID', // id_ID
		'IS' => 'is_IS',
		'IT' => 'it_IT',
		'JP' => 'ja_JP',
		'KR' => 'ko_KR',
		'MY' => 'ms_MY',
		'LV' => 'lv_LV',
		'LT' => 'lt_LT',
		'NL' => 'nl_NL',
		'NO' => 'no_NO',
		'PL' => 'pl_PL',
		'BR' => 'pt_BR',
		'PT' => 'pt_PT',
		'RU' => 'ru_RU',
		'SE' => 'sv_SE',
		'SK' => 'sk_SK',
		'TH' => 'th_TH',
		'TR' => 'tr_TR',
		'UA' => 'uk_UA',
		'VN' => 'vi_VN',
		'TW' => 'zh_TW',
		'CN' => 'zh_CN'
	);
	
	/**
	 * This is UTF-8
	 * @var string[]
	 */
	protected static $LOCALES_TO_LANGUAGE = array(
		'in_ID' => 'Bahasa Indonesia', // id_ID
		'ms_MY' => 'Bahasa Melayu',
		'da_DK' => 'Dansk',
		'de_DE' => 'Deutsch',
		'cs_CZ' => 'Čeština', // alt: Česky
		'et_EE' => 'Eesti keel',
		'en_GB' => 'English (UK)',
		'en_US' => 'English (US)',
		'es_ES' => 'Español (de España)',
		'es_MX' => 'Español (de México)',
		'fr_FR' => 'Français',
		'hr_HR' => 'Hrvatski',
		'is_IS' => 'íslenska',
		'it_IT' => 'Italiano',
		'lv_LV' => 'Latviešu',
		'lt_LT' => 'Lietuvių',
		'hu_HU' => 'magyar',
		'nl_NL' => 'Nederlands',
		'no_NO' => 'Norsk',
		'pl_PL' => 'Polski',
		'pt_PT' => 'Português',
		'pt_BR' => 'Português (do Brasil)',
		'sk_SK' => 'slovenčina',
		'fi_FI' => 'suomi',
		'sv_SE' => 'Svenska',
		'vi_VN' => 'Tiếng Việt',
		'tr_TR' => 'Türkçe',
		'el_GR' => 'Ελληνικά',
		'ru_RU' => 'Русский',
		'uk_UA' => 'Українська',
		'ar_SA' => 'العربية',
		'th_TH' => 'ไทย',
		'ko_KR' => '한국어',
		'zh_CN' => '中文 (简体)', // simplified chinese
		'zh_TW' => '正體中文 (繁體)', // traditional chinese, alt: 中文 (繁體)
		'ja_JP' => '日本語'
	);
	
	// rfc 5646 to windows locale table
	protected static $LOCALES_WIN = array(
		'en_US' => 'english-us',
		'en_GB' => 'english-uk',
		'ar_SA' => 'arabic',
		'cs_CZ' => 'czech',
		'da_DK' => 'danish',
		'de_DE' => 'german',
		'el_GR' => 'greek',
		'es_ES' => 'spanish-modern',
		'es_MX' => 'spanish-mexican',
		'et_EE' => 'estonian',
		'fi_FI' => 'finnish',
		'fr_FR' => 'french',
		'hu_HU' => 'hungarian',
		'hr_HR' => 'croatian',
		'id_ID' => 'indonesian', // in_ID
		'is_IS' => 'icelandic',
		'it_IT' => 'italian',
		'ja_JP' => 'japanese',
		'ko_KR' => 'korean',
		'ms_MY' => 'malay',
		'lv_LV' => 'latvian',
		'lt_LT' => 'lithuanian',
		'nl_NL' => 'dutch',
		'nb_NO' => 'norwegian',
		'pl_PL' => 'polish',
		'pt_BR' => 'ptb',
		'pt_PT' => 'ptg',
		'ru_RU' => 'russian',
		'sv_SE' => 'swedish',
		'sk_SK' => 'slovak',
		'th_TH' => 'thai',
		'tr_TR' => 'turkish',
		'uk_UA' => 'ukrainian',
		'vi_VN' => 'vietnamese',
		'zh_TW' => 'chinese-traditional',
		'zh_CN' => 'chinese-simplified'
	);
	
	// supported EAN currencies, ISO 4217
	protected static $CURRENCIES = array(
		'AUD' => 'Australian Dollar',
		'BRL' => 'Brazilian Real',
		'CAD' => 'Canadian Dollar',
		'CHF' => 'Swiss Franc',
		'CNY' => 'China Yuan',
		'DKK' => 'Danish Krone',
		'EUR' => 'Euro',
		'GBP' => 'British Pound',
		'HKD' => 'Hong Kong Dollar',
		'ILS' => 'Israel New Shekel',
		'IDR' => 'Indonesian Rupiah',
		'INR' => 'Indian Rupee',
		'JPY' => 'Japanese Yen',
		'KRW' => 'Korean Won',
		'MXN' => 'Mexican Peso',
		'MYR' => 'Malaysian Ringgit',
		'NOK' => 'Norwegian Kroner',
		'NZD' => 'New Zealand Dollar',
		'RUB' => 'Russian Ruble',
		'SEK' => 'Swedish Krona',
		'SGD' => 'Singapore Dollar',
		'THB' => 'Thai Bhatt',
		'TWD' => 'New Taiwan Dollar',
		'USD' => 'U.S. Dollar'
	);
	
	// unsupported amex currencies
	protected static $UNSUPPORTED_CURRENCIES_AMEX = array('BRL','INR','MXN');
	
	// recommended EAN country to currency table
	protected static $TABLE_LOCALE_CURRENCY = array(
		// NA
		'US' => 'USD',
		'CA' => 'CAD',
		// LATAM
		'BR' => 'BRL',
		'MX' => 'MXN',
		// APAC
		'AU' => 'AUD',
		'IN' => 'INR',
		'JP' => 'JPY',
		'NZ' => 'NZD',
		'HK' => 'HKD',
		'SG' => 'SGD',
		'KR' => 'KRW',
		'CN' => 'CNY',
		'TW' => 'USD',
		'PH' => 'USD',
		'TH' => 'USD',
		'MY' => 'USD',
		'ID' => 'USD',
		// EMEA
		'GB' => 'GBP',
		'DE' => 'EUR',
		'IT' => 'EUR',
		'ES' => 'EUR',
		'NL' => 'EUR',
		'SE' => 'SEK',
		'NO' => 'NOK',
		'DK' => 'DKK',
		'CH' => 'CHF',
		'RU' => 'RUB',
		'IL' => 'ILS',
		'BE' => 'EUR',
		'FI' => 'EUR',
		'IE' => 'EUR',
		'AT' => 'EUR',
		'GR' => 'EUR',
		'PT' => 'EUR',
		'PL' => 'USD',
		'CZ' => 'USD',
		'HU' => 'USD',
		'IS' => 'USD',
		'TR' => 'USD',
		'ZA' => 'USD',
		'LV' => 'USD',
		'EE' => 'USD',
		'LT' => 'USD',
		'UA' => 'USD',
		'SK' => 'USD',
		'HR' => 'USD'
	);
	
	// inverted (with assumptions) from $TABLE_LOCALE_CURRENCY
	protected static $TABLE_CURRENCY_LOCALE = array(
		'AUD' => 'AU',
		'BRL' => 'BR',
		'CAD' => 'CA',
		'CHF' => 'CH',
		'CNY' => 'CN',
		'DKK' => 'DK',
		'EUR' => 'DE', // lazy
		'GBP' => 'GB',
		'HKD' => 'HK',
		'ILS' => 'IL',
		'IDR' => 'ID', // never used, USD only
		'INR' => 'IN',
		'JPY' => 'JP',
		'KRW' => 'KR',
		'MXN' => 'MX',
		'MYR' => 'MY', // never used, USD only
		'NOK' => 'NO',
		'NZD' => 'NZ',
		'RUB' => 'RU',
		'SEK' => 'SE',
		'SGD' => 'SG',
		'THB' => 'TH', // never used, USD only
		'TWD' => 'TW', // never used, USD only
		'USD' => 'US' // lazy
	);
	
	/**
	 * This is hard coded and not looked up via an API. 
	 * Use these numbers for the sole purpose of approximation (ballpark figures). 
	 * Multiply the USD rate by the floating value for the estimate. 
	 * @var float[]
	 */
	public static $EXCHANGE_MULTIPLIER_USD = array(
		'AUD' => 1.10,
		'BRL' => 2.34,
		'CAD' => 1.06,
		'CHF' => 0.91,
		'CNY' => 6.09,
		'DKK' => 5.49,
		'EUR' => 0.74,
		'GBP' => 0.61,
		'HKD' => 7.75,
		'ILS' => 3.52,
		'IDR' => 11962.00,
		'INR' => 62.39,
		'JPY' => 102.43,
		'KRW' => 1058.21,
		'MXN' => 13.11,
		'MYR' => 3.22,
		'NOK' => 6.13,
		'NZD' => 1.23,
		'RUB' => 33.14,
		'SEK' => 6.56,
		'SGD' => 1.25,
		'THB' => 32.05,
		'TWD' => 29.59,
		'USD' => 1.00
	);
	
	/**
	 * RFC 2616
	 * @var string
	 */
	const DEFAULT_LOCALE = 'en_US';
	
	/**
	 * ISO 4217
	 * @var string
	 */
	const DEFAULT_CURRENCY = 'USD';
	
	/**
	 * @var string The normalized RFC 2616 locale.
	 */
	private $cachedLocale = '';
	
	/**
	 * @var string The normalized ISO 4217 3-letter currency code.
	 */
	private $cachedCurrency = '';
	
	/**
	 * @var string The currency symbol based on cachedCurrency.
	 */
	private $cachedSymbol = '';
	
	/**
	 * @var string The originally requested locale (or "auto").
	 */
	private $locale;
	
	/**
	 * @var string The originally requested currency (or "auto").
	 */
	private $currency;
	
	/**
	 * @param string $locale
	 * @param string $currency
	 */
	public function __construct($locale,$currency) {
		$this->updateLocale($locale,$currency);
	}
	
	/**
	 * @return string
	 */
	protected function get__locale() {
		return $this->cachedLocale;
	}
	
	/**
	 * @return string
	 */
	protected function get__currency() {
		return $this->cachedCurrency;
	}
	
	/**
	 * @return string[]
	 */
	protected function get__supportedLocales() {
		return self::$LOCALES;
	}
	
	/**
	 * @return string[]
	 */
	protected function get__supportedCurrencies() {
		return self::$CURRENCIES;
	}
	
	/**
	 * @return string[]
	 */
	protected function get__unsupportedAmexCurrencies() {
		return self::$UNSUPPORTED_CURRENCIES_AMEX;
	}
	
	/**
	 * @return string[]
	 */
	protected function get__localeToCurrencyTable() {
		return self::$TABLE_LOCALE_CURRENCY;
	}
	
	/**
	 * Returns a copy of the internal locales to currency map.
	 * @return string[]
	 */
	public static function localeToCurrencyTable() {
		return self::$TABLE_LOCALE_CURRENCY;
	}
	
	/**
	 * @return string
	 */
	protected function get__currencySymbol() {
		return $this->cachedSymbol;
	}
	
	/**
	 * Returns a copy of the internal locales to language map.
	 * @return string[]
	 */
	public static function localesToLanguageTable() {
		return static::$LOCALES_TO_LANGUAGE;
	}
	
	/**
	 * @param string $locale
	 * @param string $currency
	 */
	public function updateLocale($locale,$currency) {
		$this->locale = (string) $locale;
		$this->currency = (string) $currency;
		$this->normalizeLocale();
	}
	
	/**
	 * Like invoking setlocale with EANLocale's stored locale and UTF-8.
	 * @return string
	 */
	public function syncPHPLocale() {
		$locale = $this->cachedLocale;
		if ( strtoupper($locale) === 'IN_ID' ) {
			$locale = 'id_ID';
		} else if ( strtoupper($locale) === 'NO_NO' ) {
			$locale = 'nb_NO';
		}
		if ( Utils::isWindows() && isset(static::$LOCALES_WIN[$locale]) ) {
			$locale = static::$LOCALES_WIN[$locale];
		} else {
			$locale .= '.UTF-8';
		}
		return setlocale(LC_TIME,$locale);
	}
	
	/**
	 * @return void
	 */
	protected function normalizeLocale() {
		
		// determine auto or user-defined locale
		if ( $this->locale ) {
			if ( 'auto' === strtolower($this->locale) ) {
				$this->cachedLocale = Utils::clientLocale(self::DEFAULT_LOCALE);
			} else {
				$this->cachedLocale = $this->locale;
			}
		}
		
		// determine auto or user-defined currency
		if ( $this->currency ) {
			if ( 'auto' === strtolower($this->currency) ) {
				if ( $this->cachedLocale ) {
					$iso31661 = strtoupper((string) Locale::getRegion($this->cachedLocale));
					if ( $iso31661 && isset(self::$TABLE_LOCALE_CURRENCY[$iso31661]) ) {
						$this->cachedCurrency = self::$TABLE_LOCALE_CURRENCY[$iso31661];
					} else {
						$this->cachedCurrency = self::DEFAULT_CURRENCY;
					}
				} else {
					$this->cachedCurrency = self::DEFAULT_CURRENCY;
				}
			} else {
				$this->cachedCurrency = $this->currency;
			}
		}
		
		// normalize
		$this->cachedLocale = (string) $this->cachedLocale;
		$this->cachedLocale = Locale::canonicalize($this->cachedLocale?$this->cachedLocale:self::DEFAULT_LOCALE);
		$this->cachedCurrency = strtoupper((string) $this->cachedCurrency);
		
		// validate locale
		$iso31661 = strtoupper((string) Locale::getRegion($this->cachedLocale));
		if ( !$iso31661 || !isset(self::$LOCALES[$iso31661]) ) {
			$this->cachedLocale = self::DEFAULT_LOCALE;
			$iso31661 = strtoupper((string) Locale::getRegion($this->cachedLocale));
		}
		
		// validate currency
		if ( !isset(self::$CURRENCIES[$this->cachedCurrency]) ) {
			if ( $iso31661 && isset(self::$TABLE_LOCALE_CURRENCY[$iso31661]) ) {
				$this->cachedCurrency = self::$TABLE_LOCALE_CURRENCY[$iso31661];
			} else {
				$this->cachedCurrency = self::DEFAULT_CURRENCY;
			}
		}
		
		// cache currency symbol
		$iso31661 = self::$TABLE_CURRENCY_LOCALE[self::DEFAULT_CURRENCY];
		if ( $this->cachedCurrency && isset(self::$TABLE_CURRENCY_LOCALE[$this->cachedCurrency]) ) {
			$iso31661 = self::$TABLE_CURRENCY_LOCALE[$this->cachedCurrency];
		}
		$locale = self::DEFAULT_LOCALE;
		if ( isset(self::$LOCALES[$iso31661]) ) {
			$locale = self::$LOCALES[$iso31661];
		}
		$formatter = new NumberFormatter($locale,NumberFormatter::CURRENCY);
		$this->cachedSymbol = (string) $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
	}
	
}
