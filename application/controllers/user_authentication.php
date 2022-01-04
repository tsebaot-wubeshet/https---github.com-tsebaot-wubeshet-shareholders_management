<?php

session_start(); //we need to start session in order to access it through CI
echo "<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>";


class User_Authentication extends CI_Controller
{

	public function __construct()
	{

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
		$this->load->model('login_database');
	}

	// Show login page
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('sessions/login_form');
	}

	// Show registration page
	public function user_registration_show()
	{
		$this->load->helper('url');
		$this->load->view('sessions/user');
	}

	public function user_list()
	{
		$this->load->view('sessions/user_list');
	}
	function auto_logout($field)
	{
		$t = time();
		$t0 = $_SESSION[$field];
		$diff = $t - $t0;
		if ($diff > 1500 || !isset($t0)) {
			return true;
		} else {
			$_SESSION[$field] = time();
		}
	}
	// Validate and store registration data in database
	public function new_user_registration()
	{

		// Check validation for user input in SignUp form
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
		if (!$this->form_validation->run()) {
			$this->load->view('sessions/user');
		} else {
			$data = array(
				'user_name' => $this->input->post('username'),
				'user_password' => $this->input->post('password'),
				'fullname' => $this->input->post('fname'),
				//'lname' => $this->input->post('lname'),
				'role' => $this->input->post('role'),
			);
			$result = $this->login_database->registration_insert($data);
			if ($result == TRUE) {

				$data['message_display'] = 'Registration Successfully !';
				$this->load->view('sessions/user', $data);
			} else {
				$data['message_display'] = 'Username already exist!';
				$this->load->view('sessions/user', $data);
			}
		}
	}

	// Check for user login process
	public function user_login_process()
	{



		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {

			$this->load->view('sessions/login_form');
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

					$session_data =
						array(
							'id' => $result[0]->id,
							'username' => $result[0]->user_name,
							'role' => $result[0]->role,
							'password' => $result[0]->user_password,
						);

					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);

					if ($session_data['password'] == '123456') {

						$this->load->view('sessions/changepass');
					} else {

						$this->load->view('layouts/admin_page');
						// header('location:layouts/admin_page');
					}
				}
			} else {
				$data = array(
					'message_display' => 'Invalid Username or Password'
				);
				$this->load->view('sessions/login_form', $data);
			}
		}
	}

	// Logout from admin page
	public function logout()
	{

		// Removing session data
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('password');



		$data['message_display'] = 'Successfully Logout';
		$this->load->view('sessions/login_form', $data);
	}
}
