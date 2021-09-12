<?php
namespace Xparse\Value;

use Xparse\Parser;
use Xparse\Value;


class ValueBool extends Value {

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		$value = parent::result($oParser, $oNodes);
		return !empty($value);
	}
}