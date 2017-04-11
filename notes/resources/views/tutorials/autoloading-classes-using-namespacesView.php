<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">


<div class="page-header">
        <h1>Autoloading Classes using Namespaces</h1>
</div>

<h3>Step 1, Your File Structure</h3>

<p>In order to do this we're going to need to get your classes nice and organized, let's go through a few rules we'll be following:</p>
<ul>
	<li>1 Class per File - <b>NO EXCEPTIONS</b></li>
    <li>Classes should be organized into groups, we don't want to lob them in all together</li>
</ul>

<p>Start by creating a folder called <b>"lib"</b> in your project's base directory.</p>
<p>Now the next thing you need to get into your head, we're going to think of your project's classes as a library. For this example, I'll just pretend the project in question is called myproject.</p>
<p>So inside that lib folder, you'll want to create a myproject folder.</p>
<p>So now we have <b>/lib/myproject/</b>.</p>

<p>Next up! We need to start grouping your classes together! Let's say you have a few classes centered around your user system. Let's think of them as classes called User, UserPermissionSet and UserGroup. So we now create a folder called user inside myproject.</p>

<p>We now have <b>/lib/myproject/user</b>.</p>
<p>Now inside user we're going to create 3 files, User.php, UserPermissionSet.php and UserGroup.php, inside those files, we put classes name the same as the filename (minus the .php).</p>
<p>We now have the following:</p>
<ul>
	<li>/lib/myproject/user/User.php</li>
    <li>/lib/myproject/user/UserPermissionSet.php</li>
    <li>/lib/myproject/user/UserGroup.php</li>
</ul>

<p>Group all your classes like that and repeat the process, in the end you'll have a bunch of folders with class files inside them.</p>

<hr />
<h3>Step 2, Add namespaces to the files</h3>
<p>So we have our lovely structure. Now you might be wondering why we structured everything like that. Sure, it's nice to be neat and tidy, but was that really necessary?</p>
<p>Yes, it was, is my anwer.</p>
<p>When we get to the autoloading, the files are going to need to be in a structure which in someway resembles the namespaces.</p>
<p>Let's take our UserGroup class for example.</p>
<p>It's in /lib/myproject/user/UserGroup.php</p>
<p>The full namespace that will be used is going to be <b>myproject\user\UserGroup</b>, understand now?</p>

<p>So now we have to add the namespace line to the top of all your class files.</p>
<p>At the top of <b>/lib/myproject/user/UserGroup.php</b>, we'd put:</p>

<pre class="prettyprint">
namespace myproject\user;
</pre>

<p>The last part is filled in with the class name, so we don't need to put that there. Repeat the process for every class file you have, substituting user for the group of classes you're operating in.</p>

<hr />
<h3>Step 3, Add the autoloader</h3>
<p>Now for the autoloader, here's an autoloader we'd use for myproject. We put it in <b>/lib/myproject/myproject.inc.php</b>:</p>

<!--<div class="code">-->
<pre class="prettyprint">
&lt;?php
namespace myproject;

function load($namespace) {
	$splitpath = explode('\\', $namespace);
	$path = '';
	$name = '';
	$firstword = true;
	for ($i = 0; $i < count($splitpath); $i++) {
		if ($splitpath[$i] && !$firstword) {
			if ($i == count($splitpath) - 1)
				$name = $splitpath[$i];
			else
				$path .= DIRECTORY_SEPARATOR . $splitpath[$i];
		}
		if ($splitpath[$i] && $firstword) {
			if ($splitpath[$i] != __NAMESPACE__)
				break;
			$firstword = false;
		}
	}
	if (!$firstword) {
		$fullpath = __DIR__ . $path . DIRECTORY_SEPARATOR . $name . '.php';
		return include_once($fullpath);
	}
	return false;
}

function loadPath($absPath) {
	return include_once($absPath);
}

spl_autoload_register(__NAMESPACE__ . '\load');

?>
<!--</div>-->
</pre>

<p>Substitute the namespace for the name of your project and save the file.</p>
<hr />
<h3>Step 4, Include the autoloader into your project and use the classes</h3>
<p>Final step. You need to add the following line to any file which uses your classes, if you're using an MVC pattern, this will only be one file.</p>

<pre class="prettyprint">
require_once("lib/myproject/myproject.inc.php");

</pre>

<p>Obviously, substitute instances of myproject with your project's name.</p>
<p>Now, just use the following line to use your classes:</p>

<pre class="prettyprint">
use myproject\user\UserGroup;
</pre>

<hr />
<a href="http://webdevrefinery.com/forums/topic/7073-autoloading-your-classes-using-namespaces/" target="_blank">Original Source</a>
<hr />


</div>
<?php require_once(assets("includes/footer.php")); ?>