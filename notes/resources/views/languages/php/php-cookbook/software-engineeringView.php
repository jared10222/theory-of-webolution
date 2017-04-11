<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Software Engineering</h1>
      </div>
 

<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#using_debugger">Using a Debugger Extension</a></td>
        <td><a href="#unit_test">Writing a Unit Test</a></td>
        <td><a href="#unit_suite">Writing a Unit Test Suite</a></td>
        <td><a href="#applying_unit">Applying a Unit Test to a Web Page</a></td>
    </tr>
    <tr>
    	<td><a href="#setting_up">Setting Up a Test Environment</a></td>
        <td><a href="#web_server">Using the Built-in Web Server</a></td>
        <td></td>
        <td></td>
    </tr>    
</table>

<hr />

<h2><a name="using_debugger">Using a Debugger Extension</a></h2>
<p><b>Problem:</b> You want to debug your scripts interactively during runtime.</p>
<p><b>Solution:</b> Use the Xdebug extension. When used along with an Xdebug-capable IDE, you can examine data structure; set breakpoints; and step into, out of, or over sections of code interactively.</p>

<p>Documentation on <a href="http://www.xdebug.org/" target="_blank">Xdebug</a></p>
<p>Documentation on <a href="http://www.xdebug.org/docs-dbgp.php" target="_blank">DBGp protocol</a></p>
<p><a href="https://netbeans.org/features/php/index.html" target="_blank">NetBeans IDE Xdebug-enabled feature for PHP</a></p>

<hr />

<h2><a name="unit_test">Writing a Unit Test</a></h2>
<p><b>Problem:</b> You're working on a project that extends a set of core functionality, and you want an easy way to make sure everything still works as the project grows.</p>
<p><b>Solution:</b> Write a unit test that tests the core functionality of a function or class and alerts you if something breaks.</p>

<p>Documentation on <a href="http://qa.php.net/write-test.php" target="_blank">.phpt unit tests</a></p>
<p>Documentation on <a href="https://phpunit.de/" target="_blank">PHPUnit</a></p>

<pre class="prettyprint">
    <h3 class="nocode">A sample test using PHP-QA's.phpt testing system is:</h3>

--TEST--
str_replace() function
--FILE--

&lt;?php
$str = 'Hello, all!';
var_dump(str_replace('all', 'world', $str));
?>
--EXPECT--
string(13) "Hello, world!"

    <hr />
    <h3 class="nocode">A sample test using the powerful and popular PHPUnit package is:</h3>

class StrReplaceTest extends PHPUnit_Framework_TestCase {
     public function testStrReplaceWorks(){
         $str = 'Hello, all!';
         $this->assertEquals('Hello, world!', str_replace('all', 'world', $str));
     }
}
    </pre>


<hr />

<h2><a name="unit_suite">Writing a Unit Test Suite</a></h2>
<p><b>Problem:</b> You want to be able to run more than one unit test conveniently on a regular basis.</p>
<p><b>Solution:</b> Wrap your unit tests into a group known as a unit test suite.</p>

<p>Documentation on organizing test groups in <a href="https://phpunit.de/manual/current/en/organizing-tests.html#organizing-tests.filesystem" target="_blank">PHPUnit.</a></p>

<pre class="prettyprint">
//StringTest.php

class StringTest extends PHPUnit_Framework_TestCase {
    function testStrReplace(){
        $str = 'Hello, all!';
        $this->assertEquals('Hello, world!', str_replace('all', 'world', $str));
    }
    
    function testSubstr(){
        $str = 'Hello, all!';
        $this->assertEquals('e', substr($str,1,1));
    }
}
    </pre>


<hr />

<h2><a name="applying_unit">Applying a Unit Test to a Web Page</a></h2>
<p><b>Problem:</b> Your application is not broken down into small testable chunks, or you just want to apply unit testing to the website that your visitors see.</p>
<p><b>Solution:</b> Use PHPUnit's Selenium Server integration to write tests that make HTTP request and assert conditions on the responses. These tests make assertions about the structure of <i>www.example.com</i>:</p>

<p>Documentation on <a href="https://phpunit.de/manual/current/en/selenium.html" target="_blank">PHPUnit's Selenium integration</a></p>
<p>Documentation on <a href="http://docs.seleniumhq.org/" target="_blank">Selenium Server</a></p>
<p>Documentation on <a href="http://release.seleniumhq.org/selenium-core/1.0.1/reference.html" target="_blank"> the Selenium command reference.</a></p>

<pre class="prettyprint">
class ExampleDotComTest extends PHPUnit_Extensions_SeleniumTestCase {
    
    function setUp(){
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://www.example.com');
    }
    
    //basic homepage loading
    function testHomepageLoading(){
        $this->open('http://www.example.com/');
        $this->assertTitle('Example Domain');
    }
    
    //test clicking on a link and getting the right page
    function testClick(){
        $this->open('http://www.example.com/');
        $this->clickAndWait('link=More information...');
        $this->assertTitle('IANA - IANA-managed Reserved Domains');
    }
}

//It prints:
//<b>PHPUnit 3.7.24 by Sebastian Bergmann.</b>

//..

//Time: 9.05 seconds, Memory: 3.50MB

//OK (2 tests, 2 assertions)
    </pre>


<hr />

<h2><a name="setting_up">Setting Up a Test Environment</a></h2>
<p><b>Problem:</b> You want to test out PHP scripts without worrying about bringing your website down or contaminating your production environment.</p>
<p><b>Solution:</b> Set up a test environment for your application on your desktop machine, using XAMPP.</p>

<p>The <a href="https://www.apachefriends.org/index.html" target="_blank">XAMPP project home page.</a></p>

<hr />

<h2><a name="web_server">Using the Built-in Web Server</a></h2>
<p><b>Problem:</b> You want to use PHP's built-in web server to quickly spin up test or simple website.</p>
<p><b>Solution:</b> With PHP 5.4.0 or later, run the command-line PHP program with an -S argument giving a hostname and a port to listen on and you've go an instant PHP-enabled web server up the directory you started it in:</p>

<p>Documenatation on <a href="http://php.net/features.commandline.webserver" target="_blank">PHP's built-in web server.</a></p>

<pre class="prettyprint">
% php -S localhost:9876   
</pre>



  
      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>