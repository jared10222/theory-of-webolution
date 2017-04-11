<?php
namespace livid\controllers;
use livid\controllers\Controller;

class indexController extends Controller {
	
	public function home(){
		$data = array(
			'body_class' => 'index',
			'site_text' => 'A Framework For Everyone',
			'site_desc' => 'Welcome to the Livid Framework! This framework is built for hardcore PHP developers who do not want to waste time with inferior frameworks. We hope that you enjoy it!'
			);
		return parent::view('home.home', $data);
	}
	
	public function tutorials($tutorials = NULL){
		
		$data = array(
				'body_class' => 'tutorials'
			);
			
		if($tutorials != NULL){
			return parent::view('tutorials.'.$tutorials, $data);
		}else{
			return parent::view('tutorials', $data);
		}
	}
	
	public function design($notes = NULL){
		$data = array(
			'body_class' => 'design'
		);
		if($notes != NULL){
			return parent::view('design.'.$notes, $data);
		}else{
			return parent::view('design', $data);
		}
	}
	
	public function links($notes = NULL){
		$data = array(
			'body_class' => 'links'
		);
		if($notes != NULL){
			return parent::view('links.'.$notes, $data);
		}else{
			return parent::view('links', $data);
		}
	}
	
	
	public function feed($notes = NULL){
		$data = array(
			'body_class' => 'feed'
		);
		if($notes != NULL){
			return parent::view('feed.'.$notes, $data);
		}else{
			return parent::view('feed', $data);
		}
	}
}
?>