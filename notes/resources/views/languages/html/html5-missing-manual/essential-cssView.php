<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Essential CSS</h1>
      </div>
      
<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#adding">Adding Styles to a Web Page</a></td>
        <td><a href="#anatomy">The Anatomy of a Style Sheet</a></td>
        <td><a href="#advanced">Slightly More Advanced Style Sheets</a></td>
        <td><a href="#tour">A Style Sheet Tour</a></td>
    </tr>
</table>

<hr />
<h2 id="adding">Adding Styles to a Web Page</h2>

<p>There are three ways to use styles in a web page.</p>
<p>The first approach is to embed style information directly into an element using the style attribute. Here's an example that changes the color of a heading:</p>
<pre class="prettyprint">
&lt;h1 style="color: green">Inline Styles are Sloppy Styles&lt;/h1>
</pre>
<p>This is convenient, but it clutters the markup terribly. You have to style every line, one by one.</p>
<hr />
<p>The second approach is to embed an entire style sheet in a &lt;style> element, which you must place in the page's &lt;head> section:</p>
<pre class="prettyprint">
&lt;head>
    &lt;title>Embedded Style Sheet Test&lt;/title>
    <b>&lt;style>
    ...
    &lt;/style></b>
&lt;/head>
</pre>
<p>This code separates the formatting from your web page markup but still keeps everything together in one file.</p>

<hr />
<p>The third approach is to link to a separate style sheet file by adding a &lt;link> element to the &lt;head> section. Here's an example that tells a web browser to apply the styles from the style sheet named <b>SampleStyles.css</b>:</p>
<pre class="prettyprint">
&lt;head>
    &lt;title>External Style Sheet Test&lt;/title>
    &lt;link rel="stylesheet" href="SampleStyles.css">
&lt;/head>
</pre>
<p>This approach is the most common and the most powerful. It gives you the flexibility to reuse your styles in other pages.</p>
<hr />

<h2 id="anatomy">The Anatomy of a Style Sheet</h2>
<p>A style sheet is a text file, which you'll usually place on a web server alongside your HTML pages. It contains one or more <b>rules</b>. The order of these rules doesn't matter. Each rule applies one or more formatting details to one or more HTML elements. Here's the structure of a simple rule:</p>
<pre class="prettyprint lang-css">
selector {
    property: value;
    property: value;
}
</pre>

<p>And here's what each part means:</p>
<ul>
	<li>The <b>selector</b> identifies the type of content you want to format. A browser hunts down all the elements in the web page that match your selector. There are many different ways to write a selector, but one of the simplest approaches (shown next) is to identify the elements you want to format by their element names. For example, you could write a selector that picks out all the level-one headings in your page.</li>
    <li>The <b>property</b> identifies the type of formatting you want to apply. Here's where you choose whether you want to change colors, fonts, alignment, or something else. You can have as many property settings as you want in a rule--this example has two.</li>
    <li>The <b>value</b> sets a value for the property. For example, if your property is color, the value could be light blue or a queasy green.</li>
</ul>
<p>Now here's a rule that does something:</p>
<pre class="prettyprint lang-css">

h1 {
    text-align: center;
    color: green;
}

</pre>

<h4>CSS Properties</h4>
<p>The previous example introduces two formatting properties: text-align (which sets how text is positioned, horizontally) and color (which sets the text color).</p>

<table class="table table-responsive table-bordered table-striped">
	<caption>Commonly used style sheet properties, by category</caption>
    <thead>
   		<tr>
        	<th>&nbsp;</th>
            <th>PROPERTIES</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td>Colors</td>
            <td>color<br />
            background-color</td>
        </tr>
        <tr>
        	<td>Spacing</td>
            <td>margin<br />
            padding<br />
            margin-left, margin-right, margin-top, margin-bottom<br />
            padding-left, padding-right, padding-top, padding-bottom</td>
        </tr>
        <tr>
        	<td>Borders</td>
            <td>border-width<br />
            border-style<br />
            border-color<br />
            border (to set the width, style, and color in one step)</td>
        </tr>
        <tr>
        	<td>Text Alignment</td>
            <td>text-align<br />
            text-indent<br />
            word-spacing<br />
            letter-spacing<br />
            line-height<br />
            white-space</td>
        </tr>
        <tr>
        	<td>Fonts</td>
            <td>font-family<br />
            font-size<br />
            font-weight<br />
            font-style<br />
            font-variant<br />
            text-decoration<br />
            @font-face (for using fancy web fonts)</td>
        </tr>
        <tr>
        	<td>Size</td>
            <td>width<br />
            height</td>
        </tr>
        <tr>
        	<td>Layout</td>
            <td>position<br />
            left, right<br />
            float, clear</td>
        </tr>
        <tr>
        	<td>Graphics</td>
            <td>background-image<br />
            background-repeat<br />
            background-position</td>
        </tr>
    </tbody>
</table>

<h4>Formatting the Right Elements with Classes</h4>
<pre class="prettyprint">
&lt;h1 class="ArticleTitle">HTML5 is Winning&lt;/h1>
</pre>


<pre class="prettyprint lang-css">
/* matches any element with the <b>ArticleTitle</b> class */
.ArticleTitle {
    font-family: Garamond, serif;
    font-size: 40px;
}

/* Matches any <b>&lt;h1></b> element that uses the <b>ArticleTitle</b> class */
h1.ArticleTitle {
    font-size: 40px;
}

</pre>

<h4>Style Sheet Comments</h4>
<pre class="prettyprint lang-css">
/* The heading of the main article on a page. */
.ArticleTitle {
    font-size: 40px;
}

</pre>

<hr />
<h2 id="advanced">Slightly More Advanced Style Sheets</h2>

<h4>Structuring a Page with &lt;div> Elements</h4>
<p>When working with style sheets, you'll often use the &lt;div> element to wrap up a section of content:</p>
<pre class="prettyprint">
&lt;div>
    &lt;p>Here are two paragraphs of content.&lt;/p>
    &lt;p>In a div container&lt;/p>
&lt;/div>
</pre>

<p>On its own, the &lt;div> does nothing. but it gives you a convenient place to apply some class-based style sheet formatting. Here are some examples:</p>
<ul>
	<li><b>Inherited values:</b> Some CSS properties are <b>inherited</b>, which means the value you set in one element is automatically applied to all the elements inside. One example is the set of font properties--set them on a &lt;div>, and everything inside gets the same text formatting (unless you override it in places with more specific formatting rules).</li>
    <li><b>Boxes:</b> A &lt;div> is a natural container. Add a border, some spacing, and a different background color (or image), and you have a way to make select content stand out.</li>
    <li><b>Columns:</b> Professional websites often carve their content up into two or three columns. One way to make this happen is to wrap the content for each column in a &lt;div>, and then use CSS positioning properties to put them in their proper places.</li>
</ul>

<hr />
<p class="lead">TIP</p>
<p>Now that HTML5 has introduced a new set of semantic elements, the &lt;div> element doesn't play quite as central a role. If you can replace a &lt;div> with another, more meaningful semantic element (like &lt;header> or &lt;figure>), you should do that. But when nothing else fits, the &lt;div> remains the go-to tool.</p>
<hr />

<h4>Contextual Selectors</h4>
<p>A contextual selector matches an element <b>inside</b> another element:</p>
<pre class="prettyprint lang-css">
/* This selector looks for an element that uses the Content class. 
Then is looks for &lt;h2> elements inside that element and formats
them with a different text color and font size 
*/

.Content h2 {
    color: #24486C;
    font-size: medium;
}
</pre>
<pre class="prettyprint">
&lt;div class="Content">
...
    <b>&lt;h2>Mayan Doomsday&lt;/h2></b>
...
&lt;/div>
</pre>

<hr />
<h4>ID Selectors</h4>
<pre class="prettyprint lang-css">
#Menu {
    border-width: 2px;
    border-style: solid;
}

&lt;div id="Menu">...&lt;/div>
</pre>

<hr />
<h4>Pseudo-Class Selectors</h4>
<pre class="prettyprint lang-css">
a:link {
    color: red;
}
a:visited {
    color: blue;
}

/* You can also use pseudo-classes with a class name: */
.BackwardLink:link {
    color: red;
}
.BackwardLink:visited {
    color: blue;
}
</pre>

<hr />
<h4>Attribute Selectors</h4>
<pre class="prettyprint lang-css">
input[type="text"] {
    background-color:silver;
}
</pre>
<pre class="prettyprint lang-html">
&lt;label for="name">Name:&lt;/label>
&lt;input id="name" type="text">&lt;br />
&lt;input type="submit" value="OK">
</pre>
<pre class="prettyprint lang-css">
label[for="name"]{
    width: 200px;
}
</pre>

<hr />
<h2 id="tour">A Style Sheet Tour</h2>
      
<pre class="prettyprint">
&lt;!DOCTYPE html>
&lt;html lang="en">
&lt;head>
    &lt;title>Apocalypse Now&lt;/title>
    <b>&lt;link rel="stylesheet" href="ApocalypsePage_Original.css"></b>
&lt;/head>
...
</pre>

<pre class="prettyprint lang-css">
body {
    font-family: "Lucida Sans Unicode", "Lucida Grande", Geneva, sans-serif;
    max-width: 800px;
}

.Header {
    background-color: #7695FE;
    border: thin #336699 solid;
    padding: 10px;
    margin: 10px;
    text-align:center;
}

.Header H1 {
    margin: 0px;
    color: white;
    font-size: xx-large;
}

.Header .Teaser {
    margin: 0px;
    font-weight: bold;
}

.Header .Byline {
    font-style: italic;
    font-size: small;
    margin: 0px;
}

.Content {
    font-size: medium;
    font-family: Cambria, Cochin, Georgia, "Times New Roman", Times, serif;
    padding-top: 20px;
    padding-right: 50px;
    padding-bottom: 5px;
    padding-left: 50px;
    /* padding: 20px 50px 5px 50px; */
    line-height: 120%;
}

.Content .LeadIn {
    font-weight: bold;
    font-size: large;
    font-variant: small-caps;
}

.Content h2 {
    color: #24486C;
    margin-bottom: 2px;
    font-size: medium;
}

.Content p {
    margin-top: 0px;
}

.Footer {
    text-align:center;
    font-size: x-small;
}

.Footer .Disclaimer {
    font-style: italic;
}

.Footer p {
    margin: 3px;
}
</pre>

</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>