<?php

require("settings.php");
date_default_timezone_set('Europe/Oslo');

$datafilehandle = fopen($wundergrounddatafile, "r") or die("Cannot open $wundergrounddatafile data file.");
$wundergrounddata = fread($datafilehandle,filesize("$wundergrounddatafile"));
fclose($datafilehandle);
$wundergrounddata = json_decode($wundergrounddata);


$now = time();

$sunrise = DateTime::createFromFormat("G:i", $wundergrounddata->sun_phase->sunrise->hour . ":" . $wundergrounddata->sun_phase->sunrise->minute);
$sunrise = $sunrise->getTimestamp();
$sunset = DateTime::createFromFormat("G:i", $wundergrounddata->sun_phase->sunset->hour . ":" . $wundergrounddata->sun_phase->sunset->minute);
$sunset = $sunset->getTimestamp();




$minutestosunset = floor(($sunset - $now)/60);
$minutestosunrise = floor(($sunrise - $now)/60);

echo $now . "\n";
echo $minutestosunset . "\n";
echo $minutestosunrise . "\n";

?>


