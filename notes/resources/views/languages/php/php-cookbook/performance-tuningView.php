<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Performance Tuning</h1>
      </div>
      


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#using_accelerator">Using an Accelerator</a></td>
        <td><a href="#timing_func">Timing Function Execution</a></td>
        <td><a href="#exec_func">Timing Program Execution by Function</a></td>
        <td><a href="#exec_state">Timing Program Execution by Statement</a></td>
    </tr>
    <tr>
    	<td><a href="#exec_sect">Timing Program Execution by Section</a></td>
        <td><a href="#profiling">Profiling with a Debugger Extension</a></td>
        <td><a href="#stress">Stress-Testing Your Website</a></td>
        <td><a href="#avoiding">Avoiding Regular Expressions</a></td>
    </tr>     
</table>

<hr />

<h2><a name="using_accelerator">Using an Accelerator</a></h2>
<p><b>Problem:</b> You want to increase performance of your PHP applications.</p>
<p><b>Solution:</b> Use the Zend OPcache code-caching PHP accelerator to allow PHP to avoid compiling scripts into opcodes on each request.</p>

<p>Though PHP 5.5 builds Zend OPcache, you still need to turn it on by editing your <i>php.ini</i> file to add a reference to the full path of the extension: zend_extension=/path/to/php/lib/php/extension/debug-non-zts-20121212/opcache.so.</p>

<p>Although you should see a large improvement immediately, you can further improve performance with additional tuning. As a start, update your production configuration paramaters to:

<p>Documentation on <a href="http://us2.php.net/opcache" target="_blank">OPcache</a></p>

<pre class="prettyprint">
opcache.memory_consumption=128
opcache.interned_strings_butter=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_cli=1
    </pre>


<hr />

<h2><a name="timing_func">Timing Function Execution</a></h2>
<p><b>Problem:</b> You have a function and you want to see how long it takes to execute.</p>
<p><b>Solution:</b> Compare time in milliseconds before running the function against the time in milliseconds after running the function to see the elapsed time spend in the function itself:</p>

<pre class="prettyprint">
//create a long nonsense string
$long_str = uniqid(php_uname('a'),true);

//start timing from here
$start = microtime(true);

//function to test
$md5 = md5($long_str);

$elapsed = microtime(true) - $start;

echo "That took $elapsed seconds.\n";

<hr />
//Here are three ways to produce the exact same MD5 Hash in PHP

//PHP's basic md5() function
$hashA = md5('optimize this!');

//MD5 by way of the mhash extension
$hashB = bin2hex(mhash(MHASH_MD5, 'optimize this!'));

//MD5 with the hash() function
$hashC = hash('md5', 'optimize this!');

//They are all 83f0bb25be8de9106700840d66f261cf
//However, the third approach is more than twice as fast
//as PHP's basic md5() function.
    </pre>


<hr />

<h2><a name="exec_func">Timing Program Execution by Function</a></h2>
<p><b>Problem:</b> You have a block of code and you want to profile it to see how long each function takes to execute.</p>
<p><b>Solution:</b> Use Xdebug function tracing:</p>

<p>Documentation on <a href="http://www.xdebug.org/" target="_blank">Xdebug</a></p>
<p>Documentation on <a href="http://xdebug.org/docs/execution_trace" target="_blank">function traces</a></p>

<pre class="prettyprint">
xdebug_start_trace('/tmp/factorial-trace');

function factorial($x){
    return($x == 1) ? 1 : $x * factorial($x - 1);
}

print factorial(10);

xdebug_stop_trace();
    </pre>


<hr />


<h2><a name="exec_state">Timing Program Execution by Statment</a></h2>
<p><b>Problem:</b> You have a block of code and you want to profile it to see how long each statement takes to execute.</p>
<p><b>Solution:</b> Use the declare construct and the ticks directive:</p>

<p>Documentation on <a href="http://php.net/register-tick-function" target="_blank">register_tick_function()</a></p>
<p>Documentation on <a href="http://php.net/unregister-tick-function" target="_blank">unregister_tick_function()</a></p>
<p>Documentation on <a href="http://php.net/declare" target="_blank">declare</a></p>

<pre class="prettyprint">
function profile($display = false){
    static $times;
    
    switch($display){
    case false:
        //add the current time to the list of recorded times
        $times[] = microtime();
        break;
    case true:
        //return elapsed times in microseconds
        $start = array_shift($times);
        
        $start_mt = explode(' ', $start);
        $start_total = doubleval($start_mt[0]) + $start_mt[1];
        
        foreach($times as $stop){
            $stop_mt = explode(' ', $stop);
            $stop_total = doubleval($stop_mt[0]) + $stop_mt[1];
            $elapsed[] = $stop_total - $start_total;
        }
        
        unset($times);
        return $elapsed;
        break
    }
}

//register tick handler
register_tick_function('profile');

//clock the start time
profile();

//execute code, recording time for every statement execution
declare(ticks = 1){
    foreach($_SERVER['argv'] as $arg){
        print "$arg: " . strlen($arg) . "\n";
    }
}

//print out elapsed times
print "---\n";
$i = 0;
foreach(profile(true) as $time){
    $i++;
    print "Line $i: $time\n";
}
    </pre>


<hr />

<h2><a name="exec_sect">Timing Program Execution by Section</a></h2>
<p><b>Problem:</b> You have a block of code and you want to profile it to see how long each statement takes to execute.</p>
<p><b>Solution:</b> Use the PEAR Benchmark module:</p>

<p>Documentation on the<a href="http://pear.php.net/package/Benchmark" target="_blank">PEAR Benchmark class.</a></p>

<pre class="prettyprint">
require_once 'Benchmark/Timer.php';

$timer = new Benchmark_Timer(true);

$timer->start();
//some setup code here
$timer->setMarker('setup');
//some more code executed here
$timer->setMarker('middle');
//even yet still more code here
$timer->setMarker('done');
//and a last bit of code here
$timer->stop();

$timer->display();

    </pre>


<hr />

<h2><a name="profiling">Profiling with a Debugger Extension</a></h2>
<p><b>Problem:</b> You want a robust solution for profiling your applications so that you can continually monitor where the program spends most of its time.</p>
<p><b>Solution:</b> Use Xdebug, available from PECL. With Xdebug installed, adding xdebug.profiler_enable=1 to your <i>php.ini</i> configuration dumps a trace file to disk. Parsing that trace file with a tool gives you a breakdown of how time was spent during that run of the PHP script.</p>

<p>Documentation on <a href="http://xdebug.org/docs/profiler" target="_blank">profiling</a></p>
<p>Documentation on <a href="http://kcachegrind.sourceforge.net/html/Home.html" target="_blank">KCachegrind</a></p>
<p>Documentation on <a href="https://github.com/jokkedk/webgrind" target="_blank">Webgrind</a></p>

<hr />

<h2><a name="stress">Stress-Testing Your Website</a></h2>
<p><b>Problem:</b> You want to find out how well your website performs under a heavy load.</p>
<p><b>Solution:</b> Use a stress-testing and benchmarking tool to simulate a variety of load levels.</p>

<p>Source and Documentation for <a href="http://www.joedog.org/2013/07/siege-3-0-3-url-encoding/" target="_blank">Siege</a></p>
<p>Documentation on <a href="http://httpd.apache.org/docs/2.0/programs/ab.html" target="_blank">ab</a></p>
<p>Source and Documentation for <a href="http://stein.cshl.org/~lstein/torture/" target="_blank">torture.pl</a></p>

<hr />

<h2><a name="avoiding">Avoiding Regular Expressions</a></h2>
<p><b>Problem:</b> You want to improve script performance by optimizing string-matching operations.</p>
<p><b>Solution:</b> Replace unnecessary regular expression calls with faster string and character type function alternatives.</p>

<p>Documentation on <a href="http://php.net/ctype" target="_blank">ctype functions</a></p>
<p>Documentation on <a href="http://php.net/strings" target="_blank">string functions</a></p>
<p>Documentation on <a href="http://php.net/pcre" target="_blank">regular expression functions</a></p>


      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>