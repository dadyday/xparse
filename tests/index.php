<?php
require_once __DIR__.'/cfg.php';

//\Nette\TesterGui::run();
foreach (glob('*Test.php') as $file) {
	echo "<a href=\"/$file\">$file</a><br>";
}
