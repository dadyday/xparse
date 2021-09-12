<?php
namespace Xparse;

abstract class Value {

	const
		STRING = 'Str',
		INTEGER = 'Int',
		FLOAT = 'Float',
		BOOLEAN = 'Bool',
		STRUCT = 'Struct',
		LIST = 'List',
		MAP = 'Map';

	static function create($oValue) {
		if (!$oValue instanceof Value) {
			if (is_string($oValue)) {
				$oValue = new Value\ValueStr($oValue);
			}
			else if (is_array($oValue)) {
				$oValue = new Value\ValueStruct($oValue);
			}
			else throw new \Exception("invalid query param");
		}
		return $oValue;
	}

	static function __callStatic($name, $aArg) {
		$class = __NAMESPACE__.'\Value\Value'.ucfirst($name);
		if (!\class_exists($class)) {
			throw new \Exception("class '$class' not found");
		}
		return new $class(...$aArg);
	}

	protected
		$query,
		$handler;

	function __construct(string $query, $default = null) {
		$this->query = $query;

		if (is_callable($default)) {
			$this->handler = $default;
		}
		else {
			$this->handler = function ($result) use ($default) { 
				return $result ?? $default;
			};
		}
	}

	function parse(Parser $oParser, \DOMNode $oNode) {
		$query = $this->query;
		$aFound = $oParser->query($query, $oNode);
		$result = $this->result($oParser, $aFound);
		return ($this->handler)($result);
	}

	function result(Parser $oParser, \DOMNodeList $oNodes = null) {
		$value = null;
		foreach ($oNodes as $oNode) {
			$value .= trim($oNode->nodeValue);
			if ($value) break;
		}
		return $value;
	}

}
