<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?php echo $title; ?></h1>
      </div>
      <p class="lead"></p>
      
<pre class="prettyprint lang-xml">
&lt;xml version="1.0">
&lt;catalog>
    &lt;book id="bk101">
        &lt;author>Gambardella, Matthew&lt;/author>
        &lt;title>XML Developer's Guide&lt;/title>
        &lt;genre>Computer&lt;/genre>
        &lt;price>44.99&lt;/price>
        &lt;publish_date>2000-10-01&lt;/publish_date>
        &lt;description>An in-depth look at creating applications with XML&lt;/description>
    &lt;/book>
&lt;/catalog>
</pre>
    </div>

<?php require_once(assets("includes/footer.php")); ?>