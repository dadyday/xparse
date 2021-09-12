<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

Tracy\Debugger::enable();
Tracy\Debugger::$maxDepth = 8;
Tracy\Debugger::$strictMode = true;
