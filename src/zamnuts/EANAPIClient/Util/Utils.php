<?php

namespace zamnuts\EANAPIClient\Util;

use \Locale;
use \stdClass;
use \Traversable;

class Utils {

	/**
	 * Converts any type to boolean with consideration for strings like 'true' and 'false'.
	 * @param string $string
	 * @return boolean
	 */
	public static function anyToBoolean($string) {
		if ( strtolower((string) $string) === 'false' ) {
			return false;
		}
		return (boolean) $string;
	}

	public static $scalarTypes = array('string','int','integer','long','float','double','bool','boolean');

	/**
	 * Test if what the contents of the string represents a scalar value.
	 * Not to be confused with is_scalar which test the contents of the variable.
	 * @param string $str One of the strings specified in Utils::$scalarTypes.
	 * @param boolean $considerArray Optionally consider arrays (even though they're not scalar) (Default: true)
	 * @return boolean
	 */
	public static function isStringValueScalar($str,$considerArray=true) {
		$test = self::$scalarTypes;
		if ( $considerArray ) {
			$test[] = 'array';
		}
		return in_array(strtolower((string) $str),$test);
	}

	/**
	 * Is the current system OS windows?
	 * @return boolean
	 */
	public static function isWindows() {
		return strtoupper(substr(PHP_OS,0,3)) === 'WIN';
	}

	/**
	 * Check if a value/object/something is iterable/traversable,
	 * e.g. can it be run through a foreach?
	 * Tests for a scalar array (is_array), an instance of Traversable, and
	 * and instance of stdClass
	 * @param mixed $value
	 * @return boolean
	 */
	public static function isIterable($value) {
		return is_array($value) || $value instanceof Traversable || $value instanceof stdClass;
	}

	/**
	 * Forces the datatype of a specific variable. This is kind of stupid since
	 * PHP uses type juggling, but just in case you're a purist...
	 * @param string $type One of the strings specified in Utils::$scalarTypes.
	 * @param mixed $value The value that should be casted.
	 * @param boolean $autoTrim If true and $type is a string, it will apply trim().
	 * @return string|number|boolean|mixed
	 */
	public static function castScalar($type,$value,$autoTrim=true) {
		$type = strtolower((string) $type);
		switch ( $type ) {
			case 'string':
				$value = (string) $value;
				return $autoTrim?trim($value):$value;
				break;
			case 'int':
			case 'integer':
			case 'long':
				return (int) $value;
				break;
			case 'float':
			case 'double':
				return (float) $value;
				break;
			case 'boolean':
			case 'bool':
				return Utils::anyToBoolean($value);
				break;
		}
		return $value;
	}

	/**
	 * Attempts to get the RFC 2616 locale code from the HTTP Accept-Language header,
	 * if it fails for any number of reasons, the system default is returned (or whatever is specified as the fallback).
	 * @param string $fallbackLocale The locale to fall back to if there was a problem automatically determining one.
	 * @return string A RFC 2616 locale code.
	 */
	public static function clientLocale($fallbackLocale='') {
		if ( !$fallbackLocale ) {
			$fallbackLocale = Locale::getDefault();
			if ( !$fallbackLocale ) {
				$fallbackLocale = 'en_US';
			}
		}
		if ( isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) {
			//$locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']); // this was unreliable for zh
			preg_match('/^[a-z]{1,8}(-[a-z]{1,8})/i',$_SERVER['HTTP_ACCEPT_LANGUAGE'],$m); // partial RFC 2616 Sec 14.4
			if ( isset($m[0]) ) {
				$locale = Locale::canonicalize($m[0]);
			}
		}
		if ( !isset($locale) || !$locale ) {
			$locale = Locale::canonicalize($fallbackLocale);
			if ( !$locale ) {
				$locale = Locale::getDefault();
			}
		}
		return $locale;
	}

	/**
	 * Get the request client's IP address.
	 * Will test (in order) for headers specified by $customHeaders first,
	 * then HTTP_X_FORWARDED_FOR, HTTP_X_REAL_IP, and finally REMOTE_ADDR.
	 * If not found then 0.0.0.0 is returned.
	 * @param array|string $customHeaders Optional, an array of strings for more headers to test for (case sensitive).
	 * @return string
	 */
	public static function getIP($customHeaders=null) {
		$headers = array(
			'HTTP_X_CLUSTER_CLIENT_IP', // rackspace load balancer detection
			'HTTP_X_FORWARDED_FOR', // proxy detection
			'HTTP_X_REAL_IP', // fcgi detection (e.g. nginx)
			'REMOTE_ADDR' // standard fallback
		);
		if ( isset($customHeaders) ) {
			if ( is_array($customHeaders) ) {
				$headers = array_merge($customHeaders,$headers);
			} else if ( is_string($customHeaders) ) {
				array_unshift($headers,$customHeaders);
			}
		}
		foreach ( $headers as $header ) {
			if ( isset($_SERVER[$header]) && trim($_SERVER[$header]) ) {
				return trim($_SERVER[$header]);
			}
		}
		return '0.0.0.0';
	}

	/**
	 * Reworked from StackOverflow by netcoder http://stackoverflow.com/users/492901/netcoder
	 * @see http://stackoverflow.com/a/9265295/1481489
	 * @param array $data
	 * @return string
	 */
	public static function httpBuildQuery3986($data) {
		$data = http_build_query($data);
		$data = str_replace('+','%20',$data);
		$data = str_replace('%7E','~',$data);
		return $data;
	}

	/**
	 * Extended html entities decoding using an auxiliary lookup table.
	 * @see Utils::$htmlEntitiesExtendedTable
	 * @param string $string
	 * @return string
	 */
	public static function htmlEntitiesDecode($string) {
		foreach ( self::$htmlEntitiesExtendedTable as $numeric => $code ) {
			$string = str_replace('&'.$code.';','&#'.$numeric.';',$string);
		}
		return html_entity_decode($string,ENT_QUOTES,'UTF-8');
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public static function htmlEntitiesEncode($string) {
		return htmlentities($string,ENT_QUOTES|ENT_IGNORE,'UTF-8');
	}

	/**
	 * @see http://www.textfixer.com/resources/HTML_character_entity_list.php
	 * @var string[]
	 */
	public static $htmlEntitiesExtendedTable = array(
		34 => 'quot',
		38 => 'amp',
		39 => 'apos',
		60 => 'lt',
		62 => 'gt',
		160 => 'nbsp',
		161 => 'iexcl',
		162 => 'cent',
		163 => 'pound',
		164 => 'curren',
		165 => 'yen',
		166 => 'brvbar',
		167 => 'sect',
		168 => 'uml',
		169 => 'copy',
		170 => 'ordf',
		171 => 'laquo',
		172 => 'not',
		173 => 'shy',
		174 => 'reg',
		175 => 'macr',
		176 => 'deg',
		177 => 'plusmn',
		178 => 'sup2',
		179 => 'sup3',
		180 => 'acute',
		181 => 'micro',
		182 => 'para',
		183 => 'middot',
		184 => 'cedil',
		185 => 'sup1',
		186 => 'ordm',
		187 => 'raquo',
		188 => 'frac14',
		189 => 'frac12',
		190 => 'frac34',
		191 => 'iquest',
		192 => 'Agrave',
		193 => 'Aacute',
		194 => 'Acirc',
		195 => 'Atilde',
		196 => 'Auml',
		197 => 'Aring',
		198 => 'AElig',
		199 => 'Ccedil',
		200 => 'Egrave',
		201 => 'Eacute',
		202 => 'Ecirc',
		203 => 'Euml',
		204 => 'Igrave',
		205 => 'Iacute',
		206 => 'Icirc',
		207 => 'Iuml',
		208 => 'ETH',
		209 => 'Ntilde',
		210 => 'Ograve',
		211 => 'Oacute',
		212 => 'Ocirc',
		213 => 'Otilde',
		214 => 'Ouml',
		215 => 'times',
		216 => 'Oslash',
		217 => 'Ugrave',
		218 => 'Uacute',
		219 => 'Ucirc',
		220 => 'Uuml',
		221 => 'Yacute',
		222 => 'THORN',
		223 => 'szlig',
		224 => 'agrave',
		225 => 'aacute',
		226 => 'acirc',
		227 => 'atilde',
		228 => 'auml',
		229 => 'aring',
		230 => 'aelig',
		231 => 'ccedil',
		232 => 'egrave',
		233 => 'eacute',
		234 => 'ecirc',
		235 => 'euml',
		236 => 'igrave',
		237 => 'iacute',
		238 => 'icirc',
		239 => 'iuml',
		240 => 'eth',
		241 => 'ntilde',
		242 => 'ograve',
		243 => 'oacute',
		244 => 'ocirc',
		245 => 'otilde',
		246 => 'ouml',
		247 => 'divide',
		248 => 'oslash',
		249 => 'Ugrave',
		250 => 'Uacute',
		251 => 'Ucirc',
		252 => 'Uuml',
		253 => 'yacute',
		254 => 'thorn',
		255 => 'yuml',
		338 => 'OElig',
		339 => 'oelig',
		352 => 'Scaron',
		353 => 'scaron',
		376 => 'Yuml',
		402 => 'fnof',
		710 => 'circ',
		732 => 'tilde',
		913 => 'Alpha',
		914 => 'Beta',
		915 => 'Gamma',
		916 => 'Delta',
		917 => 'Epsilon',
		918 => 'Zeta',
		919 => 'Eta',
		920 => 'Theta',
		921 => 'Iota',
		922 => 'Kappa',
		923 => 'Lambda',
		924 => 'Mu',
		925 => 'Nu',
		926 => 'Xi',
		927 => 'Omicron',
		928 => 'Pi',
		929 => 'Rho',
		931 => 'Sigma',
		932 => 'Tau',
		933 => 'Upsilon',
		934 => 'Phi',
		935 => 'Chi',
		936 => 'Psi',
		937 => 'Omega',
		945 => 'alpha',
		946 => 'beta',
		947 => 'gamma',
		948 => 'delta',
		949 => 'epsilon',
		950 => 'zeta',
		951 => 'eta',
		952 => 'theta',
		953 => 'iota',
		954 => 'kappa',
		955 => 'lambda',
		956 => 'mu',
		957 => 'nu',
		958 => 'xi',
		959 => 'omicron',
		960 => 'pi',
		961 => 'rho',
		962 => 'sigmaf',
		963 => 'sigma',
		964 => 'tau',
		965 => 'upsilon',
		966 => 'phi',
		967 => 'chi',
		968 => 'psi',
		969 => 'omega',
		977 => 'thetasym',
		978 => 'Upsih',
		982 => 'piv',
		8194 => 'ensp',
		8195 => 'emsp',
		8201 => 'thinsp',
		8204 => 'zwnj',
		8205 => 'zwj',
		8206 => 'lrm',
		8207 => 'rlm',
		8211 => 'ndash',
		8212 => 'mdash',
		8216 => 'lsquo',
		8217 => 'rsquo',
		8218 => 'sbquo',
		8220 => 'ldquo',
		8221 => 'rdquo',
		8222 => 'bdquo',
		8224 => 'dagger',
		8225 => 'Dagger',
		8226 => 'bull',
		8230 => 'hellip',
		8240 => 'permil',
		8242 => 'prime',
		8243 => 'Prime',
		8249 => 'lsaquo',
		8250 => 'rsaquo',
		8254 => 'oline',
		8260 => 'frasl',
		8364 => 'euro',
		8465 => 'image',
		8472 => 'weierp',
		8476 => 'real',
		8482 => 'trade',
		8501 => 'alefsym',
		8592 => 'larr',
		8593 => 'uarr',
		8594 => 'rarr',
		8595 => 'darr',
		8596 => 'harr',
		8629 => 'crarr',
		8656 => 'lArr',
		8657 => 'UArr',
		8658 => 'rArr',
		8659 => 'dArr',
		8660 => 'hArr',
		8704 => 'forall',
		8706 => 'part',
		8707 => 'exist',
		8709 => 'empty',
		8711 => 'nabla',
		8712 => 'isin',
		8713 => 'notin',
		8715 => 'ni',
		8719 => 'prod',
		8721 => 'sum',
		8722 => 'minus',
		8727 => 'lowast',
		8730 => 'radic',
		8733 => 'prop',
		8734 => 'infin',
		8736 => 'ang',
		8743 => 'and',
		8744 => 'or',
		8745 => 'cap',
		8746 => 'cup',
		8747 => 'int',
		8756 => 'there4',
		8764 => 'sim',
		8773 => 'cong',
		8776 => 'asymp',
		8800 => 'ne',
		8801 => 'equiv',
		8804 => 'le',
		8805 => 'ge',
		8834 => 'sub',
		8835 => 'sup',
		8836 => 'nsub',
		8838 => 'sube',
		8839 => 'supe',
		8853 => 'oplus',
		8855 => 'otimes',
		8869 => 'perp',
		8901 => 'sdot',
		8968 => 'lceil',
		8969 => 'rceil',
		8970 => 'lfloor',
		8971 => 'rfloor',
		9001 => 'lang',
		9002 => 'rang',
		9674 => 'loz',
		9824 => 'spades',
		9827 => 'clubs',
		9829 => 'hearts',
		9830 => 'diams'
	);

}
