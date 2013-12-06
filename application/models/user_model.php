<?php
class User_model extends CI_Model {

	public function __construct()
	{	
		//$this->load->database();
		//parent::__construct();
	}
	
	public function get_all()
	{
		
		$query = $this->db->get('v_user');
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->result();
	}
	
	/*
	 * Returns the single user as an object.
	 */
	public function get_by_id( $usr_id )
	{

		$query = $this->db->get_where('v_user', array('usr_id' => $usr_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query->row();
	}
	
	/*
	 * Insert user. 
	 * Resturns NULL if fails.
	 **/
	public function put( $new_user )
	{
		$res =	$this->db->insert('v_user', $new_user ); 
		
		return $res;
	}
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
