<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Responsive Web Design with HTML5 and CSS3 - Intermediate</h1>
      </div>
<table class="table table-responsive table-bordered">
	<tr>
    	<td><a href="#validation">HTML5 Validation</a></td>
        <td><a href="#slider">Slider</a></td>
        <td><a href="#fluid-video">Fluid Video</a></td>
        <td><a href="#image-sprites">Image Sprites</a></td>
        <td><a href="#responsive-images">Responsive Images</a></td>
    </tr>
    <tr>
    	<td><a href="#twitter-feeds">Twitter Feeds</a></td>
        <td><a href="#font-icons">Font Icons</a></td>
        <td><a href="#schema">Schema</a></td>
        <td><a href="#lazy-loading">Lazy Loading Images</a></td>
        <td><a href="#add-to-home">Add to Home for Mobile Devices</a></td>
    </tr>
</table>

<h3>Remove I-phone's default stylings</h3>
<pre class="prettyprint lang-css">
input.submitBtn {
	<b><u>-webkit-appearance:none; /*remove the applie mobile default styling*/</u></b>
	color:#fff;
	border: solid 1px #111;
	border-radius:7px;
	width: 50%;
	margin:.5em 0;
	font-size: 1em;
	padding: .6em;
	background: #7d2a35;
	box-shadow: 4px 4px 10px #666;	
}
</pre>

<hr />
<h3 id="validation">New HTML5 Validation</h3>
<pre class="prettyprint lang-css">
/*This is using an image sprite I made for background image*/

/*NEW HTML5 VALIDATION*/
label input {
	background-color:#f4f2ef;
	color: #917a56;	
	padding: .3em .3em .3em 2em;
	border:solid 1px #b0aaa0;
	border-radius: 5px;
	font-size: .9em;
	width: 90%;
	max-width: 500px;
	background-image:url('../images/ico_validation.fw.png');
	background-repeat:no-repeat;
	background-position: 4px -4px;
}
/*The input that currently has the focus*/
input:focus {
	box-shadow: 1px 1px 4px rgba(0,0,0,0.5) inset;	
}
/*identifies all required fields*/
input:required {
	background-position:4px -36px; /*shows the red star*/	
}
/*Validation*/
input:focus:invalid {
	background-position: 4px -69px; /*shows the yellow circle*/	
}
/*Valid*/
input:required:valid {
	background-color:#fff;
	background-position:4px -106px; /*shows the green check*/
}

</pre>

<hr />
<h3 id="slider">Slider</h3>
<a href="http://www.woothemes.com/flexslider/" target="_blank">FlexSlider</a><br />
<a href="http://flexslider.woothemes.com/thumbnail-controlnav.html" target="_blank">Thumbnail Control Nav</a><br />
<pre class="prettyprint">
&lt;!-- LOAD THE LATEST VERSION OF JQUERY-->
&lt;script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js">&lt;/script>

&lt;!-- Flex slider-->
&lt;link rel="stylesheet" href="SliderSupport/flexslider.css" type="text/css">
&lt;script src="SliderSupport/jquery.flexslider.js">&lt;/script>
&lt;script type="text/javascript">
    $(window).load(function(){
        $('.flexslider').flexslider();
    });
&lt;/script>



&lt;div class="flexslider">
    &lt;ul class="slides">
        &lt;li>&lt;img src="sliders/kitchen_adventurer_caramel.jpg">
        &lt;span class="flex-caption">Image Description&lt;/span>
        &lt;/li>
        &lt;li>&lt;img src="sliders/kitchen_adventurer_cheesecake_brownie.jpg">&lt;/li>
        &lt;li>&lt;img src="sliders/kitchen_adventurer_donut.jpg">&lt;/li>
        &lt;li>&lt;img src="sliders/kitchen_adventurer_lemon.jpg">&lt;/li>
    &lt;/ul>
&lt;/div>&lt;!--end flexslider-->
</pre>

<pre class="prettyprint lang-css">
/*Add these changes to flexslider.css for image captions*/

/*Changes by jburdick*/
.flexslider {
	border:none;
	box-shadow:none;
}
.flexslider .slides li {
	position:relative;	
}
.flex-caption {
	position:absolute;
	font-family:Verdana, Geneva, sans-serif;
	text-align:center;
	width:100%;
	bottom:10px;
	color:#fff;
	background:rgba(0,0,0,0.4);
	z-index:1;
	display:block;
	padding:5px;	
}
</pre>

<hr />
<h3 id="fluid-video">Fluid Video widths</h3>
<a href="http://fitvidsjs.com" target="_blank">fitvidsjs.com</a><br />

<hr />
<h3 id="image-sprites">Image Sprites</h3>

<pre class="prettyprint">
&lt;!-- social icons here -->
&lt;ul class="social">
    &lt;li class="googleplus">&lt;a href="#">&lt;/a>&lt;/li>
    &lt;li class="twitter">&lt;a href="#">&lt;/a>&lt;/li>
    &lt;li class="facebook">&lt;a href="#">&lt;/a>&lt;/li>
    &lt;li class="youtube">&lt;a href="#">&lt;/a>&lt;/li>
&lt;/ul>
</pre>

<pre class="prettyprint lang-css">
/* phone-default.css */

/*----- HEADER SOCIAL ICONS -----*/
header ul.social {
    display:none;
}

@media only screen and (min-width: 600px){
/* tablet.css*/

/*----- HEADER SOCIAL ICONS -----*/
header ul.social {
    display:block;
    float:right;
}
header ul.social li {
    float: left;
}
header ul.social li a {
    display: block;
    height: 50px; /* height of image sprite */
    width: 60px; /* width of image sprite */
    background-image:url('../images/socialSprites.png');
}

ul.social li a:hover {
    opacity: 0.7;
}
ul.social li.twitter a {
    background-position: 0px 0px;
}
ul.social li.youtube a {
    background-position: -60px 0px;
}
ul.social li.facebook a {
    background-position: -120px 0px;
}
ul.social li.googleplus a {
    background-position: -180px 0px;
}

/* INSTEAD OF USING OPACITY, SWITCH THE IMAGE SPRITE ON HOVER */
ul.social li.twitter a {
    background-position: 0px -50px;
}
ul.social li.youtube a {
    background-position: -60px -50px;
}
ul.social li.facebook a {
    background-position: -120px -50px;
}
ul.social li.googleplus a {
    background-position: -180px -50px;
}

ul.social li.twitter a:hover {
    background-position: 0px 0px;
}
ul.social li.youtube a:hover {
    background-position: -60px 0px;
}
ul.social li.facebook a:hover {
    background-position: -120px 0px;
}
ul.social li.googleplus a:hover {
    background-position: -180px 0px;
}

/* ---- IF I WANTED TO CHANGE THE SPRITE IMAGE SIZE (for phone maybe) -----*/

header ul.social li a {
    display: block;
    height: 25px; /* reduced by half */
    width: 30px; /* reduced by half */
    background-image:url('../images/socialSprites.png');
    background-size: 120px 50px; //reduced by exactly half;
}

ul.social li.twitter a {
    background-position: 0px 0px;
}
ul.social li.youtube a {
    background-position: -30px 0px;
}
ul.social li.facebook a {
    background-position: -60px 0px;
}
ul.social li.googleplus a {
    background-position: -90px 0px;
}
</pre>

<hr />
<h3 id="responsive-images">Responsive Images</h3>
<a href="https://github.com/scottjehl/picturefill" target="_blank">Picturefill</a>
<pre class="prettyprint">
&lt;!-- LOAD TWO SCRIPTS NEEDED FOR RESPONSIVE IMAGES -->
    &lt;script>
	//Picture element HTML shim|v it for old IE (pairs with Picturefill.js)
	document.createElement("picture");
    &lt;/script>
    &lt;script async="true" src="js/picturefill.js">&lt;/script>
    
    
&lt;picture>
    &lt;!--[if IE 9]>&lt;video style="display: none;">&lt;![endif]-->
    &lt;source srcset="../examples/images/extralarge.jpg" media="(min-width: 1000px)">
    &lt;source srcset="../examples/images/large.jpg" media="(min-width: 800px)">
    &lt;source srcset="../examples/images/medium.jpg">
    &lt;!--[if IE 9]>&lt;/video>&lt;![endif]-->
    &lt;img srcset="../examples/images/medium.jpg" alt="A giant stone face" />
&lt;/picture>
</pre>

<hr />
<h3 id="twitter-feeds">Twitter Feeds</h3>
<p><i>*must be logged into twitter</i></p>
<a href="https://twitter.com/settings/widgets" target="_blank">https://twitter.com/settings/widgets</a>
<h4>Create a new widget</h4>
<ol>
	<li>Create new widget</li>
</ol>
<pre class="prettyprint">

&lt;div class="row">
	&lt;article>
    &lt;h4>All tweets from Jared Burdick&lt;/h4>
    
&lt;a class="twitter-timeline" href="https://twitter.com/jared_burdick10" data-widget-id="720630812429799424">Tweets by @jared_burdick10&lt;/a>
&lt;script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");&lt;/script>
    
    &lt;/article>
    
    &lt;article>
    &lt;h4>All tweets with the hashtag #webdesign&lt;/h4>
&lt;a class="twitter-timeline" href="https://twitter.com/hashtag/webdesign" data-widget-id="720632423084482560">#webdesign Tweets&lt;/a>
&lt;script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");&lt;/script>

    &lt;/article>
&lt;/div>&lt;!--end row-->


</pre>

<pre class="prettyprint lang-css">
/**
 * PHONE DEFAULT CSS FILE
 */
 
/*----- TWITTER STUFF -----*/
#content article {
	width: 96%;
	margin:.9em 2%;	
}
#content article iframe {
	width: 100%;	
}

<hr />

/**
 * TABLET CSS FILE
 */
 
/*----- CONTENT -----*/
#content div.row {
	clear:both;	
}
#content article {
	float:left;
	width: 46%;	
}
</pre>

<hr />
<h3 id="font-icons">Font Icons</h3>
<a href="https://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a>
<pre class="prettyprint">
&lt;!-- link to font-awesome stylesheet -->
&lt;link href="css/font-awesome.css" rel="stylesheet">



&lt;footer>
&lt;article>
&lt;!-- Social Icons -->
&lt;ul id="social">
     &lt;li>&lt;a href="#">&lt;i class="fa fa-facebook-square">&lt;/i>&lt;/a>&lt;/li>
     &lt;li>&lt;a href="#">&lt;i class="fa fa-twitter-square">&lt;/i>&lt;/a>&lt;/li>
     &lt;li>&lt;a href="#">&lt;i class="fa fa-linkedin-square">&lt;/i>&lt;/a>&lt;/li>
     &lt;li>&lt;a href="#">&lt;i class="fa fa-google-plus-square">&lt;/i>&lt;/a>&lt;/li>
     &lt;li>&lt;a href="#">&lt;i class="fa fa-youtube-square">&lt;/i>&lt;/a>&lt;/li>
&lt;/ul>
            
&lt;p>© Jared Burdick • Responsive Start File&lt;/p>
&lt;/article>            
&lt;/footer>
</pre>

<pre class="prettyprint lang-css">
/*----- Social Icons -----*/
footer p {
	color:#aaa;
	line-height:139%;	
}
footer a {
	color: #aaa;	
}
footer ul#social {
	text-align:center;	
}
footer ul#social li {
	display:inline-block;	
}
footer ul#social li a {
	font-size: 2em;
	margin: 0 .2em;	
}
</pre>

<hr />
<h3 id="schema">Schema</h3>
<a href="http://schema.org" target="_blank">Schema.org</a>

<pre class="prettyprint">
&lt;div id="footerWrapper" class="clearfix">
&lt;footer>
    
    &lt;article>
        &lt;address itemscope itemtype="http://schema.org/Organization">
            &lt;p itemprop="name">&lt;strong>Theory of Webolution&lt;/strong>&lt;/p>
            &lt;p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            &lt;span itemprop="streetAddress">911 West 5th Street&lt;/span>&lt;br>
            &lt;span itemprop="addressLocality">Stroud&lt;/span>,
            &lt;span itemprop="addressRegion">OK&lt;/span>
            &lt;span itemprop="postalCode">74079&lt;/span>
            &lt;/p>
        &lt;/address>
    &lt;/article>
    
    &lt;article>
        &lt;address itemscope itemtype="http://schema.org/ContactPoint">
            &lt;p itemprop="contactType">&lt;strong>Web Zen&lt;/strong>&lt;/p>
            &lt;p>&lt;a href="#" itemprop="email">Email Us&lt;/a>&lt;/p>
            &lt;p>Phone: &lt;span itemprop="telephone">801-555-1234&lt;/span>&lt;/p>
            &lt;p>Fax: &lt;span itemprop="faxNumber">801-555-4321&lt;/span>&lt;/p>
        &lt;/address>
    &lt;/article>
    
    &lt;article>
    
    &lt;/article>
    
&lt;/footer>
&lt;/div>&lt;!--end footerWrapper-->
</pre>

<hr />
<h3 id="lazy-loading">Lazy Loading Images</h3><br />
<a href="http://www.appelsiini.net/projects/lazyload" target="_blank">Lazy Load Pluging for jQuery</a><br />
<a href="https://github.com/tuupola/jquery_lazyload" target="_blank">Lazy Load Github Download</a>

<pre class="prettyprint">
&lt;!-- LOAD THE LATEST VERSION OF JQUERY-->
&lt;script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js">&lt;/script>

&lt;!-- LAZY LOADER -->
&lt;script src="js/jquery.lazyload.js">&lt;/script>
&lt;script type="text/javascript">
$(function(){
    $("img.lazy").lazyload();
});
&lt;/script>


&lt;article>
    &lt;img class="lazy" data-original="images/example.jpg" width="640" height="480" />
    
    &lt;!-- CANNOT USE WIDTH AND HEIGHT WITH RESPONSIVE DESIGNS -->
    &lt;figure>
    &lt;img class="lazy" data-original="images/example.jpg" />
    &lt;figcaption>Sample Image&lt;/figcaption>
    &lt;/figure>
    
    &lt;!-- TO LOAD MY OWN IMAGE -->
    &lt;figure>
    &lt;img class="lazy" src="images/grey.gif" data-original="images/example.jpg" />
    &lt;figcaption>Sample Image&lt;/figcaption>
    &lt;/figure>
    
    &lt;!-- MODIFICATIONS -->
    
    &lt;script type="text/javascript">
    $(function(){
        $("img.lazy").lazyload({
            threshold: 400,
            effect: "fadeIn"
        });
    });
    &lt;/script>
    
    
    &lt;!-- EVEN MORE MODIFICATIONS -->
    &lt;!-- SERVE UP SMALLER GRAYSCALE IMAGES of the originals IN THE SRC -->
    &lt;figure>
    &lt;img class="lazy" src="images/<b>grayscale.jpg</b>" data-original="images/example.jpg" />
    &lt;figcaption>Sample Image&lt;/figcaption>
    &lt;/figure>
    
    
&lt;/article>

</pre>

<hr />
<h3 id="add-to-home">Add to Home for Mobile Devices</h3>
<a href="http://cubiq.org/add-to-home-screen" target="_blank">Add To Home Screen Code</a>
<pre class="prettyprint">
	
    &lt;link rel="shortcut icon" sizes="16x16" href="A2H_stuff/icon-16x16.png">
    &lt;link rel="shortcut icon" sizes="196x196" href="A2H_stuff/icon-196x196.png">
    &lt;link rel="apple-touch-icon-precomposed" href="A2H_stuff/icon-152x152.png">-->

    &lt;link rel="stylesheet" type="text/css" href="A2H_stuff/addtohomescreen.css">
&lt;script src="A2H_stuff/addtohomescreen.js">&lt;/script>
&lt;script type="text/javascript">
addToHomescreen({
	skipFirstVisit: false,
	maxDisplayCount: 0,
	displayPace: 1	
});
&lt;/script>
</pre>

</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>