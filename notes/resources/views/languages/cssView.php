<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?php echo $title; ?></h1>
      </div>



<div class="panel panel-default">
	<div class="panel-heading">
    	<h3 class="panel-title">CSS: The Missing Manual (4th Edition)</h3>
    </div><!--end panel-heading-->
    
	<div class="panel-body">
	<p class="lead">Part One: <b>CSS Basics</b></p>
        <ol>    
           <li><a href="/css/css-missing-manual/html-and-css">HTML and CSS</a></li>
           <li><a href="/css/css-missing-manual/creating-styles-and-style-sheets">Creating Styles and Style Sheets</a></li>
           <li><a href="/css/css-missing-manual/selectors">Selectors: Identifying What to Style</a></li>
           <li><a href="/css/css-missing-manual/saving-time-with-style-inheritance">Saving Time with Style Inheritance</a></li>
           <li><a href="/css/css-missing-manual/managing-multiple-styles">Managing Multiple Styles: The Cascade</a></li>
       </ol>
       
       <p class="lead">Part Two: <b>Applied CSS</b></p>
       <ol>
           <li><a href="/css/css-missing-manual/formatting-text">Formatting Text</a></li>
           <li><a href="/css/css-missing-manual/margins-padding-borders">Margins, Padding, and Borders</a></li>
           <li><a href="/css/css-missing-manual/adding-graphics">Adding Graphics to Web Pages</a></li>
           <li><a href="/css/css-missing-manual/sprucing-up">Sprucing Up Your Site's Navigation</a></li>
           <li><a href="/css/css-missing-manual/transforms-transitions-animations">CSS Transforms, Transitions, and Animations</a></li>
           <li><a href="/css/css-missing-manual/formatting-tables-and-forms">Formatting Tables and Forms</a></li>
       </ol>
       
       <p class="lead">Part Three: <b>CSS Page Layout</b></p>
       <ol>
           <li><a href="/css/css-missing-manual/css-layout">Introducing CSS Layout</a></li>
           <li><a href="/css/css-missing-manual/float-based-layouts">Building Float-Based Layouts</a></li>
           <li><a href="/css/css-missing-manual/positioning-elements">Positioning Elements on a Web Page</a></li>
           <li><a href="/css/css-missing-manual/responsive-web-design">Responsive Web Design</a></li>
           <li><a href="/css/css-missing-manual/css-grid-system">Using a CSS Grid System</a></li>
           <li><a href="/css/css-missing-manual/flexbox">Mordern Web Layout with Flexbox</a></li>
       </ol>
       
       <p class="lead">Part Four: <b>Advanced CSS</b></p>
       <ol>
           <li><a href="/css/css-missing-manual/improving-habits">Improving Your CSS Habits</a></li>
           <li><a href="/css/css-missing-manual/sass">More Powerful Styling with Sass</a></li>
        </ol>
        
        <p class="lead">Part Five: <b>Appendixes</b></p>
        <ol>
        	<li><a href="/css/css-missing-manual/css-property-reference">CSS Property Reference</a></li>
            <li><a href="/css/css-missing-manual/css-resources">CSS Resources</a></li>
        </ol>

	</div><!--end panel body-->
</div><!--end panel-->




      
<pre class="prettyprint lang-css">
/*Phone*/
@charset "UTF-8";
h1 {
    color:#F00;
}

/*-------- Prevents iPhone from resizing in landscape mode --------*/
html {
    -webkit-text-size-adjust:none;
}

/*
 / Updated Box Model 2014
*/
html {
    box-sizing: border-box;
}
*, *:before, *:after {
    box-sizing: inherit;
}

<hr />

/*Tablet*/
@media only screen and (min-width: 550px){
    h2 {
        color: #090;
    }
}

<hr />

/*Desktop*/
@media only screen and (min-width: 1041px){
    h3 {
        color:#00f;
    }
}
</pre>
    </div>

<?php require_once(assets("includes/footer.php")); ?>