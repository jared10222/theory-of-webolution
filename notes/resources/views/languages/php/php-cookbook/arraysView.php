<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Arrays</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#specifying_an_array">Specifying an Array Not Beginning at Element 0</a></td>
        <td><a href="#multiple_elements_per_key">Storing Multiple Elements per Key in an Array</a></td>
        <td><a href="#Initializing_an_array">Initializing an Array to a Range of Integers</td>
        <td><a href="#Iterating_through_array">Iterating Through an Array</a></td>
    </tr>
    <tr>
    	<td><a href="#deleting_elements">Deleting Elements from an Array</a></td>
        <td><a href="#changing_array_size">Changing Array Size</a></td>
        <td><a href="#appending_array">Appending One Array to Another</a></td>
        <td><a href="#array_to_string">Turning an Array into a String</a></td>
    </tr>
     <tr>
    	<td><a href="#printing_with_commas">Printing an Array with Commas</a></td>
        <td><a href="#checking_key">Checking if a Key Is in an Array</a></td>
        <td><a href="#checking_element">Checking if an Element Is in an Array</a></td>
        <td><a href="#position_of_value">Finding the Position of a Value in an Array</a></td>
    </tr>
     <tr>
    	<td><a href="#finding_elements">Finding Elements That Pass a Certain Test</a></td>
        <td><a href="#finding_largest_smallest">Finding the Largest or Smallest Valued Element in an Array</a></td>
        <td><a href="#reverse_array">Reversing an Array</a></td>
        <td><a href="#sorting_array">Sorting an Array</a></td>
    </tr>
    
    <tr>
    	<td><a href="#sorting_by_computable">Sorting an Array by a Computable Field</a></td>
        <td><a href="#sorting_multiple">Sorting Multiple Arrays</a></td>
        <td><a href="#sorting_array_using_method">Sorting an Array Using a Method Instead of a Function</a></td>
        <td><a href="#radomizing_array">Randomizing an Array</a></td>
    </tr>
    
    <tr>
    	<td><a href="#removing_duplicate">Removing Duplicate Elements from an Array</a></td>
        <td><a href="#applying_function">Applying a Function to Each Element in an Array</a></td>
        <td><a href="#finding_union">Finding the Union, Intersection, or Difference of Two Arrays</a></td>
        <td><a href="#iterating_efficiently">Iterating Efficiently over Large or Expensive Datasets</a></td>
    </tr>
    
    <tr>
    	<td><a href="#accessing_object">Accessing an Object Using Array Syntax</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
     
</table>

<hr />
<p>Arrays are lists: lists of people, lists of sizes, lists of books. To store a group of related items in a variable, use an array.</p>

<dl>
	<dt>array_push()</dt>
    <dd>Pushes a new value on top of the array stack</dd>
    <dt>array_pop()</dt>
    <dd>Removes the last element from an array and returns it</dd>
</dl>

<p>To break an array apart into individual variables, use list():<br />
$fruits = array('Apples', 'Bananas', 'Cantaloupes', 'Dates');<br />
list($red, $yellow, $beige, $brown) = $fruits;
</p>
<hr />

<h2><a name="specifying_an_array">Specifying an Array Not Beginning at Element 0</a></h2>
<p><b>Problem:</b> You want to assign multiple elements to an array in one step, but you don't want the first index to be 0.</p>
<p><b>Solution:</b> Instruct array() to use a different index using the => syntax.</p>

<p>Documentation on <a href="http://php.net/manual/en/language.types.array.php" target="_blank">array()</a></p>

<pre class="prettyprint">
$presidents = array(1=>'Washington', 'Adams', 'Jefferson', 'Madison');
    </pre>

<hr />

<h2><a name="multiple_elements_per_key">Storing Multiple Elements per Key in an Array</a></h2>
<p><b>Problem:</b> You want to associate multiple elements with a single key.</p>
<p><b>Solution:</b> Store the multiple elements in an array:</p>
<p>Or use an object</p>

<pre class="prettyprint">
$fruits = array('red' => array('strawberry', 'apple'),
                'yellow' => array('banana'));

    <hr />
    <h3 class="nocode">Object</h3>

while($obj = mysqli_fetch_assoc($r)){
    $fruits[] = $obj;
}
    </pre>


<hr />

<h2><a name="Initializing_an_array">Initializing an Array to a Range of Integers</a></h2>
<p><b>Problem:</b> You want to assign a series of consecutive integers to an array.</p>
<p><b>Solution:</b> Use range($start, $stop):</p>
<p>For increments other than 1, pass an increment to range() as a third argument.</p>

<p>Documentation on <a href="http://php.net/range" target="_blank">range()</a></p>

<pre class="prettyprint">
$cards = range(1,52);

//for odd numbers
$odd = range(1, 52, 2)

//for even numbers
$even - range(2, 52, 2);
    </pre>


<hr />

<h2><a name="Iterating_through_array">Iterating Through an Array</a></h2>
<p><b>Problem:</b> You want to cycle through an array and operate on all or some of the elements insdie.</p>
<p><b>Solution:</b> Use foreach:</p>

<p>Documentation on <a href="http://php.net/manual/en/control-structures.foreach.php" target="_blank">foreach</a></p>
<p>Documentation on <a href="http://php.net/while" target="_blank">while</a></p>
<p>Documentation on <a href="http://php.net/each" target="_blank">each()</a></p>
<p>Documentation on <a href="http://php.net/reset" target="_blank">reset()</a></p>
<p>Documentation on <a href="http://php.net/array-map" target="_blank">array_map()</a></p>

<pre class="prettyprint">
foreach($array as $value){
    //Act on $value
}

//Or to get an array's keys and values
foreach($array as $key => $value){
	//Act II
}

//Another technique is to use for:
for($key = 0, $size = count($array); $key &lt; $size; $key++){
	//Act III
}

//Finally, you can use each() in combination with list() and while:
reset($array); //reset interal pointer to beginning of array
while(list($key, $value) = each ($array)){
    //Final Act
}
    <hr />
    <h3 class="nocode">Modify an array</h3>

//if you want to modify an array, reference it directly:
foreach($items as $item => $cost){
    if(! in_stock($item)){
        unset($items[$item]); //address the array directly
    }
}

//use array_map() to hand off each element to a function for processing:
//lowercase all words
$lc = array_map('strtolower', $words);
    </pre>


<hr />

<h2><a name="deleting_elements">Deleting Elements from an Array</a></h2>
<p><b>Problem:</b> You want to remove one or more elements from an array.</p>
<p><b>Solution:</b> To delete one element, use unset():</p>
<p>To delete multiple noncontiguous elements, also use unset():</p>
<p>To delete multiple contiguous elements, use array_splice():</p>

<p>To compact the array into a densely filled numeric array, use array_values():</p>
<p>Array_splice() automatically reindexes arrays to avoid leaving holes:</p>

<p>Documentation on <a href="http://php.net/unset" target="_blank">unset()</a></p>
<p>Documentation on <a href="http://php.net/array-splice" target="_blank">array_splice()</a></p>
<p>Documentation on <a href="http://php.net/array-values" target="_blank">array_values()</a></p>


<pre class="prettyprint">
unset($array[3]);
unset($array['foo']);

unset($array[3], $array[5]);
unset($array['foo'], $array['bar']);

array_splice($array, $offset, $length);

$animals = array_values($animals);

    </pre>

<hr />

<h2><a name="changing_array_size">Changing Array Size</a></h2>
<p><b>Problem:</b> You want to modify the size of an array, either by making it larger or smaller than its current size.</p>
<p><b>Solution:</b> Use array_pad() to make an array grow:</p>
<p>To reduce an array, you can use array_splice():</p>

<p>Documentation on <a href="http://php.net/array-pad" target="_blank">array_pad()</a></p>
<p>Documentation on <a href="http://php.net/array-splice" target="_blank">array_splice()</a></p>

<pre class="prettyprint">
//start at three
$array = array('apple', 'banana', 'coconut');

//grow to five
$array = array_pad($array, 5, '');

//Now, count($array) is 5, and the last two elements
//$array[3] and $array[4], contain the empty string.

//no assignment to $array
array_splice($array, 2);
//This removes all but the first two elements from the $array.
    </pre>


<hr />

<h2><a name="appending_array">Appending One Array to Another</a></h2>
<p><b>Problem:</b> You want to combine two arrays into one.</p>
<p><b>Solution:</b> Use array_merge():</p>

<p>Documentation on <a href="http://php.net/array-merge" target="_blank">array_merge()</a></p>

<pre class="prettyprint">
$garden = array_merge($fruits, $vegetables);
</pre>


<hr />

<h2><a name="array_to_string">Turning an Array into a String</a></h2>
<p><b>Problem:</b> You have an array, and you want to convert it into a nicely formatted string.</p>
<p><b>Solution:</b> Use join();</p>
<p>Or loop yourself:</p>

<p>Documentation on <a href="http://php.net/join" target="_blank">join()</a></p>
<p>Documentation on <a href="http://php.net/substr" target="_blank">substr()</a></p>

<pre class="prettyprint">
//make a comma delimited list
$string = join(',', $array);

//Loop
$string = '';
foreach ($array as $key => $value){
    $string .= ",$value";
}

$string = substr($string,1); //remove leading ","
    </pre>


<hr />

<h2><a name="printing_with_commas">Printing an Array with Commas</a></h2>
<p><b>Problem:</b> You want to print out an array with commas separating the elements and with an <i>and</i> before the last element if there are more than two elements in the array.</p>
<p><b>Solution:</b> Use the array_to_comma_string() function, which returns the correct string.</p>

<p>Documentation on <a href="http://php.net/array-pop" target="_blank">array_pop()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">array_to_comma_string()</h3>

function array_to_comma_string($array){
    switch(count($array)){
    case 0:
        return '';
    case 1:
        return reset($array);
    case 2:
        return join(' and ', $array);
    default:
        $last = array_pop($array);
        return join(', ', $array) . ", and $last";
    }
}
    </pre>


<hr />

<h2><a name="checking_key">Checking if a Key Is in an Array</a></h2>
<p><b>Problem:</b> You want to know if an array contains a certain key.</p>
<p><b>Solution:</b> Use array_key_exists() to check for a key no matter what the associated value is:</p>
<p>Use isset() to find a key whose associated value is anything but null:</p>

<p>Documentation on <a href="http://php.net/isset" target="_blank">isset()</a></p>
<p>Documentation on <a href="http://php.net/array_key_exists" target="_blank">array_key_exists()</a></p>

<pre class="prettyprint">
if(array_key_exists('key', $array)){
  /*there is a value for $array['key'] */
}

if(isset($array['key'])){
    /* there is a non-null value for 'key' in $array */
}
    </pre>


<hr />

<h2><a name="checking_element">Checking if an Element Is in an Array</a></h2>
<p><b>Problem:</b> You want to know if an array contains a certain value.</p>
<p><b>Solution:</b> Use in_array():</p>

<p>The default behavior of in_array() is to compare items using the == operator. To use the strict equality check, ===, pass <b>true</b> as the third parameter to in_array():</p>

<p>If you can't create the associative array directly but need to convert from a traditional one with integer keys, use array_flip() to swap the keys and values of an array:</p>

<p>Documentation on <a href="http://php.net/in-array" target="_blank">in_array()</a></p>
<p>Documentation on <a href="http://php.net/array-flip" target="_blank">array_flip()</a></p>

<pre class="prettyprint">
if(in_array($value, $array)){
    //an element has $value as its value in array $array
}

$array = array(1, '2', 'three');
in_array(0, $array); //true!
in_array(0, $array, true); //false
in_array(1, $array); //true
in_array(1, $array, true); //true

//array_flip()
$book_collection = array('Emma',
                         'Pride and Prejudice',
                         'Northhanger Abbey');
//convert from numeric array to associative array
$book_collection = array_flip($book_collection);
$book = 'Sense and Sensibility';

if(isset($book_collection[$book])){
  echo 'Own it.';
}else{
  echo 'Need it.';
}
    </pre>


<hr />

<h2><a name="position_of_value">Finding the Position of a Value in an Array</a></h2>
<p><b>Problem:</b> You want to know if a value is in an array. If the value is in the array, you want to know its key.</p>
<p><b>Solution:</b> Use array_search(). It returns the key of the found value. If the value is not in the array, it returns false:</p>

<p>Documentation on <a href="http://php.net/array-search" target="_blank">array_search()</a></p>
<p>Documentation on <a href="http://php.net/preg-replace" target="_blank">preg_replace()</a></p>

<pre class="prettyprint">
$position: array_search($value, $array);
if($position !== false){
    //the element in position $position has $value
    //as its value in array $array
}
    </pre>


<hr />

<h2><a name="finding_elements">Finding Elements That Pass a Certain Test</a></h2>
<p><b>Problem:</b> You want to locate entries in an array that meet certain requirements.</p>
<p><b>Solution:</b> Use a foreach loop:</p>
<p>Or array_filter()</p>

<p>Documentation on <a href="http://php.net/array-filter" target="_blank">array_filter()</a></p>
<p>Documentation on <a href="http://php.net/functions.anonymous" target="_blank">anonymous functions</a></p>

<pre class="prettyprint">
$movies = array(/*...*/);
foreach ($movies as $movie){
    if($movie['box_office_gross'] &lt; 5000000) {
        $flops[] = $movie;
    }
}

$movies = array(/*...*/);
$flops = array_filter($movies, function($movie){
    return($movie['box_office_gross'] &lt; 5000000 ? 1 : 0;
});
    </pre>


<hr />

<h2><a name="finding_largest_smallest">Finding the Largest or Smallest Valued Element in an Array</a></h2>
<p><b>Problem:</b> You have an array of elements, and you want to find the largest or smallest valued element. For example, you want to find the appropriate scale when creating a histogram.</p>
<p><b>Solution:</b> To find the largest element, use max():</p>
<p>To find the smallest element, use min():</p>

<p>Documentation for <a href="http://php.net/max" target="_blank">max()</a></p>
<p>Documentation for <a href="http://php.net/min" target="_blank">min()</a></p>
<p>Documentation for <a href="http://php.net/arsort" target="_blank">arsort()</a></p>
<p>Documentation for <a href="http://php.net/asort" target="_blank">asort()</a></p>

<pre class="prettyprint">
$largest = max($array);
$smallest = min($array);
    </pre>


<hr />

<h2><a name="reverse_array">Reversing an Array</a></h2>
<p><b>Problem:</b> You want to reverse the order of the elements in an array.</p>
<p><b>Solution:</b> Use array_reverse():</p>

<p>Documentation for <a href="http://php.net/array-reverse" target="_blank">array_reverse()</a></p>

<pre class="prettyprint">
$array = array('Zero', 'One', 'Two');
$reversed = array_reverse($array);
    </pre>


<hr />

<h2><a name="sorting_array">Sorting an Array</a></h2>
<p><b>Problem:</b> You want to sort an array in a specific way.</p>
<p><b>Solution:</b> To sort an array using the traditional definition of sort, use sort():</p>
<p>To sort numerically, pass SORT_NUMERIC as the second argument to sort():</p>

<p>The sort() function doesn't preserve the key/value association between elements; instead, entries are reindexed starting at 0 and going upward.</p>

<p>To preserve the key/value links, use asort(). The asort() function is normally used for associative arrays, but it can also be useful when the indexes of the entries are meaningful:</p>

<p>Use natsort() to sort the array using a natural sorting algorithm. Under natural sorting, you can mix strings and numbers inside your elements and still get the right answer:</p>

<p>Documentation on <a href="http://php.net/sort" target="_blank">sort()</a></p>
<p>Documentation on <a href="http://php.net/natsort" target="_blank">natsort()</a></p>
<p>Documentation on <a href="http://php.net/natcasesort" target="_blank">natcasesort()</a></p>
<p>Documentation on <a href="http://php.net/arsort" target="_blank">arsort()</a></p>

<pre class="prettyprint">
$states = array('Delaware', 'Pennsylvania', 'New Jersey');
sort($states);

$scores = array(1, 10, 2, 20);
sort($scores, SORT_NUMERIC);

$states = array(1=>'Delaware', 'Pennsylvania', 'New Jersey');
asort($states);

while(list($rank, $state) = each($states)){
	print "$state was the #$rank state to join the US\n";
}

$tests = array('test1.php', 'test10.php', 'test11.php', 'test2.php');
natsort($tests);
</pre>


<hr />

<h2><a name="sorting_by_computable">Sorting an Array by a Computable Field</a></h2>
<p><b>Problem:</b> You want to define your own sorting routine.</p>
<p><b>Solution:</b> use usort() in combination with a custom comparison function:</p>

<p>Documentation on <a href="http://php.net/usort" target="_blank">usort()</a></p>
<p>Documentation on <a href="http://php.net/array-map" target="_blank">array_map()</a></p>

<pre class="prettyprint">
$tests = array('test1.php', 'test10.php', 'test11.php', 'test2.php');

//sort in reverse natural order
usort($tests, function($a, $b){
    return strnatcmp($b, $a);
})
    </pre>
	

<hr />

<h2><a name="sorting_multiple">Sorting Multiple Arrays</a></h2>
<p><b>Problem:</b> You want to sort multiple arrays or an array with multiple dimensions.</p>
<p><b>Solutions:</b> Use array_multisort():</p>

<p>Documentation on <a href="http://php.net/array-multisort" target="_blank">array_multisort()</a></p>

<pre class="prettyprint">
$colors = array('Red', 'White', 'Blue');
$cities = array('Boston', 'New York', 'Chicago');

array_multisort($colors, $cities);
print_r($colors);
print_r($cities);
Array
(
    [0] => Blue
    [1] => Red
    [2] => White
)
Array
(
    [0] => Chicago
    [1] => Boston
    [2] => New York
    
//To sort multiple dimensions within a single array, pass
//the specific array elements:
$stuff = array(
    'colors' => array('Red', 'White', 'Blue'),
    'cities' => array('Boston', 'New York', 'Chicago'));
array_multisort($stuff['colors'], $stuff['cities']);
print_r($stuff);
    </pre>


<hr />

<h2><a name="sorting_array_using_method">Sorting an Array Using a Method Instead of a Function</a></h2>
<p><b>Problem:</b> You want to define a custom sorting routine to order an array. However, instead of using a function, you want to use an object method.</p>
<p><b>Solution:</b> Pass in an array holding a class name and method in place of the function name:</p>

<p>Documentation on <a href="http://php.net/manual/en/function.strcmp.php">strcmp()</a></p>

<pre class="prettyprint">
usort($access_times, array('dates', 'compare'));


class sort {
    //reverse-order string comparison
    static function strrcmp($a, $b){
        return strcmp($b, $a);
    }
}
usort($words, array('sort', 'strrcmp'));
    </pre>


<hr />

<h2><a name="radomizing_array">Randomizing an Array</a></h2>
<p><b>Problem:</b> You want to scramble the elements of an array in a random order.</p>
<p><b>Solution:</b> Use shuffle():</p>

<p>Documentation on <a href="http://php.net/shuffle" target="_blank">shuffle()</a></p>

<pre class="prettyprint">
shuffle($array);
    </pre>


<hr />

<h2><a name="removing_duplicate">Removing Duplicate Elements from an Array</a></h2>
<p><b>Problem:</b> You want to eliminate duplicates from an array</p>
<p><b>solution:</b> if the array is already complete, use array_unique(), which returns a new array that contains no duplicate values:</p>

<p>If you create the array while processing results, here is a technique for numerical arrays:</p>
<p>Here is one for associative arrays:</p>

<p>Documentation on <a href="http://php.net/array-unique" target="_blank">array_unique()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">array_unique()</h3>

$unique = array_unique($array);

    <hr />
    <h3 class="nocode">numerical</h3>

foreach($_GET['fruits'] as $fruit){
    if(!in_array($fruit, $array)) {
        $array[] = $fruit;   
    }
}

    <hr />
    <h3 class="nocode">associative</h3>

foreach($_GET['fruits'] as $fuite){
    $array[$fruit] = $fruit;
}
    </pre>


<hr />

<h2><a name="applying_function">Applying a Function to Each Element in an Array</a></h2>
<p><b>Problem:</b> You want to apply a function or method to each element in an array. This allows you to transform the input data for the entire set all at once.</p>
<p><b>Solution:</b> Use array_walk():</p>

<p>For nested data, use array_walk_recursive():</p>

<p>Documentation on <a href="http://php.net/array-walk" target="_blank">array_walk()</a></p>
<p>Documentation on <a href="http://php.net/array_walk_recursive" target="_blank">array_walk_recursive()</a></p>
<p>Documentation on <a href="http://php.net/htmlentities" target="_blank">htmlentities()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">array_walk()</h3>

$names = array('firstname' => "Baba",
               'lastname'  => "O'Riley");

array_walk($names, function(&amp;$value, $key){
    $value = htmlentities($value, ENT_QUOTES);
});

foreach($names as $name){
    print "$name\n";
}

    <hr />
    <h3 class="nocode">array_walk_recursive()</h3>

$names = array('firstnames' => array("Baba", "Bill"),
               'lastnames'  => array("O'Riley", "O'Riley"));

array_walk_recursive($names, function(&amp;$value, $key){
    $value = htmlentities($value, ENT_QUOTES);
});

foreach($names as $nametypes){
    foreach($nametypes as $name){
        print "$name\n";
    }
}
    </pre>


<hr />

<h2><a name="finding_union">Finding the Union, Intersection, or Difference of Two Arrays</a></h2>
<p><b>Problem:</b> You have a pair of arrays, and you want to find their union(all the elements), intersection(elements in both, not just one), or difference(in one but not both).</p>
<p><b>Solution:</b></p>
<p>To compute the union:</p>
<p>To compute the intersection:</p>
<p>To find the simple difference:</p>
<p>And for the symmetric difference:</p>

<p>Documentation on <a href="http://php.net/array-intersect" target="_blank">array_instersect()</a></p>
<p>Documentation on <a href="http://php.net/array-diff" target="_blank">array_diff()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">union</h3>

$union = array_unique(array_merge($a, $b));   

    <hr />
    <h3 class="nocode">intersection</h3>

$intersection = array_intersect($a, $b);

    <hr />
    <h3 class="nocode">simple difference</h3>

$difference = array_diff($a, $b);

    <hr />
    <h3 class="nocode">symmetric difference</h3>

$difference = array_merge(array_diff($a, $b), array_diff($b, $a));
    </pre>


<hr />

<h2><a name="iterating_efficiently">Iterating Efficiently over Large or Expensive Datasets</a></h2>
<p><b>Problem:</b> You want to iterate through a list of items, but the entire list takes up a lot of memory or is very slow to generate.</p>
<p><b>Solution:</b> Use a generator:</p>

<p>Documentation on <a href="http://php.net/generators" target="_blank">Generators</a></p>

<pre class="prettyprint">
function FileLineGenerator($file){
    if(!$fh = fopen($file, 'r')){
        return;
    }
    
    while(false !== ($line = fgets($fh))){
       yield $line;
    }
    
    fclose($fh);
}

$file = FileLineGenerator('log.txt');
foreach($file as $line){
    if(preg_match('/^rasmus: /', $line)) {
        print $line;
    }
}
    </pre>


<hr />

<h2><a name="accessing_object">Accessing an Object Using Array Syntax</a></h2>
<p><b>Problem:</b> You have an object, but you want to be able to read and write data to it as an array. This allows you to combine the benifits from an object-oriented design with the familiar interface of an array.</p>
<p><b>Solution:</b> Implement SPL's ArrayAccess interface:</p>

<pre class="prettyprint">
class FakeArray implements ArrayAccess {
  
    private $elements;
    
    public function __construct(){
        $this->elements = array();
    }
    
    public function offsetExists($offset){
        return isset($this->elements[$offset]);
    }
    
    public function offsetGet($offset){
        return $this->elements[$offset]);
    }
    
    public function offsetSet($offset, $value){
        return $this->elements[$offset] = $value;
    }
    
    public function offsetUnset($offset){
        unset($this->elements[$offset]);
    }
}

$array = new FakeArray;

//What's opera, Doc?
$array['animal'] = 'wabbit';

//Be very quiet I'm hunting wabbits
if(isset($array['animal']) &amp;&amp;
    //Wabbit tracks!!
    $array['animal'] == 'wabbit'){
        //Kill the wabbit, kill the wabbit
        unset($array['animal']);
        //Yo ho to oh! 
    }
    
    //What have I done?
    if(!isset($array['animal'])){
        print "Well, what did you expect in an opera? A Happy Ending?\n";
    }

    </pre>





      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>