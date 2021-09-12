<?php
require_once __DIR__.'/cfg.php';

use Xparse\Parser;
use Xparse\Value;

$oParser = new Parser(Value::list('body/table/tbody/tr[td]', [
	'name' => Value::str('td[1]/text()[normalize-space()]'),
	'time' => Value::int('td[2]'),
	'alt' => Value::bool('td[1]/a/span'),
	'in' => Value::map('td[3]/b',
		Value::str('following-sibling::span/a[2]'),
		Value::int('.')
	),
	'out' => Value::map('td[4]/b',
		Value::str('following-sibling::span/a[2]'),
		Value::int('.')
	),
]));
$aList = $oParser->parseHtml(__DIR__.'/demo.html');
dump($aList);

