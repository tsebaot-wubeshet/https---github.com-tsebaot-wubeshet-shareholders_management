<?php 

/**
 * the tender database files 
 */
class Tenders_Model extends MY_Model {
		
	const DB_TABLE = 'tender';
	const DB_TABLE_PK = 'id';	
		
	public $id;
	public $title;
	public $description;
	public $posted_date;
	public $closing_date;
	public $source;
	public $category_id;
	public $comp_name;
	public $comp_address;

		

	function create_tender($data){
		
		$this->db->insert('tender',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
			return false;
}
	
	public function tender_detail(){
			
		$this->load->database();
		
		$query = $this->db->get('tender');
		
		return $query->result();
	}
	
		// Count all record of table "contact_info" in database.
	public function record_count($id) {
		
		$condition = "category_id =" . "'" . $id . "'";
		
		$this->db->select("tender.id,tender.title,tender.description,tender.posted_date,tender.closing_date,tender.source,tender.comp_name,tender.comp_address,category.category_name");
		
		$this->db->from('tender');
		
		$this->db->where($condition);
		
		$this->db->join('category','category.id = tender.category_id');
		
		$query = $this->db->get();
				
		return $query->num_rows();
	
	}
	
	public function select_tenders($id){
		
		$condition = "category_id =" . "'" . $id . "'";
		
		$this->db->select("tender.id,tender.title,tender.description,tender.posted_date,tender.closing_date,tender.source,tender.comp_name,tender.comp_address,category.category_name");
		
		$this->db->from('tender');
		
		$this->db->where($condition);
		
		$this->db->join('category','category.id = tender.category_id');
		
		$query = $this->db->get();
		
		return $query->result();
	}
}




?>