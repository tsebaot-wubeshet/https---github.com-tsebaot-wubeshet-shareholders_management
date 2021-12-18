<?php


class Login extends CI_Controller {
	
	var $name;
	var $color;
	
	 function index(){
		
		$this->load->helper('url');
		$this->load->view('session/login');
	 }
}

?>