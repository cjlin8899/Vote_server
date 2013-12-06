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
    	
    	$user = $this->user_model->get_by_id( $this->get('usr_id') );
    	
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

		$all_users = $this->user_model->get_all();

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
	
    function add_post()  
    {          
        // retrieve call arguments
        $data = $this->_post_args;
        
        // parse user from passed data
        $new_user = $data;
        
        // try to insert new user
        $b_result = $this->user_model->put( $new_user );
        
        // check result
        if ( $b_result == FALSE )
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'USER_ALREADY_EXISTS',
					'v_data' => NULL
					), 
				200
				);
				return;
		}
        
    	$checked_user = $this->user_model->get_by_id( $data['usr_id'] );
    	
        if ($checked_user == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'USER_NOT_FOUND_BY_ID_CALLBACK_CALL',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(
			array(
				'v_status' => 'OK',
				'v_message' => 'USER_INSERTED',
				'v_data' => $checked_user
				), 
			200
			);        
    }	


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}
