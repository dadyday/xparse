<?php
namespace Xparse\Value;

use Xparse\Parser;
use Xparse\Value;


class ValueNum extends Value {

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		foreach ($oNodes as $oNode) {
			if (preg_match('~\s*([+-]?\d[0-9,\.]*)~', $oNode->nodeValue, $aMatch)) {
				return (float) $aMatch[1];
			}
		}
		return null;
	}
}