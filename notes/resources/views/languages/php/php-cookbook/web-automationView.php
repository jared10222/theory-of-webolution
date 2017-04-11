<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Web Automation</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#marking_up">Marking UP a Web Page</a></td>
        <td><a href="#cleaning_up">Cleaning Up Broken or Nonstandard HTML</a></td>
        <td><a href="#extracting_links">Extracting Links from an HTML file</a></td>
        <td><a href="#converting_plain">Converting Plain Text to HTML</a></td>
    </tr>
    <tr>
    	<td><a href="#converting_html">Converting HTML to Plain Text</a></td>
        <td><a href="#removing_html">Removing HTML and PHP Tags</a></td>
        <td><a href="#responding_ajax">Responding to an Ajax Request</a></td>
        <td><a href="#integrating_js">Integrating with JavaScript</a></td>
    </tr>
    <tr>
    	<td><a href="#program_1">Program: Finding Stale Links</a></td>
        <td><a href="#program_2">Program: Finding Fresh Links</a></td>
        <td></td>
        <td></td>
    </tr>
</table>

<hr />

<h2><a name="marking_up">Marking Up a Web Page</a></h2>
<p><b>Problem:</b> You want to display a web page--for example, a search result--with certain words highlighted.</p>
<p><b>Solution:</b> Build an array replacement for each word you want to highlight. Then, chop up the page into "HTML elements" and "text between HTML elements" and apply the replacements to just the text between HTML elements.</p>

<p>Documentation on <a href="http://php.net/str_ireplace" target="_blank">str_ireplace()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Marking up a web page</h3>
&lt;?php

$body = '
&lt;p>I like pickles and herring.&lt;/p>
&lt;a href="pickle.php">&lt;img src="pickle.jpg"/>A pickle picture&lt;/a>
I have a herringbone-patterned toaster cozy.
&lt;herring>Herring is not a real HTML element!&lt;/herring>
';

$words = array('pickle','herring');
$replacements = array();
foreach ($words as $i => $word){
    $replacements[] = "&lt;span class='word-$i'>$word&lt;/span>";
}

//Split up the page into chunks delimited by a
//reasonable approximation of what a HTML element
//looks like
$parts = preg_split("{(&lt;(?:\"[^\"]*\"|'[^']*'|[^'\">])*>)}",
                   $body,
                   -1, //Unlimited number of chunks
                   PREG_SPLIT_DELIM_CAPTURE);
foreach($parts as $i=> $part){
    //Skip if this part is an HTML element
    if(isset($part[0]) &amp;&amp; ($part[0] == '&lt;')){ continue; }
    //Wrap the words with &lt;span/>s
    $parts[$i] = str_replace($words, $replacements, $part);
}

//Reconstruct the body
$body = implode('',$parts);

print $body;
?>
    </pre>


<hr />

<h2><a name="cleaning_up">Cleaning Up Broken or Nonstandard HTML</a></h2>
<p><b>Problem:</b> You've got some HTML with malformed syntax that you'd like to clean up. This makes it easier to parse and ensures that the pages you produce are standards compliant.</p>
<p><b>Solution:</b> Use PHP's Tidy extension. It relies on the popular, powerful, HTML Tidy library to turn frightening piles of tag soup into well-formed, standards-compliant HTML or XHTML.</p>

<p>Documentation on <a href="http://php.net/tidy.repairfile" target="_blank">tidy_repair_file()</a></p>
<p>Documentation on <a href="http://php.net/tidy.repairstring" target="_blank">tidy_repair_string()</a></p>
<p>Documentation on <a href="http://tidy.sourceforge.net/docs/quickref.html" target="_blank">Tidy configuration options</a></p>


<pre class="prettyprint">
    <h3 class="nocode">Repairing an HTML file with Tidy</h3>

$fixed = tidy_repair_file('bad.html');
file_put_contents('good.html', $fixed);    

    <hr />
    <h3 class="nocode">Production of XHTML with Tidy</h3>

$config = array('output-xhtml' => true);
$fixed = tidy_repair_file('bad.html', $config);
file_put_contents('good.xhtml', $fixed);

    <hr />
    <h3 class="nocode">Marking up a web page with Tidy and DOM</h3>

$body = '
&lt;p>I like pickles and herring.&lt;/p>
&lt;a href="pickle.php">&lt;img src="pickle.jpg"/>A pickle picture&lt;/a>
I have a herringbone-patterned toaster cozy.
&lt;herring>Herring is not a real HTML element!&lt;/herring>
';

$words = array('pickle', 'herring');
$patterns = array();
$replacements = array();
foreach($words as $i => $word){
    $patters[] = '/' . preg_quote($word) . '/i';
    $replacements[] = "&lt;span class='word-$i'>$word&lt;/span";
}

/*Tell Tidy to produce XHTML*/
$xhtml = tidy_repair_string($body, array('output-xhtml' => true));

/*Load the XHTML as an XML document */
$doc = new DOMDocument;
$doc->loadXml($xhtml);

/*When turning our input HTML into a proper XHTML document,
* Tidy puts the input HTML inside the &lt;body/> element of the
* XHTML document*/
$body = $doc->getElementsByTagName('body')->item(0);

/*Visit all text nodes and mark up words if necessary*/
$xpath = new DOMXpath($doc);
foreach($xpath->query("descendant-or-self::text()", $body) as $textNode){
    $replaced = pre_replace($patterns, $replacements, $textNode->wholeText);
    if($replaced !== $textNode->wholeText){
        $fragment = $textNode->ownerDocument->createDocumentFragment();
        /*This makes sure that the &lt;span/> sub-nodes are created properly*/
        $fragment->appendXml($replaced);
        $textNode->parentXml->replaceChild($fragment, $textNode);
    }
}

/*Build the XHTML consisting of the content of everything under &lt;body/>*/
$markedup = '';
foreach($body->childNodes as $node){
     $markedup .= $doc->saveXml($node);
}
print $markedup;
    </pre>


<hr />

<h2><a name="extracting_links">Extracting Links from an HTML File</a></h2>
<p><b>Problem:</b> You need to extract the URLs that are specified inside an HTML document.</p>
<p><b>Solution:</b> Use Tidy to convert the document XHTML, then use XPath query to find all the links:</p>

<p>Documentation on <a href="http://php.net/DOM" target="_blank">DOMDocument</a></p>
<p>Documentation on <a href="http://php.net/domxpath.query" target="_blank">DOMXPath::query()</a></p>
<p>Documentation on <a href="http://php.net/domxpath.registernamespace" target="_blank">DOMXPath::registerNamespace()</a></p>
<p>Documentation on <a href="http://php.net/tidy.repairfile" target="_blank">tidy_repair_file()</a></p>
<p>Documentation on <a href="http://php.net/preg_match_all" target="_blank">preg_match_all()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Extracting links with Tidy and XPath</h3>
&lt;?php

$html = &lt;&lt;&lt;_HTML_
&lt;p>Some things I enjoy eating are:&lt;/P>
&lt;ul>
&lt;li>&lt;a href="http://en.wikipedia.org/wiki/Pickle">Pickes&lt;/a>&lt;/li>
&lt;li>&lt;a href="http://www.eatingintranslation.com/2011/03/great_ny_noodle.html">
        Salt-Baked Scallops&lt;/a>&lt;/li>
&lt;li>&lt;a href="http://www.thestoryofchocolate.com/">Chocolate&lt;/a>&lt;/li>
&lt;/ul>
_HTML_;

$doc = new DOMDocument();
$opts = array('output-xhtml' => true,
              //Prevent DOMDocument from being confused about entities
              'numeric-entities' => true);
$doc->loadXML(tidy_repair_string($html, $opts));
$xpath = new DOMXPath($doc);
//Tell $xpath about the XTHML namespace
$xpath->registerNamespace('xhtml', 'http://www.w3.org/1999/xhtml');
foreach($xpath->query('//xhtml:a/@href') as $node){
    $link = $node->nodeValue;
    print $link . "\n";
}
?>

    <hr />
    <h3 class="nocode">Extracting links without Tidy</h3>

&lt;?php

$html = &lt;&lt;&lt;_HTML_
&lt;p>Some things I enjoy eating are:&lt;/P>
&lt;ul>
&lt;li>&lt;a href="http://en.wikipedia.org/wiki/Pickle">Pickes&lt;/a>&lt;/li>
&lt;li>&lt;a href="http://www.eatingintranslation.com/2011/03/great_ny_noodle.html">
        Salt-Baked Scallops&lt;/a>&lt;/li>
&lt;li>&lt;a href="http://www.thestoryofchocolate.com/">Chocolate&lt;/a>&lt;/li>
&lt;/ul>
_HTML_;

$links = pc_link_extractor($html); 

foreach($links as $link){
    print $link[0] . "\n";
}   

function pc_link_extractor($html){
    $links = array();
    preg_match_all('/&lt;a\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)&lt;\/a>/i',
             $html,$matches,PREG_SET_ORDER);
    foreach($matches as $match){
        $links[] = array($match[1], $match[2]);
    }
    return $links;
}
?>
    </pre>


<hr />

<h2><a name="converting_plain">Converting Plain Text to HTML</a></h2>
<p><b>Problem:</b> You want to turn plain text into reasonably formatted HTML.</p>
<p><b>Solution:</b> First, encode entities with htmlentities(). Then, transform the text into various HTML structures. The pc_text2html() function show below has basic transformations for links and paragraph breaks.</p>

<pre class="prettyprint">
    <h3 class="nocode">pc_text2html()</h3>

function pc_text2html($s){
    $s = htmlentities($s);
    $grafs = split("\n\n",$s);
    for($i = 0, $j = count($grafs); $i &lt; $j; $i++){
        //Link to what seem to be http or ftp URLs
        $grafs[$i] = preg_replace('/((ht|f)tp:\/\/[^\s&amp;]+)/',
                              '&lt;a href="$1">$1&lt;/a>', $grafs[$i]);
        //Link to email addresses
        $grafs[$i] = preg_replace('/[^@\s]+@([a-z0-9]+\.)+[a-z]{2,}/i',
          '&lt;a href="mailto:$1">$1&lt;/a>', $grafs[$i]);
        
        //Begin with a new paragraph
        $grafs[$i] = '&lt;p>'.$grafs[$i].'&lt;/p>';
    }
    return implode("\n\n",$grafs);
}
    </pre>


<hr />

<h2><a name="converting_html">Converting HTML to Plain Text</a></h2>
<p><b>Problem:</b> You need to convert HTML to readable, formatted plain text.</p>
<p><b>Solution:</b> Use the html2text class shown below.</p>

<p>More information on <a href="http://www.chuggnutt.com/html2text" target="_blank">html2text</a> and links to download it.</p>

<pre class="prettyprint">
    <h3 class="nocode">Converting HTML to plain text</h3>

require_once 'class.html2text.inc';
/*Give file_get_contents() the path or URL of the HTML you want to process*/
$html = file_get_contents(__DIR__.'/article.html');
$converter = new html2text($html);
$plain_text = $converter->get_text();

    </pre>

    

<hr />

<h2><a name="removing_html">Removing HTML and PHP Tags</a></h2>
<p><b>Problem:</b> You want to remove HTML and PHP tags from a string or file. For example, you want to make sure there is no HTML in a string before printing it or PHP in a string before passing it to eval().</p>
<p><b>Solution:</b> Use strip_tags() or filter_var() to remove HTML and PHP tags from a string:</p>

<p>Documentation on <a href="http://php.net/strip-tags" target="_blank">strip_tags()</a></p>
<p>Documentation on <a href="http://php.net/stream_filter_append" target="_blank">stream_filter_append()</a></p>
<p>Documentation on <a href="http://php.net/filters" target="_blank">stream filters</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Removing HTML and PHP tags</h3>

$html = '&lt;a href="http://www.oreilly.com">I &lt;b>love computer books.&lt;/b>&lt;a>';
$html .= '&lt;?php echo "Hello!" ?>';
print strip_tags($html);
print "\n";
print filter_var($html, FILTER_SANITIZE_STRING);

//Prints:
I love computer books
I love computer books

    <hr />
    <h3 class="nocode">Removing HTML and PHP tags from a stream</h3>

$stream = fopen(__DIR__.'/elephant.html', 'r');
stream_filter_append($stream, 'string.strip_tags');
print stream_get_contents($stream);

    <hr />
    <h3 class="nocode">Removing some HTML and PHP tags from a stream</h3>

$stream = fopen(__DIR__.'/elephant.html','r');
stream_filter_append($stream, 'string.strip_tags', STREAM_FILTER_READ,'b,i');
print stream_get_contents($stream);
    </pre>


<hr />

<h2><a name="responding_ajax">Responding to an Ajax Request</a></h2>
<p><b>Problem:</b> You're using JavaScript to make in-page requests with XMLHTTPRequest and need to send data in reply to one of those requests.</p>
<p><b>Solution:</b> Se an appropriate Content-Type header and then omit properly formatted data.</p>

<p>Documentation on <a href="http://php.net/manual/en/function.header.php" target="_blank">header()</a></p>
<p>Read more about <a href="http://en.wikipedia.org/wiki/XMLHttpRequest" target="_blank">XMLHTTPRequest</a>, <a href="http://www.json.org/" target="_blank">JSON</a>, and the <a href="http://php.net/json" target="_blank">json extension.</a></p>


<pre class="prettyprint">
    <h3 class="nocode">Sending an XML response</h3>

&lt;?php header('Content-Type: text/xml'); ?>
&lt;menu>
&lt;dish type="appetizer">Chicken Soup&lt;/dish>
&lt;dish type="main course">Fried Monkey Brains&lt;/dish>
&lt;/menu>

    <hr />
    <h3 class="nocode">Sending a JSON response</h3>
&lt;?php

$menu = array();
$menu[] = array('type' => 'appetizer',
                'dish' => 'Chicken Soup');
$menu[] = array('type' => 'main course',
                'dish' => 'Fried Monkey Brains');
header('Content-Type: application/json');
print json_encode($menu);

?>

    <hr />
    <h3 class="nocode">Anti-caching headers</h3>
&lt;?php

header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
//Add some IE-specific options
header("Cache-Control: post-check=0, pre-check=0", false);
//For HTTP/1.0
header("Pragma: no-cache");

?>
</pre>


<hr />

<h2><a name="integrating_js">Integrating with JavaScript</a></h2>
<p><b>Problem:</b> You want part of your page to update with server-side data without reloading the whole page. For example, you want to populate a list with search results.</p>
<p><b>Solution:</b> Use a JavaScript tookit such as jQuery to wire up the client side of things so that a particular user action(such as clicking a button) fires off a request to the server. Write appropriate PHP code to generate a response containing the right data. Then, use your JavaScript toolkit to put the results in the page correctly.</p>

<pre class="prettyprint">
    <h3 class="nocode">Basic HTML for JavaScript integration</h3>
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="UTF-8" />
    &lt;meta name="viewport" content="width=device-width, initials-scale=1" />
    &lt;title>Example&lt;/title>
    
    &lt;-- Load jQuery -->
    &lt;script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.min.js">&lt;/script>
    &lt;!-- Load out JavaScript -->
    &lt;script type="text/javascript" src="search.js">&lt;/script>
&lt;/head>
&lt;body>
    &lt;!-- Some input elements -->
    &lt;input type="text id="q" />
    &lt;input type="button" id="go" value="Search" />
    &lt;hr />
    &lt;!-- Where the output goes -->
    &lt;div id="output">&lt;/div>
&lt;/body>
&lt;/html>


    <hr />
    <h3 class="nocode">JavaScript integration glue</h3>
&lt;script type="text/javascript">

//When the page loads, run this code
$(document).ready(function(){
    //Call the search() function when the 'go' button is clicked
    $("#go").click(search);
});

function search(){
    //What's in the text box?
    var q = $("#q").val();
    //Send request to the server
    //The first argument should be to wherever you save the search page
    //The second argument sends a query string parameter
    //The third argument is the function to run with the results
    $.get('/search.php', {'q': q }, showResults);
}

//Handle the results
function showResults(data){
    var html = '';
    //If we got some results...
    if(data.length > 0){
        html = '&lt;ul>';
        //build a list of them
        for(var i in data){
            var escaped = $('&lt;div/>').text(data[i]).html();
            html += '&lt;li>' + escaped + '&lt;/li>';
        }
        html += '&lt;/ul>';
    }else{
        html = 'No results.';
    }
    //Put the result HTML in the page
    $("#output").html(html);
}
&lt;/script>

    <hr />
    <h3 class="nocode">PHP to generate a response for JavaScript</h3>
&lt;?php

$results = array();
$q = isset($_GET['q']) ? $_GET['q'] : '';

//Connect to the database from Chapter 10
$db = new PDO('sqlite:/tmp/zodiac.db');

//Do the query
$st = $db->prepare('SELECT symbol FROM zodiac WHERE planet LIKE ? ');
$st->execute(array($q.'%'));

//Build an array of results
while($row = $st->fetch()){
    $results[] = $row['symbol'];
}

if(count($results) == 0){
    $results[] = "No results";
}

//Splorp out all the anti-caching stuff
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
//Add some IE-specific options
header("Cache-Control: post-check=0, pre-check=0", false);
//For HTTP/1.0
header("Pragma: no-cache");

//The response in JSON
header('Content-Type: application/json');

//Output the JSON data
print json_encode($results);

?>
    </pre>


<hr />

<h2><a name="program_1">Program: Finding Stale Links</a></h2>


<hr />

<h2><a name="program_2">Program: Finding Fresh Links</a></h2>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>