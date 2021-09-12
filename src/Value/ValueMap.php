<?php
namespace Xparse\Value;

use Xparse\Parser;
use Xparse\Value;


class ValueMap extends Value {

	protected
		$oKeyValue,
		$oValueValue;

	function __construct(string $query, $keyValue, $valueValue, ...$aArg) {
		parent::__construct($query, ...$aArg);
		$this->oKeyValue = static::create($keyValue);
		$this->oValueValue = static::create($valueValue);
	}

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		$aRet = [];
		foreach ($oNodes as $oNode) {
			$key = $this->oKeyValue->parse($oParser, $oNode);
			$value = $this->oValueValue->parse($oParser, $oNode);
			if (isset($aRet[$key])) {
				dump($aRet);
				throw new \Exception("the map has already a key of '$key'");
			}
			$aRet[$key] = $value;
		}
		return $aRet;
	}
}