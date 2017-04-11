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