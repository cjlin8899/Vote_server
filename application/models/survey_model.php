<?php
class Survey_model extends CI_Model {

	var $id				= '';
	var $creator        = '';
	var $title        	= '';
	var $type         	= '';
	var $start_time     = '';
	var $hash_or_url	= '';


	public function __construct()
	{	
		//$this->load->database();
		//parent::__construct();
	}
	
	public function get_all()
	{
		
		$query = $this->db->get('v_survey');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query;
	}
	
	public function get_by_id( $s_id )
	{
		
		//$query = $this->db->get('v_survey');
		$query = $this->db->get_where('v_survey', array('s_id' => $s_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query;
	}	
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
