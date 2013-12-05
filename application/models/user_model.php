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
	
	public function get_user_by_id( $id_user )
	{
		
		$this->db->select('*');
		//$this->db->from('user');
		$this->db->from('v_user');	
		//$this->db->where('id_user', $id_user);
		$this->db->where('usr_id', $id_user);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			$user = array(
					/*'usr_id'			=> ($row->id_user),
					'usr_nick' 			=> ($row->nick),
					'usr_firstname' 	=> ($row->firstname),
					'usr_lastname' 		=> ($row->lastname)* */
					'usr_email' 		=> ($row->usr_email),
					'usr_gender'		=> ($row->usr_gender),
					'usr_year_of_birth'	=> ($row->usr_year_of_birth),
					'usr_country'		=> ($row->usr_country),
					'usr_nationality'	=> ($row->usr_nationality),
					'usr_last_update'	=> ($row->usr_last_update)
					
			);

			return $user;
		}
		
		return NULL;
	}
	
	
	public function authentify( $column_name, $column_value, $password_value)
	{		

		$result = $this->db->get_where(
			'user',
			array(
				$column_name => $column_value,
				'password' => $password_value)
			)->row_array();
		
		return ( empty( $result ) == TRUE ? NULL : $result );
	}
	
	
	public function is_persistant_by_column_and_value( $column_name, $column_value )
	{		
		$result = $this->db->get_where('user', array($column_name => $column_value))->row_array();
		
		return (!empty( $result ));
	}
	
	
	public function get_user_by_column_and_value( $column_name, $column_value )
	{
		
		$user = $this->db->get_where('user', array($column_name => $column_value))->row_array();
		
		return $user;
	}
	
	/*
	 * Updates last_login date of user with id $id_user.
	 * @timestamp is value returned as php's int time(void), so conversion is needed ?
	 */
	public function update_last_login( $id_user, $time )
	{
		
		// conversion
		$timestamp = date("Y-m-d H:i:s", $time);		
		
		$updated_user = array(
               'last_login' => $timestamp
            );

		$this->db->where('id_user', $id_user);
		$this->db->update('user', $updated_user);
		
	}
	
	public function get_user_group_name_and_supreme_flag( $id_user )
	{
		
		$this->db->select('id_user, fk_id_user_group, name, supreme_flag');
		$this->db->from('user');
		$this->db->join('user_group', 'user_group.id_user_group = user.fk_id_user_group');
		$this->db->where('id_user', $id_user);		

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return array(
				'group_name'   => ($row->name),
				'supreme_flag' => ($row->supreme_flag) );
		}
		
		return NULL;
	} 
	
	public function execute_query( $p_sql_query ){
		
		
		$query = $this->db->query( $p_sql_query );
		
		return $query;
	}


	/***  handling clients ***/
	
	public function get_all_clients()
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('user_group', 'user_group.id_user_group = user.fk_id_user_group');
		$this->db->where('user.fk_id_user_group', 3 );
		$this->db->order_by('lastname', 'asc');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return NULL;
	}
}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
