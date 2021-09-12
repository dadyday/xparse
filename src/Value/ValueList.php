<?php
namespace Xparse\Value;

use Xparse\Parser;
use Xparse\Value;


class ValueList extends Value {

	protected
		$oItemValue;

	function __construct(string $query, $itemValue, ...$aArg) {
		parent::__construct($query, ...$aArg);
		$this->oItemValue = static::create($itemValue);
	}

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		$aRet = [];
		foreach ($oNodes as $oNode) {
			$item = $this->oItemValue->parse($oParser, $oNode);
			$aRet[] = $item;
		}
		return $aRet;
	}
}