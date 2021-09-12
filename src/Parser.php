<?php
namespace Xparse;

class Parser {

	protected 
		$oValue,
		$oXpath;

	function __construct($strOrValue, $aOptions = null) {
		$this->oValue = Value::create($strOrValue);
	}

	function parseXml($docOrFile) {
		if ($docOrFile instanceof \DOMDocument) {
			$oDoc = $docOrFile;
		}
		else if (is_string($docOrFile)) {
			$str = is_file($docOrFile) ? file_get_contents($docOrFile) : $docOrFile;
			$oDoc = new \DOMDocument();
			$oDoc->loadXml($str);
		}
		else throw new \Exception("unable to parse document");
		
		return $this->parse($oDoc);
	}

	function parseHtml($docOrFile) {
		if ($docOrFile instanceof \DOMDocument) {
			$oDoc = $docOrFile;
		}
		else if (is_string($docOrFile)) {
			$str = is_file($docOrFile) ? file_get_contents($docOrFile) : $docOrFile;
			$oDoc = new \DOMDocument();
			$oDoc->loadHtml($str);
		}
		else throw new \Exception("unable to parse document");
		
		return $this->parse($oDoc);
	}

	function parse(\DOMDocument $oDoc) {
		$oDoc->normalizeDocument();
		$this->oXpath = new \DOMXpath($oDoc);
		return $this->oValue->parse($this, $oDoc->documentElement);
	}

	function query(string $query, \DOMNode $oNode) {
		$oNodes = @$this->oXpath->query($query, $oNode);
		if (!$oNodes) throw new \Exception("query invalid '$query'");
		return $oNodes;
	}

}