<footer>
<article>

<ul id="social">
	<li><a class="share" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Ftheoryofwebolution.com%2F"><i class="fa fa-facebook-square"></i></a></li>
    
    <li><a class="share" href="https://twitter.com/intent/tweet?url=http%3A%2F%2Ftheoryofwebolution.com%2F&text=Theory%20of%20Webolution&hashtags=web,development"><i class="fa fa-twitter-square"></i></a></li>
    
    <li><a class="share" href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Ftheoryofwebolution.com%2F&title=Theory%20of%20Webolution"><i class="fa fa-linkedin-square"></i></a></li>
    
    <li><a class="share" href="https://plus.google.com/share?url=http%3A%2F%2Ftheoryofwebolution.com%2F"><i class="fa fa-google-plus-square"></i></a></li>
    
</ul>


<p>&copy;2016 Theory of Webolution<span class="trademark">&trade;</span> &bull; Website Solutions</p>
</article>
</footer>


	</div><!--end content-->
</div><!--end wrapper-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js">	</script>
    <!--<script src="js/hideMenu.js"></script>-->
    <script type="text/javascript">
    $(document).ready(function() {
    $(function(){
		$('#showPhoneNav').click(function(){
			$("#myNav").slideToggle('normal', function(){ //shows Nav area
				if($('#myNav').is(':visible')){
					$('#showPhoneNav').text('Hide Menu').append(' <i class="fa fa-angle-double-up fa-lg"></i>');
				}else{
					$('#showPhoneNav').text('Show Menu').append(' <i class="fa fa-bars fa-lg"></i>');
				}//end of if
				}); //end of slidetoggle
			}); //end of myNav
		}); //end showPhoneNav
	});
	</script>
		
    <!-- Flex slider-->
	<link rel="stylesheet" href="SliderSupport/flexslider.css" type="text/css">
	<script src="SliderSupport/jquery.flexslider.js"></script>
	<script type="text/javascript">
   	 	$(window).load(function(){
        	$('.flexslider').flexslider({
				animation: "slide"	
			});
   		 });
	</script>

	<!--<script src="js/socialShare.js"></script>-->
    <script type="text/javascript">
	$(document).ready(function(){$('a.share').click(function(){var NWin=window.open($(this).prop('href'),'','height=500,width=500');if(window.focus){NWin.focus();}return false;});});
	</script>
</body>
</html>
<?php ob_end_flush(); ?>