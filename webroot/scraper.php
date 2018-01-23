<?php

$from = $_GET['from'];
$to = $_GET['to'];

$url = "http://www.x-rates.com/calculator/?from=$from&to=$to&amount=1";

$c = file_get_contents($url);

preg_match('/<span class=\"ccOutputRslt\">(.*?)<span class=\"ccOutputTrail\">/i', $c, $m);

echo $m[1];

?>

