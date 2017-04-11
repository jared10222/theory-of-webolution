    <footer class="footer">
      <div class="container">
      <?php
	  $year = date('Y');
	  ?>
        <p class="text-muted">&copy;2012 - <?php echo $year; ?> Powered by Livid Framework</p>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo assets("js/vendor/jquery.min.js"); ?>"><\/script>')</script>
    <script src="/resources/assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/resources/assets/js/ie10-viewport-bug-workaround.js"></script>
    
    <!--<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>-->
    <!--<script src="<?php //echo assets("js/run_prettify.js"); ?>:"></script>-->
    <script src="/resources/assets/js/prettify.js"></script>
    <script src="/resources/assets/js/lang-css.js"></script>
    <script src="/resources/assets/js/lang-sql.js"></script>
    <script>
	$(document).ready(function() {
        prettyPrint();
    });
	</script>
  </body>
</html>