<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

<div class="page-header">
        <h1>.htaccess re-route all request to index.php</h1>
</div>

<pre class="prettyprint">
&lt;IfModule mod_rewrite.c>
  RewriteEngine on
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^ index.php [L]
&lt;/IfModule>

<hr />

RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /index.php?path=$1 [NC,L,QSA]

If you want the whole shebang installed in a sub-directory, 
such as /mvc/ or /framework/ the least complicated way to 
do it is to change the rewrite rule slightly to take that 
into account.

RewriteRule ^(.*)$ /mvc/index.php?path=$1 [NC,L,QSA]

And ensure that your index.php is in that folder whilst the .htaccess file is in the document root.

</pre>

<p>Explaining the code:</p>
<ol>
	<li>First, check if the module is present, else, we can't do anything.</li>
    <li>Turn on the Rewrite Engine</li>
    <li>Then it checks if the request filename isn't a file</li>
    <li>And check if it isn't a directory</li>
    <li>Then, the RewriteRule makes a call to index.php, no matter what was written in the URL</li>
    <li>Close the if statement</li>
</ol>

<p>So, the effect is, that if the file or directory doesn't exist, we can let index.php deal with this call instead.</p>


</div>

<?php require_once(assets("includes/footer.php")); ?>