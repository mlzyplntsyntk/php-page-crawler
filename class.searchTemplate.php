<?php

class searchTemplate {
    var $templateFinder;
    var $repeats;
    var $routeWSDL = array();
    var $name;

    function searchTemplate($name, $repeats, $tf)
    {
        $this->name = $name;
        $this->templateFinder = $tf;
        $this->repeats = $repeats;
        $this->routeWSDL = array();
    }

    function addRoute($startIndexes, $endIndex, $fieldName, $sortOrder, $breakIfNoneFound)
    {
        $w = new RouteWSDL();
        
    	$w->breakIfNoneFound = $breakIfNoneFound;
    	$w->endIndex = $endIndex;
    	$w->fieldName = $fieldName;
    	$w->startIndexes = $startIndexes;
    	$w->sortOrder = $sortOrder;
        
        array_push($this->routeWSDL, $w);
    }
}
