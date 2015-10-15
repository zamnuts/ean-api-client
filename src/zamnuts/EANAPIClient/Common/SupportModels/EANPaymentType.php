<?php

namespace zamnuts\EANAPIClient\Common\SupportModels;

use \SimpleXMLElement;

/**
 * @property string $code
 * @property string $name
 */
class EANPaymentType extends EANAbstractSupportModel implements IEANSupportModel {
	
	/**
	 * @var string
	 */
	protected static $ROOT = 'PaymentType';
	
	const CARD_VI = 'Visa';
	const CARD_AX = 'American Express';
	const CARD_BC = 'BC Card';
	const CARD_MC = 'MasterCard';
	const CARD_IK = 'MasterCard Alaska';
	const CARD_CA = 'MasterCard Canada';
	const CARD_CB = 'Carte Blanche';
	const CARD_CU = 'China Union Pay';
	const CARD_DS = 'Discover';
	const CARD_DC = 'Diners Club';
	const CARD_T = 'Carta Si';
	const CARD_R = 'Carte Bleue';
	const CARD_N = 'Dankort';
	const CARD_L = 'Delta';
	const CARD_E = 'Electron';
	const CARD_JC = 'Japan Credit Bureau';
	const CARD_TO = 'Maestro';
	const CARD_S = 'Switch';
	const CARD_O = 'Solo';
	const CARD_F = 'Maestro';
	
	/**
	 * @var SimpleXMLElement
	 */
	protected $xml;
	
	/**
	 * @var string
	 */
	protected $code;
	
	/**
	 * @var string
	 */
	protected $name;
	
	public static $propertyMap = array(
		'code' => 'string',
		'name' => 'string'
	);
	
	/**
	 * @param EANPaymentType $supportModel
	 * @return EANPaymentType
	 */
	public static function cast($supportModel) {
		return $supportModel;
	}
	
	public function __construct($code=null,$name=null) {
		parent::__construct();
		$this->set__code($code);
		$this->set__name($name);
		$this->refreshXML();
	}
	
	protected function set__code($value) {
		if ( $value ) {
			$this->code = trim((string) $value);
		} else {
			$this->code = null;
		}
		$this->refreshXML();
	}
	
	protected function get__code() {
		return $this->code;
	}
	
	protected function set__name($value) {
		if ( $value ) {
			$this->name = trim((string) $value);
		} else {
			$this->name = null;
		}
		$this->refreshXML();
	}
	
	protected function get__name() {
		return $this->name;
	}
	
	protected function get__xml() {
		return $this->xml;
	}
	
	public function refreshXML() {
		if ( isset($this->code) ) {
			$this->xml->code = (string) $this->code;
		} else {
			unset($this->xml->code);
		}
		if ( isset($this->name) ) {
			$this->xml->name = (string) $this->name;
		} else {
			unset($this->xml->name);
		}
	}
	
	public static function isCardType($code) {
		return preg_match('/[A-Z]{1,2}/',$code) && defined('static::CARD_'.$code);
	}
	
}
