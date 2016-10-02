<?php

require("settings.php");

function callhueapi($method, $url, $data = false) {

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    ));
    if($data) {
    curl_setopt($curl,CURLOPT_POSTFIELDS, $data);
    }

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    return $response;
    }

}

function gethuelights($id = false) {
    global $bridgeip, $bridgeuser;
    if($id) { 
        $url = "http://$bridgeip/api/$bridgeuser/lights/$id";
    } else {
        $url = "http://$bridgeip/api/$bridgeuser/lights/";
    }
    $hueanswer = callhueapi("GET", $url);
    return json_decode($hueanswer);
}
function gethuegroups($id = false) {
    global $bridgeip, $bridgeuser;
    if($id) { 
        $url = "http://$bridgeip/api/$bridgeuser/groups/$id";
    } else {
        $url = "http://$bridgeip/api/$bridgeuser/groups/";
    }
    $hueanswer = callhueapi("GET", $url);
    return json_decode($hueanswer);
}
function sethuelight($id, $kelvin = false, $brightness = false, $transitiontime = 300){
    global $bridgeip, $bridgeuser;
    $options = array();
    if($kelvin) {
        $mirek = round(1000000 / $kelvin);
        $options[ct] = $mirek;
    }
    if($brightness) {
        if($brightness>100) { $brightness = 100; }
        $percenttobri = round((254/100)*$brightness);
        $options[bri] = $percenttobri;
    }
    if($transitiontime) {
        $options[transitiontime] = $transitiontime;
    }
    $data = json_encode($options);
    $hueanswer = callhueapi("PUT", "http://$bridgeip/api/$bridgeuser/lights/$id/state/", $data);
    return json_decode($hueanswer);
}
function sethuegroup($id, $kelvin = false, $brightness = false, $transitiontime = 300){
    global $bridgeip, $bridgeuser;
    $options = array();
    if($kelvin) {
        $mirek = round(1000000 / $kelvin);
        $options[ct] = $mirek;
    }
    if($brightness) {
        if($brightness>100) { $brightness = 100; }
        $percenttobri = round((254/100)*$brightness);
        $options[bri] = $percenttobri;
    }
    if($transitiontime) {
        $options[transitiontime] = $transitiontime;
    }
    $data = json_encode($options);
    $hueanswer = callhueapi("PUT", "http://$bridgeip/api/$bridgeuser/groups/$id/action/", $data);
    return json_decode($hueanswer);
}
/*
$huelights = gethuelights();
foreach($huelights as $huelightid=>$light) {
    sethuelight($huelightid, $sleeptemp, 100);
}
*/

$huegroups = gethuegroups();
foreach($huegroups as $huegroupid=>$light) {
    print_r(sethuegroup($huegroupid, $daylighttemp, 100, 18000));
}
//print_r($huegroups);


?>