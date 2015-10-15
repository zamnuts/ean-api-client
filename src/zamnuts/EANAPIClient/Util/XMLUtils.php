<?php

namespace zamnuts\EANAPIClient\Util;

use \DOMDocument;
use \DOMNodeList;
use \DomNode;
use \SimpleXMLElement;

class XMLUtils {
	
	/**
	 * Get the xml string for a SimpleXMLElement without the XML declaration.
	 * Returns an empty string on failure.
	 * @param SimpleXMLElement $node
	 * @return string
	 */
	public static function SXEasXML(SimpleXMLElement $node) {
		$dom = dom_import_simplexml($node);
		if ( $dom ) {
			return trim($dom->ownerDocument->saveXML($dom->ownerDocument->documentElement));
		}
		return '';
	}
	
	/**
	 * Convert a SimpleXMLElement to a DOMDocument.
	 * Returns false on failure.
	 * @param SimpleXMLElement $node
	 * @param string $encoding
	 * @return boolean|DOMDocument
	 */
	public static function SXEtoDOM(SimpleXMLElement $node,$encoding='utf-8') {
		$domSXE = dom_import_simplexml($node);
		if ( !$domSXE ) {
			return false;
		}
		$dom = new DOMDocument('1.0',$encoding);
		$dom->appendChild($dom->importNode($domSXE,true));
		return $dom;
	}
	
	/**
	 * Add one SimpleXMLElement to another.
	 * @param SimpleXMLElement $sxeTo The SXE to append to. This is modified (passed by reference, also SXE objects are resources).
	 * @param SimpleXMLElement $sxeFrom The SXE to append from. This is not modified, and is actually internally cloned.
	 * @param boolean $wrap Whether to encapsulate the root XML node in another node or not. This is mainly used internally. True will consider the original root element, and false will ignore it.
	 * @see http://pt.php.net/manual/en/ref.simplexml.php#91561
	 */
	public static function appendSXE(SimpleXMLElement &$sxeTo,SimpleXMLElement $sxeFrom,$wrap=true) {
		if ( $wrap ) {
			$sxeFromClone = new SimpleXMLElement('<wrap>'.self::SXEasXML($sxeFrom).'</wrap>');
		} else {
			$sxeFromClone = clone $sxeFrom;
		}
		foreach ( $sxeFromClone->children() as $sxeChild ) {
			/* @var $sxeChild SimpleXMLElement */
			$sxeTemp = $sxeTo->addChild($sxeChild->getName(),preg_replace('/&(?![a-z0-9]+;)/','&amp;',(string) $sxeChild)); // throws unterminated entity reference warnings when rogue & are not escaped
			foreach ( $sxeChild->attributes() as $attrKey => $attrValue ) {
				$sxeTemp->addAttribute($attrKey,$attrValue);
			}
			self::appendSXE($sxeTemp,$sxeChild,false);
		}
	}
	
	/**
	 * Cleans HTML syntax. Does not actually use Tidy, uses DOMDocument::loadHTML instead.
	 * @param string $dirtyHtml
	 * @return DOMNodeList Returns a list of top-level nodes.
	 */
	public static function tidyPartialHTML($dirtyHtml) {
		$dirtyHtml = (string) $dirtyHtml;
		if ( $dirtyHtml ) {
			$libxmlUIE = libxml_use_internal_errors(true);
			$dom = new DOMDocument('1.0','UTF-8');
			$dom->loadHTML(mb_convert_encoding($dirtyHtml,'HTML-ENTITIES','UTF-8'));
			libxml_use_internal_errors($libxmlUIE);
			$body = self::htmlBody($dom);
			if ( isset($body) ) {
				return $body->childNodes;
			}
		}
		return new DOMNodeList();
	}
	
	/**
	 * Get the contents of the <body> tag.
	 * @param DOMDocument $dom
	 * @return DOMNode
	 */
	public static function htmlBody(DOMDocument $dom) {
		return $dom->getElementsByTagName('body')->item(0);
	}
	
	/**
	 * Concatenate siblings in a DOMNodeList as a XML string.
	 * @param DOMNodeList $nodeList
	 * @param boolean $asXML
	 * @return string
	 */
	public static function nodeListToString(DOMNodeList $nodeList,$asXML=true) {
		$buffer = '';
		if ( $asXML ) {
			foreach ( $nodeList as $node ) {
				$buffer .= $node->ownerDocument->saveXML($node);
			}
		} else {
			foreach ( $nodeList as $node ) {
				$buffer .= $node->ownerDocument->saveHTML($node);
			}
		}
		return $buffer;
	}
	
	/**
	 * As if one were to perform tidyPartialHTML and nodeListToString in series.
	 * @param string $dirtyHtml The really nasty dirty HTML that should be washed with soap.
	 * @param bool $isSpecialCharEncoded Set to true if the incoming is encoded with htmlspecialchars or htmlentities (or Utils::htmlEntitiesEncode).
	 * @param bool $autoDetectEncoded Defaults to true, will auto-detect encoded entities/html. Takes precedence over $isSpecialCharEncoded.
	 * @return string An empty string on failure, or something clean if successful.
	 */
	public static function tidyPartialHTMLToString($dirtyHtml,$isSpecialCharEncoded=false,$autoDetectEncoded=true) {
		if ( !isset($autoDetectEncoded) ) {
			$autoDetectEncoded = false;
		}
		$dirtyHtml = (string) $dirtyHtml;
		if ( $autoDetectEncoded ) {
			$hasTags = static::hasTags($dirtyHtml);
			$hasEntities = static::hasEntities($dirtyHtml);
			if ( $hasEntities && !$hasTags ) {
				$dirtyHtml = Utils::htmlEntitiesDecode($dirtyHtml);
			}
		} else if ( $isSpecialCharEncoded ) {
			$dirtyHtml = Utils::htmlEntitiesDecode($dirtyHtml);
		}
		$cleanHtml = '';
		$nodes = XMLUtils::tidyPartialHTML($dirtyHtml);
		if ( isset($nodes) ) {
			$cleanHtml = XMLUtils::nodeListToString($nodes);
		}
		return $cleanHtml;
	}
	
	/**
	 * Detect if an input string has HTML tags.
	 * @param string $input
	 * @return boolean
	 */
	public static function hasTags($input) {
		return preg_match('/<[^>]+>/',$input) === 1;
	}
	
	/**
	 * Detect if an input string has encoded HTML entities.
	 * @param string $input
	 * @return boolean
	 */
	public static function hasEntities($input) {
		return !(strcmp($input,Utils::htmlEntitiesDecode($input)) == 0);
	}
	
}
