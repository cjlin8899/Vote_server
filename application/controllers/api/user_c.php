<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class User_c extends REST_Controller
{
	function user_get()
    {
        if (!$this->get('usr_id'))
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_USER_ID',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$user = $this->user_model->get_by_id( $this->get('usr_id') )->result_array();
    	
        if ($user == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'USER_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'USER_FOUND',
				'v_data' => $user
				), 
			200
			);
    }
    
    function user_post()
    {
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
    	//$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function users_get()
    {
		
		$all_users = $this->user_model->get_all()->result_array();
        
        if( $all_users == NULL )
        {
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'NO_USERS_FOUND',
						'v_data' => NULL
						), 
					200
					);
		}else{
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'USERS_FOUND',
						'v_data' => $all_users
						), 
					200
					);
		}
    }


	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}
