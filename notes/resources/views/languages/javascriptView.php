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
    	<h3 class="panel-title">Professional JavaScript for Web Developers (3rd Edition)</h3>
    </div><!--end panel-heading-->
    
	<div class="panel-body">
        <ol>    
           <li><a href="/javascript/pro-js-for-web-developers/what-is-javascript">What Is JavaScript</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/javascript-in-html">JavaScript in HTML</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/language-basics">Language Basics</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/variables-scope-memory">Variables, Scope, and Memory</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/reference-types">Reference Types</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/object-oriented-programming">Object-Oriented Programming</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/function-expressions">Function Expressions</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/browser-object-model">The Browser Object Model</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/client-detection">Client Detection</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/document-object-model">The Document Object Model</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/dom-extensions">DOM Extensions</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/dom-levels-2-3">DOM Levels 2 and 3</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/events">Events</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/scripting-forms">Scripting Forms</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/graphics-with-canvas">Graphics with Canvas</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/html5-scripting">HTML5 Scripting</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/error-handling">Error Handling and Debugging</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/xml">XML in JavaScript</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/ecmascript-xml">ECMAScript for XML</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/json">JSON</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/ajax-comet">Ajax and Comet</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/advanced-techniques">Advanced Techniques</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/offline-applications">Offline Applications and Client-Side Storage</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/best-practices">Best Practices</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/emerging-apis">Emerging APIs</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/ecmascript-harmony">ECMAScript Harmony</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/strict-mode">Strict Mode</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/js-libraries">JavaScript Libraries</a></li>
           <li><a href="/javascript/pro-js-for-web-developers/js-tools">JavaScript Tools</a></li>
       </ol> 

	</div><!--end panel body-->
</div><!--end panel-->






<pre class="prettyprint lang-js">
public void Page_Load(Object sender, EventArgs e)
{
    String csname1 = "XssScript";
    Type cstype = this.GetType();
    
    ClientScriptManager cs = Page.ClientScript;
    
    if(!cs.IsStartupScriptRegistered(cstype, scname1))
    {
        String cstext1 = "Form1.Message.onmouseover=function(){"+
            Request.QueryString["data"] + "}";
        cs.RegisterStartupScript(cstype, scname1, cstext1, true);
    }
}
</pre>
    </div>

<?php require_once(assets("includes/footer.php")); ?>