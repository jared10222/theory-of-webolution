<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Functions</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#accessing_parameters">Accessing Function Parameters</a></td>
        <td><a href="#setting_default">Setting Default Values for Function Parameters</a></td>
        <td><a href="#passing_values">Passing Values by Reference</a></td>
        <td><a href="#using_parameters">Using Named Parameters</a></td>
    </tr>
    <tr>
    	<td><a href="#enforcing">Enforcing Types of Function Arguments</a></td>
        <td><a href="#creating">Creating Functions That Take a Variable Number of Arguments</a></td>
        <td><a href="#returning_values">Returning Values by Reference</a></td>
        <td><a href="#returning_more">Returning More Than one Value</a></td>
    </tr>
    <tr>
    	<td><a href="#skipping">Skipping Selected Return Values</a></td>
        <td><a href="#returning_failure">Returning Failure</a></td>
        <td><a href="#calling_variable_functions">Calling Variable Functions</a></td>
        <td><a href="#accessing_global">Accessing a Global Variable Inside a Function</a></td>
    </tr>
    <tr>
        <td><a href="#creating_dynamic_functions">Creating Dynamic Functions</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
     
</table>

<h2><a name="accessing_parameters">Accessing Function Parameters</a></h2>
<p><b>Problem:</b> You want to access the values passed to a function.</p>
<p><b>Solution:</b> USe the names from the function prototype:</p>

<pre class="prettyprint">
function commercial_sponsorship($letter, $number){
    print "This episode of Sesame Street is brought to you by ";
    print "the letter $letter and number $number.\n";
}
commercial_sponsorship('G', 3);

$another_letter = 'X';
$another_number = 15;
commercial_sponsorship($another_letter, $another_number);
    </pre>


<hr />

<h2><a name="setting_default">Setting Default values for Function Parameters</a></h2>
<p><b>Problem:</b> You want a parameter to have a default value if the function's caller doesn't pass it. For example, a function to wrap text in an HTML tag might have a parameter for the tag name, which defaults to strong if none is given.</p>
<p><b>Solution:</b> Assign the default value to the parameters inside the funciton prototype:</p>

<pre class="prettyprint">
function wrap_in_html_tag($text, $tag = 'strong'){
	return "&lt;$tag>$text&lt;/$tag>";
}
    </pre>


<hr />

<h2><a name="passing_values">Passing Values by Reference</a></h2>
<p><b>Problem:</b> You want to pass a variable to a function and have it retain any changes made to its value inside the function</p>
<p><b>Solution:</b> To instruct a function to accept an argument passed by reference instead of value, prepend an & to the parameter name in the function prototype:</p>

<pre class="prettyprint">
function wrap_in_html_tag(&amp;$text, $tag = 'strong'){
    $text = "&lt;$tag>$text&lt;/$tag>";
} 
//Now there's no need to return the string because the 
//original is modified in place.   
    </pre>


<hr />

<h2><a name="using_parameters">Using Named Parameters</a></h2>
<p><b>Problem:</b> You want to specify your arguments to a function by name, instead of simply their position in the funciton invocation.</p>
<p><b>Solution:</b> PHP doesn't have language-level named parameter support like some other languages do. However, you can emulate it by having a function use one parameter and making that parameter an associative array:</p>

<pre class="prettyprint">
function image($img){
    $tag = '&lt;img src="' . $img['src'] . '" ';
    $tag .= 'alt="' . (isset($img['alt']) ? $img['alt'] : ''). '"/>';
    return $tag;
}

//$image1 is '&lt;img src="cow.png" alt="cows say moo"/>'
$image1 = image(array('src' => 'cow.png', 'alt' => 'cows say moo'));

//$image2 is '&lt;img src="pig.jgeg" alt=""/>'
$image2 = image(array('src' => 'pig.jpeg'));
    </pre>


<hr />

<h2><a name="enforcing">Enforcing Types of Function Arguments</a></h2>
<p><b>Problem:</b> You want to ensure argument values have certain types.</p>
<p><b>Solution:</b> Use type hints on the arguments when you define your function. A type hint goes before the parameter name in a funciton declaration:</p>

<p>Documentation on <a href="http://php.net/language.oop5.typehinting" target="_blank">type hints</a></p>

<pre class="prettyprint">
function drink_juide(Liquid $drink){
    /*...*/
}

function enumerate_some_stuff(array $values){
    /*...*/
}
    </pre>


<hr />

<h2><a name="creating">Creating Functions That Take a Variable Number of Arguments</a></h2>
<p><b>Problem:</b> You want to define a function that takes a variable number of arguments.</p>
<p><b>Solution:</b> Pass the function a single array-typed argument and put your varible arguments inside the array:</p>

<p>Documentation on <a href="http://php.net/func-num-args" target="_blank">func_num_args()</a></p>
<p>Documentation on <a href="http://php.net/func-get-arg" target="_blank">func_get_arg()</a></p>
<p>Documentation on <a href="http://php.net/func-get-args" target="_blank">func_get_args()</a></p>

<pre class="prettyprint">
//find the "average" of a group of numbers
function mean($numbers){
    //initialize to avoid warnings
    $sum = 0;
    
    //the number of elements in the array
    $size = count($numbers);
    
    //iterate through the array and add up the numbers
    for($i = 0; $i &lt; $size; $i++){
        $sum += $numbers[$i];
    }
    
    //divide by the amount of numbers
    $average = $sum / $size;
    
    //return average
    return $average;
}

//$mean is 96.25
$mean = mean(array(96, 93, 98, 98));


    <hr />
    <h3 class="nocode">Accessing function params without using the argument list</h3>

// find the "average" of a group of numbers
function mean() {
// initialize to avoid warnings
$sum = 0;
// the arguments passed to the function
$size = func_num_args();
// iterate through the arguments and add up the numbers
for ($i = 0; $i < $size; $i++) {
$sum += func_get_arg($i);
}
// divide by the amount of numbers
$average = $sum / $size;
// return average
return $average;
}
// $mean is 96.25
$mean = mean(96, 93, 98, 98);



// find the "average" of a group of numbers
function mean() {
// initialize to avoid warnings
$sum = 0;
// the arguments passed to the function
$size = func_num_args();
// iterate through the arguments and add up the numbers
foreach (func_get_args() as $arg) {
$sum += $arg;
}
// divide by the amount of numbers
$average = $sum / $size;
// return average
return $average;
}
// $mean is 96.25
$mean = mean(96, 93, 98, 98);
    </pre>


<hr />

<h2><a name="returning_values">Returning Values by Reference</a></h2>
<p><b>Problem:</b> You want to return a value by reference, not by value. This allows you to avoid making a duplicate copy of a variable.</p>
<p><b>Solution:</b> The syntax for returning a variable by reference is similar to passing it by reference. However, instead of placing an &amp; before the parameter, place it before the name of the function:</p>

<p>Also, you must use the =&amp; assignment operator instead of plain = when invoking the function:</p>

<p>Returning a reference from a function allows you to directly operate on the return value and have those changes reflected in the original variable.</p>

<pre class="prettyprint">
function &amp;array_find_value($needle, &amp;$haystack){
    foreach($haystack as $key => $value){
        if($needle == $value){
            return $haystack[$key];
        }
    }
}

$band =&amp; array_find_value('The Doors', $artists);
    </pre>


<hr />

<h2><a name="returning_more">Returning More Than One Value</a></h2>
<p><b>Problem:</b> You want to return more than one value from a function.</p>
<p><b>Solution:</b> Return an array and use list() to separate elements:</p>

<pre class="prettyprint">
function array_stats($values){
    $min = min($values);
    $max = max($values);
    $mean = array_num($values) / count($values);
    
    return array($min, $max, $mean);
}
$values = array(1,3,5,9,13,1442);
list($min, $max, $mean) = array_stats($values);
    </pre>


<hr />

<h2><a name="skipping">Skipping Selected Return Values</a></h2>
<p><b>Problem:</b> A function returns multiple values, but you only care about some of them.</p>
<p><b>Solution:</b> Omit variables inside of list():</p>

<pre class="prettyprint">
//Only care about minutes
function time_parts($time){
    return explode(':', $time);
}

list(, $minute,) = time_parts('12:34:56');
    </pre>


<hr />

<h2><a name="returning_failure">Returning Failure</a></h2>
<p><b>Problem:</b> You want to indicate a failure from a function</p>
<p><b>Solution:</b> Return false:</p>

<pre class="prettyprint">
function lookup($name){
    if(empty($name)) {return false; }
    /*...*/
}

$name = 'alice';

if(false !== lookup($name)){
    /* act upon lookup */
}else{
    /* log an error */
}
    </pre>


<hr />

<h2><a name="calling_variable_functions">Calling Variable Functions</a></h2>
<p><b>Problem:</b> You want to call different funcitons depending on a variable's value.</p>
<p><b>Solution:</b> use call_user_func():</p>

<p>Use call_user_func_array() when your functions accept differing argument counts:</p>

<p>The call_user_func() and call_user_func_array() functions are a little different from your standard PHP functions. Their first argument isn't a string to print, or a number to add, but the name of a function that's executed. The concept of passing a function name that the language invokes is known as a callback, or a callback function.</p>

<p>Documentation on <a href="http://php.net/call-user-func" target="_blank">call_user_func()</a></p>
<p>Documentation on <a href="http://php.net/call-user-func-array" target="_blank">call_user_func_array()</a></p>

<pre class="prettyprint">
function get_file($filename) {
    return file_get_contents($filename);
}    

$function = 'get_file';
$filename = 'graphic.png';

//calls get_file('graphic.png')
call_user_func($function, $filename);



funciton get_file($filename){
    return file_get_contents($filename);
}
function put_file($filename, $d){
    return file_put_contents($filename, $d);
}

if($action == 'get'){
    $function = 'get_file';
    $args = array('graphic.png');
}elseif ($action == 'put'){
    $funciton = 'put_file';
    $args = array('graphic.png', $graphic);
}

//calls get_file('graphic.png')
//calls put_file('graphic.png', $graphic)
call_user_func_array($function, $args);


    </pre>


<hr />

<h2><a name="accessing_global">Accessing a Global Variable Inside a Function</a></h2>
<p><b>Problem:</b> You need to access a global variable inside a function</p>
<p><b>Solution:</b> Bring the global variable into local scope with the global keyword:</p>

<p>Or reference it directly in $GLOBALS:</p>

<p>Documentation on <a href="http://php.net/variables.scope" target="_blank">variable scope</a></p>
<p>Documentation on <a href="http://php.net/language.references" target="_blank">variable references</a></p>

<pre class="prettyprint">
function eat_fruit($fruit){
    global $chew_count;
    
    for($i = $chew_count; $i > 0; $i--){
        /*...*/
    }
}


function eat_fruit($fruit){
    for($i = $GLOBALS['chew_count']; $i > 0; $i--){
        /*...*/
    }
}
    </pre>


<hr />

<h2><a name="creating_dynamic_functions">Creating Dynamic Functions</a></h2>
<p><b>Problem:</b> You want to create and define a function as your program is running.</p>
<p><b>Solution:</b> Use the closure syntax to define a function and store it in a variable:</p>

<pre class="prettyprint">
$increment = 7;
$add = function($i, $j) use ($increment) {
    return $i + $j + $increment;
};

$sum = $add(1, 2);
    </pre>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>