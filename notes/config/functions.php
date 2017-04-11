<?php
function assets($asset){
	$path = "resources/assets/" . $asset;
	return $path;
}


function checkActiveLink($body_class, $link){
	if($body_class == $link){
		echo "class='active'";
	}else{
		echo "";	
	}
}

function checkDropDownLink($body_class){
	$drop_down_array = array(
		'html',
		'css',
		'javascript',
		'jquery',
		'mysql',
		'php',
		'cplusplus'
	);
	if(in_array($body_class, $drop_down_array)){
		echo " active";
	}else{
		echo "";
	}
}
?>