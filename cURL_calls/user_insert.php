<?php

// run from command line with:
// $ php user_insert.php

print "\n-----TESTING REST POST-----\n";
test_post();

function test_post() {
	
	
        $new_user = array(
			'usr_nick' => 'Vladimir',
			'usr_email' => 'vladimir.fejercak@student.tuke.sk',
			'usr_gender' => 0,
			'usr_year_of_birth' => '1992',
			'usr_country' => 'Slovakia',
			'usr_nationality' => 'Slovak'
			//,'usr_last_update' = $this->post('usr_last_update')
			);	
	
   //$data = array("name" => "bolt");
   $data_string = json_encode($new_user);
   print_r( $data_string );

   $ch = curl_init('http://localhost/vote/index.php/api/user_c/add');
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
