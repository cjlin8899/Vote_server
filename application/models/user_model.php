<?php
class User_model extends CI_Model {

	var $id_user          = '';
	var $nick             = '';
	var $firstname        = '';
	var $lastname         = '';
	var $phone            = '';
	var $email		      = '';
	var $gender		  	  = '';
	var $last_login   	  = ''; // TODO
	var $password		  = '';
	var $fk_id_wallet	  = '';
	var $fk_id_user_goup  = '';

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
		
		return $query;
	}
	
	public function get_by_id( $usr_id )
	{

		$query = $this->db->get_where('v_user', array('usr_id' => $usr_id), 1);
		
		if ($query->num_rows() <= 0)
		{
			return NULL;
		}
		
		return $query;
	}
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
