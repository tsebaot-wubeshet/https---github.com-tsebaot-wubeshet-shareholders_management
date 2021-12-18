<?php 

/**
 * the exchange_info database files 
 */
class Pledged_Model extends MY_Model {
		
	const DB_TABLE = 'shareholders';
	const DB_TABLE_PK = 'id';	
	
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
	
	public function create_pledge($data){

	$result = mysqli_query($conn,"INSERT INTO pludge (account_no,total_paidup_capital,name,pledged_by,pledged_amount,pledged_status,pldate,pledged_reason,year) VALUES (
		"$data['account_no']","$data['pledgedamount']","$data['name']","$data['pledged_by']","$data['pledged_amount']","$data['status']","$data['pldate']","$data['reason']","$data['year']")") or die(mysqli_error($conn));

		if($this->db->affected_rows() > 0){			
			return true;
		}
			return false;                   		
}
	
	public function edit_data($data){
		
		$this->db->where('id', $data['id']);
		
		$this->db->update('exchange_info', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	public function edit_tf_data($data){
		
		$this->db->where('id', $data['id']);
		
		$this->db->update('exchange_info', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}

	public function edit_shareholder($data){
		
		$this->db->where('id', $data['id']);
		
		$this->db->update('shareholders', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	public function get_customer($data){
		
		$sql="SELECT * FROM shareholders WHERE id = '".$q."'";
		
		$result = mysqli_query($sql);
		
		while($row = mysqli_fetch_array($result)) {
				
			echo $row['account_no'];
			echo $row['total_subscribed_share'];
			
		}
	
}
	
	
	public function edit_authorised_data($data){
		
		$this->db->where('id', $data['id']);
		
		$this->db->update('exchange_info', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	
	public function create_foreign($data){
		
		$this->db->insert('exchange_info',$data);
		
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
}

public function create_request($data){
		
		$this->db->insert('new_request',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	public function select_rforeign($registeration,$data){
		
		//exchange_info.id,exchange_info.registration_no,exchange_info.branch_name,exchange_info.application_date,exchange_info.applicant_name,exchange_info.account_no,exchange_info.amount_in_no,exchange_info.amount_in_word,exchange_info.tin_no,exchange_info.nbe_account_no,exchange_info.mode_of_payment,exchange_info.proforma_invoice_no,exchange_info.proforma_invoice_date,exchange_info.proforma_invoice_amount,exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");
	
		$query = $this->db->query("SELECT * FROM exchange_info WHERE registration_no = '$registeration'");
				
		if($query->num_rows() > 0){
			
		/*$new_reg = $registeration + 1 ;
			
		$data['registration_no'] = $new_reg; */
		
		$this->db->insert('exchange_info',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
	}
	return false;
}	
	public function foreign_detail(){
			
		$this->load->database();
		
		$query = $this->db->get('exchange_info');
		
		return $query->result();
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

	public function select_foreign(){
		
		//exchange_info.id,exchange_info.registration_no,exchange_info.branch_name,exchange_info.application_date,exchange_info.applicant_name,exchange_info.account_no,exchange_info.amount_in_no,exchange_info.amount_in_word,exchange_info.tin_no,exchange_info.nbe_account_no,exchange_info.mode_of_payment,exchange_info.proforma_invoice_no,exchange_info.proforma_invoice_date,exchange_info.proforma_invoice_amount,exchange_info.supplier_name,exchange_info.description,exchange_info.requested_by,exchange_info.approved_by,exchange_info.approved_date,exchange_info.status,exchange_info.remark");
	
		$query = $this->db->get('exchange_info');
		
		$this->db->order_by("application_date", "asc");

		return $query->result();
	}

	public function check_deposit($key){
		
		$query = $this->db->query("SELECT * FROM exchange_info WHERE (tin_no = '$key') AND (status = 'pending' || status = 'authorized') AND (loan > 15000000 || deposit > 10000000)");
    	 
    	if ($query->num_rows() > 0){
    	
        return true;
			
    	}
   		 else
    	{
        return false;
   		 }
}
	public function tin_exists($key){
    	
		
	$query = $this->db->query("SELECT * FROM exchange_info WHERE tin_no = '$key'");
    
    if ($query->num_rows() > 0){
    	
        return true;
    	}
    else
    {
        return false;
    }
}


public function count_tin($tin){
    	
		
	$query = $this->db->query("SELECT * FROM exchange_info WHERE (tin_no = '$tin') AND (status= 'pending' || status = 'authorized')");
    
    if ($query->num_rows() > 0){
    	
        return $query->num_rows();
    }
}

	public function request_exists($key){
    	
		
	$query = $this->db->query("SELECT * FROM exchange_info WHERE tin_no = '$key' and status = 'authorized' || 'pending' and loan < 15000000 || deposit < 10000000 ");
    
    if ($query->num_rows() > 0){
    	
        return true;
    	}
    else
    {
        return false;
    }
}

}




?>