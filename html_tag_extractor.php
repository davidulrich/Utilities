<?php
//extracts html tags from page using DOM

$page_url = '<your link here>'; //url
$tagName = 'span'; //tag type (span, div, table, etc)
$attrName = 'class'; //tag identifier (class, id, name)
$attrValue = 'street-address'; //tag value (street-address is example)

$dom = new DOMDocument;
$dom->preserveWhiteSpace = false;
@$dom->loadHTMLFile($page_url);

$html = getTags( $dom, $tagName, $attrName, $attrValue );
$name = getTags($dom,"span","class","<tag name here>");
$link = getTags($dom,"a","class","<tag url here> ");

//display tags matching criteria
for($i=0;$i<count($html);$i++) {
	echo "Parent name: " . $html[$i] . ". Class name: " . $name[$i] . "Link: " . $link[$i] . "<br>";
	}

function getTags( $dom, $tagName, $attrName, $attrValue ){
    $html = '';
    $domxpath = new DOMXPath($dom);
    $newDom = new DOMDocument;
    $newDom->formatOutput = true;

    $filtered = $domxpath->query("//$tagName" . '[@' . $attrName . "='$attrValue']");
    
    $i = 0;
    while( $myItem = $filtered->item($i++) ){
        $node = $newDom->importNode( $myItem, true );    
        $newDom->appendChild($node);                    
        $myArray[]= get_inner_html($node);
    }
    $html = $newDom->saveHTML();
    return $myArray;
    
}
function get_inner_html( $node ) { 
    $innerHTML= ''; 
    $children = $node->childNodes; 
    foreach ($children as $child) { 
        $innerHTML .= $child->ownerDocument->saveXML( $child ); 
    } 

    return $innerHTML; 
}
?>