<?php
header('Content-Type: text/html; charset=utf-8');
/* 
 * Gets all the countries displayed at URL : http://www.booking.com/country.en.html
 * with flag, link, name properties
 */

include("../autoload.php");

$s = new spinner();
$s->noJobAuth();
$s->URL = "https://www.amazon.ca/Best-Sellers-generic/zgbs/";

$tf = new templateFinder(array('<body'), '</body>', TRUE);
$st = new searchTemplate("Best Sellers", true, $tf);
$st->addRoute(array("<li class=\"a-carousel-card\"", "p13n-sc-truncate-desktop-type2", ">"), "<", "name", 1, true);  
$st->addRoute(array("a-color-price", ">"), "</a", "price", 2, true);  
array_push($s->searchTemplate, $st);  

$x = $s->getResult();
print_r($x);