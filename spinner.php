<?php
header('Content-Type: text/html; charset=utf-8');
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
        
        /*$this->noJobAuth();
        $this->URL = "http://teknoloji.milliyet.com.tr/";
        $tf = new templateFinder(array('<div class="startTop">'), '<div class="paging">', TRUE);
        $st = new searchTemplate("Nenanona", true, $tf);
        $st->addRoute(array("<a target=\"_blank\" href=\""), "\">", "link", 1, true);    
        $st->addRoute(array("<strong>"), "</strong>", "title", 1, false);    
        array_push($this->searchTemplate, $st);
        $this->getResult();
        */
        /*$this->noJobAuth();
        $this->URL = "http://teknoloji.milliyet.com.tr/nokia-dan-dev-telefon-geliyor/mobildunya/detay/1801213/default.htm";
        $st = new searchTemplate("Nenanona", false, null);
        $st->addRoute(array("<div class=\"date\">"), "</div>", "date", 1, true);
        $st->addRoute(array("<h1>"), "</h1>", "title", 2, false);    
        $st->addRoute(array("<h2>"), "</h2>", "subTitle", 3, false);   
        $st->addRoute(array("<div id=\"divAdnetKeyword3\" class=\"content\">", "<p", ">"), "</p>", "content1", 4, false);     
        $st->addRoute(array("<p", ">"), "</p>", "content2", 4, false);       
        $st->addRoute(array("<p", ">"), "</p>", "content3", 4, false);       
        $st->addRoute(array("<p", ">"), "</p>", "content4", 4, false);       
        $st->addRoute(array("<p", ">"), "</p>", "content5", 4, false);     
        array_push($this->searchTemplate, $st);
        $this->getResult();*/
        
        /*
        $this->noJobAuth();
        $this->URL = "http://www.sanalmarket.com.tr/kweb/shview/1-migros-sanal-market";
        
        $tf = new templateFinder(array('<div class="hurBox promoBox">'), 'div class="hurRight">', TRUE);
        $st = new searchTemplate("Nenanona", true, $tf);
        $st->addRoute(array('<a target="_blank" href="'), '"', "link", 1, true);    
        $st->addRoute(array('title="'), '"', "title", 1, false);    
        $st->addRoute(array(' data-original="'), '"', "picture", 3, false);
        array_push($this->searchTemplate, $st);
        
        $tf = new templateFinder(array('<div class="hurBox flasFour">'), '<div class="hurBox clr">', TRUE);
        $st2 = new searchTemplate("Nenanona2", true, $tf);
        $st2->addRoute(array('<a target="_blank" href="'), '"', "link", 1, true);    
        $st2->addRoute(array('title="'), '"', "title", 2, false);    
        $st2->addRoute(array('<img src="'), '"', "picture", 3, false);
        array_push($this->searchTemplate, $st2);
        
        $tf = new templateFinder(array('<div class="mansetRight mainMansetRight">'), '<div class="hurBox clr">', TRUE);
        $st2 = new searchTemplate("Nenanona2", true, $tf);
        $st2->addRoute(array('<a target="_blank" href="'), '"', "link", 1, true);    
        $st2->addRoute(array('title="'), '"', "title", 2, false);    
        $st2->addRoute(array(' data-original="'), '"', "picture", 3, false);
        array_push($this->searchTemplate, $st2);
        */
        
        /*
        $this->noJobAuth();
        $this->URL = "http://localhost/horeca/temp/migrosMain.html";
        
        $tf = new templateFinder(array('anaNavLayout'), 'mainLayout', TRUE);
        $st = new searchTemplate("Nenanona", true, $tf);
        $st->addRoute(array('class="anaNavListHeader2">', '>'), '<', "category", 1, true);
        $st->addRoute(array('class="baslik">', '>'), '<', "subCategory", 2, false);
        $st->addRoute(array('<div>', '>'), '<', "product", 3, true);
        array_push($this->searchTemplate, $st);
        
        
        $this->getResult();
        */
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
                    
                    /*$subContent = "";
                    
                    if ((!$_st->templateFinder != null) && (!$_st->templateFinder->searchContent)) {
                        
                        print("subContent");
                        
                        $startIndex = 0;
                        $endIndex = 0;
                        
                        foreach ($_st->templateFinder->startIndexes as $si) {
                            if ($si == null) continue;
                            
                            $mainIndex = strpos($responseBody, $si, $mainIndex);
                            if ($mainIndex === false)
                                break;
                            
                            $mainIndex = $mainIndex  + strlen($si);
                        }
                        
                        if ($mainIndex === false) break;
                        
                        $afterLife = strpos($responseBody, $_st->templateFinder->endIndex, $mainIndex);
                        if ($afterLife === false) {
                            if ($_st->templateFinder->moveCaretToEndIfNoEndIndex)
                                $afterLife = strlen(responseBody);
                            else
                                break;
                        }
                        $subContent = substr($responseBody, $mainIndex, $afterLife-$mainIndex);
                    } else {
                        print("noSubContent");
                        $subContent = $responseBody;
                    }*/
                    
                    
                    $resultRow = array();
                    
                    foreach ($_st->routeWSDL as $r) {
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
                        array_push($resultRow, array($r->fieldName => $value, "s"=>$startIndex, "e"=>$endIndex));
                        $startIndex = $endIndex + strlen($toFind);
                    }
                    
                    if (count($resultRow) > 0)
                        array_push($result, $resultRow);
                }
            } else {
                $startIndex = 0;
                $endIndex = 0;

                $resultRow = array();
                
                foreach ($_st->routeWSDL as $r) {
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
                    array_push($resultRow, array($r->fieldName => $value, "s"=>$startIndex, "e"=>$endIndex));
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

class RouteWSDL {
    var $startIndexes;
    var $endIndex;
    var $fieldName;
    var $sortOrder;
    var $breakIfNoneFound;    
}
