<?php
function checkActiveLink($body_class, $link){
	if($body_class == $link){
		return "active";
	}else{
		return "";
	}
}

function redirect($url){
	header('Location: ' . $url);
}
?>