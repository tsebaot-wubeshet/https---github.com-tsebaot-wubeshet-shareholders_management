<?php

/**
 * manage the category of tenders
 */
class Category extends MY_Model{
	
	const DB_TABLE = 'category';
	const DB_TABLE_PK = 'id';		
	
	public $id;
	public $category_name;
	
	public function create_category($data){
		
		$this->db->insert('category',$data);
		
		if($this->db->affected_rows() > 0){
			
			return true;
		}
		
		return false;	
	}
	
	public function category_detail(){
			
		$this->load->database();
		
		$query = $this->db->get('category');
		
		return $query->result();
	}
	
	public function getAllCategories(){
	
	$this->db->select();
	
    $q = $this->db->get('category');

    if ($q->num_rows() > 0){
    	
        foreach($q->result() as $row) {
        	
            $data[] = $row;
        }
		
        return $data;
    }

}
}


?>