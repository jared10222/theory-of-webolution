<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Variables</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#avoiding_confusion">Avoiding == Verus = Confusion</a></td>
        <td><a href="#establishing_default_value">Establishing a Default Value</a></td>
        <td><a href="#exchanging_values">Exchanging Values Without Using Temporary Variables</td>
        <td><a href="#Creating_dynamic_name">Creating a Dynamic Variable name</a></td>
    </tr>
    <tr>
    	<td><a href="#Persisting_value">Persisting a Local Variable's Value Across Function Invocations</a></td>
        <td><a href="#sharing_variables">Sharing Variables Between Processes</a></td>
        <td><a href="#encapsulating">Encapsulating Complex Data Types in a String</a></td>
        <td><a href="#dumping">Dumping Variable Contents as Strings</a></td>
    </tr>
    
     
</table>
<hr />

<h2><a name="avoiding_confusion">Avoiding == Versus = Confusion</a></h2>
<p><b>Problem:</b> You don't want to accidentally assign values when comparing a variable and a constant.</p>
<p><b>Solution:</b> Use:<br />
if(12 == $dwarves){...}<br />
instead of <br />
if($dwarves == 12){...}<br />
</p>
<p>Putting the constant on the left triggers a parse error with the assignment operator.</p>

<hr />

<h2><a name="establishing_default_value">Establishing A Default Value</a></h2>
<p><b>Problem:</b> You want to assign a default value to a variable that doesn't already have a value. It often happens that you want a hardcoded default value for a variable that can be overridden from form input or through an environment variable.</p>
<p><b>Solution:</b> Use <b>isset()</b> to assign a default to a variable that may already have a value:</p>

<p>Use the ternary(a ? b : c) operator to give a new variable a (possibly default) value:</p>

<p>Documentation on <a href="http://php.net/language.variables.variable" target="_blank">variable variables</a></p>

<pre class="prettyprint">
if(!isset($cars)){
    $cars = $default_cars;
}  

$cars = isset($_GET['cars'] ? $_GET['cars'] : $default_cars; 
    </pre>


<hr />

<h2><a name="exchanging_values">Exchanging Values Without Using Temporary Variables</a></h2>
<p><b>Problem:</b> You want to exchange the values in two variables without using additional variables for storage.</p>
<p><b>Solution:</b> To swap $a and $b:</p>

<p>PHP's list() language construct lets you assign values from an array to individual variables.</p>

<pre class="prettyprint">
$a = 'Alice';
$b = 'Bob';

list($a, $b) = array($b, $a);
//now $a is Bob and $b is Alice
    </pre>


<hr />

<h2><a name="Creating_dynamic_name">Creating a Dynamic Variable Name</a></h2>
<p><b>Problem:</b> You want to construct a variable's name dynamically. For example, you want to use variable names that match the field names from a database query.</p>
<p><b>Solution:</b> Use PHP's variable variable syntax by prepending a $ to a variable whose value is the variable name you want:</p>

<p>Placing two dollar signs before a variable name causes PHP to dereference the right variable name to get a value. It then uses that value as the name fo your real variable. The example prints 103 because $animal = turtles, so $$animal is $turtles, which equals 103.</p>

<p>Using curly braces, you can construct more complicated expressions that indicate varible names:</p>

<p>Variable variables are also useful when iterating through similarly names variable. Say your are querying a database table that has fields named title_1, title_2, etc. If you want to check if a title matches any of those values, the easiest way is to loop through them like this:</p>

<pre class="prettyprint">
$animal = 'turtles';
$turtles = 103;
print $$animal;

//this prints
103

    <hr />

$stooges = array('Moe', 'Larray', 'Curly');
$stooge_moe = 'Moses Horwitz';
$stooge_larry = 'Louis Feinberg';
$stooge_curly = 'Jerome Horwitz';

foreach($stooges as $s){
    print "$s's real name was ${'stooge_'.strtolower($s)}.\n";
}

    <hr />

for($i = 1; $i &lt;= $n; $i++){
    $t = "title_$i";
    if($title == $$t){ /*match*/}
}
    </pre>


<hr />

<h2><a name="Persisting_value">Persisting a Local Variable's Value Across Function Invocations</a></h2>
<p><b>Problem:</b> You want a local variable to retain its value between invocations of a function</p>
<p><b>Solution:</b> Declare the variable as static:</p>

<p>Documentatino on <a href="http://php.net/language.variables.scope" target="_blank">static variables</a></p>

<pre class="prettyprint">
function track_times_called(){
    static $i = 0;
    $i++;
    return $i;
}
    </pre>


<hr />

<h2><a name="sharing_variables">Sharing Variables Between Processes</a></h2>
<p><b>Problem:</b> You want a way to share information between processes that provides fast access to the shared data.</p>
<p><b>Solution:</b> Use the data store functionality of the APC extension:</p>

<p>If you don't have APC available, use one of the two bundled shared memory extensions, shmop or System V shared memory.</p>

<p>With shmop, you create a block and read and write to and from it:</p>

<p>With System V shared memory, you store the data in a shared memory segment, and guarantee exclusive access to the shared memory with a semaphore:</p>

<p>Documentation on <a href="http://pecl.php.net/package/APC" target="_blank">apc</a></p>
<p>Documentation on <a href="http://php.net/shmop" target="_blank">shmop</a></p>
<p>Documentation on <a href="http://php.net/sem" target="_blank">System V</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Using APC's data store</h3>

//retrieve the old value
$population = apc_fetch('population');
//manipulate the data
$population += ($births + $immigrants - $deaths - $emigrants);
//write the new value back
apc_store('population', $population);

    <hr />
    <h3 class="nocode">Using the shmop shared memory functions</h3>

//create key
$shmop_key = ftok(__FILE__, 'p');
//create 16384 byte shared memory block
$shmop_id = shmop_open($shmop_key, "c", 0600, 16384);
//retrieve the entire shared memory segment
$population = shmop_read($shmop_id, 0, 0);
//manipulate the data
$population += ($births + $immigrants - $deaths - $emigrants);
//store the value back in the shared memory segment
$shmop_bytes_written = shmop_write($shmop_id, $population, 0);
//check that it fit
if($shmop_bytes_written != strlen($population)){
 echo "Can't write all of : $population\n";
}    
//close the handle
shmop_close($shmop_id);

    <hr />
    <h3 class="nocode">Using the System V shared memory functions</h3>

$semaphore_id = 100;
$segment_id = 200;
//get a handle to the semaphore associated with the shared memory
//segment we want
$sem = sem_get($semaphore_id,1,0600);
//ensure exclusive access to the semaphore
sem_acquire($sem) or die("Can't acquire semaphore");
//get a handle to our shared memory segment
$shm = shm_attach($segment_id, 16348, 0600);
//each value stored in the segment is identified by a integer
//ID
$var_id = 3476;
//retrieve a value from the shared memory segment
if(shm_has_var($shm, $var_id)){
    $population = shm_get_var($shm, $var_id);
}    
//or initialize it if it hasn't been set yet
else{
    $population = 0;
}
//manipulate the value
$population += ($births + $immigrants - $deaths - $emigrants);
//store the value back in the shared memory segment
shm_put_var($shm, $var_id, $population);
//release the handle to the shared memory segment
shm_detach($shm);
//release the semaphore so other processes can aquire it
sem_release($sem);
    </pre>


<hr />

<h2><a name="encapsulating">Encapsulating Complex Data Types in a String</a></h2>
<p><b>Problem:</b> You want a string representation of an array or object for storage in a file or database. This string should be easily reconstitutable into the original array or object.</p>
<p><b>Solution:</b> Use serialize() to encode variables and their values into textual form:</p>

<p>To re-create the variables, use unserialize();</p>

<p>For easier interoperability with other languages (at a slight performance cost), use json_encode() to serialize data:</p>

<p>Documentation on <a href="http://php.net/serialize" target="_blank">serialize()</a></p>
<p>Documentation on <a href="http://php.net/unserialize" target="_blank">unserialize()</a></p>
<p>Documentation on <a href="http://php.net/json_encode" target="_blank">json_encode()</a></p>
<p>Documentation on <a href="http://php.net/json_decode" target="_blank">json_decode()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">serialize()</h3>

$pantry = array('sugar' => '2 lbs.', 'butter' => '3 sticks');
$fp = fopen('/tmp/pantry', 'w') or die ("can't open pantry");
fputs($fp,serialize($pantry));
flose($fp);

    <hr />
    <h3 class="nocode">unserialize()</h3>

//re-create the variables
//$new_pantry will be the array:
//array('sugar' => '2 lbs.', 'butter' => '3 sticks');
$new_pantry = unserialize(file_get_contents('/tmp/pantry'));

    <hr />
    <h3 class="nocode">json_encode()</h3>

$pantry = array('sugar' => '2 lbs.', 'butter' => '3 sticks');
$fp = fopen('/tmp/pantry.json','w') or die("Can't open pantry");
fputs($fp, json_encode($pantry));
fclose($fp);

    <hr />
    <h3 class="nocode">json_decode()</h3>

//$new_pantry will be the array:
//array('sugar' => '2 lbs.', 'butter' => '3 sticks');
$new_pantry = json_decode(file_get_contents('/tmp/pantry.json'),TRUE);
    </pre>


<hr />

<h2><a name="dumping">Dumping Variable Contents as Strings</a></h2>
<p><b>Problem:</b> You want to inspect the values stored in a variable. It may be a  complicated nested array or object, so you can't just print it out or loop through it.</p>
<p><b>Solution:</b> USe var_dump(), print_r(), or var_export(), depending on exactly what you need.</p>

<p>The var_dump() and print_r() functions provide different human-readable prepresentations of variables.</p>

<p>The print_r() function is a little more concise:</p>

<p>Documentation on <a href="http://php.net/print-r" target="_blank">print_r()</a></p>
<p>Documentation on <a href="http://php.net/var-dump" target="_blank">var_dump()</a></p>
<p>Documentation on <a href="http://php.net/var_export" target="_blank">var_export()</a></p>


      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>