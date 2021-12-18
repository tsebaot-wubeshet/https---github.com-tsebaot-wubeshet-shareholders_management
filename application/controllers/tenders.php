<?php

session_start(); //we need to start session in order to access it through CI

Class Tenders extends CI_Controller {

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
$this->load->model('tenders_model');
}
public function index(){
	
	$this->load->library('pagination');
	$this->load->model('tenders_model');
	$data['query'] = $this->tenders_model->tender_detail();
	$this->load->model('category');
	$category = new Category();
	$data['category'] = $this->category->category_detail();
	$config['base_url'] = 'http://127.0.0.1/fetanjobs/index.php/tenders/index';
	$config['total_rows'] = $this->db->get('tender')->num_rows();
	$config['per_page'] = 5;
	$config['num_links'] = 5;
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>'; 
	$this->pagination->initialize($config);
	$data['records'] = $this->db->get('tender',$config['per_page'],$this->uri->segment(3));
	$this->load->view('tender/index',$data);
}
// Show login page
public function detail($id) {
	
	$data = array();
	$tender = new tenders_model();
	$tender->load($id);	
	$data['tender'] = $tender; 
	$this->load->model('category');
	$category = new Category();
	$data['category'] = $this->category->category_detail();
	$this->load->view('tender/tender_detail',$data);
	//$this->load->view('layouts/admin_page');
}

// Show registration page
public function tender_registration_show() {
	$data = array();
    $this->load->model('category');
    $query = $this->category->getAllCategories();
    if ($query)
    {
        $data['records'] = $query;
    }
    
	$this->load->view('tender/new_tender_form',$data);
}

public function view_tender_in_category($id){
		
	$this->load->library('pagination');
	$this->load->model('tenders_model');
	$data['query'] = $this->tenders_model->select_tenders($id);
	
	$config['base_url'] = 'http://127.0.0.1/fetanjobs/index.php/tenders/view_tender_in_category';
	$config['total_rows'] = $this->tenders_model->record_count($id);
	$config['per_page'] = 3;
	$config['num_links'] = 5;

	$this->pagination->initialize($config);
	
	$this->load->model('category');
	$category = new Category();
	$data['category'] = $this->category->category_detail();
	$data['records'] = $this->db->get('tender',$config['per_page'],$this->uri->segment(3));
	$this->pagination->create_links();
	$this->load->view('tender/index',$data);
	
}
 
public function view_tender(){
		
	$this->load->library('pagination');
	$this->load->library('table');
	//$this->table->set_heading('Id','Tender Title');
	
	$config['base_url'] = 'http://127.0.0.1/fetanjobs/index.php/tenders/view_tender';
	$config['total_rows'] = $this->db->get('tender')->num_rows();
	$config['per_page'] = 5;
	$config['num_links'] = 5;
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>'; 
	
	$this->pagination->initialize($config);
	
	$data['records'] = $this->db->get('tender',$config['per_page'],$this->uri->segment(3));
	
	$this->load->view('tender/view_tender',$data);

}

// Validate and store registration data in database
public function new_tender_registration() {

// Check validation for user input in SignUp form
$this->form_validation->set_rules('title','Title','trim|required|xss_clean');
$this->form_validation->set_rules('desc','Desc','trim|required|xss_clean');
$this->form_validation->set_rules('posted_date','Posted_date','trim|required|xss_clean');
$this->form_validation->set_rules('closing_date','Closing_date','trim|required|xss_clean');
$this->form_validation->set_rules('category_id','Category_id','trim|required|xss_clean');
$this->form_validation->set_rules('source','Source','trim|required|xss_clean');
$this->form_validation->set_rules('comp_name','Comp_name','trim|required|xss_clean');
$this->form_validation->set_rules('comp_address','Comp_address','trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) 
	{
	$this->load->view('tender/new_tender_form');
	
	} 
else {
	$data = array(
	
	'title' => $this->input->post('title'),
	'description' => $this->input->post('desc'),
	'posted_date' => $this->input->post('posted_date'),
	'closing_date' => $this->input->post('closing_date'),
	'source' => $this->input->post('source'),
	'category_id' => $this->input->post('category_id'),
	'comp_name' => $this->input->post('comp_name'),
	'comp_address' => $this->input->post('comp_address')
	
	);
	
$result = $this->tenders_model->create_tender($data);

if ($result == TRUE) 
	{
	$data['message_display'] = 'Tender Created Successfully !';
	$this->load->view('tender/new_tender_form', $data);
	//print_r($data);
	} 
else 
	{
	$data['message_display'] = 'There is a problem of creating tender!';
	$this->load->view('tender/new_tender_form', $data);
	}
}
}

// Check for user login process
public function user_login_process() {

$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
if(isset($this->session->userdata['logged_in'])){
$this->load->view('layouts/admin_page');
}else{
$this->load->view('sessions/login_form');
}
} else {
$data = array(
'username' => $this->input->post('username'),
'password' => $this->input->post('password')
);
$result = $this->login_database->login($data);
if ($result == TRUE) {

$username = $this->input->post('username');
$result = $this->login_database->read_user_information($username);
if ($result != false) {
$session_data = array(
'username' => $result[0]->user_name,
'email' => $result[0]->user_email,
);
// Add user data in session
$this->session->set_userdata('logged_in', $session_data);
$this->load->view('layouts/admin_page');
}
} else {
$data = array(
'error_message' => 'Invalid Username or Password'
);
$this->load->view('sessions/login_form', $data);
}
}
}

// Logout from admin page
public function logout() {

// Removing session data
$sess_array = array(
'username' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);
$data['message_display'] = 'Successfully Logout';
$this->load->view('tender/index', $data);

}
}

?>