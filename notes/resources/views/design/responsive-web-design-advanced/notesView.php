<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Responsive Web Design with HTML5 and CSS3 - Advanced</h1>
      </div>

<table class="table table-responsive table-bordered">
	<tr>
    	<td><a href="#variables">Variables</a></td>
        <td><a href="#nesting">Nesting</a></td>
        <td><a href="#mixins">Mixins</a></td>
        <td><a href="#extending-inheritance">Extending or Inheritance</a></td>
        <td><a href="#operators">Operators</a></td>
    </tr>
    <tr>
    	<td><a href="#jquery-highlighting">jQuery Highlighting</a></td>
        <td><a href="#foundation5">Foundation 5</a></td>
    </tr>
</table>

<h3>CSS Preprocessors</h3>
<a href="http://sass-lang.com/install" target="_blank">SASS</a><br />
<a href="http://compass.kkbox.com" target="_blank">COMPASS</a><br />

<hr />
<h3 id="partials-imports">Partials &amp; Imports</h3>
<p>First, create a new compass project</p>

<p>Partial files begin with an underscore(_) and are only used for imports</p>
<pre class="prettyprint lang-css">
/* In the sass folder */
<div class="nocode">
_phone-default.scss
_tablet.scss
_desktop.scss
</div>
</pre>

<p>Link to the screen.css file in your html document</p>
<pre class="prettyprint">
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="UTF-8">
    &lt;title>SASS&lt;/title>
    <b><u>&lt;link rel="stylesheet" type="text/css" href="stylesheets/screen.css"></u></b>
&lt;/head>
&lt;body>

&lt;/body>
&lt;/html>
</pre>

<h3>Import the partials</h3>
<p><i>Use the media queries in this file rather than individual scss files</i></p>
<pre class="prettyprint lang-css">
/* THIS IS THE screen.scss FILE */

/* Welcome to Compass.
 * In this file you should write your main styles. (or centralize your imports)
 * Import this file using the following HTML or equivalent:
 * &lt;link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" /> */

@import "compass/reset";

@import "phone-default";

@media only screen and (min-width: 600px){
    @import "tablet";
}/* End of the tablet rules */

@media only screen and (min-width: 1141px){
    @import "desktop";
}/* End of the Desktop rules */
</pre>

<hr />
<h3 id="variables">Variables</h3>
<pre class="prettyprint">
&lt;!-- LINK TO YOUR FONT -->
&lt;head>
    &lt;link href='https://fonts.googleapis.com/css?family=Signika:300,600' rel='stylesheet' type='text/css'>
&lt;/head>
</pre>

<pre class="prettyprint lang-css">
/* This is the CSS for the phone */

$main-color: #292c44;
$accent-color: #ff5349;

$main-font: 'Signika', sans-serif;
$light:300;
$heavy:600;

body {
    font-family:$main-font;
}

h1 {
    color:$main-color;
    font-size: 4em;
    font-weight: $heavy;
}
p {
    color:$accent-color;
}
</pre>

<hr />

<h3 id="nesting">Nesting</h3>

<pre class="prettyprint">
&lt;nav class="main">
    	&lt;ul>
            &lt;li>&lt;a href="#">Preprocessing&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Partials&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Import&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Variables&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Nesting&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Mixins&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Extend/Inheritance&lt;/a>&lt;/li>
            &lt;li>&lt;a href="#">Operators&lt;/a>&lt;/li>
        &lt;/ul>
        &lt;div class="keepOpen">&lt;/div>
&lt;/nav>
</pre>

<pre class="prettyprint lang-css">
/*----- phone-default.css -----*/

/* DEMONSTRATION OF NESTING */
nav.main {
    background-color: $alt2-color;

    ul li {
        width: 50%;
        float:left;
    
        a {
            display:block;
            background:$alt1-color;
            border: 1px solid rgba(0,0,0,0.5);
            margin: .1em 2%;
            padding: .4em;
            text-decoration:none;
            font-weight:$heavy;
            border-radius: 16px;
        }
        a:hover {
            color: white;
        }
    }/* end of li nesting */
}/* end of nav nesting */

<hr />
/*----- tablet.css -----*/

/*----- NAVigation -----*/
nav.main {
    float:none;
    width: 100%;
    border:none;

    ul {
        margin-left: 2%;
        border:none;

        /*main menu items float side by side*/
        li{
            width: auto;
            float:left;
            border-right: solid 1px rgba(0,0,0,0.7);
            border-left: solid 1px rgba(255,255,255, 0.1);

            a {
                border:none;
                background:none;
                border-radius: 0;
                margin: 0;
                font-size: .8em;
                padding: .7em .9em;
            }

        }/*end li nesting*/
    }/*end ul nesting*/
}/*end nav nesting*/
</pre>

<hr />
<h3 class="mixins">Mixins</h3>
<pre class="prettyprint lang-css">
@mixin border-radius($radius) {
    -webkit-border-radius: $radius;
    -moz-border-radius: $radius;
    -ms-border-radius: $radius;
    border-radius: $radius;
}

@mixin gradient($start, $end){
    background: -moz-linear-gradient(top, $start 0%, $end 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(top,  $start 0%, $end 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to bottom,  $start 0%, $end 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=$start, endColorstr=$end,GradientType=0 ); /* IE6-9 */
}

p {
    border: 1px solid orange;
    @include border-radius(10px);
    @include gradient(#c6ffcf, #9ab89f);
}
</pre>

<hr />
<h3 id="extending-inheritance">Extending or Inheritance</h3>
<pre class="prettyprint lang-css">
 /* DEMONSTRATION OF INHERIT*/
 span.button {
     border: 1px solid #666;
     border-radius: 15px 5px;
     display: block;
     padding: .3em 1em .2em 1em;
     margin: .3em 0;
     max-width: 100px;
     font-size: .7em;
     font-weight:$heavy;
 }
 span.read {
     @extend span.button;
     background-color: $main-color;
 }
span.continue {
     @extend span.button;
     background-color: $accent-color;
 }
span.cancel {
     @extend span.button;
     background-color: red;
 }
span.toTop {
     @extend span.button;
     background-color: #999;
 }
</pre>

<hr />

<h3 id="operators">Operators</h3>
<pre class="prettyprint">
/* DEMONSTRATION OF OPERATORS */
/*----- IMAGES -----*/

figure.img4col {
    $width: 12 / 12 * 100%; /* 12 out of 12 colums */
    width: $width - 4%; /* 96% */
    background-color: #fff;
    border:1px solid #999;
    box-shadow: 2px 2px 5px rgba(63,63,63,0.5);
    margin: .5em 2%;
}
figure.img4col img {
    width: 100%;
}
figcaption {
    text-align:center;
    font-size: .7em;
    padding: .3em;
}
figure.right {
    float:right;
    margin-left: 2%;
}

<hr />
/*----- TABLET -----*/

figure.img4col {
    $width: 8 / 12 * 100%; /* 8 out of 12 columns */
    width: $width - 4%; /* 62.66667% */
}

<hr />
/*----- DESKTOP -----*/

figure.img4col {
    $width: 4 / 12 * 100%; /* 4 out of 12 columns*/
    width: $width - 4%; /* 29.33333% */
}
</pre>

<hr />
<h3 id="jquery-highlighting">jQuery Highlighting</h3>
<pre class="prettyprint">
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="UTF-8">
    &lt;title>Virtual Homes&lt;/title>
    
    &lt;meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    &lt;!-- LOAD THE LATEST VERSION OF JQUERY -->
    &lt;script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js">&lt;/script>
    &lt;script>
    $(document).ready(function(){
        var str=location.href.toLowerCase(); // loads the url into the string
        $(".mymenu li a").each(function(){
            if(str.indexOf(this.href.toLowerCase()) > -1){ 
                $("li.active").removeClass("active");// removes from previous
                $(this).parent().addClass("active"); //adds to the current
            }
        });
    })
    &lt;/script>
&lt;/head>
&lt;body>
&lt;nav class="clearfix">
    &lt;ul class="mymenu">
        &lt;li class="active">&lt;a href="index.php">Tours&lt;/a>&lt;/li>
        &lt;li>&lt;a href="contact.php">Contact Us&lt;/a>&lt;/li>
        &lt;li>&lt;a href="pricing.php">Pricing&lt;/a>&lt;/li>
        &lt;li>&lt;a href="craft.php">Craftsmanship&lt;/a>&lt;/li>
    &lt;/ul>
&lt;/nav>

&lt;/body>
&lt;/html>
</pre>

<hr />
<h3 id="foundation5">Foundation 5</h3>
<a href="http://foundation.zurb.com/sites/download.html" target="_blank">Foundation 5</a><br />


</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>