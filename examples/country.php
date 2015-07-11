<?php
header('Content-Type: text/html; charset=utf-8');
/* 
 * Gets all the countries displayed at URL : http://www.booking.com/country.en.html
 * with flag, link, name properties
 */

include("../autoload.php");

$s = new spinner();
$s->noJobAuth();
$s->URL = "http://www.booking.com/country.en.html";

$tf = new templateFinder(array('<body'), '</body>', TRUE);
$st = new searchTemplate("Countries", true, $tf);
$st->addRoute(array("<h2 style=\"", "url("), ");", "flag", 1, true);  
$st->addRoute(array("<a href=\""), "?sid", "link", 2, true);  
$st->addRoute(array(">"), "</a>", "name", 2, true);  
array_push($s->searchTemplate, $st);  

$x = $s->getResult();
print_r($x);