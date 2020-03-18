<?php

$includes = "../../includes/";
require( "../../config.php" );
require( "Medoo.php" );
require( "db_init.php" );	
require( "base.php" );


if( array_key_exists('t', $_GET) ){

	if( $_GET['t'] == "0" ){
	
		// LOGIN
		if( array_key_exists('phone', $_GET) && array_key_exists('mail', $_GET) && array_key_exists('pw', $_GET) ){
		
			$phone = base64_decode($_GET['phone']);
			$mail = base64_decode($_GET['mail']);
			$pw = base64_decode($_GET['pw']);
			
			global $db;	
			$response = $db->select('users', '*', [
				"AND" => [
					"OR" => [
						"email" => $mail,
						"phone" => $phone
					],
					"password" => $pw
				]
			]);
			
			if( count($response) > 0 )
				print( json_encode($response[0]) );
		}
	
	}

}
