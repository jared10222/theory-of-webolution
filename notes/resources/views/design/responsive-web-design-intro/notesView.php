<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Responsive Web Design with HTML5 and CSS3 - Introduction</h1>
      </div>

<table class="table table-responsive table-bordered">
	<tr>
    	<td><a href="#progressive-enhancements">Progressive Enhancements</a></td>
        <td><a href="#css-reset">CSS Reset</a></td>
        <td><a href="#natural-box-model">Natural Box Model</a></td>
        <td><a href="#start-file">HTML5 Start File</a></td>
        <td><a href="#advanced-css">Real World Advanced CSS that you can use today</a></td>
    </tr>
    <tr>
    	<td><a href="#clearfix">Clear Fix</a></td>
        <td><a href="#mobile-dropdown-conversion">Mobile Dropdown Conversion</a></td>
    </tr>
</table>

<pre class="prettyprint">
&lt;!-- take the device width and set it to the reported width -->
&lt;meta name="viewport" content="width=device-width, initial-scale=1.0" />

<hr />
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="UTF-8">
    
    &lt;title>Device Width Example&lt;/title>
    
    &lt;style type="text/css">
        /* ----- Prevents iPhone from resizing in landscape mode ----- */
        html, body {
             -webkit-text-size-adjust:none;
        }
        
        /* ----- SMALL rules here ----- */
        @media only screen and (max-width: 400px){
            body { background-color: Red; }
        }
        
        /* ----- MEDIUM rules here ----- */
        @media only screen and (min-width: 401px) and (max-width: 900px){
            body { background-color: Green; }
        }
        
        /* ----- LARGE rules here ----- */
        @media only screen and (min-width: 901px){
            body { background-color: Blue; }
        }
    &lt;/style>
    
    &lt;!-- TELLS PHONES NOTE TO LIE ABOUT THEIR WIDTH -->
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0">
    
&lt;/head>
&lt;body>

&lt;/body>
&lt;/html>
</pre>

<pre class="prettyprint">
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="UTF-8">
    
    &lt;title>Browser Width Example&lt;/title>
    
    &lt;!-- Phone-default -->
    &lt;link href="CSS3/phone.css" rel="stylesheet" type="text/css">
    &lt;!-- enhance-tablet -->
    &lt;link href="CSS3/tablet.css" rel="stylesheet" type="text/css">
    &lt;!-- enhance-desktop -->
    &lt;link href="CSS3/desktop.css" rel="stylesheet" type="text/css">
    
    &lt;!-- TELLS PHONES NOT TO LIE ABOUT THEIR WIDTH -->
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    &lt;!-- THIS MAKE IE WORK WITH HTML5 AND MEDIA QUERIES-->
    &lt;!--[if lt IE 9]>
        &lt;script src="http://html5shim.googlecode.com/svn/trunk/html5.js">&lt;/script>
        &lt;script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/
            css3-mediaqueries.js">&lt;/script>
    &lt;![endif]-->

&lt;/head>
&lt;body>

&lt;/body>
&lt;/html>

<hr />


/* RESPECTIVE STYLE SHEETS */

/* PHONE */
@media only screen and (max-width: 600px){
    h1 {
        background-color: #F00;
    }
}

/* TABLET */
@media only screen and (min-width: 601px) and max-width: 1024px){
    h1 {
        background-color: #0F0;
    }
}

/* DESKTOP */
@media only screen and (min-width: 1025px){
    h1 {
        background-color: #00F;
    }
}

</pre>

<hr />
<h2 id="progressive-enhancements">Progressive Enhancements And Mobile First Development</h2>

<pre class="prettyprint lang-html">
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="UTF-8">
    
    &lt;title>Progressive Enhancement Example&lt;/title>
    
    &lt;link rel="stylesheet" href="CSS3/phone.css">
    &lt;link rel="stylesheet" href="CSS3/tablet.css">
    &lt;link rel="stylesheet" href="CSS3/desktop.css">
    
    &lt;!-- TELLS PHONE NOT TO LIE ABOUT THEIR WIDTH -->
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    &lt;!-- THIS MAKES IE WORK WITH HTML5 AND MEDIA QUERIES -->
    &lt;!--[if lt IE 9]>
        &lt;script src="http://html5shim.googlecode.com/svn/trunk/html5.js">&lt;/script>
        &lt;script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/
        css3-mediaqueries.js">&lt;/script>
    &lt;![endif]-->
&lt;/head>
&lt;body>

&lt;/body>
&lt;/html>
</pre>

<h3>Respective Stylesheets</h3>
<pre class="prettyprint lang-css">
/* ----- PHONE ----- */
@charset "UTF-8";
h1 {
    color: #F00;
}

/* ----- TABLET ----- */
@media only screen and (min-width: 550px){
    h2 {
        color: #090;
    }
}

/* ----- DESKTOP ----- */
@media only screen and (min-width: 1041px){
    h3 {
        color: #00f;
    }
}
</pre>


<h3 id="css-reset">CSS Reset</h3>
<pre class="prettyprint lang-css">
/* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}
</pre>

<h3 id="natural-box-model">Natural Box Model</h3>
<pre class="prettyprint lang-css">
/* ----- IN THE PHONE DEFAULT FILE ----- */

/*----- Prevents iPhone from resizing in landscape mode -----*/
html {
	-webkit-text-size-adjust:none;	
}

/*----- apply a natural box layout model to all elements -----*/
*{
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;	
}


/**********************************************/
/********** UPDATED BOX MODEL *****************/
/**********************************************/
html {
    box-sizing: border-box;
}
*, *:before, *:after {
    box-sizing: inherit;
}
</pre>

<hr />
<h2>Responsive Design</h2>
<h3>Additive - Mobile First</h3>
<p>Design for the phone first, then you enhance</p>
<p>Use min-width with no max-width</p>

<h3>Media = print</h3>
<p>Use if you know a website will be printed alot</p>

<pre class="prettyprint">
&lt;!--CSS FOR PRINTING-->
&lt;link href="CSS3/print.css" rel="stylesheet" type="text/css" media="print" />
</pre>

<hr />
<h2 id="start-file">HTML5 Start File</h2>
<pre class="prettyprint">
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="utf-8">
    
    &lt;title>HTML5 Start File&lt;/title>
    
    &lt;!-- TELLS PHONES NOT TO LIE ABOUT THEIR WIDTH & STOPS THE FONT FROM ENLARGING WHEN PHONE IS TURNED SIDEWAYS-->
    &lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    &lt;!-- LOAD THE LATEST VERSION OF JQUERY-->
    &lt;script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js">&lt;/script>
    
    &lt;!-- STYLE SHEETS -->
    &lt;link href="CSS3/reset.css" rel="stylesheet">
    &lt;!-- phone-default -->
    &lt;link href="CSS3/phone-default.css" rel="stylesheet">
    &lt;!-- enhance-tablet -->
    &lt;link href="CSS3/tablet.css" rel="stylesheet">
    &lt;!-- enhance-desktop -->
    &lt;link href="CSS3/desktop.css" rel="stylesheet">
    
    &lt;!--[if lt IE 9]>
        &lt;script src="http://html5shim.googlecode.com/svn/trunk/html5.js">&lt;/script>
        &lt;script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js">&lt;/script>
    &lt;![endif]-->

&lt;/head>
&lt;body>
    &lt;div id="wrapper">
    	&lt;div id="container">
            &lt;header>
            &lt;hgroup>
            &lt;h1>Site Name&lt;/h1>
            &lt;h2>Tag Line&lt;/h2>
            &lt;/hgroup>
            &lt;/header>
           
           
            &lt;!-- page navigation links here -->
            &lt;nav>
                &lt;ul>
                    &lt;li>&lt;a href="#">One&lt;/a>&lt;/li>
                    &lt;li>&lt;a href="#">Two&lt;/a>&lt;/li>
                    &lt;li>&lt;a href="#">Three&lt;/a>&lt;/li>
                &lt;/ul>
            &lt;/nav>
            
            
            &lt;!-- page content here -->
            &lt;div id="content">
                &lt;h1>Page Name&lt;/h1>
                &lt;p>Content for this page&lt;/p>
            &lt;/div>&lt;!--end content--> 
            
            &lt;footer>
                &lt;p>&copy; Jared Burdick &bull; Responsive Start File
            &lt;/footer>
            
            
        &lt;/div>&lt;!--end container-->
    &lt;/div>&lt;!--end wrapper-->
&lt;/body>
&lt;/html>
</pre>

<hr />
<h2 id="advanced-css">Real World Advanced CSS that you can Use Today</h2>
<style type="text/css">
nav.stupid {
	background-color:#960;	
	overflow:hidden;
}
nav.stupid ul {
	list-style-type:none;	
}
nav.stupid ul li {
	float:left;
	width:auto;
	margin:0;
}
nav.stupid ul li a {
	text-align:center;
	display:block;
	font-weight:600;
	color:#fff;	
	text-decoration:none;
	padding: 1em .5em;
	font-weight: 300;
	font-size:.8em;
	border-right: solid 1px rgba(0,0,0,0.2);
	border-left: solid 1px rgba(255,255,255,0.2);
}
nav.stupid ul li a:hover {
	background-color: rgba(0,0,0,0.4);
	color:#fff;	
	text-decoration:none;
}
</style>
<nav class="stupid">
	<ul>
    	<li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Products</a></li>
    </ul>
</nav>

<pre class="prettyprint lang-html">
&lt;nav>
	&lt;ul>
    	&lt;li>&lt;a href="#">Home&lt;/a>&lt;/li>
        &lt;li>&lt;a href="#">About&lt;/a>&lt;/li>
        &lt;li>&lt;a href="#">Contact&lt;/a>&lt;/li>
        &lt;li>&lt;a href="#">Products&lt;/a>&lt;/li>
    &lt;/ul>
&lt;/nav>
</pre>

<pre class="prettyprint lang-css">
nav {
	background-color:#960;	
	overflow:hidden;
}
nav ul {
	list-style-type:none;	
}
nav ul li {
	float:left;
	width:auto;
	margin:0;
}
nav ul li a {
	text-align:center;
	display:block;
	font-weight:600;
	color:#fff;	
	text-decoration:none;
	padding: 1em .5em;
	font-weight: 300;
	font-size:.8em;
	border-right: solid 1px rgba(0,0,0,0.2);
	border-left: solid 1px rgba(255,255,255,0.2);
}
nav ul li a:hover {
	background-color: rgba(0,0,0,0.4);
	color:#fff;	
	text-decoration:none;
}
</pre>

<hr />
<h3 id="clearfix">Clear Fix</h3>
<pre class="prettyprint lang-html">
&lt;nav>
    &lt;ul class="clearfix">
      &lt;li class="selected">&lt;a href="#">Home&lt;/a>&lt;/li>
    &lt;/ul>
&lt;/nav>
</pre>

<pre class="prettyprint lang-css">
nav ul li {
    float:left;	
}

.clearfix:after {
    content:"";
    display:table;
    clear:both;	
}
</pre>

<hr />
<h3 id="mobile-dropdown-conversion">Mobile Dropdown Conversion</h3>
<a href="http://astuteo.com/mobilemenu/" target="_blank">Mobile Dropdown Conversion</a><br />
<pre class="prettyprint">

</pre>
<hr />

<a href="http://projects/project-two/" target="_blank">Example Site 2</a><br />
<a href="http://projects/project-three/" target="_blank">Example Site 3</a><br />
<a href="http://projects/project-four/" target="_blank">Example Site 4</a><br />
<a href="http://projects/project-five/" target="_blank">Example Site 5</a><br />




</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>