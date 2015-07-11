<?php

class templateFinder {
    var $startIndexes = array();
    var $endIndex = "";
    var $moveCaretToEndIfNoEndIndex = false;
    var $searchContent = false;
            
    function templateFinder($startIndexes, $endIndex, $moveCaretToEndIfNoEndIndex) 
    {
        $this->startIndexes = $startIndexes;
        $this->endIndex = $endIndex;
        $this->moveCaretToEndIfNoEndIndex = $moveCaretToEndIfNoEndIndex;
    }
}
