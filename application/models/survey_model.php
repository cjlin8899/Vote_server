<?php
class Survey_model extends CI_Model {

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
		
		return $query->result();
	}
	
	/*
	 * Get survey according to survey's id $s_id
	 */
	public function get_by_id( $s_id )
	{
		
		//$query = $this->db->get('v_survey');
		$query = $this->db->get_where('v_survey', array('s_id' => $s_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->row();
	}
	
	/*
	 * Get survey according to MULTIPLE survey's ids $s_ids
	 */
	public function get_by_ids( $s_ids )
	{		
		$this->db->where_in('s_id', $s_ids);
		$query = $this->db->get('v_survey');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}	
	
	/*
	 * Get surveys according to creator
	 */ 
	public function get_by_creator_id( $s_creator )
	{
		$query = $this->db->get_where('v_survey', array('s_creator' => $s_creator));
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}	
}

/* End of file survey_model.php */
/* Location: ./application/models/survey_model.php */
