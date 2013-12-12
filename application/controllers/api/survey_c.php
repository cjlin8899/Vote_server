<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Survey_c extends REST_Controller
{
	function survey_get()
    {
        if (!$this->get('s_id'))
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
    	
    	$survey = $this->survey_model->get_by_id( $this->get('s_id') );
    	
        if ($survey == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEY_BY_ID_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEY_BY_ID_FOUND',
				'v_data' => $survey
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
    
    function surveys_get()
    {
		
		$all_surveys = $this->survey_model->get_all();
        
        if( $all_surveys == NULL )
        {
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'NO_SURVEYS_FOUND',
						'v_data' => NULL
						), 
					200
					);
		}else{
				$this->response(  
					array(
						'v_status' => 'OK',
						'v_message' => 'ALL_SURVEYS_FOUND',
						'v_data' => $all_surveys
						), 
					200
					);
		}
    }
    
    /*
     * Get all surveys which belong to certain user as creator.
     */ 
	function surveys_by_creator_get()
    {
        if (!$this->get('s_creator'))
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_CREATOR_ID',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$surveys = $this->survey_model->get_by_creator_id( $this->get('s_creator') );
    	
        if ($surveys == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEYS_BY_CREATOR_ID_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEYS_BY_CREATOR_ID_FOUND',
				'v_data' => $surveys
				), 
			200
			);
    } 
    
    
	function surveys_by_ids_get()
    {
        if ( !$this->get('k_name') )
        {
				$this->response(  
					array(
						'v_status' => 'BAD_REQUEST',
						'v_message' => 'BAD_PARAMETER_KEYWORD_NAME',
						'v_data' => NULL
						), 
					400
					);
        }
    	
    	$keywords_by_name = $this->keyword_model->get_by_name( $this->get('k_name') );
    	
    	// array of surveys' ids
    	$surveys_ids = array();
    	
    	//print_r( $keywords_by_name );
    	foreach ( $keywords_by_name as $single_keyword )
		{
			array_push($surveys_ids, $single_keyword->k_survey);
		}
    	
    	$surveys_by_ids = $this->survey_model->get_by_ids( $surveys_ids );
    	
    	//print_r( $surveys_by_ids );
    	
        if ($surveys_by_ids == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEYS_BY_IDS_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }

		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEYS_BY_IDS_FOUND',
				'v_data' => $surveys_by_ids
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
	
    function add_post()  
    {          

		log_message('info', 'add_post' );
	
        // retrieve call arguments
        // parse user from passed data
        $client_message =  $this->_post_args;
		
        $new_survey = json_decode( $client_message['v_survey'] ) ;
        $new_keywords = $client_message['v_keywords'];
		
        log_message('info', '******************************************************************************************');
        log_message('info', print_r($new_survey, TRUE) );
		log_message('info', print_r($new_keywords, TRUE) );
		log_message('info', '******************************************************************************************');		
        
        if( strcasecmp( $new_survey->s_type , 'GLOBAL' ) == 0  ){
			
			log_message('info', 'Transforming type of a survey from String \'GLOBAL\' to Number 0' );
			$new_survey->s_type = '0';
			
		}else if( strcasecmp( $new_survey->s_type, 'LOCAL' ) == 0  ){
			
			log_message('info', 'Transforming type of a survey from String \'GLOBAL\' to Number 0' );
			$new_survey->s_type = '1';
			
		}else{
			
			log_message('info', 'Type ' . print_r( $new_survey->s_type, TRUE) . ' is unsupported.' );
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'UNSUPPORTED_SURVEY_TYPE',
					'v_data' => NULL
					), 
				200
				);
				return;			
		}
		
        // try to insert new user
        $latest_id = $this->survey_model->put( $new_survey );
		
		log_message('info', 'latest_id ' . print_r($latest_id, TRUE) );
        
        // check result
        if ( $latest_id == FALSE )
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEY_NOT_CREATED',
					'v_data' => NULL
					), 
				200
				);
				return;
		}
        
        //TODO: edit!
    	$checked_survey = $this->survey_model->get_by_id( $latest_id );
    	
        if ($checked_survey == NULL)
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'SURVEY_NOT_FOUND_BY_ID_CALLBACK_CALL',
					'v_data' => NULL
					), 
				200
				);
				return;
        }
        
        $new_keywords_updated = array();
        //$checked_survey['s_id']
		
	$data_kwrds = array(
		array(
			'title' => 'My title' ,
			'name' => 'My Name' ,
			'date' => 'My date'
		),
		array(
			'title' => 'Another title' ,
			'name' => 'Another Name' ,
			'date' => 'Another date'
		)
	);		log_message('info', 'Survey after update: ' . print_r($data_kwrds, TRUE) );
		
		foreach ($new_keywords as $single_keyword) {

			
			array_push( $new_keywords_updated, array('k_name' => $single_keyword, 'k_survey' => $checked_survey->s_id ) );
		}
		
		log_message('info', 'Survey after update: ' . print_r($new_keywords_updated, TRUE) );

		$this->keyword_model->add_multiple_keyword( $new_keywords_updated );
		
		$this->response(
			array(
				'v_status' => 'OK',
				'v_message' => 'SURVEY_INSERTED',
				'v_data' => $checked_survey
				), 
			200
			);        
    }	
}
