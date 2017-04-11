<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Regular Expressions</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#switching">Switching from ereg to preg</a></td>
        <td><a href="#matching">Matching Words</a></td>
        <td><a href="#finding">Finding the nth Occurrence of a Match</a></td>
        <td><a href="#choosing">Choosing Greedy or Nongreedy Matches</a></td>
    </tr>
    <tr>
    	<td><a href="#finding_all">Finding All Lines in a File That Match a Pattern</a></td>
        <td><a href="#capturing">Capturing Text Inside HTML Tags</a></td>
        <td><a href="#preventing">Preventing Parentheses from Capturing Text</a></td>
        <td><a href="#escaping">Escaping Special Characters in a Regular Expression</a></td>
    </tr>
    <tr>
    	<td><a href="#reading_records">Reading Records with a Pattern Separator</a></td>
        <td><a href="#using_php">Using a PHP Function in a Regular Expression</a></td>
        <td></td>
        <td></td>
    </tr>     
</table>

<hr />
<p>Usefule information on <a href="http://php.net/pcre" target="_blank">Perl-compatible regular expressions.</a></p>

<hr />

<h2><a name="switching">Switching from ereg to preg</a></h2>
<p><b>Problem:</b> You want to convert from using ereg functions to preg functions</p>
<p><b>Solution:</b> First, you have to add delimters to your patterns:</p>
<p>For case-insenstive matching, use the /i modifier with preg_match() instead:</p>
<p>When using integers instead of strings as patterns or replacement values, convert the number to hexadecimal and specify it using an escape sequence:</p>

<p>Documentation on <a href="http://php.net/preg-match" target="_blank">preg_match()</a></p>
<p>Documentation on <a href="http://php.net/addcslashes" target="_blank">addcslashes()</a></p>


<pre class="prettyprint">
preg_match('/pattern/', 'string');

preg_match('/pattern/i', 'string');

$hex = dechex($number);
preg_match("/\x$hex/", 'string');
    </pre>


<hr />

<h2><a name="matching">Matching Words</a></h2>
<p><b>Problem:</b> You want to pull out all words from a string.</p>
<p><b>Solution:</b> The simplest way to do this is to use the PCRE "word character" character type escape sequence, \w:</p>

<p>Documentation on <a href="http://php.net/regexp.reference.escape" target="_blank">preg escape sequences.</a></p>

<pre class="prettyprint">
$text = "Knock, Knock. Who's there? r2d2!";
$words = preg_match_all('/\w+/', $text, $matches);
var_dump($matches[0]);
    </pre>


<hr />

<h2><a name="finding">Finding the nth Occurrence of a Match</a></h2>
<p><b>Problem:</b> You want to find the <i>n</i>th word match instead of the first one.</p>
<p><b>Solution:</b> Use preg_match_all() to pull all the matches into an array; then pick out the specific matches in which you're insterested:</p>

<p>Documentation on <a href="http://php.net/preg-match-all" target="_blank">preg_match_all()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Finding the nth match</h3>

$todo = "1. Get Dressed 2. Eat Jelly 3. Squash every week into a day";

pre_match_all("/\d\. ([^\d]+)/", $todo, $matches);

print "The second item on the todo list is: ";
//$matches[1] is an array of each substring captured by ([^\d]+)
print $matches[1][1] . "\n";

print "The entire todo list is: ";
foreach($matches[1] as $match){
    print "$match\n";
}

    <hr />
    <h3 class="nocode">Grouping captured subpatterns</h3>

$todo = "
first=Get Dressed
next=Eat Jelly
last=Squash every week into a day
";

preg_match_all("/([a-zA-Z]+)=(.*)/", $todo, $matches, PREG_SPLIT_ORDER);

foreach($matches as $match){
    print "The {$match[1]} action is {$match[2]}\n";
}

//This prints:
//The first action is Get Dressed
//The next action is Eat Jelly
//The last action is Squash every week into a day.
    </pre>


<hr />

<h2><a name="choosing">Choosing Greedy or Nongreedy Matches</a></h2>
<p><b>Problem:</b> You want your pattern to match the smallest possible string instead of the largest.</p>
<p><b>Solution:</b> Place a ? after a quantifier to alter that portion of the pattern:</p>
<p>Or use the U pattern-modifier ending to invert all quantifiers from greedy ("match as many characters as possible") to nongreedy("match as few characters as possible").</p>

<pre class="prettyprint">
    <h3 class="nocode">Making a quantifier match as few characters as possible</h3>

//find all &lt;em>empahsized&lt;/em> sections
preg_match_all('@&lt;em>.+?&lt;/em>@', $html, $matches);

<hr />
//find all &lt;em>empahsized&lt;/em> sections
preg_match_all('@&lt;em>.+&lt;/em>@U', $html, $matches);

    <hr />
    <h3 class="nocode">Greedy versus nongreedy matching</h3>

$html = 'I simply &lt;em>love&lt;/em> your &lt;em>work&lt;/em>';
//Greedy
$matchCount = preg_match_all('@&lt;em>.+&lt;/em>@', $html, $matches);
print "Greedy count: " . $matchCount . "\n";

//Nongreedy
$matchCount = preg_match_all('@&lt;em>.+?&lt;/em>@', $html, $matches);
print "First non-greedy count: " . $matchCount . "\n";
//Nongreedy
$matchCount = preg_match_all('@&lt;em>.+&lt;/em>@U', $html, $matches);
print "Second non-greedy count: " . $matchCount . "\n";

//Prints:

Greedy count: 1
First non-greedy count: 2
Second non-greedy count: 2
    </pre>


<hr />

<h2><a name="finding_all">Finding All Lines in a File That Match a Pattern</a></h2>
<p><b>Problem:</b> You want to find all the lines in a file that match a pattern.</p>
<p><b>Solution:</b> Read the file into an array and use preg_grep().</p>

<p>Documentation on <a href="http://php.net/preg-grep" target="_blank">preg_grep()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Quickly finding lines that match a pattern</h3>

$pattern = "/\bo'reilly\b/i"; //only O'Reilly books
$ora_books = preg_grep($pattern, file('/path/to/you/file.txt'));

    <hr />
    <h3 class="nocode">Efficiently finding lines that match a pattern</h3>

$fh = fopen('/path/to/your/file.txt', 'r') or die($php_errormsg);
while(!feof($fh)){
    $line = fgets($fh);
    if(preg_match($pattern, $line)) {$ora_books[ ] = $line; }
}
fclose($fh);
    </pre>


<hr />

<h2><a name="capturing">Capturing Text Inside HTML Tags</a></h2>
<p><b>Problem:</b> You want to capture text inside HTML tags. For example, you want to find all the heading tags in an HTML document.</p>
<p><b>Solution:</b> Read the HTML file into a string and use nongreedy matching in your pattern:</p>

<p>Documentation on <a href="http://php.net/tidy" target="_blank">Tidy</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Capturing HTML headings</h3>

$html = file_get_contents(__DIR__.'/example.html');
preg_match_all('@&lt;h([1-6])>(.+?)&lt;/h\1>@is', $html, $matches);
foreach($matches[2] as $text){
    print "Heading: $text\n";
}
    </pre>


<hr />

<h2><a name="preventing">Preventing Parentheses from Capturing Text</a></h2>
<p><b>Problem:</b> You've used parentheses for grouping in a pattern, but you don't want the text that matches what's in the parentheses to show up in your array of captured matches.</p>
<p><b>Solution:</b> Put ?: just after the opening parenthesis:</p>

<p>The <a href="http://php.net/reference.pcre.pattern.syntax" target="_blank">PCRE Pattern Syntax Documentation</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Preventing text capture</h3>

$html = "&lt;link rel="icon" href="http://www.example.com/icon.gif"/>
&lt;link rel="prev" href="http://www.example.com/prev.xml"/>
&lt;link rel="next" href="http://www.example.com/next.xml"/>;

preg_match_all('/rel="(prev|next)" href="([^"]*?)"/', $html, $bothMatches);
preg_match_all('/rel="(?:prev|next)" href="([^"]*?)"/' $html, $linkMatches);

print '$bothMatches is: '; var_dump($bothMatches);
print '$linkMatches is: '; var_dump($linkMatches);
    </pre>


<hr />

<h2><a name="escaping">Escaping Special Characters in a Regular Expression</a></h2>
<p><b>Problem:</b> You want to have characters such as * or + treated as literals, not as metacharacters, inside a regular expression. This is useful when allowing users to type in search strings you want to use inside a regular expression.</p>
<p><b>Solution:</b> Use preg_quote() to escape PCRE metacharacters:</p>

<p>Documentation on <a href="http://php.net/preg-quote" target="_blank">preg_quote()</a></p>

<pre class="prettyprint">
$pattern = preg_quote('The Education of H*Y*M*A*N K*A*P*L*A*N).:(\d+)';
if(preg_match("/$pattern/", $book_rank, $matches)){
    print "Leo Rosten's book ranked: " .$matches[1];
}
    </pre>


<hr />

<h2><a name="reading_records">Reading Records with a Pattern Separator</a></h2>
<p><b>Problem:</b> You want to read in records from a file, in which each record is separated by a pattern you can match with a regular expression.</p>
<p><b>Solution:</b> Read the entire file into a string and then split on the regulare expression:</p>

<pre class="prettyprint">
$contents = file_get_contents('/path/to/your/file.txt');
$records = preg_split('/[0-9]+\) /', $contents);
    </pre>


<hr />

<h2><a name="using_php">Using a PHP Function in a Regular Expression</a></h2>
<p><b>Problem:</b> You want to process matched text with a PHP function. For example, you want to decode all HTML entities in captured subpatterns.</p>
<p><b>Solution:</b> Use preg_replace_callback(). Instead of a replacement pattern, give it a callback function. This callback function is passed an array of matched subpatterns and should return an appropriate replacement string.</p>

<p>Documentation on <a href="http://php.net/language.types.callable" target="_blank">callable pseudotype</a></p>
<p>Documentation on <a href="http://php.net/create_function" target="_blank">create_function()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Generating replacement strings with a callback function</h3>

$h = 'The &amp;lt;b&amp;gt; tag makes text bold: &lt;code>&amp;lt;b&amp;gt;&lt;/code>';
print preg_replace_callback('@&lt;code>(.*?)&lt;/code>@', 'decode', $h);

//$matches[0] is the entire matched string
//$matches[1] is the first captured subpattern
function decode($matches){
    return html_entity_decode($matches[1]);
}

//Prints:
//The &lt;b> tag makes text bold: &lt;b>bold&lt;/b>
   
    <hr />
    <h3 class="nocode">Generating replacement strings with an anonymous function</h3>

$callbackFunction = function($matches){
    return html_entity_decode($matches[1]);
}

$fp = fopen(__DIR__.'/html-to-decode.html', 'r');
while(!feof($fp)){
    $line = fgets($fp);
    print preg_replace_callback('@&lt;code>(.*?)&lt;/code>@', $callbackFunction, $line);
}
fclose($fp);
    </pre>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>