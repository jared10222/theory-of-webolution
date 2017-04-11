<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Packages</h1>
      </div>
      


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#comp_depend">Defining and Installing Composer Dependencies</a></td>
        <td><a href="#comp_pack">Finding Composer Packages</a></td>
        <td><a href="#installing_comp_pack">Installing Composer Packages</a></td>
        <td><a href="#using_pear">Using the PEAR Installer</a></td>
    </tr>
    <tr>
    	<td><a href="#finding_pear_pack">Finding PEAR Packages</a></td>
        <td><a href="#Finding_pear_info">Finding Information About a Package</a></td>
        <td><a href="#installing_pear">Installing PEAR Packages</a></td>
        <td><a href="#upgrading_pear">Upgrading PEAR Packages</a></td>
    </tr>
    <tr>
    	<td><a href="#uninstalling_pear">Uninstalling PEAR Packages</a></td>
        <td><a href="#installing_pecl">Installing PECL Packages</a></td>
        <td></td>
        <td></td>
    </tr>     
</table>

<hr />

<h2><a name="comp_depend">Defining and Installing Composer Dependencies</a></h2>
<p><b>Problem:</b> You want to use Composer. This allows you to install new packages, and get information about your existing packages.</p>
<p><b>Solution:</b> Install Composer:</p>

<p>The <a href="https://getcomposer.org/" target="_blank">Composer site</a> and documentation on <a href="https://getcomposer.org/doc/00-intro.md" target="_blank">installation</a></p>

<pre class="prettyprint">
% curl -sS https://getcomposer.org/installer | php

<hr />
//To execute a command, type the command name as the first argument
//on the command line:

% php composer.phar command
    </pre>


<hr />

<h2><a name="comp_pack">Finding Composer Packages</a></h2>
<p><b>Problem:</b> You want to find packages you can install using Composer.</p>
<p><b>Solution:</b> Check <a href="https://packagist.org/" target="_blank">Packagist</a> or ask Composer to list or search packages.</p>

<hr />

<h2><a name="installing_comp_pack">Installing Composer Packages</a></h2>
<p><b>Problem:</b> You want to install packages using Composer.</p>
<p><b>Solution:</b> Use Composer's require command:</p>

<p>Documentation on using <a href="https://getcomposer.org/doc/01-basic-usage.md" target="_blank">Composer</a></p>
<p>The <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md" target="_blank">PSR-0 Autoloading Standard</a></p>
<p>The <a href="https://github.com/sebastianbergmann/php-code-coverage" target="_blank">PHP_CodeCoverage package</a></p>
<p>The <a href="http://docs.guzzlephp.org/en/latest/" target="_blank">Guzzle project</a></p>
<p><a href="https://github.com/Seldaek/monolog" target="_blank">Monolog</a></p>

<pre class="prettyprint">
% php composer.phar require vendor/package:version
    </pre>


<hr />

<h2><a name="using_pear">Using the PEAR Installer</a></h2>
<p><b>Problem:</b> You want to use the PEAR installer, pyrus. This allows you to install new packages, upgrade, and get information about your existing PEAR packages.</p>
<p><b>Solution:</b> Install Pyrus</p>

<p>Pyrus is a tool to manage PEAR packages. It’s not bundled with PHP, so you need to
install it yourself. Fortunately, Pyrus is distributed as a self-contained PHP Archive (aka
a phar). So, all that’s necessary is to download the file.
Then use PHP to run it:</p>

<p>Pyrus documentation on <a href="http://pear.php.net/manual/en/installationpyrus.introduction.php" target="_blank">installation</a></p>

<pre class="prettyprint">
% php pyrus.phar command

<hr />

% php pyrus.phar --version
Pyrus version 2.0.0a4 SHA-1: 72271D9C3AA1FA96DF9606CD538868544609A52

Using PEAR installation found at /Users/rasmus/lib
php pyrus.phar version 2.0.0a4
    </pre>


<hr />

<h2><a name="finding_pear_pack">Finding PEAR Packages</a></h2>
<p><b>Problem:</b> You want a listing of PEAR packages. From this list you want to learn more about each package and decide if you want to install it.</p>
<p><b>Solution:</b> Browse <a href="http://pear2.php.net/categories" target="_blank">PEAR 2 Packages</a> and <a href="http://pear.php.net/packages.php?php=5" target="_blank">PEAR Packages</a>, or <a href="http://pear.php.net/search.php" target="_blank">search for packages</a>. Use pear's remote-list command to get a listing of PEAR packages. Explore <a href="http://pear.php.net/channels/" target="_blank">listings of PEAR channel servers.</a></p>

<hr />

<h2><a name="Finding_pear_info">Finding Information About a Package</a></h2>
<p><b>Problem:</b> You want to gather information about a package, such as a description of what it does, who maintains it, what version you have installed, and which license it's released under.</p>
<p><b>Solution:</b> Use Pyrus's info command:</p>

<pre class="prettyprint">
% php pyrus.phar info pear/HTTP2
    </pre>


<hr />

<h2><a name="installing_pear">Installing PEAR Packages</a></h2>
<p><b>Problem:</b> You want to install a PEAR package.</p>
<p><b>Solution:</b> Download and install the package from the PEAR Channel server using Pyrus:</p>

<pre class="prettyprint">
% php pyrus.phar install pear/Package_Name
<hr />
//You can also install from another PEAR Channel:
% php pyrus.phar install channel/Package_Name
<hr />
//You can also install from any location on the Internet:
% php pyrus.phar install http://pear.example.com/Package_Name-1.0.0.tgz
<hr />
//Here's how to install if you have a local copy of a package:
% php pyrus.phar install Package_Name-1.0.0.tgz
    </pre>


<hr />

<h2><a name="upgrading_pear">Upgrading PEAR Packages</a></h2>
<p><b>Problem:</b> You want to upgrade a package on your system to the latest version for additional functionality and bug fixes.</p>
<p><b>Solution:</b> Find out if any upgrades are available and then tell Pyrus to upgrade the packages you want:</p>

<p>PEAR also has an RSS feed listing <a href="http://pear.php.net/feeds/latest.rss" target="_blank">new and upgraded packages.</a></p>



<pre class="prettyprint">
% php pyrus.phar list-upgrades
% pear upgrade pear/Package_Name
    </pre>


<hr />

<h2><a name="uninstalling_pear">Uninstalling PEAR Packages</a></h2>
<p><b>Problem:</b> You wish to remove a PEAR package from your system.</p>
<p><b>Solution:</b> The uninstall command tells the PEAR installer to delete packages:</p>

<pre class="prettyprint">
% php pyrus.phar uninstall pear /XML_Beautifier
    </pre>


<hr />

<h2><a name="installing_pecl">Installing PECL Packages</a></h2>
<p><b>Problem:</b> You want to install a PECL package; this builds a PHP extension written in C to use inside PHP.</p>
<p><b>Solution:</b> Make sure you have all necessary extension libraries and then use the bundled installer pecl:</p>

<pre class="prettyprint">
% pecl install mailparse
<hr />
//To use the extension from PHP, add the appropriate line
//to your php.ini file:
extension=mailparse.so
    </pre>



 
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>