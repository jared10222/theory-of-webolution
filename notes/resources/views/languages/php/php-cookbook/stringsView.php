<?php
require_once(assets("includes/header.php"));
?>

<!-- Begin page content -->
<div class="container">
      <div class="page-header">
        <h1>Strings</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    	<tr>
        	<td><a href="#accessing_substrings">Accessing Substrings</a></td>
        	<td><a href="#extracting_substrings">Extracting Substrings</a></td>
        	<td><a href="#replacing_substrings">Replacing Substrings</a></td>
            <td><a href="#Processing_a_string">Processing a string one byte at a time</a></td>
        </tr>
        <tr>
        	<td><a href="#reversing_a_string">Reversing a string by word or byte</a></td>
            <td><a href="#generating_random_string">Generating a random string</a></td>
            <td><a href="#expanding_compressing_tabs">Expanding &amp; Compressing Tabs</a></td>
            <td><a href="#controlling_case">Controlling Case</a></td>
        </tr>
        <tr>
            <td><a href="#interpolating">Interpolating Functions &amp; Expressions Within Strings</a></td>
            <td><a href="#trimming">Trimming blanks from a string</a></td>
            <td><a href="#generating_csv">Generating Comma-separated data</a></td>
        	<td><a href="#parsing_csv">Parsing Comma-separated Data</a></td>
        </tr>
        <tr>
            <td><a href="#fixed_width_field_data">Generating Fixed-width Field Data Records</a></td>
            <td><a href="#parsing_fixed_width">Parsing Fixed-width Field Data Records</a></td>
            <td><a href="#taking_strings_apart">Taking Strings Apart</a></td>
        	<td><a href="#wrapping_text">Wrapping text at a certain line length</a></td>
        </tr>
        <tr>
            <td><a href="#storing_binary">Storing Binary data in strings</a></td>
         </tr>
        </table>
<hr />
        

<table class="table table-responsive table-bordered table-striped">
	<caption>Double-quoted string escape sequence</caption>
	<thead>
    	<th>Escape Sequence</th>
        <th>Character</th>
    </thead>
    	<tr>
        	<td>\n</td>
            <td>Newline (ASCII 10)</td>
        </tr>
        <tr>
        	<td>\r</td>
            <td>Carriage return (ASCII 13)</td>
        </tr>
        <tr>
        	<td>\t</td>
            <td>Tab(ASCII 9)</td>
        </tr>
        <tr>
        	<td>\\</td>
            <td>Backslash</td>
        </tr>
        <tr>
        	<td>\$</td>
            <td>Dollar sign</td>
        </tr>
        <tr>
        	<td>\"</td>
            <td>Double Quote</td>
        </tr>
        <tr>
        	<td>\0 through \777</td>
            <td> Octal Value</td>
        </tr>
        <tr>
        	<td>\x0 through \xFF</td>
            <td>Hex Value</td>
        </tr>	
</table>

<p><b>Heredoc-specified strings</b> recognize all the interpolation and escapes of double-quoted strings, but they don't require double quotes to be escaped. Heredocs start with &lt;&lt;&lt; and a token. That token(with no leading or trailing whitespace), followed by a semicolon to end the statement(if necessary) ends the heredoc.</p>

<p>Newlines, spacing and quotes are all preserved in a heredoc.</p>

<pre class="prettyprint">
<h3 class="nocode">Defining a here document</h3>        
print &lt;&lt;&lt;END
It's funny when signs say things like:
	Original "Root" Beer
    "Free" Gift
    Shoes cleaned while "you" wait
    or have other misquoted words.
END;
</pre>
<hr />

<h2><a name="accessing_substrings"></a>Accessing Substrings</h2>
<p><b>Problem:</b> You want to know if a string contains a particular substring. For example, you want to find out if an email address contains a @.</p>

<p><b>Solution:</b> Use strpos()</p>

<p>Documentation on <a href="http://us2.php.net/strpos" target="_blank">strpos</a></p>
<pre class="prettyprint">
<h3 class="nocode">Finding a substring with strpos()</h3>
    
if(strpos($_POST['email'], '@') === false){
	print 'There was no @ in the e-mail address!';
}
</pre>

<hr />


<h3><a name="extracting_substrings"></a>Extracting Substrings</h3>

<p><b>Problem:</b> You want to extract part of a string, starting at a particular place in the string. For example, you want the first eith characters of a username entered into a form.</p>

<p><b>Solution:</b> Use substr() to select your substring</p>

<p>Documentation on <a href="http://us2.php.net/substr" target="_blank">substr()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Using substr() with positive $start and $length</h3>
    
print substr('watch out for that tree',6,5);
//prints out f
</pre>

<hr />
<h3><a name="replacing_substrings"></a>Replacing Substrings</h3>
<p><b>Problem:</b> You want to replace a substring with a different string. For example, you want to obscure all but the last four digist of a credit card before printing it.</p>

<p><b>Solution:</b> Use substr_replace</p>

<p>Documentation on <a href="http://us2.php.net/substr-replace" target="_blank">substr_replace()</a></p>

<p>The function substr_replace() is useful when you've got text that's too big to dispaly all at once, and you want to display some of the text with a link to the rest.</p>

<pre class="prettyprint">
<h3 class="nocode">Replacing a substring with substr_replace()</h3>
    
//Everything from position $start to the end of $old_string
//becomes $new_substring
$new_string = substr_replace($old_string, $new_substring, $start);

//$length characters, starting at position $start, become $new_substring
$new_string = substr_replace($old_string, $new_substring, $start, $length);

$credit_card = '4111 1111 1111 1111';
print substr_replace($credit_card, 'xxxx ', 0, strlen($credit_card)-4);
    
<h3 class="nocode">Displaying long text with an ellipsis(...)</h3>
    
//displays the first 25 characters of a message with an ellipsis after it
//as a link to a page that displays more text

$r = mysql_query("SELECT id, message FROM message WHERE id= $id") or die();
$ob = mysql_fetch_object($r);
printf('&lt;a href="more-text.php?id=%d">%s&lt;/a>',
    $ob->id, substr_replace($ob->message,' ...', 25));

//The more-text.php page referenced can use the message ID passed
//in the query string to retrieve the full message and display it.    
</pre>

<hr />


<h3><a name="Processing_a_string"></a>Processing a String One byte at a Time</h3>
<p><b>Problem:</b> You need to process a byte in a string individually</p>

<p><b>Solution:</b> Loop through each byte in the string with for</p>

<p>The <b>strstr()</b> function searches for the first occurence of a string inside another string.</p>
<p>This function is case-senstive. For a case-insensitive search, use <b>stristr()</b> function</p>

<p><b>Syntax:</b> strstr(string, search, before_search)</p>

<p>Documentation on <a href="http://us2.php.net/manual/en/control-structures.for.php" target="_blank">for</a></p>

<p>more about <a href="http://mathworld.wolfram.com/LookandSaySequence.html" target="_blank">"Look and Say"</a> sequence</p>

<pre class="prettyprint">
<h3 class="nocode">Processing each byte in a string</h3>
    
$string = "This weekend, I'm going shopping for a pet chicken.";
$vowels = 0;
for($i = 0, $j = strlen($string); $i &lt; $j; $i++){
	if(strstr('aeiouAEIOU',$string[$i])){
    	$vowels++;
    }
}
</pre>

<hr />
<h3><a name="reversing_a_string"></a>Reversing a String by Word or Byte</h3>
<p><b>Problem:</b> You want to reverse the words or the bytes in a string.</p>

<p><b>Solution:</b> Use strrev() to reverse by byte.</p>

<p>The <b>explode()</b> function breaks a string into an array.</p>
<p><b>Syntax</b> explode(separator, string, limit)</p>

<p>The <b>implode()</b> function returns a string from the elements of an array.</p>

<p><b>Syntax</b> implode(separator, array)</p>

<p>Documentation for <a href="http://us1.php.net/strrev" target="_blank">strrev()</a></p>
<p>Documentation for <a href="http://us2.php.net/array-reverse" target="_blank">array_reverse()</a></p>
<pre class="prettyprint">
<h3 class="nocode">Reversing a string by byte</h3>
    
print strrev('This is not a palindrome.');

//prints: .emordnilap a ton si siht

<h3 class="nocode">Reversing a string by word</h3>

//to reverse by words, explode the string by word boundary, reverse the words
// and then rejoin

$s = "Once upon a time there was a turtle.";
//break the string up into words
$words = explode(' ',$s);
//reverse the array of words
$words = array_reverse($words);
//rebuild the string
$s = implode(' ',$words);
print $s

//prints turtle. a was there time a upon Once

//reversing a string by words can also be done all in one line 
$reversed_s = implode(' ',array_reverse(explode(' ',$s)));
</pre>

<hr />


<h3><a name="generating_random_string"></a>Generating a Random String</h3>
<p><b>Problem:</b> You want to generate a random string.</p>

<p><b>Solution:</b> use str_rand()</p>

<pre class="prettyprint">
<h3 class="nocode">str_rand()</h3>
    
function str_rand($length = 32,
$characters = ↵
'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
if (!is_int($length) || $length < 0) {
return false;
}
$characters_length = strlen($characters) - 1;
$string = '';
for ($i = $length; $i > 0; $i--) {
$string .= $characters[mt_rand(0, $characters_length)];
}
return $string;
}
</pre>

<hr />

<h3><a name="expanding_compressing_tabs"></a>Expanding and Compressing Tabs</h3>

<p><b>Problem:</b> You want to change spaces to tabs (or tabs to spaces) in a string while keeping text aligned with tab stops. For Example, you want to display formatted text to users in a standarized way.</p>

<p><b>Solution:</b> Use str_replace() to switch spaces to tabs or tabs to spaces</p>

<p>Documentation on <a href="http://us2.php.net/str-replace" target="_blank">str_replace()</a></p>
<p>Documentation on <a href="http://us3.php.net/preg_replace_callback" target="_blank">preg_replace_callback()</a></p>
<p>Documentation on <a href="http://us3.php.net/str_split" target="_blank">str_split()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Switching tabs and spaces</h3>
    
$rows = $db->query('SELECT message FROM messages WHERE id = 1');
$obj = $rows->fetch(PDO::FETCH_OBJ);
$tabbed = str_replace(' ' , "\t", $obj->message);
$spaced = str_replace("\t", ' ' , $obj->message);

print "with Tabs: &lt;pre>$tabbed&lt;/pre>";
print "with Spaces: &lt;pre>$spaces&lt;/pre>";
</pre>

<hr />


<h3><a name="controlling_case"></a>Controlling Case</h3>

<p><b>Problem:</b> You need to capitalize, lowercase, or otherwise modify the case of letters in a string. For example, you want to capitalize the intial letters of names but lowercase the rest.</p>

<p><b>Solutions:</b> Use ucfirst() or ucwords() to capitalize the first letter of one or more words.</p>

<p>use strtolower() or strtoupper() to modify the case of entire strings</p>

<p>Documentation for <a href="http://us3.php.net/ucfirst" target="_blank">ucfirst()</a></p>
<p>Documentation for <a href="http://us3.php.net/ucwords" target="_blank">ucwords()</a></p>
<p>Documentation for <a href="http://us3.php.net/strtolower" target="_blank">strtolower()</a></p>
<p>Documentation for <a href="http://us1.php.net/strtoupper" target="_blank">strtoupper()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Capitalizing letters</h3>
    
print ucfirst("how do you do today?");
print ucwords("the price of wales");
//How do you do today?
//The Prince Of Wales

<h3 class="nocode">Changing the case of strings</h3>
    
print strtoupper("i'm not yelling!");
print strtolower('&lt;A HREF="one.php">one&lt;/A>');

//I'M NOT YELLING!
//&lt;a href="one.php">one&lt;/a>
</pre>

<hr />

<h3><a name="interpolating"></a>Interpolating Functions and Expressions within Strings</h3>
<dl>
	<dt>Interpolate</dt>
    <dd>insert (something) between fixed points.<br />
    "illustrations were interpolated in the text"</dd>
</dl>

<p><b>Problem:</b> You want to include the results of executing a function or expression within a string.</p>

<p><b>Solution:</b> Use the string concatenation operator(.)</p>

<p>Documentation on the <a href="http://us1.php.net/language.operators.string" target="_blank">string concatenation operator</a></p>

<pre class="prettyprint">
<h3 class="nocode">String Concatenation</h3>
    
print 'You have '.($_POST['boys'] + $_POST['girls']).' children.';
print "The word '$word' is ".strlen($word).' characters long.';
print 'You owe '.$amounts['payment'].' immediately.';
print "My circle's diameter is ".$circle->getDiameter().' inches.';

//You can put variables, object properties, and array elements
//(if the subscript is unquoted) directly in double-quoted strings:
print "I have $children children.";
print "You owe $amounts[payment] immediately.";
print "My circle's diameter is $circle->diameter inches.";

//Use curly braces around more complicated expressions to
//interpolate them into a string:
print "I have {$children} children.";
print "You owe {$amounts['payment']} immediately.";
print "My circle's diameter is {$circle->getDiameter()} inches.";

//Direct interpolation or using string concatenation also works with
//heredocs. The closing heredoc delimiter and the string concatenation
//operator have to be on separate lines:
print &lt;&lt;&lt; END
Right now, the time is
END
. strftime('%c') . &lt;&lt;&lt; END
but tomorrow it will be
END
. strftime('%c',time() + 86400);
</pre>

<hr />


<h3><a name="trimming"></a>Trimming Blanks from a String</h3>

<p><b>Problem:</b> You want to remove whitespace from the beginning or end of a string. For example, you want to clean up user input before validating it.</p>

<p><b>Solutions:</b> Use ltrim(), rtrim(), or trim(). The ltrim() function removes whitespace from the beginning of a string, rtrim() from the end of a string, and trim() from both the beginning and the end of a string:</p>

<p>Documentation for <a href="http://us2.php.net/trim" target="_blank">trim()</a></p>
<p>Documentation for <a href="http://us3.php.net/ltrim" target="_blank">ltrim()</a></p>
<p>Documentation for <a href="http://us3.php.net/rtrim" target="_blank">rtrim()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Trim</h3>
    
$zipcode = trim($_GET['zipcode']);
$no_linefeed = rtrim($_GET['text']);
$name = ltrim($_GET['name']);

//Remove numerals and space from the beginning of the line
print ltrim('10 Print A$', ' 0..9');
//Remove semicolon from the end of the line
print ltrim(SELECT * FROM turtles;',';');

//PRINT A$
//SELECT * FROM turtles
</pre>

<hr />

<h3><a name="generating_csv"></a>Generating Comma-Separated Data</h3>

<p><b>Problem:</b> You want to format data as comma-separated values (CSV) so that it can be imported by a spreadsheet or database</p>

<p><b>Solution:</b> use the fputcsv() function to generate a CSV-formatted line from an array of data.</p>

<p>Documentation for <a href="http://us3.php.net/fputcsv" target="_blank">fputcsv()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Generating comma-separated data</h3>
    
$sales = array( array('Northeast','2005-01-01','2005-02-01',12.54),
array('Northwest','2005-01-01','2005-02-01',546.33),
array('Southeast','2005-01-01','2005-02-01',93.26),
array('Southwest','2005-01-01','2005-02-01',945.21),
array('All Regions','--','--',1597.34) );
$filename = './sales.csv';
$fh = fopen($filename,'w') or die("Can't open $filename");
foreach ($sales as $sales_line) {
if (fputcsv($fh, $sales_line) === false) {
die("Can't write CSV line");
}
}
fclose($fh) or die("Can't close $filename");
</pre>

<hr />

<h3><a name="parsing_csv"></a>Parsing Comma-Separated Data</h3>

<p><b>Problem:</b> You have data in comma-separated values (CSV) format-for example, a file exported from Excel or a database- and you want to extract the records and fields into a format you can manipulate in PHP.</p>

<p><b>Solution:</b> If the CSV data is in a file (or available via a URL), open the file with fopen() and read in the data with fgetcsv().</p>

<p>Documentation for <a href="http://us2.php.net/fgetcsv" target="_blank">fgetcsv</a></p>

<pre class="prettyprint">
<h3 class="nocode">Reading CSV data from a file</h3>
    
$fp = fopen($filename,'r') or die("can't open file");
print "&lt;table>\n";
while($csv_line = fgetcsv($fp)) {
print '&lt;tr>';
for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
print '&lt;td>'.htmlentities($csv_line[$i]).'&lt;/td>';
}
print "&lt;/tr>\n";
}
print "&lt;/table>\n";
fclose($fp) or die("can't close file");
</pre>

<hr />


<h3><a name="fixed_width_field_data"></a>Generating Fixed-Width Field Data Records</h3>

<p><b>Problem:</b> You need to format data records such that each field takes up a set amount of characters</p>

<p><b>Solution:</b> Use pack() with a format string that specifies a sequence of space-padded strings.</p>

<p>Documentation on <a href="http://us1.php.net/pack" target="_blank">pack()</a></p>
<p>Documentation on <a href="http://us1.php.net/str_pad" target="_blank">str_pad()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Generating fixed-width field data records</h3>
    
$books = array( array('Elmer Gantry', 'Sinclair Lewis', 1927),
array('The Scarlatti Inheritance','Robert Ludlum', 1971),
array('The Parsifal Mosaic','William Styron', 1979) );
foreach ($books as $book) {
print pack('A25A15A4', $book[0], $book[1], $book[2]) . "\n";
}
</pre>

<hr />


<h3><a name="parsing_fixed_width"></a>Parsing Fixed-Width Field Data Records</h3>

<p><b>Problem:</b> You need to break apart fixed-width records in strings</p>

<p><b>Solution:</b> use substr()</p>

<p>Documentation for <a href="http://us3.php.net/str_split" target="_blank">str_split</a></p>

<pre class="prettyprint">
<h3 class="nocode">Parsing fixed-width records with substr()</h3>
    
$fp = fopen('fixed-width-records.txt','r',true) or die ("can't open file");
while ($s = fgets($fp,1024)) {
$fields[1] = substr($s,0,25); // first field: first 25 characters of the line
$fields[2] = substr($s,25,15); // second field: next 15 characters of the line
$fields[3] = substr($s,40,4); // third field: next 4 characters of the line
$fields = array_map('rtrim', $fields); // strip the trailing whitespace
// a function to do something with the fields
process_fields($fields);
}
fclose($fp) or die("can't close file");

//or unpack()

function fixed_width_unpack($format_string,$data) {
$r = array();
for ($i = 0, $j = count($data); $i < $j; $i++) {
$r[$i] = unpack($format_string,$data[$i]);
}
return $r;
}
</pre>

<hr />

<h3><a name="taking_strings_apart"></a>Taking Strings Apart</h3>

<p><b>Problem:</b> You need to break a string into pieces. For example, you wan to access each line that a user enters in a &lt;textarea> form field.</p>

<p><b>Solution:</b> Use explode() if what separates the pieces is a constant string:<br />
Use preg_split() if you need a Perl-compatible regular expression to describe the separator:<br />
Use the /i flag to preg_slit() for case-insensitive separator matching:</p>

<p>Documentation for <a href="http://us3.php.net/explode" target="_blank">explode()</a></p>
<p>Documentation for <a href="http://us3.php.net/preg-split" target="_blank">preg_split()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Taking Strings Apart</h3>
    
$words = explode(' ', 'My sentence is not very complicated');

$words = preg_split('/\d\. /', 'my day: 1, get up 2. get dressed 3. eat toast');
$lines = preg_split('/[\n\r]+/',$_POST['textarea']);

$words = preg_split('/ x /i', '31 inches x 22 inches x 9 inches');
</pre>

<hr />


<h3><a name="wrapping_text"></a>Wrapping Text at a Certain Line Length</h3>

<p><b>Problem:</b> You need to wrap lines in a string. For example, you want to display text by using &lt;pre> and &lt;/pre> tags but have it stay within a regularly sized browser window.</p>

<p><b>Solution:</b> Use wordwrap():</p>

<p>Documentation on <a href="http://us3.php.net/wordwrap" target="_blank">wordwrap()</a></p>

<pre class="prettyprint">
<h3 class="nocode">Using wordwrap()</h3>
    
$s = "Four score and seven years ago our fathers brought forth on this continent ↵
a new nation, conceived in liberty and dedicated to the proposition ↵
that all men are created equal.";
print "&lt;pre>\n".wordwrap($s)."\n&lt;/pre>";
</pre>

<hr />

<h3><a name="storing_binary"></a>Storing Binary Data in Strings</h3>

<p><b>Problem:</b> You want to parse a string that contains values encoded as binary or encode values into a string. For example, you want to store numbers in their binary representation instead of as sequences of ASCII characters.</p>

<p><b>Solution:</b> Use pack() to store binary data in a string</p>
<p>Use unpack() to extract binary data from a string</p>

<p>Documentation on <a href="http://us3.php.net/pack" target="_blank">pack()</a></p>
<p>Documentation on <a href="http://us3.php.net/unpack" target="_blank">unpack()</a></p>

<pre class="prettyprint">
<h3 class="nocode">pack()</h3>
    
$packed = pack('S4', 1974, 106, 28225, 32725);

$nums = unpack('S4', $packed);
</pre>

<table class="table table-bordered table-responsive table-striped">
	<caption>Format characters for pack() &amp; unpack()</caption>
    <thead>
    	<th>Format Character</th>
        <th>Data type</th>
    </thead>
    <tr>
    	<td>a</td>
        <td>NUL-padded string</td>
    </tr>
    <tr>
    	<td>A</td>
        <td>Space-padded string</td>
    </tr>
    <tr>
    	<td>h</td>
        <td>Hex string,low nibble first</td>
    </tr>
    <tr>
    	<td>H</td>
        <td>Hex string, high nibble first</td>
    </tr>
    <tr>
    	<td>c</td>
        <td>Signed char</td>
    </tr>
    <tr>
    	<td>C</td>
        <td>Unsigned char</td>
    </tr>
    <tr>
    	<td>s</td>
        <td>signed short(16 bit, machine byte order)</td>
    </tr>
    <tr>
    	<td>S</td>
        <td>unsigned short(16 bit, machine byte order)</td>
    </tr>
    <tr>
    	<td>n</td>
        <td>unsigned short(16 bit, big endian byte order)</td>
    </tr>
    <tr>
    	<td>v</td>
        <td>unsigned short(16 bit, little endian byte order)</td>
    </tr>
    <tr>
    	<td>i</td>
        <td>signed int (machine-dependent size and byte order)</td>
    </tr>
    <tr>
    	<td>I</td>
        <td>Unsigned int (machine-dependent size and byte order)</td>
    </tr>
    <tr>
    	<td>l</td>
        <td>signed long(32 bit, machine byte order)</td>
    </tr>
    <tr>
    	<td>L</td>
        <td>unsigned long(32 bit, machine byte order)</td>
    </tr>
    <tr>
    	<td>N</td>
        <td>unsigned long(32 bit, big endian byte order)</td>
    </tr>
    <tr>
    	<td>V</td>
        <td>unsigned long(32 bit, little endian byte order)</td>
    </tr>
    <tr>
    	<td>f</td>
        <td>float(machine-dependent size and representation)</td>
    </tr>
    <tr>
    	<td>d</td>
        <td>double(machine-dependent size and respresentation)</td>
    </tr>
    <tr>
    	<td>x</td>
        <td>NUL byte</td>
    </tr>
    <tr>
    	<td>X</td>
        <td>Back up one byte</td>
    </tr>
    <tr>
    	<td>@</td>
        <td>NUL-fill to absolute position</td>
    </tr>
</table>

</div><!--end container-->

<?php require_once(assets("includes/footer.php")); ?>



