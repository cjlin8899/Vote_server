<?php

// run from command line with:
// $ php user_insert.php

print "\n-----TESTING REST POST-----\n";
test_post();

function test_post() {
		
        $new_survey = array(
			's_creator' => '2',
			's_title' => 'Local survey',
			's_type' => 'LOCAL',
			's_start_time' => '2013-12-01 15:00:00',
			's_end_time' => '2013-12-25 15:00:00',
			's_hash_or_url' => '/basic/url'
			//,'usr_last_update' = $this->post('usr_last_update')
			);		
 
   //$data_string = json_encode($new_user);
   $data_string = json_encode($new_survey);
   
   print_r( $data_string );

   $ch = curl_init('http://localhost/vote/index.php/api/survey_c/add');
   
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json',
       'Content-Length: ' . strlen($data_string))
   );

   $result = curl_exec($ch);
   $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   $contenttype = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
   print "Status: $httpcode" . "\n";
   print "Content-Type: $contenttype" . "\n";
   print "\n" . $result . "\n";
}
