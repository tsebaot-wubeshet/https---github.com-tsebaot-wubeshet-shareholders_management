<?php 

/**
 * a class to handle the job 
 */
class Jobs extends CI_Controller {
	
	function index(){
		
		$this->load->helper('url');
		$this->load->view('/templates/header');
		$this->load->view('/content/index');
		$this->load->view('/templates/footer');
		
	}
}
