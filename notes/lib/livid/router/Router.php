<?php
namespace livid\router;


class Router {
	
	private $routes = array();
	private $current_url;
	
	private $current_route;
	private $not_found;
	private $error_message;
	
	public function __construct(){
		if($_SERVER['REQUEST_URI'] != '/'){
			$this->current_url = preg_replace('{/$}', '', $_SERVER['REQUEST_URI']);
		}else{
			$this->current_url = $_SERVER['REQUEST_URI'];
		}
	}
	
	public function add($url, $action){
		$this->routes[$url] = $action;
	}
	
	public function get(){
		return $this->routes;	
	}
	
	public function currentUrl(){
		return $this->current_url;	
	}
	
	public function dispatch(){
		if(array_key_exists($this->current_url, $this->routes)){

			foreach($this->routes as $route => $action){
				if($this->current_url == $route){
					$this->current_route = $route;
					
					$controller = substr($action, 0, strpos($action, '@'));
					
					$method = substr($action, strpos($action, "@") + 1);

				}
			}

			$this->not_found = FALSE;
			
			$path = "livid\\controllers\\" . $controller;
			
			//check that class exists
			if(class_exists($path)){
				$new_controller = new $path;
				
				//check that method exists and is callable
				if(method_exists($new_controller, $method) && is_callable(array($new_controller, $method))){
					$get = explode("/", $this->current_route, 3);
					if(isset($get[2])){
						$new_controller->$method($get[2]);
					}else{
						$new_controller->$method();
					}
				}else{
					$this->not_found = TRUE;
					$this->error_message = "The method \"$method\" either does not exists or is not callable.";	
				}
			}else{
				$this->not_found = TRUE;
				$this->error_message = "The class \"$controller\" does not exist.";	
			}		
			
		}else{
			$this->not_found = TRUE;
			$this->error_message = "Invalid Route Entered.";
		}
		
		if($this->not_found == TRUE){
			echo "<h2>" . $this->error_message . "</h2>";
		}
	}
	
}//end of class
?>