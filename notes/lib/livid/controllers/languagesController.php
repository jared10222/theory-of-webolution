<?php
namespace livid\controllers;
use livid\controllers\Controller;

class languagesController extends Controller {
	
	public function html($notes = NULL){

		$data = array(
			'title' => 'HTML',
			'body_class' => 'html'
		);
		
		if($notes != NULL){
			return parent::view('languages.html.'.$notes, $data);
		}else{
			return parent::view('languages.html', $data);
		}
	}
	
	public function css($notes = NULL){
		$data = array(
			'title' => 'CSS',
			'body_class' => 'css'
		);
		if($notes != NULL){
			return parent::view('languages.css.'.$notes, $data);
		}else{
			return parent::view('languages.css', $data);
		}
	}
	
	public function javascript($notes = NULL){
		$data = array(
			'title' => 'JavaScript',
			'body_class' => 'javascript'
		);
		if($notes != NULL){
			return parent::view('languages.javascript.'.$notes, $data);
		}else{
			return parent::view('languages.javascript', $data);
		}
	}
	
	public function jquery(){
		$data = array(
			'title' => 'jQuery',
			'body_class' => 'jquery'
		);
		return parent::view('languages.jquery', $data);
	}
	
	public function mysql(){
		$data = array(
			'title' => 'MySQL',
			'body_class' => 'mysql'
		);
		return parent::view('languages.mysql', $data);
	}
	
	public function php($notes = NULL){
		$data = array(
			'title' => 'PHP',
			'body_class' => 'php'
		);
		
		if($notes != NULL){
			return parent::view('languages.php.'.$notes, $data);
		}else{
			return parent::view('languages.php', $data);
		}
	}
	
	public function cplusplus(){
		$data = array(
			'title' => 'C++',
			'body_class' => 'cplusplus'
		);
		return parent::view('languages.cplusplus', $data);
	}
	
	
	public function xml($notes = NULL){
		$data = array(
			'title' => 'XML',
			'body_class' => 'xml'
		);
		
		if($notes != NULL){
			return parent::view('languages.xml.'.$notes, $data);
		}else{
			return parent::view('languages.xml', $data);
		}
	}
	
	
	public function java($notes = NULL){
		$data = array(
			'title' => 'Java',
			'body_class' => 'java'
		);
		
		if($notes != NULL){
			return parent::view('languages.java.'.$notes, $data);
		}else{
			return parent::view('languages.java', $data);
		}
	}
	
	
	public function csharp($notes = NULL){
		$data = array(
			'title' => 'C#',
			'body_class' => 'csharp'
		);
		
		if($notes != NULL){
			return parent::view('languages.csharp.'.$notes, $data);
		}else{
			return parent::view('languages.csharp', $data);
		}
	}
	
	
}
?>