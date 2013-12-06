<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Question_c extends REST_Controller
{
	function question_get()
    {
        if (!$this->get('q_id'))
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_QUESTION_ID',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$question = $this->question_model->get_by_id( $this->get('q_id') );
    	
        if ($question == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'QUESTION_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'QUESTION_FOUND',
				'v_data' => $question
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
        
        $this->response($message, 200);
    }
    
    function questions_get()
    {
		
		$all_questions = $this->question_model->get_all();
        
        if( $all_questions == NULL )
        {
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'NO_QUESTIONS_FOUND',
						'v_data' => NULL
						), 
					200
					);
		}else{
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'QUESTIONS_FOUND',
						'v_data' => $all_questions
						), 
					200
					);
		}
    }
    
    function questions_by_survey_get()
   {
        if (!$this->get('q_survey'))
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_SURVEY_ID',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$questions = $this->question_model->get_by_survey_id( $this->get('q_survey') );
    	
        if ($questions == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'QUESTIONS_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'QUESTIONS_FOUND',
				'v_data' => $questions
				), 
			200
			);
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
