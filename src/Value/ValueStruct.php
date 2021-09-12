<?php
namespace Xparse\Value;

use Xparse\Parser;
use Xparse\Value;


class ValueStruct extends Value {

	protected
		$aValue;

	function __construct(array $aValue, ...$aArg) {
		parent::__construct('.', ...$aArg);
		$this->aValue = [];
		foreach ($aValue as $name => $itemValue) {
			$this->aValue[$name] = static::create($itemValue);
		}
	}

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		$oNode = $oNodes[0];
		
		$aRet = [];
		foreach ($this->aValue as $name => $oValue) {
			$value = $oValue->parse($oParser, $oNode);
			$aRet[$name] = $value;
		}
		return $aRet;

	}
}