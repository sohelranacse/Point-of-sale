<?php

class Common extends CI_Model{
	
	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function anyName($table,$col,$id,$name,$col2=null,$id2=null,$col3=null,$id3=null){
		
		
		
		$w = $this->session->userdata('wire');
		
		
		if(!empty($col2)){
			
					$this->db->where($col2,$id2);	

		}
		if(!empty($col3)){
			
					$this->db->where($col3,$id3);	

		}
		
	$this->db->where("(ware='".$w."' OR ware='0')");

	
	
		$this->db->where($col,$id);
		$info=$this->db->get($table);
		foreach($info->result_array() as $val){
			
			return $val[$name];
			
		}
	}
}



 ?>