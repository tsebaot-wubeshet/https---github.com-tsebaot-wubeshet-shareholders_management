<?php

session_start(); //we need to start session in order to access it through CI

Class Foreign extends CI_Controller {

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
$this->load->model('foreign_model');
$this->load->model('prefix_model');
$this->load->model('branch_model');
$this->load->model('priority_model');
$this->load->model('login_database');

}
public function index(){
	
	/*
	$this->load->library('pagination');
	$this->load->model('foreign_model');
	$data['query'] = $this->foreign_model->foreign_detail();
	$config['base_url'] = 'http://127.0.0.1/foreign/';
	$config['total_rows'] = $this->db->get('exchange_info')->num_rows();
	$config['per_page'] = 10;
	$config['num_links'] = 5;
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>'; 
	$this->pagination->initialize($config);
	$data['records'] = $this->db->get('exchange_info',$config['per_page'],$this->uri->segment(3));
	$this->load->view('foreign/index',$data);
	
	 */
	 $this->load->helper('url');
	 $this->load->view('sessions/login_form');
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
public function convertnum() {
	$this->load->view('foreign/convertnum');
}
public function allocated() {
	$this->load->view('foreign/allocated');
}
public function allocate_money() {
	$this->load->view('foreign/allocate_money');
}
public function listed() {
	$this->load->view('foreign/listed');
}
public function upload_user() {
	$this->load->view('foreign/upload_user');
}
public function upload_branch() {
	$this->load->view('foreign/upload_branch');
}
public function register() {
	$this->load->view('foreign/register');
}
public function returned() {
	$this->load->view('foreign/returned');
}
public function reprint() {
	$this->load->view('foreign/reprint');
}
public function allocated_list() {
	$this->load->view('foreign/allocated_list');
}

public function editrequest() {
	$this->load->view('foreign/edit');
}
public function returnedtorequest() {
	$this->load->view('foreign/returnedtorequest');
}
public function npregister() {
	$this->load->view('foreign/npregister');
}

public function authorize() {
	$this->load->view('foreign/authorize');
}
public function canvassing_excel() {
	$this->load->view('foreign/canvassing_excel');
}

public function authorize_request() {

	$this->load->view('foreign/slipprint');
	
}

public function tradefinance() {
	
	$this->load->view('foreign/tradefinance');
}

public function transfer_blocked_message() {
	
	$this->load->view('foreign/transfer_blocked_message');
}

public function authorized() {
	
	$this->load->view('foreign/authorized');
}

public function audit() {
	
	$this->load->view('foreign/audit');
}
public function audited() {
	
	$this->load->view('foreign/audited');
}

public function add_prefix() {
	
	$this->load->view('foreign/add_prefix');
}

public function branch() {
	
	$this->load->view('foreign/branch');
}

public function priority() {
	
	$this->load->view('foreign/priority');
}

public function changepass() {
	
	$this->load->view('sessions/changepass');
}

public function allocate_lists_for_manager(){
	$this->load->view('foreign/allocate_lists_for_manager');
}
public function editauthorised_request(){
	$this->load->view('foreign/editauthorize');
}
public function allocatedlist(){
	$this->load->view('foreign/allocatedlist');
}
public function edittf(){
	$this->load->view('foreign/edittf');
}
public function allocatelist(){
	$this->load->view('foreign/allocatelist');
}
// Validate and store registration data in database
public function allocated_request() {

	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
	$this->form_validation->set_rules('id','ID','trim|required|xss_clean');
	$this->form_validation->set_rules('allocated_date','Allocated date','trim|required|xss_clean');
	$this->form_validation->set_rules('allocated_amount','Allocated','trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) 
	{
	echo "error";
	
	} 
else {

	$data = array(
	
	//'registration_no' => $this->input->post('registration_no'),
	'id' => $this->input->post('idnum'),
	'allocated_date' => $this->input->post('allocated_date'),
	'allocated' => $this->input->post('allocated_amount'),
	'status' => $this->input->post('allocate_status')
	
	);

//$registration = $this->foreign_model->select_rforeign($data['registration_no'],$data);

//if($registration == FALSE){
	
$result = $this->foreign_model->create_allocate($data);

if ($result == TRUE) 
	{
	
	$this->load->view('foreign/allocated', $data);
	$data['message_display'] = ' Allocated Successfully !';
	 //redirect(current_url());
	} 
else 
	{
	
	$this->load->view('foreign/allocated', $data);
	$data['message_display'] = 'There is a problem of creating allocation!';	
}
/*} else {
	
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	 //redirect(current_url());
}*/


}
}



public function new_priority() {

// Check validation for user input in SignUp form
$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

$this->form_validation->set_rules('priority', 'priority', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
$this->load->view('foreign/priority');
} else {
$data = array(
'description' => $this->input->post('priority')
);

$result = $this->priority_model->create_priority($data);

if ($result == TRUE) {
	
$data['message_display'] = 'Priority Goods Created Successfully !';
$this->load->view('foreign/priority', $data);
	 //redirect(current_url());

} else {
$data['message_display'] = 'Username already exist!';
$this->load->view('sessions/user', $data);
}
}
}


public function new_branch() {

// Check validation for user input in SignUp form
$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
$this->load->view('foreign/branch');
} else {
$data = array(
'name' => $this->input->post('branch')
);

$result = $this->branch_model->create_branch($data);

if ($result == TRUE) {
	
$data['message_display'] = 'Branch Created Successfully !';
$this->load->view('foreign/branch', $data);
	 //redirect(current_url());

} else {
$data['message_display'] = 'Username already exist!';
$this->load->view('sessions/user', $data);
}
}
}

public function change_pass() {

// Check validation for user input in SignUp form
$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

$this->form_validation->set_rules('newpass', 'New password', 'trim|required|matches[confirmpass]|xss_clean');
$this->form_validation->set_rules('confirmpass', 'Confirm Password', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
	
$this->load->view('sessions/changepass');

} else {
	
$data = array(

'oldpass' => $this->input->post('oldpass'),
'newpass' => $this->input->post('newpass'),
'confirmpass' => $this->input->post('confirmpass'),
'username' => $this->input->post('username')
);

$confirm_pass = $data['confirmpass'];
$username = $data['username'];

if($data['oldpass'] == $data['newpass']){

	$data['message_display'] = 'New password must be different from old password !';
	
} elseif($data['newpass'] != $data['confirmpass']){
	
	$data['message_display'] = 'New password must be the same from confirm password !';
}

$result = $this->login_database->change_pass($confirm_pass,$username);

if ($result == TRUE) {
	
$data['message_display'] = 'Password Changed Successfully !';
$this->load->view('sessions/login_form', $data);
	 //redirect(current_url());

} else {
$data['message_display'] = 'Username already exist!';
$this->load->view('sessions/user', $data);
}
}
}

public function new_prefix() {

// Check validation for user input in SignUp form
$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

$this->form_validation->set_rules('prefix', 'Prefix', 'trim|required|xss_clean');
$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
$this->load->view('foreign/add_prefix');
} else {
$data = array(
'code' => $this->input->post('prefix'),
'branch' => $this->input->post('branch')
);

$result = $this->prefix_model->create_prefix($data);

if ($result == TRUE) {
	
$data['message_display'] = 'Prefix Created Successfully !';
$this->load->view('foreign/add_prefix', $data);
	 //redirect(current_url());

} else {
$data['message_display'] = 'Username already exist!';
$this->load->view('sessions/user', $data);
}
}
}

public function edit_authorised_foreign_registration() {


	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
	/*$this->form_validation->set_rules('prefix','Prefix','trim|required|xss_clean');
	$this->form_validation->set_rules('branch_name','Branch Name','trim|required|xss_clean');
	$this->form_validation->set_rules('application_date','Application date','trim|required|xss_clean');*/
	$this->form_validation->set_rules('applicant_name','Applicant Name','trim|required|xss_clean');
	$this->form_validation->set_rules('account_no','Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_no','Amount in No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_word','Amount in Words','trim|required|xss_clean');
	$this->form_validation->set_rules('tin_no','Tin No','trim|required|xss_clean');
	$this->form_validation->set_rules('currency','Currency','trim|required|xss_clean');
	
	$this->form_validation->set_rules('nbe_account_no','NBE Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('mode_of_payment','Mode of Payment','trim|required|xss_clean');
	//$this->form_validation->set_rules('proforma_invoice_no','Proforma invoice no','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_date','Proforma invoice no','trim|required|xss_clean');
	//$this->form_validation->set_rules('proforma_invoice_amount','Proforma invoice amount','trim|required|xss_clean');
	
	$this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|xss_clean');
	$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
	
	//$this->form_validation->set_rules('priority','Priority','trim|required|xss_clean');
	//$this->form_validation->set_rules('remark','Remark','trim|required|xss_clean');

	
if ($this->form_validation->run() == FALSE) 
	{
	$this->load->view('foreign/register');
	
	} 
else {

	$data = array(
	
	'id' => $this->input->post('id'),
	//'prefix' => $this->input->post('prefix'),
	//'application_time' => $this->input->post('time'),
	//'branch_name' => $this->input->post('branch_name'),
	//'application_date' => $this->input->post('application_date'),
	'applicant_name' => $this->input->post('applicant_name'),
	'account_no' => $this->input->post('account_no'),
	'amount_in_no' => $this->input->post('amount_in_no'),
	'amount_in_word' => $this->input->post('amount_in_word'),
	'tin_no' => $this->input->post('tin_no'),
	'currency' => $this->input->post('currency'),
	'nbe_account_no' => $this->input->post('nbe_account_no'),
	'mode_of_payment' => $this->input->post('mode_of_payment'),
	//'proforma_invoice_no' => $this->input->post('proforma_invoice_no'),
	'proforma_invoice_date' => $this->input->post('proforma_invoice_date'),
	//'proforma_invoice_amount' => $this->input->post('proforma_invoice_amount'),
	'supplier_name' => $this->input->post('supplier_name'),
	'description' => $this->input->post('description'),
	//'requested_by' => $this->input->post('requested_by'),
	//'approved_by' => $this->input->post('approved_by'),
	//'approved_date' => $this->input->post('approved_date'),
	//'status' => $this->input->post('status'),
	//'priority' => $this->input->post('priority'),
	'remark' => $this->input->post('remark')
	
	);

//$registration = $this->foreign_model->select_rforeign($data['registration_no'],$data);

//if($registration == FALSE){
	
$result = $this->foreign_model->edit_authorised_data($data);

if ($result == TRUE) 
	{
	$data['message_display'] = 'Request Edited Successfully !';
	$this->load->view('foreign/authorized', $data);
	 //redirect(current_url());
	} 
else
	{
	$data['message_display'] = 'There is a problem of creating Request!';
	$this->load->view('foreign/register', $data);
	}
/*} else {
	
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	 //redirect(current_url());
}*/
}
}


public function edit_tf_list() {


	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
	/*$this->form_validation->set_rules('prefix','Prefix','trim|required|xss_clean');
	$this->form_validation->set_rules('branch_name','Branch Name','trim|required|xss_clean');
	$this->form_validation->set_rules('application_date','Application date','trim|required|xss_clean');*/
	$this->form_validation->set_rules('applicant_name','Applicant Name','trim|required|xss_clean');
	$this->form_validation->set_rules('account_no','Account No','trim|required|xss_clean');

	$this->form_validation->set_rules('loan','Loan','trim|required|xss_clean');
	$this->form_validation->set_rules('deposit','Deposit','trim|required|xss_clean');
	$this->form_validation->set_rules('account_active_period','account_active_period','trim|required|xss_clean');


	$this->form_validation->set_rules('amount_in_no','Amount in No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_word','Amount in Words','trim|required|xss_clean');
	$this->form_validation->set_rules('tin_no','Tin No','trim|required|xss_clean');
	$this->form_validation->set_rules('currency','Currency','trim|required|xss_clean');
	
	$this->form_validation->set_rules('nbe_account_no','NBE Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('mode_of_payment','Mode of Payment','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_no','Proforma invoice no','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_date','Proforma invoice no','trim|required|xss_clean');
	//$this->form_validation->set_rules('proforma_invoice_amount','Proforma invoice amount','trim|required|xss_clean');
	
	$this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|xss_clean');
	$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
	
	//$this->form_validation->set_rules('priority','Priority','trim|required|xss_clean');
	//$this->form_validation->set_rules('remark','Remark','trim|required|xss_clean');

	
if ($this->form_validation->run() == FALSE) 
	{
	$this->load->view('foreign/allocated');
	
	} 
else {

	$data = array(
	
	'id' => $this->input->post('id'),
	//'prefix' => $this->input->post('prefix'),
	//'application_time' => $this->input->post('time'),
	//'branch_name' => $this->input->post('branch_name'),
	//'application_date' => $this->input->post('application_date'),
	'applicant_name' => $this->input->post('applicant_name'),
	'account_no' => $this->input->post('account_no'),

	'loan' => $this->input->post('loan'),
	'deposit' => $this->input->post('deposit'),
	//'account_no' => $this->input->post('account_no'),
	'life_time' => $this->input->post('account_active_period'),

	'amount_in_no' => $this->input->post('amount_in_no'),
	'amount_in_word' => $this->input->post('amount_in_word'),
	'tin_no' => $this->input->post('tin_no'),
	'currency' => $this->input->post('currency'),
	'nbe_account_no' => $this->input->post('nbe_account_no'),
	'mode_of_payment' => $this->input->post('mode_of_payment'),
	'proforma_invoice_no' => $this->input->post('proforma_invoice_no'),
	'proforma_invoice_date' => $this->input->post('proforma_invoice_date'),
	//'proforma_invoice_amount' => $this->input->post('proforma_invoice_amount'),
	'supplier_name' => $this->input->post('supplier_name'),
	'description' => $this->input->post('description'),
	//'requested_by' => $this->input->post('requested_by'),
	//'approved_by' => $this->input->post('approved_by'),
	//'approved_date' => $this->input->post('approved_date'),
	//'status' => $this->input->post('status'),
	//'priority' => $this->input->post('priority'),
	'remark' => $this->input->post('remark')
	
	);

//$registration = $this->foreign_model->select_rforeign($data['registration_no'],$data);

//if($registration == FALSE){
	
$result = $this->foreign_model->edit_tf_data($data);

if ($result == TRUE) 
	{
	$data['message_display'] = 'Request Edited Successfully !';
	$this->load->view('foreign/allocated', $data);
	 //redirect(current_url());
	} 
else
	{
	$data['message_display'] = 'There is a problem of creating Request!';
	$this->load->view('foreign/allocated', $data);
	}
/*} else {
	
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	 //redirect(current_url());
}*/
}
}

public function edit_foreign_registration() {


	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
	/*$this->form_validation->set_rules('prefix','Prefix','trim|required|xss_clean');
	$this->form_validation->set_rules('branch_name','Branch Name','trim|required|xss_clean');
	$this->form_validation->set_rules('application_date','Application date','trim|required|xss_clean');*/
	$this->form_validation->set_rules('applicant_name','Applicant Name','trim|required|xss_clean');

	$this->form_validation->set_rules('account_no','Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('loan','Loan','trim|required|xss_clean');
	$this->form_validation->set_rules('deposit','Deposit','trim|required|xss_clean');
	$this->form_validation->set_rules('account_active_period','account_active_period','trim|required|xss_clean');

	$this->form_validation->set_rules('amount_in_no','Amount in No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_word','Amount in Words','trim|required|xss_clean');
	$this->form_validation->set_rules('tin_no','Tin No','trim|required|xss_clean');
	$this->form_validation->set_rules('currency','Currency','trim|required|xss_clean');
	
	$this->form_validation->set_rules('nbe_account_no','NBE Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('mode_of_payment','Mode of Payment','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_no','Proforma invoice no','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_date','Proforma invoice no','trim|required|xss_clean');
	//$this->form_validation->set_rules('proforma_invoice_amount','Proforma invoice amount','trim|required|xss_clean');
	
	$this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|xss_clean');
	$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
	
	//$this->form_validation->set_rules('priority','Priority','trim|required|xss_clean');
	//$this->form_validation->set_rules('remark','Remark','trim|required|xss_clean');

	
if ($this->form_validation->run() == FALSE) 
	{
	$this->load->view('foreign/register');
	
	} 
else {

	$data = array(
	
	'id' => $this->input->post('id'),
	//'prefix' => $this->input->post('prefix'),
	//'application_time' => $this->input->post('time'),
	//'branch_name' => $this->input->post('branch_name'),
	//'application_date' => $this->input->post('application_date'),
	'applicant_name' => $this->input->post('applicant_name'),

	'loan' => $this->input->post('loan'),
	'deposit' => $this->input->post('deposit'),
	'account_no' => $this->input->post('account_no'),
	'life_time' => $this->input->post('account_active_period'),

	'amount_in_no' => $this->input->post('amount_in_no'),
	'amount_in_word' => $this->input->post('amount_in_word'),
	'tin_no' => $this->input->post('tin_no'),
	'currency' => $this->input->post('currency'),
	'nbe_account_no' => $this->input->post('nbe_account_no'),
	'mode_of_payment' => $this->input->post('mode_of_payment'),
	'proforma_invoice_no' => $this->input->post('proforma_invoice_no'),
	'proforma_invoice_date' => $this->input->post('proforma_invoice_date'),
	//'proforma_invoice_amount' => $this->input->post('proforma_invoice_amount'),
	'supplier_name' => $this->input->post('supplier_name'),
	'description' => $this->input->post('description'),
	//'requested_by' => $this->input->post('requested_by'),
	//'approved_by' => $this->input->post('approved_by'),
	//'approved_date' => $this->input->post('approved_date'),
	//'status' => $this->input->post('status'),
	//'priority' => $this->input->post('priority'),
	'remark' => $this->input->post('remark')
	
	);

//$registration = $this->foreign_model->select_rforeign($data['registration_no'],$data);

//if($registration == FALSE){
	
$result = $this->foreign_model->edit_data($data);

if ($result == TRUE) 
	{
	$data['message_display'] = 'Request Edited Successfully !';
	$this->load->view('foreign/listed', $data);
	 //redirect(current_url());
	} 
else
	{
	$data['message_display'] = 'There is a problem of creating Request!';
	$this->load->view('foreign/register', $data);
	}
/*} else {
	
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	 //redirect(current_url());
}*/
}
}


public function request_exists($key)
{
    $this->foreign_model->request_exists($key);
}
// Validate and store registration data in database
public function new_foreign_registration() {


	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
	$this->form_validation->set_rules('prefix','Prefix','trim|required|xss_clean');
	$this->form_validation->set_rules('branch_name','Branch Name','trim|required|xss_clean');
	$this->form_validation->set_rules('application_date','Application date','trim|required|xss_clean');
	$this->form_validation->set_rules('applicant_name','Applicant Name','trim|required|xss_clean');
	$this->form_validation->set_rules('account_no','No of Accounts','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_no','Amount in No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_word','Amount in Words','trim|required|xss_clean');
	$this->form_validation->set_rules('tin_no','Tin No','trim|required|xss_clean|callback_check_deposit');
	
	$this->form_validation->set_rules('currency','Currency','trim|required|xss_clean');
	
	$this->form_validation->set_rules('nbe_account_no','NBE Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('mode_of_payment','Mode of Payment','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_no','Proforma invoice no','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_date','Proforma invoice no','trim|required|xss_clean');
	$this->form_validation->set_rules('loan','Outstanding Loan Balance','trim|required|xss_clean');
	$this->form_validation->set_rules('deposit','Deposit Balance','trim|required|xss_clean');
	$this->form_validation->set_rules('account_active_period','Account Life Time','trim|required|xss_clean');
	//$this->form_validation->set_rules('proforma_invoice_amount','Proforma invoice amount','trim|required|xss_clean');
	
	$this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|xss_clean');
	$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
	
	$this->form_validation->set_rules('priority','Priority','trim|required|xss_clean');
	//$this->form_validation->set_rules('remark','Remark','trim|required|xss_clean');
	
	
	
if ($this->form_validation->run() == FALSE) 
	{
	  $this->load->view('foreign/register');
	
	} else {

	$data = array(
	
	//'registration_no' => $this->input->post('registration_no'),
	'prefix' => $this->input->post('prefix'),
	'application_time' => $this->input->post('time'),
	'branch_name' => $this->input->post('branch_name'),
	'application_date' => $this->input->post('application_date'),
	'applicant_name' => $this->input->post('applicant_name'),
	'account_no' => $this->input->post('account_no'),
	'amount_in_no' => $this->input->post('amount_in_no'),
	'amount_in_word' => $this->input->post('amount_in_word'),
	'tin_no' => $this->input->post('tin_no'),
	'currency' => $this->input->post('currency'),
	'nbe_account_no' => $this->input->post('nbe_account_no'),
	'mode_of_payment' => $this->input->post('mode_of_payment'),
	'proforma_invoice_no' => $this->input->post('proforma_invoice_no'),
	'proforma_invoice_date' => $this->input->post('proforma_invoice_date'),
	//'proforma_invoice_amount' => $this->input->post('proforma_invoice_amount'),
	'loan' => $this->input->post('loan'),
	'deposit' => $this->input->post('deposit'),
	'life_time' => $this->input->post('account_active_period'),
	'supplier_name' => $this->input->post('supplier_name'),
	'description' => $this->input->post('description'),
	'requested_by' => $this->input->post('requested_by'),
	'approved_by' => $this->input->post('approved_by'),
	'approved_date' => $this->input->post('approved_date'),
	'status' => $this->input->post('status'),
	'priority' => $this->input->post('priority'),
	'remark' => $this->input->post('remark')
	
	);



$result = $this->foreign_model->check_deposit($data['tin_no']);		

if($result == TRUE){
		
		$check_tin = $this->foreign_model->count_tin($data['tin_no']);

	if($check_tin == 3){

		$this->session->set_flashdata('flashError', 'You have registered 3 performas!please wait for allocation');
		redirect('foreign/register');
	}

$result = $this->foreign_model->create_foreign($data);
	
if ($result == TRUE) 
	{
	$data['message_success'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	
} 
else 
	{
	$data['message_display'] = 'There is a problem of creating Request!';
	$this->load->view('foreign/register', $data);
	}
}
else{
	
	
	$result = $this->foreign_model->tin_exists($data['tin_no']);
	
	if($result == FALSE){
		
	$result2 = $this->foreign_model->create_foreign($data);
	
	if($result2 == TRUE)	{
		
	$data['message_success'] = 'Request Created Successfully !!';	
	$this->load->view('foreign/register', $data);	
	
	/*
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);*/
	 //redirect(current_url());
	 }else{
	 	/*
		$data['message_display'] = 'Tin No Already Exist !';
		$this->load->view('foreign/register', $data);	
		*/
	 	$data['message_display'] = 'There is a problem of creating Request!';
		$this->load->view('foreign/register', $data);
	 }
	}
else{
	
	$data['message_display'] = 'Applicant Already Registered in Other Branch! New Registration will not allow until the pending request Allocated';
	$this->load->view('foreign/register', $data);	
}
}

}
}
// Validate and store registration data in database
public function new_foreign_npregistration() {


	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	// Check validation for user input in SignUp form
	//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
	$this->form_validation->set_rules('prefix','Prefix','trim|required|xss_clean');
	$this->form_validation->set_rules('branch_name','Branch Name','trim|required|xss_clean');
	$this->form_validation->set_rules('application_date','Application date','trim|required|xss_clean');
	$this->form_validation->set_rules('applicant_name','Applicant Name','trim|required|xss_clean');
	$this->form_validation->set_rules('account_no','Account No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_no','Amount in No','trim|required|xss_clean');
	$this->form_validation->set_rules('amount_in_word','Amount in Words','trim|required|xss_clean');
	$this->form_validation->set_rules('tin_no','Tin No','trim|required|xss_clean');
	$this->form_validation->set_rules('currency','Currency','trim|required|xss_clean');
	
	$this->form_validation->set_rules('nbe_account_no','NBE Account No','trim|required|xss_clean');
	//$this->form_validation->set_rules('mode_of_payment','Mode of Payment','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_no','Proforma invoice no','trim|required|xss_clean');
	$this->form_validation->set_rules('proforma_invoice_date','Proforma invoice no','trim|required|xss_clean');
	//$this->form_validation->set_rules('proforma_invoice_amount','Proforma invoice amount','trim|required|xss_clean');
	
	$this->form_validation->set_rules('loan','Outstanding Loan Balance','trim|required|xss_clean');
	$this->form_validation->set_rules('deposit','Deposit Balance','trim|required|xss_clean');
	$this->form_validation->set_rules('account_active_period','Account Life Time','trim|required|xss_clean');
	$this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|xss_clean');
	$this->form_validation->set_rules('description','Description','trim|required|xss_clean');
	
	$this->form_validation->set_rules('priority','Priority','trim|required|xss_clean');
	//$this->form_validation->set_rules('remark','Remark','trim|required|xss_clean');

	
if ($this->form_validation->run() == FALSE) 
	{
	$this->load->view('foreign/npregister');
	
	} 
else {

	$data = array(
	
	//'registration_no' => $this->input->post('registration_no'),
	'prefix' => $this->input->post('prefix'),
	'application_time' => $this->input->post('time'),
	'branch_name' => $this->input->post('branch_name'),
	'application_date' => $this->input->post('application_date'),
	'applicant_name' => $this->input->post('applicant_name'),
	'account_no' => $this->input->post('account_no'),
	'amount_in_no' => $this->input->post('amount_in_no'),
	'amount_in_word' => $this->input->post('amount_in_word'),
	'tin_no' => $this->input->post('tin_no'),
	'currency' => $this->input->post('currency'),
	'nbe_account_no' => $this->input->post('nbe_account_no'),
	'mode_of_payment' => $this->input->post('mode_of_payment'),
	'proforma_invoice_no' => $this->input->post('proforma_invoice_no'),
	'proforma_invoice_date' => $this->input->post('proforma_invoice_date'),
	//'proforma_invoice_amount' => $this->input->post('proforma_invoice_amount'),
	'loan' => $this->input->post('loan'),
	'deposit' => $this->input->post('deposit'),
	'life_time' => $this->input->post('account_active_period'),
	'supplier_name' => $this->input->post('supplier_name'),
	'description' => $this->input->post('description'),
	'requested_by' => $this->input->post('requested_by'),
	'approved_by' => $this->input->post('approved_by'),
	'approved_date' => $this->input->post('approved_date'),
	'status' => $this->input->post('status'),
	'priority' => $this->input->post('priority'),
	'remark' => $this->input->post('remark')
	
	);

$result = $this->foreign_model->check_deposit($data['tin_no']);		

if($result == TRUE){
		
		$check_tin = $this->foreign_model->count_tin($data['tin_no']);

	if($check_tin == 3){

		$this->session->set_flashdata('flashError', 'You have registered 3 performas!please wait for allocation');
		redirect('foreign/register');
	}
	
$result = $this->foreign_model->create_foreign($data);
	
if ($result == TRUE) 
	{
	$data['message_success'] = 'Request Created Successfully !';
	$this->load->view('foreign/npregister', $data);
	 //redirect(current_url());
} 
else 
	{
	$data['message_display'] = 'There is a problem of creating Request!';
	$this->load->view('foreign/npregister', $data);
	}
}
else{
	
	
	$result = $this->foreign_model->tin_exists($data['tin_no']);
	
	if($result == FALSE){
		
	$result2 = $this->foreign_model->create_foreign($data);
	
	if($result2 == TRUE)	{
		
	$data['message_success'] = 'Request Created Successfully !!';	
	$this->load->view('foreign/npregister', $data);	
	
	/*
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);*/
	 //redirect(current_url());
	 }else{
	 	/*
		$data['message_display'] = 'Tin No Already Exist !';
		$this->load->view('foreign/register', $data);	
		*/
	 	$data['message_display'] = 'There is a problem of creating Request!';
		$this->load->view('foreign/npregister', $data);
	 }
	}
else{
	
	$data['message_display'] = 'Applicant Already Registered in Other Branch! New Registration will not allow until the pending request Allocated';
	$this->load->view('foreign/npregister', $data);	
}
}

}
}


// Check for user login process
public function user_login_process() {

$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
		
	$this->load->view('sessions/login_form');
}else{
	
$data = array(
'username' => $this->input->post('username'),
'password' => $this->input->post('password')
);


$result = $this->login_database->login($data);
if ($result == TRUE) {

$username = $this->input->post('username');
$result = $this->login_database->read_user_information($username);

if ($result != false) {
	
$session_data = 
array(
'username' => $result[0]->user_name,
'email' => $result[0]->user_email,
'branch' => $result[0]->branch,
'role' => $result[0]->role,
'password' => $result[0]->user_password,

);

// Add user data in session
$this->session->set_userdata('logged_in', $session_data);

if($this->$session_data['password'] == '123456'){
		
	$this->load->view('foreign/changepass');
	
} else{

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
}
// Logout from admin page
public function logout() {

// Removing session data
$sess_array = array(
'username' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);
$data['message_display'] = 'Successfully Logout';
$this->load->view('sessions/login_form', $data);

}
}

?>