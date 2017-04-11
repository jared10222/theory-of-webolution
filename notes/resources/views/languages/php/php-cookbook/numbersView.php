<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Numbers</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#checking_valid_number">Checking Whether a Var Contains a Valid Number</a></td>
        <td><a href="#comparing_floating">Comparing Floating-Point Numbers</a></td>
        <td><a href="#rounding_floating">Rounding Floating-Point Numbers</td>
        <td><a href="#operating_on_integers">Operating on a Series of Intergers</a></td>
    </tr>
    <tr>
    	<td><a href="#generating_random">Generating Random Numbers Within a Range</a></td>
        <td><a href="#generating_predictable">Generating Predictable Random Numbers</a></td>
        <td><a href="#generating_biased">Generating Biased Random Numbers</a></td>
        <td><a href="#taking_logarithms">Taking Logarithms</a></td>
    </tr>
     <tr>
    	<td><a href="#calculating_exponents">Calculating Exponents</a></td>
        <td><a href="#formatting_numbers">Formatting Numbers</a></td>
        <td><a href="#formatting_monetary">Formatting Monetary Values</a></td>
        <td><a href="#printing_plurals">Printing Correct Plurals</a></td>
    </tr>
     <tr>
    	<td><a href="#calculating_trig">Calculating Trigonemetric Functions</a></td>
        <td><a href="#doing_trig">Doing Trigonometry in Degrees, No Radians</a></td>
        <td><a href="#handling_large_small">Handling Very Large or Very Small Numbers</a></td>
        <td><a href="#converting_bases">Converting Between Bases</a></td>
    </tr>
     <tr>
    	<td><a href="#calculating_using_numbers">Calculating Using Numbers in Bases Other Than Decimal</a></td>
        <td><a href="#finding_distance">Finding The Distance Between Two Places</a></td>
        <td></td>
        <td></td>
    </tr>
</table>
<hr />

<h2><a name="checking_valid_number"></a>Checking Whether a Variable Contains a Valid Number</h2>
<p><b>Problem:</b><br />
You want to ensure that a variable contains a number, even if it's typed as a string. Alternatively, you want to check if a variable is not only a number, but is specifically typed as one.
</p>
<p><b>Solutions:</b><br />
Use is_numberic() to discover whether a variable contains a number:
</p>
<p>is_numeric() properly parses decimal numbers such as 5.1; however, numbers with thousands separators, such as 5,100, cause is_numeric() to return false.</p>
<p>To strip the thousands separator from your number before calling is_numeric(), use str_replace():</p>
<p>To check if your number is a specific type, there are a variety of related functions with self-explanatory names:</p>
<ul>
	<li>is_float() (or is_double() or is_real(); they're all the same)</li>
    <li>is_int() (or is_integer() or is_long())</li>
</ul>

<p>Documentation on <a href="http://php.net/is-numeric" target="_blank">is_numeric()</a></p>
<p>Documentation on <a href="http://php.net/str-replace" target="_blank">str_replace()</a></p>
<pre class="prettyprint">
<h3 class="nocode">is_numeric</h3>

foreach([5, '5', '05', 12.3, '16.7', 'five', 0xDECAFBAD, '10e200']
	as $maybeNumber){
        $isItNumeric = is_numeric($maybeNumber);
        $actualType = gettype($maybeNumber);
        print "Is the $actualType $maybeNumber numeric? ";
        if(is_numeric($maybenumber)){
            print "yes";
        }else{
            print "no";
        }
        print "\n";
    }

    <hr />
    <h3 class="nocode">str_replace()</h3>

$number = "5,100";

//this is_numeric() call returns false
$withCommas = is_numeric($number);


//This is_numeric() call returns true
$withoutCommas = is_numeric(str_replace(',', '', $number));    
</pre>

<hr />
<h2><a name="comparing_floating">Comparing Floating-Point Numbers</a></h2>
<p><b>Problem:</b> You want to check whether two floating-point numbers are equal.</p>
<p><b>Solutions:</b> Use a small delta value, and check if the numbers have a difference smaller than that delta</p>

<p>Documentation on <a href="http://php.net/language.types.float" target="_blank">Floating Point Numbers</a></p>
<p>Documentation on <a href="http://php.net/manual/en/function.abs.php" target="_blank">abs - Absolute value</a></p>

<pre class="prettyprint">
<h3 class="nocode">$delta</h3>
$delta = 0.00001;

$a = 1.00000001;
$b = 1.00000000;

if(abs($a - $b) < $delta){
    print '$a and $b are equal enough.';
}
</pre>

<hr />

<h2><a name="rounding_floating">Rounding Floating-Point Numbers</a></h2>
<p><b>Problem:</b> You want to round a floating-point number, either to an integer value or to a set number of decimal places.</p>
<p><b>Solution:</b> To round a number to the closest integer, use round():</p>

<p>To round up, use ceil()</p>
<p>To round down, use floor()</p>

<p>To keep a set number of digits after the decimal point, round() accepts an optional precision argument.</p>

<p>Documentation on <a href="http://php.net/ceil" target="_blank">ceil()</a></p>
<p>Documentation on <a href="http://php.net/floor" target="_blank">floor()</a></p>
<p>Documentation on <a href="http://php.net/round" target="_blank">round()</a></p>
<p>Documentation on <a href="http://php.net/sprintf" target="_blank">printf formatting strings such as %s</a></p>

<pre class="prettyprint">
<h3 class="nocode">round()</h3>

$number = round(2.4);
printf("2.4 rounds to the float %s", $number);

//this prints:
2.4 rounds to the float 2

<hr />
<h3 class="nocode">ceil()</h3>

$number = ceil(2.4);
printf("2.4 rounds up to the float %s", $number);

//this prints:
2.4 rounds up to the float 3

<hr />
    <h3 class="nocode">floor()</h3>

$number = floor(2.4);
printf("2.4 rounds down to the float %s", $number);

//this prints
2.4 rounds down to the float 2
</pre>
	
<hr />

<h2><a name="operating_on_integers">Operating on a Series of Integers</a></h2>
<p><b>Problem:</b> You want to apply a piece of code to a range of integers</p>
<p><b>Solutions:</b> Use a for loop:</p>

<p>If you want to preserve the numbers for use beyond iteration, use the range() method:</p>

<p>range() can also be used to retrieve character sequences:</p>
<p>Documentation on <a href="http://php.net/range" target="_blank">range()</a></p>

<pre class="prettyprint">
<h3 class="nocode">for</h3>

$start = 3;
$end = 7;
for ($i = $start; $i <= $end; $i++){
    printf("%d squared is %d\n", $i, $i * $i);
}

<hr />
<h3 class="nocode">range()</h3>
    
$numbers = range(3, 7);
foreach($numbers as $n){
    printf("%d squared is %d\n", $n, $n * $n);
}
foreach($numbers as $n){
    printf("%d cubed is $d\n", $n, $n * $n * $n);
}

<hr />
<h3 class="nocode">character sequence with range()</h3>

print_r(range('l', 'p'));

//this prints
Array
(
   [0] => l
   [1] => m
   [2] => n
   [3] => o
   [4] => p
)
</pre>

<hr />

<h2><a name="generating_random">Generating Random Numbers Within a Range</a></h2>
<p><b>Problem:</b> You want to generate a random number within a range of numbers</p>
<p><b>Solution:</b> Use mt_rand():</p>

<p>Generating random numbers is useful when you want to display a random image on a page, randomize the starting position of a game, select a random record from a database, or generate a unique session identifier.</p>

<pre class="prettyprint">
<h3 class="nocode">mt_rand()</h3>

$lower = 65;
$upper = 97;
//random number between $upper and $lower, inclusive
$random number = mt_rand($lower, $upper);
</pre>

<hr />

<h2><a name="generating_predictable">Generating Predictable Random Numbers</a></h2>
<p><b>Problem:</b> You want to make the random number generate predictable numbers so you can guarantee repeatable behavior</p>
<p><b>Solution:</b> Seed the random number generator with a known value using mt_srand() (or srand()):</p>

<p>Documentation on <a href="http://php.net/mt_srand" target="_blank">mt_srand()</a></p>

<pre class="prettyprint">
<h3 class="nocode">mt_srand()</h3>

&lt;?php

function pick_color(){
    $colors = array('red', 'purple', 'yellow', 'blue', 'green', 'indigo', 'violet');
    $i = mt_rand(0, count($colors) -1);
    return $colors[$i];
}

mt_srand(34534);
$first = pick_color();
$second = pick_color();

//Because a specific value was passed to mt_srand(), we can be
//sure the same colors will get picked each time: red and yellow

print "$first is red and $second is yellow.";
</pre>

<hr />

<h2><a name="generating_biased">Generating Biased Random Numbers</a></h2>
<p><b>Problem:</b> You want to generate random numbers, but you want these numbers to be somewhat biased, so that numbers in a certain range appear more frequently than others. For example, you want to spread out a series of banner ad impressions in proportion to the number of impressions remaining for each ad campaign.</p>

<p><b>Solution:</b> Use the rand_weighted() function:</p>

<pre class="prettyprint">
<h3 class="nocode">rand_weighted()</h3>

//returns the weighted randomly selected key
function rand_weighted($numbers){
    $total = 0;
    foreach($numbers as $number => $weight){
        $total += $weight;
        $distribution[$number] = $total;
    }
    $rand = mt_rand(0, $total - 1);
    foreach($distribution as $number => $weights){
        if($rand &lt; $weights){return $number;}
    }
}
</pre>

<hr />

<h2><a name="taking_logarithms">Taking Logarithms</a></h2>
<p><b>Problem:</b> You want to take the logarithm of a number.</p>
<p><b>Solution:</b> For logs using base e (natural log), use log():</p>
<p>For logs using base 10, use log10():</p>
<p>For logs using other bases, pass the base as the second argument to log():</p>

<dl>
	<dt>logarithm</dt>
    <dd>In mathematics, the <b>logarithm</b> of a number is the exponent to which another fixed value, the base, must be raised to produce that number. For example, the logarithm of 1000 to base 10 is 3, because 10 to the power 3 is 1000: 1000 = 10 * 10 * 10 = 10 to the 3</dd>
</dl>

<p>Documentation on <a href="http://php.net/log" target="_blank">log()</a></p>
<p>Documentation on <a href="http://php.net/log10" target="_blank">Log10()</a></p>

<pre class="prettyprint">
<h3 class="nocode">log()</h3>

//$log is about 2.30258
$log = log(10);

//$log10 == 1
$log10 = log10(10);

//log base 2 of 10 is about 3.32
$log2 = log(10,2);
</pre>

<hr />

<h2><a name="calculating_exponents">Calculating Exponents</a></h2>
<p><b>Problem:</b> You want to raise a number to a power</p>
<p><b>Solution:</b> To raise e to a power, use exp()</p>
<p>To raise it to any power, use pow();</p>

<p>Documentation on <a href="http://php.net/pow" target="_blank">pow()</a></p>
<p>Documentation on <a href="http://php.net/exp" target="_blank">exp()</a></p>
<p><a href="http://php.net/math" target="_blank">Predifined mathematical constants</a></p>

<pre class="prettyprint">
<h3 class="nocode">exp()</h3>

//$exp (e squared) is about 7.389
$exp = exp(2);

<hr />
<h3 class="nocode">pow()</h3>

//$exp (2^e) is about 6.68
$exp = pow(2, M_E);
//$pow1 (2^10) is 1024
$pow1 = pow(2, 10);
</pre>

<hr />

<h2><a name="formatting_numbers">Formatting Numbers</a></h2>
<p><b>Problem:</b> You have a number and you want to print it with thousands and decimal separators. For example, you want to display the number of people who have viewed a page, or the percentage of people who have voted for an option in a poll.</p>

<p><b>Solution:</b> If you always need specific characters as decimal point and thousands operators, use number_format():</p>

<p>If you need to generate appropriate formats for a particular local, use NumberFormatter:</p>

<p>Documentation on <a href="http://php.net/number-format" target="_blank">nubmer_format()</a></p>
<p>Documentation on <a href="http://php.net/numberformatter" target="_blank">NumberFormatter</a></p>

<pre class="prettyprint">
<h3 class="nocode">number_format()</h3>

$number = 1234.56;

//$formatted1 is "1,2345" - 1234.56 gets rounded up and , is
//the thousands separator");
$formatted1 = number_format($number);

//second argument specifies number of decimal places to use.
//$formatted2 is 1,234.56
$formatted2 = number_format($number, 2);

//Third agrument specifies decimal point character
//Fourth argument specifies thousands separator
//$formatted3 is 1.234,56
$formatted3 = number_format($number, 2, ",", ".");

<hr />
<h3 class="nocode">NumberFormatter</h3>

$number = '1234.56';

//$formatted1 is 1,234.56
$usa = new NumberFormatter("en-US", NumberFormatter::DEFAULT_STYLE);
$formatted1 = $usa->format($number);

//$formatted2 is 1 234,56
//Note that it's a "non breaking space (\u00A0) between the 1 and the 2
$france = new NumberFormatter("fr-FR", NumberFormatter::DEFAULT_STYLE);
$formatted2 = $france->format($number);
</pre>
	
<hr />

<h2><a name="formatting_monetary">Formatting Monetary Values</a></h2>
<p><b>Problem:</b> You have a number and you want to print it with thousands and decimal separators. For instance, you want to display prices for items in a shopping cart.</p>
<p><b>Solution:</b> Use the NumberFormatter class with the NumberFormatter::CURRENCY format style:</p>

<p>To produce the right format for a currency other than the locale's native currency, use the formatCurrency() method. It's second argument lets you specify the currency to use. For example, what's the correct way, in the USA, to format the price of something in Euro?</p>

<p>ISO-4217 specifies the three-letter codes to use for the various currencies of Earth</p>

<p>Documentation on <a href="http://en.wikipedia.org/wiki/ISO_4217" target="_blank">ISO-4217 currency codes</a></p>
<p>Documentation on <a href="http://php.net/numberformatter" target="_blank">NumberFormatter</a></p>

<pre class="prettyprint">
<h3 class="nocode">CURRENCY</h3>

$number = 1234.56;

//US used $ , and .
//$formatted1 is $1,234.56
$use = new NumberFormatter("en-US", NumberFormatter::CURRENCY);
$formatted1 = $use->format($number);

//France uses , and &euro;
//$formatted2 is 1 234, 56 &euro;
$france = new NumberFormatter("fr-FR", NumberFormatter::CURRENCY);
$formatted2 = $france->format($number);

<hr />
<h3 class="nocode">formatCurrency()</h3>

$number = 1234.56
//US uses &euro; , and . for Euro
//$formatted is &euro;1,234.56
$usa = new NumberFormatter("en-US", NumberFormatter::CURRENCY);
$formatted = $use->formatCurrency($number, 'EUR');
</pre>

<hr />

<h2><a name="printing_plurals">Printing Correct Plurals</a></h2>
<p><b>Problem:</b> You want to correctly pluralize words based on the value of a variable. For instance, you are returning text that depends on the number of matches by a search.</p>
<p><b>Solution:</b> Use a conditional expression:</p>

<p>Another option is to use one function for all pluralization:</p>

<pre class="prettyprint">
<h3 class="nocode">conditional expression</h3>

$number = 4;
print "Your search returned $number " . ($number == 1 ? 'hit' : 'hits') . '.';
//this prints
Your search returned 4 hits.


<hr />
<h3 class="nocode">may_pluralize</h3>

function may_pluralize($singular_word, $amount_of){
    //array of special plurals
    $plurals = array(
        'fish' => 'fish',
        'person' => 'people',
    );
    
    //only one
    if(1 == $amount_of){
        return $singular_word;
    }
    
    //more than one, special plural
    if(isset($plurals[$singular_word])){
      return $plurals[$singular_word];
    }
    
    //more than one, standard plural: add 's' to end of word
    return $singular_word . 's';
}
</pre>

<hr />

<h2><a name="calculating_trig">Calculating Trigonometric Functions</a></h2>
<p><b>Problem:</b> You want to use trigonometric functions, such as sine, cosine, and tangent</p>
<p><b>Solution:</b> PHP supports many trigonometric functions natively: sin(), cos(), and tan():</p>
<p>You can also use their inverses: asin(), acos(), and atan():</p>
<p>Documentation on <a href="http://php.net/sin" target="_blank">sin()</a></p>
<p>Documentation on <a href="http://php.net/cos" target="_blank">cos()</a></p>
<p>Documentation on <a href="http://php.net/tan" target="_blank">tan()</a></p>
<p>Documentation on <a href="http://php.net/asin" target="_blank">asin()</a></p>
<p>Documentation on <a href="http://php.net/acos" target="_blank">acos()</a></p>
<p>Documentation on <a href="http://php.net/atan" target="_blank">atan()</a></p>
<p>Documentation on <a href="http://php.net/atan2" target="_blank">atan2()</a></p>

<pre class="prettyprint">
<h3 class="nocode">trigonometric</h3>

//cosine of 2 pi is 1, $result = 1
$result = cos(2 * M_PI);

//arctan of pi/4 is about 0.665773
$result = atan(M_PI / 4);
</pre>

<hr />

<h2><a name="doing_trig">Doing Trigonometry in Degrees, Not Radians</a></h2>
<p><b>Problem:</b> You have numbers in degrees but want to use the trigonometric functions</p>
<p><b>Solution:</b> Use deg2rad() and rad2deg() on your input and output:</p>

<p>Documentation on <a href="http://php.net/deg2rad" target="_blank">deg2rad()</a></p>
<p>Documentation on <a href="http://php.net/rad2deg" target="_blank">rad2deg()</a></p>

<pre class="prettyprint">
<h3 class="nocode">deg2rad() and rad2deg()</h3>

$degree = 90;
//cosine of 90 degrees is 0
$cosine = cos(deg2rad($degree));
</pre>

<hr />

<h2><a name="handling_large_small">Handling Very Large or Very Small Numbers</a></h2>
<p><b>Problem:</b> You need to use numbers that are too large (or small) for PHP's built-in floating-point numbers.</p>
<p><b>Solution:</b> Use either BCMath or GMP libraries</p>

<p>Documentation on <a href="http://php.net/bc" target="_blank">BCMATH</a></p>
<p>Documentatino on <a href="http://pecl.php.net/package/big_int" target="_blank">big_int</a></p>
<p>Documentation on <a href="http://php.net/gmp" target="_blank">GMP</a></p>

<pre class="prettyprint">
<h3 class="nocode">BCMath</h3>

//$sum = "9999999999999"
$sum = bcadd('1234567812345678', '8765432187654321);

<hr />
<h3 class="nocode">GMP</h3>

//$sum = gmp_add('1234567812345678', '8765432187654321');
//$sum is now a GMP resource, not a string; use gmp_strval() to convert
print gmp_strval($sum); //prints 9999999999999999
</pre>

<hr />

<h2><a name="converting_bases">Converting Between Bases</a></h2>
<p><b>Problem:</b> You need to convert a number from one base to another</p>
<p><b>Solution:</b> Use the base_convert() function:</p>

<p>Documentation on <a href="http://php.net/base-convert" target="_blank">base_convert()</a></p>
<p>Documentation on <a href="http://php.net/sprintf" target="_blank">sprintf()</a></p>

<pre class="prettyprint">
<h3 class="nocode">base_convert()</h3>

//hexadecimal number (base 16)
$hex = 'a1';

//convert from base 16 to base 10
//$decimal is '161'
$decimal = base_convert($hex, 16, 10);
</pre>

<hr />

<h2><a name="calculating_using_numbers">Calculating Using Numbers in Bases Other Than Decimal.</a></h2>
<p><b>Problem:</b> You want to perform mathematical operations with numbers formatted not in decimal, but in octal or hexadecimal. For example, you want to calculate web-safe colors in hexadecimal.</p>
<p><b>Solution:</b> Prefix the number with a leading symbol, so PHP knows it isn't in base 10. The leading symbol 0b indeicates binary(base 2), the leading symbol 0 indicates octal(base 8) and the leading symbol 0x indicates hexadecimal(base 16). If $a = 100 and $b = 0144 and $c = 0x64 and $d = 0b1100100, PHP considers $a, $b, $c, and $d to be equal.</p>

<p><a href="https://groups.google.com/forum/#!msg/comp.lang.c/VByoIO8GySs/2XN9iGTpgmsJ" target="_blank">times 33 hash</a></p>

<pre class="prettyprint">
<h3 class="nocode">count from decimal 1 to 5 using hexadecimal</h3>

for($i = 0x1; $i < 0x10; $i++){
    print "$i\n";
}
</pre>

<hr />

<h2><a name="finding_distance">Finding The Distance Between Two Places</a></h2>
<p><b>Problem:</b> You want to find the distance between two places on planet Earth.</p>
<p><b>Solution:</b> Use sphere_distance()</p>

<p>Documentation on <a href="http://en.wikipedia.org/wiki/Earth_radius" target="_blank">Earth Radius</a></p>
<p>Documentation on <a href="http://www.onlamp.com/pub/a/php/2002/11/07/php_map.html" target="_blank">Trip Mapping with PHP</a></p>

<pre class="prettyprint">
<h3 class="nocode">sphere_distance()</h3>

function sphere_distance(){
    $rad = doubleval(M_PI/180.0);
    
    $lat1 = doubleval($lat1) * $rad;
    $lon1 = doubleval($lon1) * $rad;
    $lat2 = doubleval($lat2) * $rad;
    $lon2 = doubleval($lon2) * $rad;
    
    $theta = $lon2 - $lon1;
    $dist = acos(sin($lat1) * sin($lat2) +
                 cos($lat1) * cos($lat2) *
                 cos($theta));
    if($dist &lt; 0) { $dist += M_PI; }
    //Default is earth equatorial radius in kilometers
    return $dist = $dist * $radius;
}

//NY, NY (10040)
$lat1 = 40.858704;
$lon1 = -73.928532;

//SF, CA (94144)
$lat2 = 37.758434;
$lon2 = -122.435126;

$dist = sphere_distance($lat1, $lon1, $lat2, $lon2);

//It's about 2570 miles from NYC to SF
//$formatted is 2570.18
$formatted = sprintf("%.2f", $dist * 0.621); //Format and convert to miles
</pre>


      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>