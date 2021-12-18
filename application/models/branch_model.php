<?php 

/**
 * the exchange_info database files 
 */
class Branch_Model extends MY_Model {
		
	const DB_TABLE = 'branch';
	const DB_TABLE_PK = 'id';	
		
	public $id;

	public function create_branch($data){
		
		$this->db->insert('branch',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	
	public function branch_detail(){
			
		$this->load->database();
		
		$query = $this->db->get('branch');
		
		return $query->result();
	}

	public function select_all_branch(){
		
		//exchange_info.id,exchange_info.registration_no,exchange_info.branch_name,exchange_info.application_date,exchange_info.applicant_name,exchange_info.account_no,exchange_info.amount_in_no,exchange_info.amount_in_word,exchange_info.tin_no,exchange_info.nbe_account_no,exchange_info.mode_of_payment,exchange_info.proforma_invoice_no,exchange_info.proforma_invoice_date,exchange_info.proforma_invoice_amount,exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");
	
		$query = $this->db->get('branch');
		
		return $query->result();
	}
	
	public function select_branch(){
		
		//exchange_info.id,exchange_info.registration_no,exchange_info.branch_name,exchange_info.application_date,exchange_info.applicant_name,exchange_info.account_no,exchange_info.amount_in_no,exchange_info.amount_in_word,exchange_info.tin_no,exchange_info.nbe_account_no,exchange_info.mode_of_payment,exchange_info.proforma_invoice_no,exchange_info.proforma_invoice_date,exchange_info.proforma_invoice_amount,exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");
		
		$sess_branch = $this->session->userdata['logged_in']['branch'];
		
		$query = $this->db->get('branch');
		
		$this->db->where('branch',$sess_branch);
		
		return $query->result();
	}
}




?>