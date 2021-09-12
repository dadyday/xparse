<?php
namespace Xparse\Value;

use Xparse\Parser;
use Xparse\Value;


class ValueInt extends ValueNum {

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		$value = parent::result($oParser, $oNodes);
		return is_null($value) ? null : round($value);
	}
}