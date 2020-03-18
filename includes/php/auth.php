<?php
session_start();

$includes = "../../includes/";
require( "../../config.php" );
require( "Medoo.php" );
require( "db_init.php" );	
require( "base.php" );

// logout user by setting timestamp to zero
function logout(){

	updateUserTime($timestamp=0);

}

// Login existing user
function login($ret=true){

	if( array_key_exists('phone', $_GET) && array_key_exists('mail', $_GET) && array_key_exists('pw', $_GET) ){
		
		$phone = $_GET['phone'];
		$mail = $_GET['mail'];
		$pw = $_GET['pw'];
		
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
		
		if( is_array($response) && count($response) > 0 ){
		
			unset( $response['password'] );
			$_SESSION['user'] = $response[0];			
			updateUserTime();
			
			if( $ret ){
				print( json_encode($response[0]) );
			}
			
		}
	}

};

// Register new user
function register($ret=true){

	if(
	array_key_exists('phone', $_GET) &&
	array_key_exists('mail', $_GET) &&
	array_key_exists('pw', $_GET) &&
	array_key_exists('name', $_GET) &&
	array_key_exists('plz', $_GET) &&
	array_key_exists('pw', $_GET) &&
	array_key_exists('adress', $_GET) ){
	
		// request existing users
		$phone = $_GET['phone'];
		$mail = $_GET['mail'];
		$pw = $_GET['pw'];
		
		global $db;	
		$response = $db->select('users', '*', [
			"OR" => [
				"email" => $mail,
				"phone" => $phone
			]
		]);
		
		if( count($response) == 0 ){
			
			// no existing user
			$response = $db->insert('users', [
				"name" => $_GET['name'],
				"adress" => $_GET['adress'],
				"plz" => base64_decode($_GET['plz']),
				"email" => $_GET['mail'],
				"phone" => $_GET['phone'],
				"password" => $_GET['pw'],
				"last_updated" => time(),
				"login_timestamp" => time()
			]);
			$id = $db->id();
			
			if( count($response) > 0 ){
			
				// login user
				$_GET['t'] = "0";
				login($ret);
				if( !$ret ){
					return $id;
				}

			}
			
		}		
	
	}
	
	return:

};

// Update existing user data
function update(){

	if(
		array_key_exists('phone', $_GET) &&
		array_key_exists('mail', $_GET) &&
		array_key_exists('pw', $_GET) &&
		array_key_exists('name', $_GET) &&
		array_key_exists('plz', $_GET) &&
		array_key_exists('pw', $_GET) &&
		array_key_exists('adress', $_GET) &&
		array_key_exists('userid', $_GET) &&
		validateUserTime() ){
			
			// request existing users
			$phone = $_GET['phone'];
			$mail = $_GET['mail'];
			$pw = $_GET['pw'];
			
			if( $pw.length <= 0 ){
				$pw = $_SESSION['user']['password'];
			}
			
			global $db;	
			$response = $db->select('users', '*', [
				"OR" => [
					"email" => $mail,
					"phone" => $phone
				]
			]);
			
			if( count($response) > 0 ){
				
				// existing user
				$response = $db->update('users', [
					"name" => $_GET['name'],
					"adress" => $_GET['adress'],
					"plz" => base64_decode($_GET['plz']),
					"email" => $_GET['mail'],
					"phone" => $_GET['phone'],
					"password" => $_GET['pw'],
					"last_updated" => time(),
					"login_timestamp" => time()
				], ["id" => $_GET['userid']]);
				
				if( $response ){
				
					// login user
					$_GET['t'] = "0";
					login();				

				}
				
			}			
			
		}

}


if( array_key_exists('t', $_GET) ){

	if( $_GET['t'] == "0" ){	
		// LOGIN
		login();
	} else if( $_GET['t'] == "1" ){	
		// REGISTER
		register();
	} else if( $_GET['t'] == "2"){
		// UPDATE
		update();
	} else {
		// LOGOUT
		logout();
	}

}
