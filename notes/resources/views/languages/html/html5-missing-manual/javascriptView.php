<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>JavaScript: The Brains of Your Page</h1>
      </div>
      
<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#how">How a Web Page Uses JavaScript</a></td>
        <td><a href="#few">A Few Language Essentials</a></td>
        <td><a href="#page">Interacting with the Page</a></td>
    </tr>
</table>

<hr />
<h2 id="how">How a Web Page Uses JavaScript</h2>
<h3>Embedding Script in Your Markup</h3>
<pre class="prettyprint">
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="utf-8">
    &lt;title>A Simple JavaScript Example &lt;/title>
&lt;/head>
&lt;body>
    &lt;p>At some point in the processing of this page, a script block
    will run and show a message box.&lt;/p>
    
    &lt;script>
    alert("We interrupt this web page with a special JavaScript announcement");
    &lt;/script>
    
    &lt;p>If you get here, you've already seen it.&lt;/p>
&lt;/body>
&lt;/html>
</pre>



<hr />
<h2 id="few">A Few Language Essentials</h2>
<h3>Variables</h3>
<pre class="prettyprint">
var myMessage;
var myMessage = "Everybody loves variables";

var firstName = "Jared";
var lastName = "Burdick";
var fullName = firstName + " " + lastName;

//shortcut
var myNumber = 20;
myNumber += 10;
//myNumber = myNumber + 10;



<hr />

//LOOPS
for(var i = 0; i &lt; 5; i++){
     //(This code executes five times.)
     alert("This is message: " + i);
}

<hr />

//ARRAYS

var colorList = [];

colorList.push("blue");
colorList.push("green");
colorList.push("red");

colorList[3] = "magenta";

var color = colorList[3];

for(var i = 0; i &lt; colorList.length; i++){
    alert("Found color: " + colorList[i]);
}

<hr />
//OBJECTS

function Person(){
    this.firstName = "Jared";
    this.lastName = "Burdick";
}

//Create a new Person, and store it in a variable name jBurdick
var jBurdick = new Person();

alert("His name is " + jBurdick.firstName);

//change the first name property
jBurdick.firstName = "Joseph";

//BETTER
function Person(fname, lname){
    this.firstName = fname;
    this.lastName = lname;
}
var newCustomer1 = new Person("Lauren", "Burdick");

//Object Literals
var personObject = {
    firstName = "Joe",
    lastName = "Grapta"
};
</pre>

<a href="http://www.javascriptkit.com/javatutors/oopjs.shtml" target="_blank">JavaScript OOP</a>

<h4>Identifying Errors in JavaScript Code</h4>
<a href="https://msdn.microsoft.com/library/gg589507(v=vs.85).aspx" target="_blank">Internet Explorer</a><br />
<a href="http://getfirebug.com/javascript" target="_blank">Firefox</a><br />
<a href="https://developer.chrome.com/extensions/tut_debugging" target="_blank">Google Chrome</a><br />
<a href="http://www.opera.com/dragonfly/" target="_blank">Opera</a><br />
<a href="https://developer.apple.com/library/safari/documentation/AppleApplications/Conceptual/Safari_Developer_Guide/Introduction/Introduction.html" target="_blank">Safari</a>


<hr />
<h2 id="page">Interacting with the Page</h2>
<a href="https://developer.mozilla.org/en-US/docs/Web/API/element" target="_blank">Element</a><br />      


</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>