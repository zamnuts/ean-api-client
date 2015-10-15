<?php

namespace zamnuts\EANAPIClient\Util;

class MathUtils {
	
	/**
	 * Rounds a float to the nearest 0.5.
	 * @param float $x
	 * @return float
	 */
	public static function roundHalf($x) {
		return (float) round( $x * 2 ) / 2;
	}
	
	/**
	 * Bounds a number (float or integer) by a given min (or -INF) or max (or +INF).
	 * @param number $x
	 * @param number $min
	 * @param number $max
	 * @return number
	 */
	public static function bound($x,$min=null,$max=null) {
		if ( !isset($min) ) {
			$min = -INF;
		}
		if ( !isset($max) ) {
			$max = INF;
		}
		return min(max($x,$min),$max);
	}
	
	/**
	 * Checks if a number (int or float) is between a minimum and maximum, 
	 * optionally considering whether min and max are inclusive. 
	 * @param int|float $x The value to test
	 * @param int|float $min The minimum value to compare against.
	 * @param int|float $max The maximum value to compare against.
	 * @param bool $inclusive Whether min and max are inclusive or not, default: true
	 * @return boolean
	 */
	public static function isInBounds($x,$min=0,$max=0,$inclusive=true) {
		if ( $inclusive ) {
			return $x >= $min && $x <= $max;
		} else {
			return $x > $min && $x < $max;
		}
	}
	
	/**
	 * Clamp latitude float (DD.MMmm...) to -90.0...+90.0
	 * @param float $latitude
	 * @return float
	 */
	public static function normalizeLatitude($latitude) {
		$latitude = (float) $latitude;
		if ( $latitude > 0 ) {
			$latitude = (float) min($latitude,90.0);
		} else {
			$latitude = (float) max($latitude,-90.0);
		}
		return (float) round($latitude,7);
	}
	
	/**
	 * Convert longitude float (DDD.MMmm...) to -180.0...+180.0, will roll the value as needed.
	 * @param float $longitude
	 * @return float
	 */
	public static function normalizeLongitude($longitude) {
		$longitude = (float) $longitude;
		$result = (float) $longitude%360;
		if ( $result > 180 ) {
			$result = (float) -180 + ( $result - 180 );
		} else if ( $result < -180 ) {
			$result = (float) 180 + ( $result + 180 );
		}
		return (float) round($result,7);
	}
	
	/**
	 * The ratio between miles and kilomters; 1 mile = 1.609344 kilometers
	 * @var float
	 */
	public static $RATIO_MI_TO_KM = 1.609344;
	
	public static $RATIO_KM_TO_MI = 0.621371;
	
	/**
	 * Convert miles to kilometers.
	 * @param float $miles
	 * @return float
	 */
	public static function milesToKilometers($miles) {
		$miles = (float) $miles;
		return $miles * self::$RATIO_MI_TO_KM;
	}
	
	/**
	 * Convert kilometers to miles.
	 * @param float $kilometers
	 * @return float
	 */
	public static function kilometersToMiles($kilometers) {
		$kilometers = (float) $kilometers;
		return $kilometers * self::$RATIO_KM_TO_MI;
	}
	
	public static $IECAbbreviations = array('B','KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB');
	
	/**
	 * Converts bytes (as an integer) to a human-readable binary prefix format (string with unit).
	 * @see MathUtils::$IECAbbreviations
	 * @param int $bytes
	 * @return string
	 */
	public static function convertToBinaryPrefix($bytes) {
		$calcBytes = $bytes;
		if ( !$bytes ) {
			return '0 '.self::$IECAbbreviations[0];
		} else if ( $bytes < 0 ) {
			$calcBytes = abs($calcBytes);
		}
		$i = (int) floor(log($calcBytes,1024));
		$result = @round($calcBytes/pow(1024,$i),2).' '.self::$IECAbbreviations[$i];
		if ( $bytes < 0 ) {
			return '-'.$result; 
		}
		return $result;
	}
	
	/**
	 * Check if the given string is a Luhn/mod10 based number.
	 * @param string $subject
	 * @return boolean
	 */
	public static function luhnValid($subject) {
		$checkDigit = static::luhnCheckDigit($subject);
		$checksum = static::luhnChecksum($subject);
		$mod10 = $checksum * 9 % 10;
		return  $mod10 === $checkDigit;
	}
	
	/**
	 * Generate the Luhn checksum.
	 * @param string $subject
	 * @return int
	 */
	public static function luhnChecksum($subject) {
		$sum = 0;
		foreach ( str_split(strrev($subject)) as $i => $digit ) {
			if ( $i % 2 ) {
				$double = $digit * 2;
				if ( $double > 9 ) {
					$doubleSum = 0;
					foreach ( str_split($double) as $v ) {
						$doubleSum += $v;
					}
					$double = $doubleSum;
				}
				$sum += $double;
			} else if ( $i !== 0 ) {
				$sum += $digit;
			}
		}
		return $sum;
	}
	
	/**
	 * Get the check digit for use in validating a Luhn compatible number.
	 * @param string $subject
	 * @return int
	 */
	public static function luhnCheckDigit($subject) {
		return (int) substr($subject,-1);
	}
	
}
