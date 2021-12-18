<?php 

/**
 * the exchange_info database files 
 */
class Shareholder_Model extends MY_Model {
		
	const DB_TABLE = 'shareholders';
	const DB_TABLE_PK = 'account_no';	

	//exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");
	
	
	public $id;
	//public $registration_no;
	public $prefix;
	public $branch_name;
	public $application_date;
	public $applicant_name;
	public $account_no;
	public $amount_in_no;
	public $amount_in_word;
	public $tin_no;
	public $nbe_account_no;
	public $mode_of_payment;
	public $proforma_invoice_no;
	public $proforma_invoice_date;
	public $proforma_invoice_amount;
	public $supplier_name;
	public $description;
	public $requested_by;
	public $approved_by;
	public $approved_date;
	public $status;
	public $priority;
	public $remark;
	
	//public $id;
	
	
	public function create_reason($data){
		
		$this->db->where('id', $data['id']);
		
		$this->db->update('shareholders', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	public function edit_balance($data){
		
		$this->db->where('account', $data['account']);
		
		$this->db->update('balance', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	
	public function edit_shareholder($data){
		
		$this->db->where('account_no', $data['account_no']);		
		$this->db->update('shareholders', $data); 
		// var_dump($data);
		if($this->db->affected_rows() > 0){
			return true;
		}
			return false;
}
public function edit_shareholder_address($data){
		
	$this->db->where('account', $data['account']);		
	$this->db->update('shareholder_address', $data); 
	
	if($this->db->affected_rows() > 0){
		// var_dump($data);
		return true;
	}
		return false;
	
}
	public function get_customer($data){
		
		
		if($this->db->get_where('shareholders',array('account_no'=>$data['account_no']))->result()) {
				
			return true;
			
		}
		return false;
	
}
	
	public function edit_authorised_data($data){
		
		$this->db->where('id', $data['id']);
		
		$this->db->update('exchange_info', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}

public function create_new_shareholder($data){
		
	$this->db->insert('shareholders',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
	// $conn=mysqli_connect('localhost','root','','shareholder');	
	// 	$shareholders = mysqli_query($conn,"INSERT INTO shareholders (account_no,name, total_share_subscribed,total_paidup_capital_inbirr,share_type,city,sub_city,woreda,house_no,pobox,telephone_residence,telephone_office,mobile,member,remark,status_of_new_share,year,data_created_at,data_created_by,type_of_creation) 
	// 									VALUES ('".$data['account_no']."','".$data['name']."','".$data['total_share_subscribed']."','".$data['total_paidup_capital_inbirr']."','".$data['share_type']."','".$data['city']."','".$data['sub_city']."','".$data['woreda']."','".$data['house_no']."','".$data['pobox']."','".$data['telephone_residence']."','".$data['telephone_office']."','".$data['mobile']."','".$data['member']."','".$data['remark']."','".$data['status_of_new_share']."','".$data['year']."','".$data['data_created_at']."','".$data['data_created_by']."','".$data['type_of_creation']."')"
	// ) or die(mysqli_error($conn));

	// 	if(!$shareholders)
	// 	{
	// 		return false;
	// 	}
	// 	else{
	// 		return true;
	// 	}

}
public function create_shareholder_address($data){
				
	$this->db->insert('shareholder_address',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
	}
public function create_balance($data){
				
		$this->db->insert('balance',$data);
			
			if($this->db->affected_rows() > 0){
				
				return true;
			}
				return false;
}
public function create_share_transfer_status($data){
	   $conn=mysqli_connect('localhost','root','','shareholder');	
		$share_transfer_status = "check transfer";

		$account_no = $data['account_no'];

		$shareholders = mysqli_query($conn,"UPDATE shareholders set share_transfer_status = '$share_transfer_status' WHERE account_no = '$account_no'") or die(mysqli_error($conn));

		if(!$shareholders)
		{
			return false;
		}
		else{
			return true;
		}

}
public function create_transfer_from_nib($data){
	 $conn=mysqli_connect('localhost','root','','shareholder');
		$year = date('Y-m-d');
		$transfer_date = date('Y-m-d');
		$account_no = $data['account_no'];
		$name = $data['name'];
		$total_share_subscribed = $data['total_share_subscribed'];
		$total_share_in_birr = $data['total_share_subscribed']*500;
		$buyyer_paidup_in_birr =  $data['total_paidup_capital_inbirr']*500;
		$seller_paidup_in_birr = 'NIB';
		$pervalue = '500';
		$agreement = 'buyer';
		$agred_to = $data['account_no'];
		$transfer_type = 'sale';
		$value_date = $data['value_date'];
		
		$transfer = mysqli_query($conn,"INSERT INTO transfer (
														account_no,
														total_share, 
														name,
														raccount_no,
														rname,
														rtotal_share,
														total_share_transfered,
														total_transfered_in_birr,
														buyyer_paidup_in_birr,
														seller_paidup_in_birr,
														transfer_date,
														value_date,
														pervalue,
														status_of_transfer,
														year,
														agreement,
														agred_to,
														both_seller,
														both_buyer,
														transfer_type
														) 
										VALUES (
														'NIB',
														'NIB',
														'NIB',
														'$account_no',
														'$name',
														'$total_share_subscribed',
														'$total_share_subscribed',
														'$total_share_in_birr',
														'$buyyer_paidup_in_birr',
														'$seller_paidup_in_birr',
														'$transfer_date',
														'$value_date',
														'$pervalue',
														'pending',
														'$year',
														'buyer',
														'$account_no',
														'',
														'',
														'$transfer_type'
														)"
	) or die(mysqli_error($conn));

		if(!$transfer)
		{
			return false;
		}
		else{
			return true;
		}
}

public function check_account_no($data){
	 $conn=mysqli_connect('localhost','root','','shareholder');
		$check = mysqli_query($conn,"SELECT * FROM shareholders WHERE account_no =".$data['account_no']);
		
		$count = mysqli_num_rows($check);

		if($count > 0){
			
			return true;
		}
			return false;
	
}

public function select_budget_year(){
		
		//exchange_info.id,exchange_info.registration_no,exchange_info.branch_name,exchange_info.application_date,exchange_info.applicant_name,exchange_info.account_no,exchange_info.amount_in_no,exchange_info.amount_in_word,exchange_info.tin_no,exchange_info.nbe_account_no,exchange_info.mode_of_payment,exchange_info.proforma_invoice_no,exchange_info.proforma_invoice_date,exchange_info.proforma_invoice_amount,exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");

		$query = $this->db->get_where('budget_year', array('budget_status' => 1));
		
		return $query->result();
	}


public function create_request($data){


		
		$this->db->insert('share_request',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	
	
	
	/*public function authorize_request(){
			
		$this->load->database();
		
		$data = array(
               'status' => 'authorized',
               'approved_by' => $name,
               'approved_date' => $date
            );

		$this->db->where('id', $id);
		
		$query = $this->db->update('exchange_info');
		
		return $query->result();
	}
	*/



}




?>