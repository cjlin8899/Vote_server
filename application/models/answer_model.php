<?php
class Answer_model extends CI_Model {

	public function __construct()
	{	
		//$this->load->database();
		//parent::__construct();
	}
	
	public function get_all()
	{
		
		$query = $this->db->get('v_answer');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}
	
	/*
	 * Returns single object representing Answer.
	 */
	public function get_by_id( $a_id )
	{
		$query = $this->db->get_where('v_answer', array('a_id' => $a_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->row();
	}
	
	/*
	 *  Gets all answers which belong to a question with id: $survey_id.
	 */
	public function get_by_question_id( $question_id )
	{
		$query = $this->db->get_where('v_answer', array('a_question' => $question_id));
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}
	
	/*
	 * Get answers according to MULTIPLE questions's ids $s_ids
	 */
	public function get_by_questions( $q_ids )
	{
		$this->db->where_in('a_question', $q_ids);
		$query = $this->db->get('v_answer');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}
}

/* End of file answer_model.php */
/* Location: ./application/models/answer_model.php */
