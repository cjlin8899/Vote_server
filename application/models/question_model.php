<?php
class Question_model extends CI_Model {

	public function __construct()
	{	
		//$this->load->database();
		//parent::__construct();
	}
	
	public function get_all()
	{
		
		$query = $this->db->get('v_question');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}
	
	public function get_by_id( $q_id )
	{
		$query = $this->db->get_where('v_question', array('q_id' => $q_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->row();
	}
	
	/*
	 *  get all questions which belong to a survey with id: $survey_id
	 */
	public function get_by_survey_id( $survey_id )
	{
		$query = $this->db->get_where('v_question', array('q_survey' => $survey_id));
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}	
}

/* End of file question_model.php */
/* Location: ./application/models/question_model.php */
