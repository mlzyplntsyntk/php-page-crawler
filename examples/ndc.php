<?php
header('Content-Type: text/html; charset=utf-8');

include("../autoload.php");

$s = new spinner();
$s->noJobAuth();
$s->URL = "https://ndc-london.com/agenda/";

$tf = new templateFinder(array('day wednesday'), '</section>', TRUE);
$st = new searchTemplate("Countries", true, $tf);
//$st->addRoute(array("<h3", ">"), "</h3>", "time", 1, true);  
$st->addRoute(array("href=\""), "\">", "link", 1, true);  
$st->addRoute(array("data-time=\""), "\"", "time", 1, true);  
$st->addRoute(array(">"), "</p>", "room", 1, true);  
$st->addRoute(array("<h2", ">"), "</h2>", "title", 1, true);  
array_push($s->searchTemplate, $st);  

$x = $s->getResult();
//print_r($x);



$tf = new templateFinder(array('day thursday'), '</section>', TRUE);
$st = new searchTemplate("Countries", true, $tf);
//$st->addRoute(array("<h3", ">"), "</h3>", "time", 1, true);  
$st->addRoute(array("href=\""), "\">", "link", 1, true);  
$st->addRoute(array("data-time=\""), "\"", "time", 1, true);  
$st->addRoute(array(">"), "</p>", "room", 1, true);  
$st->addRoute(array("<h2", ">"), "</h2>", "title", 1, true);  
array_push($s->searchTemplate, $st);  

$x = $s->getResult(true);


$tf = new templateFinder(array('day friday'), '</section>', TRUE);
$st = new searchTemplate("Countries", true, $tf);
//$st->addRoute(array("<h3", ">"), "</h3>", "time", 1, true);  
$st->addRoute(array("href=\""), "\">", "link", 1, true);  
$st->addRoute(array("data-time=\""), "\"", "time", 1, true);  
$st->addRoute(array(">"), "</p>", "room", 1, true);  
$st->addRoute(array("<h2", ">"), "</h2>", "title", 1, true);  
array_push($s->searchTemplate, $st);  

$x = $s->getResult(true);

$result = [];

foreach ($x as $c) {
    $timeTemp = explode("<br/>", $c[1]["time"]);
    $day = $timeTemp[0];
    $time = $timeTemp[1];
    $result[] = [
        "link"=>$c[0]["link"],
        "day"=>$day,
        "time"=>$time,
        "room"=>$c[2]["room"],
        "title"=>$c[3]["title"]
    ];
}

header('Content-Type: application/json');
echo json_encode($result);

//print_r($x);