<?php
namespace livid\controllers;

class Controller {
	
	
	
	public function view($view, array $data){
		global $site_name;
		
		if(strpos($view, ".") !== false){
			$view = str_replace(".", "/", $view);
		}
		
		$views_path = "resources/views/" . $view . "View.php";
		extract($data);
		
		if(file_exists($views_path)){
		    require_once($views_path);
		}else{
			echo "<h3>View \"" . $view . "View.php\" Does Not Exist!</h3>";	
		}
		
	}
	
}
?>