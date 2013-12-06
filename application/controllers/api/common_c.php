<?php defined('BASEPATH') OR exit('No direct script access allowed');


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Common_c extends REST_Controller
{
	function full_survey_by_id_get()
    {
		// url parameter: survey id
		$p_survey_id;
		
		// survey object
		$survey = NULL;
		
		// array of question objects belonging to a certain survey
		$survey_questions = array();
		
    	// array of questions' ids
    	$questions_ids = array();		
		
		// array of answers of questions
		$question_answers = array();
		
		$p_survey_id = $this->get('s_id');
		
        if ( !$p_survey_id )
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

		// load survey by id
    	$survey = $this->survey_model->get_by_id( $p_survey_id );
    	
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
    	
    	// load all questions that belong to certain survey by survey's id
    	$survey_questions = $this->question_model->get_by_survey_id( $survey->s_id );

        if ( $survey_questions == NULL )
        {
			$this->response(  
				array(
					'v_status' => 'OK',
					'v_message' => 'QUESTIONS_BY_SURVEY_ID_NOT_FOUND',
					'v_data' => NULL
					), 
				200
				);
				return;
        }   	
  	
    	// prepare array of questions' ids
    	foreach ( $survey_questions as $single_question )
		{
			array_push( $questions_ids, $single_question->q_id );
		}
    	
    	// load answers from DB according to questions' ids
    	$question_answers = $this->answer_model->get_by_questions( $questions_ids );
    	
    	// send data
		$this->response(  
			array(
				'v_status' => 'OK',
				'v_message' => 'FULL_SURVEY_HANDLED',
				'v_data' => array(
								'v_survey' => $survey,
								'v_questions' => $survey_questions,
								'v_answers'=> $question_answers
								)
				), 
			200
			);
    }
}
