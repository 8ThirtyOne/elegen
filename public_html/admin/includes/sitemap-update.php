<?php
$xmldoc = new DomDocument('1.0');
$xmldoc->preserveWhiteSpace = false;
$xmldoc->formatOutput = true;
$siteurl = "https://elegen.8romans.com/".$dir."/".$slugurl;
$found = false;
if($xml = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml')){
    $xmldoc->loadXML($xml, LIBXML_NOBLANKS);
    //check if already exists
    if($addurl == 'newurl'){
       $list = $xmldoc->getElementsByTagName('loc');
       foreach ($list as $domElement){
          $attrValue = $domElement->textContent;
          if($attrValue == $siteurl){
             $found = true;
          }
       }
       if(!$found){
        // find the urlset tag
        $root = $xmldoc->getElementsByTagName('urlset')->item(0);
        // create the <url> tag
        $url = $xmldoc->createElement('url');
        // add the url tag before the first element in the <urlset> tag
        $root->insertBefore($url, $root->lastChild);
        $loc = $xmldoc->createElement('loc');
        $url->appendChild($loc);
        $locText = $xmldoc->createTextNode($siteurl);
        $loc->appendChild($locText);
        $freq = $xmldoc->createElement('changefreq');
        $url->appendChild($freq);
        $freqText = $xmldoc->createTextNode('weekly');
        $freq->appendChild($freqText);
        $xmldoc->save($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml');
       }
    }else{
       $i=0;
       while(is_object($url = $xmldoc->getElementsByTagName("url")->item($i))){
           foreach($url->childNodes as $nodename){
               if($nodename->nodeName=='loc'){
                  foreach($nodename->childNodes as $subNodes){
                    if($subNodes->nodeValue == $siteurl){
                     $url->parentNode->removeChild($url);
                    }
                  }
               }
           }
         $i++;
       }
       $xmldoc->save($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml');
    }
}