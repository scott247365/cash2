<?php

$symbol = $_GET['symbol'];

$url = "http://www.nasdaq.com/symbol/$symbol";

$c = file_get_contents($url);

//looks like: <div id="qwidget_lastsale" class="qwidget-dollar">$104.28</div>
preg_match('/<div id=\"qwidget_lastsale\" class=\"qwidget-dollar\">(.*?)<\/div>/i', $c, $m);

echo trim(trim($m[1], ' '), '$');

?>

