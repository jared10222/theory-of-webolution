<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?php echo $title; ?></h1>
      </div>
      <p class="lead"></p>
      
     

<div class="panel panel-default">
	<div class="panel-heading">
    	<h3 class="panel-title">PHP Advanced &amp; Object Oriented Programming</h3>
    </div><!--end panel-heading-->
    
	<div class="panel-body">

        <ol>    
           <li><a href="/php/advanced-php-techniques">Advanced PHP Techniques</a></li>
           <li><a href="/php/developing-web-apps">Developing Web Applications</a></li>
           <li><a href="/php/advanced-db-concepts">Advanced Database Concepts</a></li>
           <li><a href="/php/basic-oop">Basic Object-Oriented Programming</a></li>
           <li><a href="/php/advanced-oop">Advanced OOP</a></li>
           <li><a href="/php/more-advanced-oop">More Advanced OOP</a></li>
           <li><a href="/php/design-patterns">Design Patterns</a></li>
           <li><a href="/php/using-existing-classes">Using Existing Classes</a></li>
           <li><a href="/php/cms-with-oop">CMS With OOP</a></li>
           <li><a href="/php/networking-with-php">Networking with PHP</a></li>
           <li><a href="/php/php-and-the-server">PHP and the Server</a></li>
           <li><a href="/php/php-command-line-interface">PHP's Command-Line Interface</a></li>
           <li><a href="/php/xml-and-php">XML and PHP</a></li>
           <li><a href="/php/debugging-testing-and-performance">Debugging, Testing, and Performance</a></li>
        </ol>

	</div><!--end panel body-->
</div><!--end panel-->





<div class="panel panel-default">
	<div class="panel-heading">
    	<h3 class="panel-title">PHP Cookbook 3rd Edition</h3>
    </div><!--end panel-heading-->
    
	<div class="panel-body">

        <ol>    
           <li><a href="/php/php-cookbook/strings">Strings</a></li>
           <li><a href="/php/php-cookbook/numbers">Numbers</a></li>
           <li><a href="/php/php-cookbook/dates-and-times">Dates &amp; Times</a></li>
           <li><a href="/php/php-cookbook/arrays">Arrays</a></li>
           <li><a href="/php/php-cookbook/variables">Variables</a></li>
           <li><a href="/php/php-cookbook/functions">Functions</a></li>
           <li><a href="/php/php-cookbook/classes-and-objects">Classes &amp; Objects</a></li>
           <li><a href="/php/php-cookbook/web-fundamentals">Web Fundamentals</a></li>
           <li><a href="/php/php-cookbook/forms">Forms</a></li>
           <li><a href="/php/php-cookbook/database-access">Database Access</a></li>
           <li><a href="/php/php-cookbook/sessions-and-data-persistence">Sessions &amp; Data Persistence</a></li>
           <li><a href="/php/php-cookbook/xml">XML</a></li>
           <li><a href="/php/php-cookbook/web-automation">Web Automation</a></li>
           <li><a href="/php/php-cookbook/consuming-restful-apis">Consuming RESTful APIs</a></li>
           <li><a href="/php/php-cookbook/serving-restful-apis">Serving RESTful APIs</a></li>
           <li><a href="/php/php-cookbook/internet-services">Internet Services</a></li>
           <li><a href="/php/php-cookbook/graphics">Graphics</a></li>
           <li><a href="/php/php-cookbook/security-and-encryption">Security &amp; Encryption</a></li>
           <li><a href="/php/php-cookbook/internationalization">Internationalization</a></li>
           <li><a href="/php/php-cookbook/error-handling">Error Handling</a></li>
           <li><a href="/php/php-cookbook/software-engineering">Software Engineering</a></li>
           <li><a href="/php/php-cookbook/performance-tuning">Performance Tuning</a></li>
           <li><a href="/php/php-cookbook/regular-expressions">Regular Expressions</a></li>
           <li><a href="/php/php-cookbook/files">Files</a></li>
           <li><a href="/php/php-cookbook/directories">Directories</a></li>
           <li><a href="/php/php-cookbook/command-line-php">Command Line PHP</a></li>
           <li><a href="/php/php-cookbook/packages">Packages</a></li>
        </ol>

	</div><!--end panel body-->
</div><!--end panel-->





<hr />
    
<pre class="prettyprint">
&lt;?php
namespace livid\users;
use livid\users\User;

class userLogin extends User {
    private $username;
    private $password;
    
    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }
}

$login = new userLogin("jared10222", "Guitar@10");
?>
</pre>
    </div>

<?php require_once(assets("includes/footer.php")); ?>