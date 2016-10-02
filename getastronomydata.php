<?php
// Run this once a day

require("settings.php");

$datafilehandle = fopen("$wundergrounddatafile", "w") or die ("Unable to open $wundergrounddatafile data file");

function callwundergroundapi($url) {

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    return "cURL Error #:" . $err;
    } else {
    return $response;
    }

}

$wundergrounddata = callwundergroundapi("http://api.wunderground.com/api/$wundergroundapikey/astronomy/q/Norway/Oslo.json");
fwrite($datafilehandle, $wundergrounddata);
fclose($datafilehandle);

?>