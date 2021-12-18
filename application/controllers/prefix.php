<?php

session_start(); //we need to start session in order to access it through CI

Class Prefix extends CI_Controller {

public function __construct() {
	
parent::__construct();

// Load form helper library
$this->load->helper('html');
$this->load->helper('form');
$this->load->helper('url');

// Load form validation library
$this->load->library('form_validation');

// Load session library
$this->load->library('session');

// Load database
$this->load->model('prefix_model');
}
public function index(){
	
	$this->load->library('pagination');
	$this->load->model('prefix_model');
	$data['query'] = $this->prefix_model->prefix_detail();
	$config['base_url'] = 'http://127.0.0.1/foreign/';
	$config['total_rows'] = $this->db->get('prefix')->num_rows();
	$config['per_page'] = 10;
	$config['num_links'] = 5;
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>'; 
	$this->pagination->initialize($config);
	$data['records'] = $this->db->get('prefix',$config['per_page'],$this->uri->segment(3));
	$this->load->view('prefix/index',$data);

}

// Validate and store registration data in database
public function new_prefix_registration() {

//exchange_info.proforma_invoice_amount,exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");
	
	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	$this->form_validation->set_rules('code','code','trim|required|xss_clean');
	$this->form_validation->set_rules('branch','branch','trim|required|xss_clean');
	$this->form_validation->set_rules('status','status','trim|required|xss_clean');
	

if ($this->form_validation->run() == FALSE) 
	{
	$this->load->view('foreign/prefix');
	
	} 
else {
	$data = array(
	
	'code' => $this->input->post('code'),
	'branch' => $this->input->post('branch'),
	'status' => $this->input->post('stauts')
	
	);
	
$result = $this->prefix_model->create_prefix($data);

if ($result == TRUE) 
	{
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/new_prefix', $data);
	//print_r($data);
	} 
else 
	{
	$data['message_display'] = 'There is a problem of creating Request!';
	$this->load->view('foreign/new_prefix', $data);
	}
}
}
}

?>