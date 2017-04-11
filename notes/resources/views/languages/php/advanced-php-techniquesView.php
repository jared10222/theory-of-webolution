<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Advanced PHP Techniques</h1>
      </div>
       <ul>
         <li><a href="#multidimensional-arrays">Multidimesional Arrays</a></li>
         <li><a href="#advanced-function-defs">Advanced Function Definitions</a></li>
         <li><a href="#heredoc">The Heredoc Syntax</a></li>
         <li><a href="#printf-sprintf">Using printf() and sprintf()</a></li>
       </ul>
     <hr /> 

<h2 id="multidimensional-arrays">Multidimensional Arrays</h2>
<p class="lead">Sorting Multidimensional arrays</p>

<pre class="prettyprint">
<h3 class="nocode">The Short Array Syntax</h3>
<p class="nocode">New in PHP 5.4 is the <b>short array syntax</b>, which is simply an alternative 
way of creating an array. To use the short array syntax, replace calls to the 
array() function with the square array brackets:</p>
//Old way:
$a = array(); //Empty
$b = array('this' => 'that');
//New way:
$a = []; //Empty
$b = ['this' => 'that'];
</pre>

<p>To sort a multidimensional array, you define your own sort function and then tell PHP to use that function by invoking the built-in <b>usort(), uasort(), or uksort()</b> function.</p>

<p>The function you define must take exactly two parameters and return a value indicating which parameter should be first in the sorted list. A negative or false value means that the first parameter should be listed before the second. A positive or true value means the second parameter should come first. A value of 0 indicates the parameters have the same value.</p>

<p>To sort the preceding array on the first key, the sorting function would be defined as:</p>

<pre class="prettyprint">
$a = array(
    array('key1' => 940, 'key2' => 'blah'),
    array('key1' => 23, 'key2' => 'this'),
    array('key1' => 894, 'key2' => 'that')
);

function asc_number_sort($x, $y){
    if($x['key1'] > $y['key1']){
        return true;
    }elseif($x['key1'] &lt; $y['key1']){
        return false;
    }else{
        return 0;
    }
}

//Then the PHP code would use this function:
usort($a, 'asc_number_sort');

//OUTPUTS
Array
(
    [0] => Array
        (
            [key1] => 23
            [key2] => this
        )
    [1] => Array
        (
            [key1] => 894
            [key2] => that
        )
    [2] => Array
        (
            [key1] => 940
            [key2] => blah
        )
)
</pre>

<p>PHP will continue sending the inner arrays to this function so that they may be sorted. If you want to see this in detail, print the values being compared in the function.</p>
<pre class="prettyprint">
Iteration 1: 23 vs. 940
Iteration 2: 894 vs. 23
Iteration 3: 940 vs. 23
Iteration 4: 894 vs. 940

Array
(
    [0] => Array
        (
            [key1] => 23
            [key2] => this
        )
        
<p class="nocode">By printing out the values of $x['key1'] and $y['key1'], you can
see how the user-defined sorting function is invoked.</p>
</pre>

<p>The <b>usort()</b> function sorts by values but does not maintain the keys (for the outermost array). When you use <b>uasort()</b>, the keys will be maintained. When you use <b>uksort()</b>, the sort is based on the keys.</p>

<p>To sort on the second key in the preceding example, you would want to compare two strings. That code woud be:</p>

<pre class="prettyprint">
function string_sort($x, $y){
    return strcasecmp($x['key2'], $y['key2']);
}
usort($a, 'string_sort');
</pre>

<p class="lead">Database-driven arrays</p>
<p>Selecting multiple columns from multiple rows in a database results in a multidimensional array.</p>

<pre class="prettyprint">
<h3 class="nocode">Type Hinting Function Parameters</h3>
<p class="nocode">Type hinting is the act of indicating what type a variable needs to be.
For example, this code insists that the function's single parameter is an array:</p>

function f(array $input){}
</pre>

<h3 id="advanced-function-defs">Advanced Function Definitions</h3>
<p>There are four potential features of user-defined functions that arise in more advanced programming. These are:</p>
<ul>
	<li>Recursive functions</li>
    <li>Static variables</li>
    <li>Accepting values by reference</li>
    <li>Anonymous functions</li>
</ul>

<h3>Recursive functions</h3>
<p><b>Recursion</b> is the act of a function calling itself:</p>
<pre class="prettyprint">
function someFunction(){
    //Some code.
    someFunction();
    //Possible other code.
}
</pre>

<p>The end result of a recursion is that the function’s code is executed repeatedly, as if called from within
a loop.</p>

<p>Recursive functions are necessary when you have a process that would be followed to an unknown
depth. For example, a script that searches through a directory may have to search through any number
of subdirectories. That can easily be accomplished using recursion:</p>
<pre class="prettyprint">
function list_dir($start){
  $contents = scandir($start);
  foreach($contents as $item){
      if(is_dir("$start/$item") &amp;&amp; (substr($item, 0, 1) != '.')){
          //Use $item
          list_dir("$start/$item");
      } else {
          //Use $item
      }//End of if-else
  }//End of foreach
}//End of function
list_dir('.');
</pre>


<hr />
<h3>Using Static Variables</h3>
<p>When working with recursion or, in face, any script in which the same function may be called multiple times, you might want to consider using the <b>static</b> statement. <b>static</b> forces the function to remember the value of a variable from function call to function call, without using global variables.</p>

<pre class="prettyprint">
function make_list($parent, $all = null){
    static $tasks;
    if(isset($all)){
        $tasks = $all;
    }
}
</pre>

<hr />
<h3>Anonymous functions</h3>
<p><b>anonymous functions</b> are also called <b>lambdas</b>. An anonymous function is a function without a name. Anonymous functions are created by defining a function as you would any other, but without a name. However, in order to be able to later reference that function (e.g., call it), the unnamed function needs to be assigned to a varible:</p>
<pre class="prettyprint">
$hello = function($who){
    echo "&lt;p>Hello, $who&lt;/p>";
};

$hello('World!');
$hello('Universe!');
</pre>

<p>Several functions in PHP take a function as an argument. For example, the <b>array_map()</b> function takes a function as its first argument and an array whose elements will be run through that function as its second:</p>
<pre class="prettyprint">
function format_names($value){
    //Do whatever with $value
}
array_map('format_name', $names);

<hr />

//first way
function name_sort($x, $y){
	static $count = 1;
	echo "&lt;p>Iteration $count: {$x['name']} vs. {$y['name']} &lt;/p>\n";
	$count++;
	return strcasecmp($x['name'], $y['name']);	
}

uasort($students, 'name_sort');

//anonymous function way
//Sort by name:
uasort($students, function($x, $y){
    static $count = 1;
	echo "&lt;p>Iteration $count: {$x['name']} vs. {$y['name']} &lt;/p>\n";
	$count++;
	return strcasecmp($x['name'], $y['name']);
});
</pre>

<pre class="prettyprint">
<h3 class="nocode">References and Functions</h3>
<p class="nocode">As a default, function parameters are <b>passed by value</b>. This means
that a function receives the value of a variable, not the actual variable itself. 
The function can also be described as <b>makeing a copy</b> of the variable. One
result of this behavior is that changing the value within the function has no
impact on the original variable outside of it:</p>

function increment($var){
    $var++;
}
$num = 2;
increment($num);
echo $num; // Still 2!

<p class="nocode">The alternative to this default behavior is to have a function's
parameters be <b>passed by reference</b>, instead of value. There are two benefits
to doing so. The first is it allows you to change an external variable within a 
function without making that variable global. The second benefit is one of
performance. In situations where the data being passed in large, passing by reference
means that PHP will not need to make a duplicate of that data. For strings and
numbers, the duplication is not an issue, but for a large data set as in the tasks
example, it would be better if PHP did not have to make that copy.</p>
<p class="nocode">To pass a variable by reference instead of by value, precede
the variable in the parameter list with the ampersand(&amp;):</p>

function increment(&amp;$var){
    $var++;
}
$num = 2;
increment($num);
echo $num; //3

<p class="nocode">Alternatively, the function definition can stay the same and how
the function is called would change:</p>

function increment($var){
    $var++;
}
$num = 2;
increment(&amp;$num);
echo $num; //3

<p class="nocode">You probably won’t (or shouldn’t) find yourself passing values by reference often, but
like the other techniques in this chapter, it’s often the perfect solution to an advanced
problem.</p>
</pre>

<hr />
<h3 id="heredoc">The Heredoc Syntax</h3>
<p><b>Heredoc</b> is an alternative way for encapsulating strings. It's used and seen much less often than the standard single or double quotes, but it fulfills the same role.</p>

<p>The heredoc approach works just like a double quote in that the values of variables will be printed but
you can define your own delimiter. Heredoc is a particularly nice alternative to using double quotation
marks when you are printing oodles of HTML (which normally has its own double quotation marks).
The only catch to heredoc is that its syntax is very particular!</p>

<p>The heredoc syntax starts with &lt;&lt;&lt;, immediately followed by an identifier. The identifier is normally a
word in all caps. It can only contain alphanumeric characters plus the underscore (no spaces), and it
cannot begin with a number. There should be nothing on the same line after the initial identifier, not
even a space! Use of heredoc might begin like</p>

<pre class="prettyprint">
echo &lt;&lt;&lt;EOT
blah...
or
$string = &lt;&lt;&lt;EOD
blah...

<p class="nocode">At the end of the string, use the same identifier without the
&lt;&lt;&lt;. The closing identifier has to be the very first item on the line
(it cannot be indented at all) and can only be followed by a semicolon!</p>

$var = 23;
$that = 'test';
echo &lt;&lt;&lt;EOT
Somevar $var
Thisvar $that
EOT;
$string = &lt;&lt;&lt;EOD
string with $var \n
EOD;
echo $string;
</pre>

<pre class="prettyprint">
<h3 class="nocode">The Nowdoc Syntax</h3>
<p class="nocode">Nowdoc is to heredoc as single quotes are to double quotes. 
This is to say that nowdoc provides another way to encapsulate a string, but 
any variables within the nowdoc syntax will not be replaced with their values. 
In terms of syntax, nowdoc uses the same rules as heredoc except that the 
delimiting string needs to be placed within single quotes on the first line:</p>
$var = 23;
$string = &lt;&lt;&lt;'EOD'
string with $var
EOD;
<p class="nocode">To be clear, <b>$string</b> now has the literal value of string with $var, not string 23.</p>
</pre>

<hr />
<h3 id="printf-sprintf">Using printf() and sprintf()</h3>
<p><b>printf(string format [, mixed argument]);</b></p>
<p><i>printf() is used to "PRINT" some formatted string<br />
sprintf() is used to "STORE" some formatted string, and print it with the help of echo or print.</i></p>

<p>The format is a combination of literal and text and special formatting parameters, beginning with the percent sign(%). After that, you may have any combination of the following (in order):</p>
<ul>
	<li>A sign specifier (+/-) to force a positive number to show the plus sign</li>
    <li>A padding specifier that indicates the character used for right-padding(space is the default, but you might want to use 0 for numbers).</li>
    <li>An alignment specifier(default is right-justified, use - to force left-justification).</li>
    <li>A number indicating the minimum width to be used.</li>
    <li>A precision specifier for how many decimal digits should be shown for floating-point numbers (or how many characters in a string).</li>
    <li>The type specifier (see table below)</li>
</ul>

<table class="table table-responsive table-striped table-bordered">
	<caption>Type Specifiers</caption>
    <thead>
    	<tr>
        	<th>Character</th>
            <th>Meaning</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td>b</td>
            <td>Binary integer</td>
        </tr>
        <tr>
        	<td>c</td>
            <td>ASCII integer</td>
        </tr>
        <tr>
        	<td>d</td>
            <td>Standard integer</td>
        </tr>
        <tr>
        	<td>e</td>
            <td>Scientific notation</td>
        </tr>
        <tr>
        	<td>u</td>
            <td>Unsigned decimal integer</td>
        </tr>
        <tr>
        	<td>f</td>
            <td>Floating-point number</td>
        </tr>
        <tr>
        	<td>o</td>
            <td>Octal integer</td>
        </tr>
        <tr>
        	<td>s</td>
            <td>String</td>
        </tr>
        <tr>
        	<td>x</td>
            <td>Hexadecimal integer</td>
        </tr>
    </tbody>
</table>

<pre class="prettyprint">
<p class="nocode">This all my seem complicated, and well, it kind of is. You can
start practicing by playing with a number:</p>
printf('b: %b &lt;br>c: %c &lt;br>d: %d &lt;br>f: %f', 80, 80, 80, 80);

//outputs
b: 1010000    //binary
c: P          //corresponding ASCII character
d: 80         //integer
f: 80.000000  //floating-point number
//The same output printed using four differenct type specifiers

<p class="nocode">From here, take the two most common number type --d and f-- and
add some formatting:</p>
printf('%0.2f &lt;br>%+d &lt;br>%0.2f &lt;br>', 8, 8, 1235.456);

//outputs
8.00     //floating-point with two digits after the decimal and padded with zeros
+8       //signed integer
1235.46  //floating-point with two digits after the decimal

<p class="nocode">Taking this idea further, mix in the string type:</p>
printf('The cost of %d %s at $%0.2f each is $%0.2f.', 4, 'brooms', 8.50, (4*8.50));

//outputs
The cost of 4 brooms at $8.50 each is $34.00

</pre>

<h3>Tip</h3>
<p>To use a literal percent sign in a string, escape it with another percent sign:</p>
<pre class="prettyprint">
printf('The tax rate is %0.2%%', $tax);
</pre>

<hr />
<h3>Tip</h3>
<p>The <b>vprintf()</b> function works exactly like <b>printf()</b> but takes only two arguments: the format and an array of values</p>
<hr />

<h3>Tip</h3>
<p>The <b>scanf()</b> and <b>fscanf()</b> functions also work exaclty like <b>printf()</b> and <b>sprintf()</b> in terms of formatting parameters. The <b>scanf()</b> function is used for reading input; <b>fscanf()</b> is used to read data from a file</p>
<hr />

</div><!-- end container-->

<?php require_once(assets("includes/footer.php")); ?>