<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?php echo $title; ?></h1>
      </div>
      <p class="lead"></p>
      
<pre class="prettyprint lang-js">
$(document).ready(function(){
    $("button").click(function(){
        $("p").toggle();
    });
});//end ready

</pre>
    </div>

<?php require_once(assets("includes/footer.php")); ?>