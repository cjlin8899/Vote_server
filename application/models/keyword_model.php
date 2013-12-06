<?php
class Keyword_model extends CI_Model {

	public function __construct()
	{	
		//$this->load->database();
		//parent::__construct();
	}
	
	public function get_all()
	{
		
		$query = $this->db->get('v_keyword');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}
	
	public function get_by_id( $k_id )
	{
		$query = $this->db->get_where('v_keyword', array('k_id' => $k_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->row();
	}
	
	/*
	 * Get all keys with specified name $k_name.
	 * For example get all v_keyword entities according to k_name "product".
	 */
	public function get_by_name( $k_name )
	{
		$query = $this->db->get_where('v_keyword', array('k_name' => $k_name));
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}	
}

/* End of file keyword_model.php */
/* Location: ./application/models/keyword_model.php */
