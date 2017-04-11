<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Error Handling</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#finding_fixing">Finding and Fixing Parse Errors</a></td>
        <td><a href="#create_exc_class">Creating Your Own Exception Classes</a></td>
        <td><a href="#printing_trace">Printing a Stack Trace</a></td>
        <td><a href="#reading_vars">Reading Configuration Variables</a></td>
    </tr>
    <tr>
    	<td><a href="#setting_vars">Setting Configuration Variables</a></td>
        <td><a href="#hiding">Hiding Error Messages from Users</a></td>
        <td><a href="#tuning">Tuning Error Handling</a></td>
        <td><a href="#custom_handler">Using a Custom Error Handler</a></td>
    </tr>
    <tr>
    	<td><a href="#logging_errors">Logging Errors</a></td>
        <td><a href="#eliminating">Eliminating "headers already sent" Errors</a></td>
        <td><a href="#debug_info">Logging Debugging Information</a></td>
        <td></td>
    </tr>    
</table>

<hr />

<h2><a name="finding_fixing">Finding and Fixing Parse Errors</a></h2>
<p><b>Problem:</b> Your PHP script fails to run due to fatal parse errors, and you want to find the problem quickly and continue coding.</p>
<p><b>Solution:</b> Check the line that the PHP interpreter reports as having a problem. If that line is OK, work your way backward in the program until you find the problematic line.</p>
<p>Or use a PHP-aware development environment that will alert you to syntax errors as your code, and that can also help you track down parse errors when they occur.</p>

<p>The <a href="http://php.net/tokens" target="_blank">PHP parser token cheat sheet</a></p>

<hr />

<h2><a name="create_exc_class">Creating Your Own Exception Classes</a></h2>
<p><b>Problem:</b> You want control over how (or if) error messages are displayed to users, even though you're using several third-party libraries that each have their own views on handling errors.</p>
<p><b>Solution:</b> Take advantage of PHP 5's support for exceptions to create your own exception handler that will do your bidding when errors occur in third-party libraries:</p>

<p>Documentation on <a href="http://php.net/exceptions" target="_blank">exceptions</a></p>

<pre class="prettyprint">
class CustomException extends Exception {
    public function __construct($e){
        //make sure everything is assigned properly
        parent::__construct($e->getMessage(), $e->getCode());
        
        //log what we know
        $msg = "----------------------------------------------\n";
        $msg .= __CLASS__.": [{$this->code}]: {$this->message}\n";
        $msg .= $e->getTraceAsString() . "\n";
        error_log($msg);
    }
    
    //overload the __toString() method to suppress any "normal" output
    public function __toString(){
        return $this->printMessage();
    }
    
    //map error codes to output messages or templates
    public function printMessage(){
        $usermsg = '';
        $code = $this->getCode();
        
        switch($code){
          case SOME_DEFINED_ERROR_CODE:
            $usermsg = 'Oooops! Sorry about that.';
            break;
          case OTHER_DEFINED_ERROR_CODE:
            $usermsg = "Drat!";
            break;
          default:
            $usermsg = file_get_contents('/templates/general_error.html');
            break;
        }
        return $usermsg;
    }
    
    //static exception_handler for default exception handling
    public static function exception_handler($exception){
      throw new CustomException($exception);
    }
}

//Make sure to catch every exception
set_exception_handler('CustomException::exception_handler');

try {
  $obj = new CoolThirdPartyPackage();
}catch(CustomException $e){
  echo $e;
}

<hr />

try {
    //do something
    $obj = new CoolThing();
} catch(PossibleException $e){
    //we thought this could possibly happen
    print "&lt;!-- caught exception $e! -->";
    $obj = new PlanB();
} catch(AnotherPossibleException $e){
    //we knew about this possibility as well
    print "&lt;!-- aha! caught exception $e -->";
    $obj - new PlanC();
} catch(CustomException $e){
    //if all else fails, go to clean-up
    $e->cleanUp();
    $e->bailOut();
}
    </pre>


<hr />

<h2><a name="printing_trace">Printing a Stack Trace</a></h2>
<p><b>Problem:</b> You want to know what's happening at a specific point in your program, and what happened leading up to that point.</p>
<p><b>Solution:</b> Use debug_print_backtrace():</p>

<p>Documentation on <a href="http://php.net/debug-backtrace" target="_blank">debug_backtrace()</a></p>
<p>Documentation on <a href="http://php.net/debug-print-backtrace" target="_blank">debug_print_backtrace()</a></p>
<p><a href="https://netbeans.org/" target="_blank">NetBeans</a></p>

<pre class="prettyprint">
function stooges(){
    print "woo woo woo!\n";
    larry();
}

function larry(){
    curly();
}

function curly(){
    moe();
}

function moe(){
    debug_print_backtrace();
}

stooges();

//This Will Print:

//woo woo woo!
//#0 moe() called at [backtrace.php:12]
//#1 curly() called at [backtrace.php:8]
//#2 larry() called at [backtrace.php:4]
//#3 stooges() called at [backtrace.php:19]
    </pre>


<hr />

<h2><a name="reading_vars">Reading Configuration Variables</a></h2>
<p><b>Problem:</b> You want to get the value of a PHP configuration setting.</p>
<p><b>Solution:</b> Use ini_get():</p>

<p>Documentation on <a href="http://php.net/ini-get" target="_blank">ini_get()</a></p>
<p>Documentation on <a href="http://php.net/ini-get-all" target="_blank">ini_get_all()</a></p>
<p>Documentation on <a href="http://php.net/get-cfg-var" target="_blank">get_cfg_var()</a></p>
<p>a complete list of <a href="http://php.net/ini.list" target="_blank">configuration variables, their defaults, and when they can be modified.</a></p>

<pre class="prettyprint">
//find out the include path:
$include_path = ini_get('include_path');
    </pre>


<hr />

<h2><a name="setting_vars">Setting Configuration Variables</a></h2>
<p><b>Problem:</b> You want to change the value of a PHP configuration setting.</p>
<p><b>Solution:</b> Use ini_set():</p>

<p>Documentation on <a href="http://php.net/ini-set" target="_blank">ini_set()</a></p>
<p>Documentation on <a href="http://php.net/ini-restore" target="_blank">ini_restore()</a></p>

<pre class="prettyprint">
//add a directory to the include path
ini_set('include_path', ini_get('include_path') . ':/home/fezzik/php'); 
    </pre>


<hr />

<h2><a name="hiding">Hiding Error Messages from Users</a></h2>
<p><b>Problem:</b> You don't want PHP error messages to be visible to users.</p>
<p><b>Solution:</b> Set the following values in your php.ini or web server configuration file:</p>
<p><b>display_errors =off</b><br />
   <b>log_errors     =on</b></p>

<p>You can also set these values using ini_set() if you don't have access to edit your server's php.ini file:</p>

<p><b>error_log = /var/log/php.error.log</b></p>

<p>Documentation on <a href="http://php.net/configuration" target="_blank">PHP configuration directives</a></p>

<pre class="prettyprint">
ini_set('display_errors', 'off');
ini_set('log_errors', 'on'); 

<hr />

ini_set('error_log', '/var/log/php.error.log');   
    </pre>


<hr />

<h2><a name="tuning">Tuning Error Handling</a></h2>
<p><b>Problem:</b> You want to alter the error-logging sensitivity on a particular page. This lets your control what types of errors are reported.</p>
<p><b>Solution:</b> To adjust the types of errors PHP complains about, use error_reporting():</p>

<p>Documentation on <a href="http://php.net/manual/en/errorfunc.configuration.php#ini.error-reporting" target="_blank">error_reporting()</a></p>
<p>Documentation on <a href="http://php.net/set-error-handler" target="_blank">set_error_handler()</a></p>
<p>more information about <a href="http://php.net/manual/en/ref.errorfunc.php" target="_blank">errors</a></p>

<pre class="prettyprint">
error_reporting(E_ALL);    //everything
error_reporting(E_ERROR | E_PARSE); //only major problems
error_reporting(E_ALL & ~E_NOTICE); //everything but notices
    </pre>


<hr />

<h2><a name="custom_handler">Using a Custom Error Handler</a></h2>
<p><b>Problem:</b> You want to create a custom error handler that lets you control how PHP reports errors.</p>
<p><b>Solution:</b> To set up your own error function, use set_error_handler():</p>

<pre class="prettyprint">
set_error_handler('pc_error_handler');

function pc_error_handler($errno, $error, $file, $line){
    $message = "[ERROR][$errno][$error][$file:$line]";
    error_log($message);
}
    </pre>


<hr />

<h2><a name="logging_errors">Logging Errors</a></h2>
<p><b>Problem:</b> You want to save program errors to a log. These errors can include everything from parser errors and files not being found to bad database queries and dropped connections.</p>
<p><b>Solution:</b> Use error_log() to write to the error log:</p>

<p>Documentation on <a href="http://php.net/manual/en/errorfunc.configuration.php#ini.error-log" target="_blank">error_log()</a></p>
<p>Documentation on <a href="http://php.net/language.constants.predefined" target="_blank">magic constants</a></p>

<pre class="prettyprint">
//LDAP error
if(ldap_errno($ldap)){
    error_log("LDAP ERROR #" . ldap_errno($ldap) . ": " . ldap_error($ldap));
}    
    </pre>


<hr />

<h2><a name="eliminating">Eliminating "headers already sent" Errors</a></h2>
<p><b>Problem:</b> you are trying to send an HTTP header or cookie using header() or setcookie(), but PHP reports a "headers already sent" error message.</p>
<p><b>Solution:</b> This error happens when you send nonheader output before calling header() or setcookie().</p>
<p>Rewrite your code so any output happens after sending headers:</p>

<pre class="prettyprint">
&lt;?php
//good
setcookie("name", $name);
print "Hello $name!";

//bad
print "Hello $name!";
setcookie("name", $name);

//good
setcookie("name", $name); ?>
&lt;html>&lt;title>Hello&lt;/title>
    </pre>


<hr />

<h2><a name="debug_info">Logging Debugging Information</a></h2>
<p><b>Problem:</b> You want to make debugging easier by adding statements to print out variables. But you want to be able to switch back and fourth easily between production and debug modes.</p>
<p><b>Solution:</b> Put a function that conditionally prints out messages based on a defined constant in a page included using the auto_prepend_file configuration setting. Save the following code to <i>debug.php</i>:</p>

<p>Set the <b>auto_prepend_file</b> directive in php.ini or your site .htaccess file:</p>
<p><b>auto_prepend_file=debug.php</b></p>

<p>Now call pc_debug() from your code to print out debugging information:</p>

<p>Documentation on <a href="http://php.net/define" target="_blank">define()</a></p>
<p>Documentation on <a href="http://php.net/defined" target="_blank">defined()</a></p>

<pre class="prettyprint">
//turn debugging on
define('DEBUG', true);

//generic debugging function
function pc_debug($message){
    if(defined('DEBUG') &amp;&amp; DEBUG){
        error_log($message);
    }
}   

<hr />

$sql = 'SELECT color, shape, smell FROM vegetables';
pc_debug("[sql: $sql"); //only printed if DEBUG is true
$r - mysql_query($sql);
    </pre>










      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>