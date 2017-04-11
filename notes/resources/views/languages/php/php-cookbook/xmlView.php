<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>XML</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#generating_xml_string">Generating XML as a String</a></td>
        <td><a href="#generating_xml_dom">Generating XML with DOM</a></td>
        <td><a href="#parsing_basic">Parsing Basic XML Documents</a></td>
        <td><a href="#parsing_complex">Parsing Complex XML Documents</a></td>
    </tr>
    <tr>
    	<td><a href="#parsing_large">Parsing Large XML Documents</a></td>
        <td><a href="#extracting_info">Extracting Information Using XPath</a></td>
        <td><a href="#transforming">Transforming XML with XSLT</a></td>
        <td><a href="#setting_xslt">Setting XSLT Parameters from PHP</a></td>
    </tr>
    <tr>
    	<td><a href="#calling_functions">Calling PHP Functions from XSLT Stylesheets</a></td>
        <td><a href="#validating_xml">Validating XML Documents</a></td>
        <td><a href="#handling_encoding">Handling Content Encoding</a></td>
        <td><a href="#reading_rss">Reading Rss and Atom Feeds</a></td>
    </tr>
    <tr>
        <td><a href="#writing_rss">Writing RSS Feeds</a></td>
        <td><a href="#writing_atom">Writing Atom Feeds</a></td>
        <td></td>
        <td></td>
    </tr>     
</table>

<hr />

<h2><a name="generating_xml_string">Generating XML as a String</a></h2>
<p><b>Problem:</b> You want to generate XML. For instance, you want to provide an XML version of your data for another program to parse.</p>
<p><b>Solution:</b> Loop through your data and prit it out surrounded by the correct XML tags:</p>

<pre class="prettyprint">
&lt;?php

header('Content-type: text/xml');
print '&lt;?xml version="1.0"?>' . "\n";
print "&lt;shows>\n";

$shows = array(array('name'        => 'Modern Family',
                     'channel'     => 'ABC',
                     'start'       => '9:00 PM',
                     'duration'    => '30'),
               array('name'        => 'Law &amp; Order: SVU',
                     'channel'     => 'NBC',
                     'start'       => '9:00 PM',
                     'duration'    => '60'));
foreach($shows as $show){
    print "    &lt;show>\n";
    foreach($show as $tag=> $data){
        print "        &lt;$tag>" . htmlspecialchars($data) . "&lt;/$tag>\n";
    }
    print "    &lt;/show>\n";
}
print "&lt;/shows>\n";

?>
    </pre>


<hr />

<h2><a name="generating_xml_dom">Generating XML with DOM</a></h2>
<p><b>Problem:</b> You want to generate XML but want to do it in an organized way instead of using print and loops.</p>
<p><b>Solution:</b> Use the DOM extension to create DOMDocument object. After building up the document, call DOMDocument::save() or DOMDocument::saveXML() to generate a well-formed XML document:</p>

<p>Documentation on <a href="http://php.net/domdocument" target="_blank">DOMDocument</a></p>
<p>Documentation on the <a href="http://php.net/dom" target="_blank">DOM functions in general</a></p>
<p>More information about the underlying <a href="http://xmlsoft.org/" target="_blank">libxml2 C library.</a></p>

<pre class="prettyprint">
&lt;?php
//create a new document
$dom = new DOMDocument('1.0');

//create the root element, &lt;book>, and append it to the document
$book = $dom->appendChild($dom->createElement('book'));

//create the title element and append it to $book
$title = $book->appendChild($dom->createElement('title'));

//set the text and the cover attribute for $title
$title->appendChild($dom->createTextNode('PHP Cookbook'));
$title->setAttribute('edition', '3');

//create and append author elements to $book
$sklar = $book->appendChild($dom->createElement('author'));
//create and append the text for each element
$sklar->appendChild($dom->createTextNode('Sklar'));

$trachtenberg = $book->appendChild($dom->createElement('author'));
$trachtenberg->appendChild($dom->createTextNode('Trachtenberg'));

//print a nicely formatted version of the DOM document as XML
$dom->formatOutput = true;
echo $dom->saveXML();

//write the XML document

?>

//prints out
&lt;?xml version="1.0"?>
&lt;book>
    &lt;title edition="3">PHP Cookbook&lt;/title>
    &lt;author>Sklar&lt;/author>
    &lt;author>Trachtenberg&lt;/author>
&lt;/book>
    </pre>


<hr />

<h2><a name="parsing_basic">Parsing Basic XML Documents</a></h2>
<p><b>Problem:</b> You want to parse a basic XML document that follows a known scheme, and you don't need access to more esoteric XML features, such as processing instructions.</p>
<p><b>Solution:</b> Use the SimpleXML extension:</p>

<p>Documentation on <a href="http://php.net/simplexml" target="_blank">SimpleXML</a></p>

<pre class="prettyprint">
//Here's how to read XML from a file:
$sx = simplexml_load_file(__DIR__.'/address-book.xml');

foreach ($sx->person as $person){
    $firstname_text_value = $person->firstname;
    $lastname_text_value = $person->lastname;
    
    print "$firstname_text_value $last_name_text_value\n";
}
    </pre>


<hr />

<h2><a name="parsing_complex">Parsing Complex XML Documents</a></h2>
<p><b>Problem:</b> You have a complex XML document, such as one where you need to introspect the document to determine its schema, or you need to use more esoteric XML features, such as processing instructions or comments.</p>
<p><b>Solution:</b> Use the DOM extension. It provides a complete interface to all aspects of the XML specification:</p>

<pre class="prettyprint">
//$node is the DOM parsed node &lt;book cover="soft">PHP Cookebook&lt;/book>
$type = $node->nodeType;

switch($type){
    case XML_ELEMENT_NODE:
        //I'm a tag. I have a tagname property.
        print $node->tagName; //prints the tagname property: "book"
        break;
    case XML_ATTRIBUTE_NODE:
        //I'm an attribute. I have a name and a value property.
        print $node->name; //prints the name property: "cover"
        print $node->value; //prints the value property: "soft"
        break;
    case XML_TEXT_NODE:
        //I'm a piece of text inside an element.
        //I have a name and a content property
        print $node->nodeName; //prints the name property: '#text'
        print $node->nodeValue; //prints the text content: "PHP Cookbook"
        break
    default:
        //another type
        break;
}
    </pre>

<hr />

<h2><a name="parsing_large">Parsing Large XML Documents</a></h2>
<p><b>Problem:</b> You want to parse a large XML document. This document is so large it's impractical to use SimpleXML or DOM because you cannot hold the entire document in memory. Instead, you must load the document in one section at a time.</p>
<p><b>Solution:</b> Use the XMLReader extension:</p>

<p>Documentation on <a href="http://php.net/xmlreader" target="_blank">XMLReader</a></p>

<pre class="prettyprint">
$reader = new XMLReader();
$reader->open(__DIR__.'/card-catalog.xml');
/*Loop through document*/
while($reader->read()){
    /*If you're at an element named 'author' */
    if($reader->nodeType == XMLREADER::ELEMENT &amp;&amp;
    $reader->localName == 'author'){
        /*Move to the text node and print it out*/
        $reader->read();
        print $reader->value . "\n";
    }
}
    </pre>


<hr />

<h2><a name="extracting_info">Extracting Information Using XPath</a></h2>
<p><b>Problem:</b> You want to make sophisticated queries of your XML data without parsing the document node by node.</p>
<p><b>Solution:</b> Use XPath</p>

<p>Documentation on <a href="http://php.net/domxpath.construct" target="_blank">DOM XPath</a></p>
<p>The official <a herf="http://www.w3.org/TR/xpath/" target="_blank">XPath specification</a></p>

<pre class="prettyprint">
//XPATH is available in SimpleXML:
$s = simplexml_load_file(__DIR__.'/address-book.xml');
$emails = $s->xpath('/address-book/person/email');

foreach($emails as $email){
    //do something with $email
}

//AND in DOM:
$dom = new DOMDocument;
$dom->load(__DIR__.'/address-book.xml');
$xpath = new DOMXPath($dom);
$emails = $xpath->query('/address-book/person/email');

foreach($emails as $email){
    //do something with $email
}
    </pre>


<hr />

<h2><a name="transforming">Transforming XML with XSLT</a></h2>
<p><b>Problem:</b> You have an XML document and an XSL stylesheet. You want to transform the document using XSLT and capture the results. This lets you apply stylesheets to your data and create different versions of your content for different media.</p>
<p><b>Solution:</b> Use PHP's XSLT extension:</p>

<p>Documentation on <a href="http://php.net/xsl" target="_blank">XSL functions</a></p>

<pre class="prettyprint">
//Load XSL template
$xsl = new DOMDocument;
$xsl->load(__DIR__.'/stylesheet.xsl');

//Create new XSLTProcessor
$xslt = new XSLTProcessor();
//Load stylesheet
$sxlt->importStylsheet($sxl);

//Load XML input file
$xml = new DOMDocument;
$xsl->load(__DIR__.'/address-book.xml');

//Transform to string
$results = $xslt->transformToXML($xml);

//Transform to a file
$results = $xslt->transformToURI($xml, 'results.txt');

//Transform to DOM object
$results = $xslt->transformToDoc($xml);
    </pre>


<hr />

<h2><a name="setting_xslt">Setting XSLT Parameters from PHP</a></h2>
<p><b>Problem:</b> You want to set parameters in your XSLT stylesheet from PHP.</p>
<p><b>Solution:</b> Use the XSLTProcessor::setParameter() method:</p>

<p>Documentation on <a href="http://php.net/xsltprocessor.setparameter" target="_blank">XSLTProcessor::setParameter();</a></p>

<pre class="prettyprint">
//This could also come from $_GET['city'];
$city = 'San Francisco';

$dom = new DOMDocument;
$dom->load(__DIR__.'/address-book.xml');
$xsl = new DOMDocument;
$sxl->load(__DIR__.'/stylesheet.xsl');

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);
$xslt->setParameter(NULL, 'city', $city);
print $xslt->transformToXML($dom);
    </pre>


<hr />

<h2><a name="calling_functions">Calling PHP Functions from XSLT Stylesheets</a></h2>
<p><b>Problem:</b> You want to call PHP functions from within an XSLT stylesheet.</p>
<p><b>Solution:</b> Invoke the XSLTProcessor::registerPHPFunctions() method to enable this functionality:</p>

<pre class="prettyprint">
&lt;?php
$xslt = new XSTLProcessor();
$xslt->registerPHPFunctions();
?>

//And use the function() of functionString() function within your stylesheet:

&lt;?xml version="1.0" ?>
&lt;xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xsl:extension-element-prefixes="php">
&lt;xsl:template match="/">
    &lt;xsl:value-of select="php:function('strftime', '%c')" />
&lt;/xsl:template/>

&lt;/xsl:stylesheet>
    </pre>


<hr />

<h2><a name="validating_xml">Validating XML Documents</a></h2>
<p><b>Problem:</b> You want to make sure your XML document abides by a schema, such as XML Schema, Relax NG, and DTDs</p>
<p><b>Solution:</b> Use the DOM extension:</p>

<p>Documentation on <a href="http://www.w3.org/XML/Schema" target="_blank">XML Schema specification</a></p>
<p>Documentation on <a href="http://www.relaxng.org/" target="_blank">Relax NG specification</a></p>

<pre class="prettyprint">
$file = __DIR__.'/address-book.xml';
$schema = __DIR__.'/address-book.xsd';
$ab = new DOMDocument;
$ab->load($file);

if($ab->schemaValidate($schema)){
    print "$file is valid.\n";
}else{
    print "$file is invalid.\n";
}
    </pre>


<hr />

<h2><a name="handling_encoding">Handling Content Encoding</a></h2>
<p><b>Problem:</b> PHP XML extensions use UTF-8, but your data is in a different encoding.</p>
<p><b>Solution:</b> Use the iconv library to convert data before passing it into an XML extension:</p>
<p>$utf_8 = iconv('ISO-8859-1', 'UTF-8', $iso_8859_1);</p>
<p>Then convert the data back when you are finished:</p>
<p>$iso_8859_1 = iconv('UTF-8', 'ISO-8859-1', $utf_8);</p>

<p>Documentation on <a href="http://www.gnu.org/software/libiconv/" target="_blank">GNU libiconv homepage</a></p>
<p>Documentation on <a href="http://php.net/iconv" target="_blank">iconv</a></p>

<hr />

<h2><a name="reading_rss">Reading RSS and Atom Feeds</a></h2>
<p><b>Problem:</b> You want to retrieve RSS and Atom feeds and look at the items. This allows you to incorporate newsfeeds from multiple websites into your application.</p>
<p><b>Solution:</b> Use the <a href="http://magpierss.sourceforge.net/" target="_blank">MagpieRSS parser.</a></p>

<pre class="prettyprint">
require __DIR__.'/magpie/rss_fetch.inc';

$feed = 'http://news.php.net/group.php?group=php.announce&amp;format=rss';

$rss = fetch_rss( $feed );

print "&lt;ul>\n";
foreach ($rss->items as $item){
    print '&lt;li>&lt;a href="' . $item['link'] . '">' . $item['title'] . 
          "&lt;/a>&lt;/li>\n";
}
print "&lt;/ul>\n";
    </pre>

   

<hr />

<h2><a name="writing_rss">Writing RSS Feeds</a></h2>
<p><b>Problem:</b> You want to generate RSS feeds from your data. This will allow you to syndicate your content.</p>
<p><b>Solution:</b> Use this Class:</p>

<pre class="prettyprint">
class rss2 extends DOMDocument {
    private $channel;
    
    public function __construct($title, $link, $description){
        parent::__construct();
        $this->formatOutput = true;
        
        $root = $this->appendChild($this->createElement('rss'));
        $root->setAttribute('version', '2.0');
        
        $channel = $root->appendChild($this->createElement('channel'));
        
        $channel->appendChild($this->createElement('title', $title));
        $channel->appendChild($this->createElement('link', $link));
        $channel->appendChild($this->createElement('description',
                                                   $description));
        $this->channel = $channel;
    }
    
    public function addItem($title, $link, $description){
        $item = $this->createElement('item');
        $item->appendChild($this->createElement('title', $title));
        $item->appendChild($this->createElement('link', $link));
        $item->appendChild($this->createElement('description', $description));
        
        $this->channel->appendChild($item);
    }
}

$rss = new rss2('Channel Title', 'http://www.example.org',
                'Channel Description');
$rss->addItem('Item 1', 'http://www.example.org/item1',
              'Item 1 Description');
$rss->addItem('Item 2', 'http://www.example.org/item2',
              'Item 2 Description');
print $rss->saveXML();
    </pre>


<hr />

<h2><a name="writing_atom">Writing Atom Feeds</a></h2>
<p><b>Problem:</b> You want to generate Atom feeds from your data. This will allow you to syndicate your content.</p>
<p><b>Solution:</b> Use this class:</p>

<p>The <a href="http://www.atomenabled.org/" target="_blank">Atom Homepage.</a></p>
<p>The <a href="http://www.intertwingly.net/wiki/pie/" target="_blank">Atom Wiki.</a></p>
<p>More information on <a href="http://en.wikipedia.org/wiki/Atom_%28standard%29" target="_blank">Atom</a></p>

<pre class="prettyprint">
class atom1 extends DOMDocument {
    private $ns;
    
    public function __construct($title, $href, $name, $id){
        parent::__construct();
        $this->formatOutput = true;
        
        $this->ns = 'http://www.w3.org/2005/Atom';
        
        $root = $this->appendChild($this->createElementsNS($this->ns, 'feed'));
        
        $root->appendChild($this->createElementNS($this->ns, 'title', $title));
        $link = $root->appendChild($this->createElementNS($this->ns, 'link'));
        $link->setAttribute('href', $href);
        $root->appendChild($this->createElementNS($this->ns, 'updated',
            date(DATE_ATOM)));
        $author = $root->appendChild($this->createElementNS($this->ns,
                                                         'author'));
        $author->appendChild($this->createElementNS($this->ns, 'name', $name));
        $root->appendChild($this->createElementNS($this->ns, 'id', $id));
    }
    
    public function addEntry($title, $link, $summary){
        $entry = $this->createElementNS($this->ns, 'entry');
        $entry->appendChild($this->createElementNS($this->ns, 'title', $title));
        $entry->appendChild($this->createELementNS($this->ns, 'link', $link));
        
        $id = uniqid('http://example.org/atom/entry/ids/');
        $entry->appendChild($this->createElementNS($this->ns, 'id', $id));
        
        $entry->appendChild($this->createElementNS($this->ns, 'updated',
            date(DATE_ATOM)));
        $entry->appendChild($this->createElementNS($this->ns, 'summary',
            $summary));
        $this->documentElement->appendChild($entry);
    }
}

$atom = new atom1('Channel Title', 'http://www.example.org',
               'Joyn Quincy Atom', 'http://example.org/atom/feed/ids/1');
     
$atom->addEntry('Item 1', 'http://www.example.org/item1',
               'Item 1 Description', 'http://example.org/atom/entry/ids/1');
               
$atom->addEntry('Item 2', 'http://www.example.org/item2',
               'Item 2 Description', 'http://example.org/atom/entrys/ids/2');
  
print $atom->saveXML();
    </pre>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>