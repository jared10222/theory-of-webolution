<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">



<div class="page-header">
        <h1>Fix Project Links on WAMP Server</h1>
</div>
<p class="lead">How to create a Virtual Host in WampServer</p>

<p>There are 3 steps to create your Virtual Host in Apache, and only 2 if you already have one defined.</p>
<ol>
	<li>Create the Virtual Host definition(s)</li>
    <li>Add your new domain name to the HOSTS file</li>
    <li>Uncomment the line in httpd.conf that includes the Virtual Hosts definition file.</li>
</ol>

<hr />
<h3>Step 1, Create the Virtual Host definition(s)</h3>
<p>Edit the file called <b>httpd-hosts.conf</b> which for WampServer lives in:</p>
<pre class="prettyprint">
\wamp\bin\apache\apache2.4.9\conf\extra\httpd-vhosts.conf
</pre>

<p>(Apache version numbers may differ, engage brain before continuing)</p>

<p>If this is the first time you edit this file, remove the default example code, it is of no use.</p>

<p>I am assuming we want to create a definition for a site called project1 that lives in</p>
<pre class="prettyprint">
\wamp\www\project1
</pre>

<p>Very important, first we must make sure that localhost still works so that is the first VHOST definition we will put in this file.</p>

<pre class="prettyprint">
&lt;VirtualHost *:80>
    DocumentRoot "c:/wamp/www"
    ServerName localhost
    ServerAlias localhost
    &lt;Directory  "c:/wamp/www">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require local
    &lt;/Directory>
&lt;/VirtualHost>
</pre>

<p>Now we define our project: and this of course you do for each of your projects as you start a new one.</p>

<pre class="prettyprint">
&lt;VirtualHost *:80>
    DocumentRoot "c:/wamp/www/project1"
    ServerName project1
    &lt;Directory  "c:/wamp/www/project1">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require local
    &lt;/Directory>
&lt;/VirtualHost>
</pre>
<p>NOTE: That each Virtual Host as its own DocumentRoot defined. There are also many other parameters you can add to a Virtual Hosts definition, check the Apache documentation.</p>

<hr />
<h3>Step 2</h3>
<p class="lead">Add your new domain name to the HOSTS file.</p>
<p>Edit:</p>
<pre class="prettyprint">
C:\windows\system32\drivers\etc\hosts
</pre>

<p>Also this is a protected file so you must edit it with administrator privileges, so launch you editor using the Run as Administrator menu option.</p>

<p>The hosts file should look like this when you have completed these edits</p>
<pre class="prettyprint">
127.0.0.1 localhost
127.0.0.1 project1

::1 localhost
::1 project1
</pre>

<p>Now we must tell windows to refresh its domain name cache, so launch a command window again using the <b>Run as Administrator</b> menu option again, and do the following.</p>

<pre class="prettyprint">
net stop dnscache
net start dnscache
</pre>

<hr />
<h3>Step 3</h3>
<p class="lead">Uncomment the line in httpd.conf that includes the Virtual Hosts definition file</p>

<p>Edit your httpd.conf, use the wampmanager.exe menus to make sure you edit the correct file.</p>

<p>Find this line in httpd.conf</p>
<pre class="prettyprint">
# Virtual hosts
#Include conf/extra/httpd-vhosts.conf
</pre>

<p>And just remove the # to uncomment that line.</p>

<p>To activate this change in you running Apache we must now stop and restart the Apache service.</p>

<pre class="prettyprint">
wampmanager.exe -> Apache -> Service -> Restart Service
</pre>

<p>Now if the WAMP icon in the system tray does not go GREEN again, it means you have probably done something wrong in the <b>\wamp\bin\apache\apache2.4.9\conf\extra\httpd-hosts.conf</b> file.</p>

<p>If so here is a useful mechanism to find out what is wrong. It uses a feature of the Apache exe (httpd.exe) to check its config files and report errors by filename and line numbers.</p>

<p>Launch a command window.</p>

<pre class="prettyprint">
cd \wamp\bin\apache\apache2.4.9\bin
httpd -t
</pre>

<p>So fix the errors and retest again until you get the output</p>

<pre class="prettyprint">
Syntax OK
</pre>


<hr />
<a href="http://stackoverflow.com/questions/23665064/project-links-do-not-work-on-wamp-server/" target="_blank">Original Source</a>
<hr />




</div>

<?php require_once(assets("includes/footer.php")); ?>