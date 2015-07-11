<?php
class spinner {
    
    var $gotAuth;
    var $jobAuth;
    var $authParameters;
    var $authURL;
    var $authMethod;
    
    var $searchTemplate = array();
    
    var $URL = "";
    
    function spinner() 
    {
        
    }
    
    function getResult() 
    {
        $result = array();
        
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\r\n" .
                "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36\r\n"
          )
        );

        $context = stream_context_create($opts);
        $responseBody = file_get_contents($this->URL, false, $context);
        
        foreach ($this->searchTemplate as $_st)
        {        
            $mainIndex = 0;
            $afterLife = 0;
            $startIndex = 0;
            $endIndex = 0;

            $toFind = "";
            $value = "";
            
            if ($_st->repeats) {
                $hasToGoON = true;
                
                if ($_st->templateFinder != null) {
                    $startIndex = 0;
                    $endIndex = 0;
                    
                    foreach ($_st->templateFinder->startIndexes as $si) {
                        $mainIndex = strpos($responseBody, $si, $mainIndex);
                        if ($mainIndex === false)
                            break;
                        $mainIndex = $mainIndex + strlen($si);
                    }
                    
                    if ($mainIndex === false) break;
                    
                    $afterLife = strpos($responseBody, $_st->templateFinder->endIndex, $mainIndex);
                    if ($afterLife === false) {
                        if ($_st->templateFinder->moveCaretToEndIfNoEndIndex)
                            $afterLife = strlen($responseBody);
                        else
                            break;
                    }
                    $subContent = substr($responseBody, $mainIndex, $afterLife-$mainIndex);
                }
                
                while ($hasToGoON) {
                    
                    $resultRow = array();
                    
                    foreach ($_st->routeSPD as $r) {
                        if ($r == null) continue;
                        
                        foreach ($r->startIndexes as $si) {
                            if ($si == null) continue;
                            
                            $toFind = $si;
                            
                            $startIndex = strpos($subContent, $toFind, $startIndex);
                            if ($startIndex === false) {
                                
                                if ($r->breakIfNoneFound) {
                                    $hasToGoON = false;
                                    break;
                                } else 
                                    continue;    
                            }
                            
                            $startIndex = $startIndex + strlen($toFind);
                        }
                        
                        if ($startIndex === false) {
                            if ($r->breakIfNoneFound) {
                                $hasToGoON = false;
                                break;
                            } else {
                                if (($_st->templateFinder != null) && (!$_st->templateFinder->searchContent)) 
                                    $startIndex = 0;
                            }
                        }
                        
                        $toFind = $r->endIndex;
                        $endIndex = strpos($subContent, $toFind, $startIndex);
                        
                        if ($endIndex === false) {
                            if ($r->breakIfNoneFound) {
                                $hasToGoON = false;
                                break;
                            } else {
                                if (($_st->templateFinder != null) && (!$_st->templateFinder->searchContent)) 
                                    $startIndex = 0;
                                continue;
                            }
                        }
                        
                        $value = substr($subContent, $startIndex, $endIndex-$startIndex);
                        array_push($resultRow, array($r->fieldName => $value));
                        $startIndex = $endIndex + strlen($toFind);
                    }
                    
                    if (count($resultRow) > 0)
                        array_push($result, $resultRow);
                }
            } else {
                $startIndex = 0;
                $endIndex = 0;

                $resultRow = array();
                
                foreach ($_st->routeSPD as $r) {
                    if ($r == null) continue;

                    foreach ($r->startIndexes as $si) {
                        if ($si == null) continue;

                        $toFind = $si;

                        $startIndex = strpos($responseBody, $toFind, $startIndex);
                        if ($startIndex === false) {
                            if ($r->breakIfNoneFound) {
                                break;
                            } else 
                                continue;    
                        }

                        $startIndex = $startIndex + strlen($toFind);
                    }

                    if ($startIndex === false) {
                        if ($r->breakIfNoneFound) {
                            break;
                        } else {
                            continue;
                        }
                    }

                    $toFind = $r->endIndex;
                    $endIndex = strpos($responseBody, $toFind, $startIndex);

                    if ($endIndex === false) {
                        if ($r->breakIfNoneFound) {
                            break;
                        } else {
                            continue;
                        }
                    }

                    $value = substr($responseBody, $startIndex, $endIndex-$startIndex);
                    array_push($resultRow, array($r->fieldName => $value));
                    $startIndex = $endIndex + strlen($toFind);
                }
                if (count($resultRow) > 0)
                    array_push($result, $resultRow);
            }
        }
        return ($result);
    }
    
    function addJobAuth($authURL, $authMethod, $authParameters)
    {
   	 $this->jobAuth = true;
   	 $this->gotAuth = false;
   	 $this->authParameters = $authParameters;
   	 $this->authURL = $authURL;
   	 $this->authMethod = $authMethod;
    }
    
    function noJobAuth()
    {
   	 $this->jobAuth = false;
   	 $this->gotAuth = true;
    }
}