<?php
session_start();

$includes = "../../includes/";
require( "../../config.php" );
require( "Medoo.php" );
require( "db_init.php" );	
require( "base.php" );

// logout user by setting timestamp to zero
function logout(){
	$_SESSION['user'] = null;
	updateUserTime($timestamp=0);
}

// Login existing user
function login($print=true){

	if( array_key_exists('phone', $_GET) && array_key_exists('mail', $_GET) && array_key_exists('pw', $_GET) ){
		
		$phone = $_GET['phone'];
		$mail = $_GET['mail'];
		$pw = $_GET['pw'];		
		$response = getUser( $phone, $mail, $pw );
		
		if( $response ){
		
			$_SESSION['user'] = $response;			
			updateUserTime();
			
			if( $print ){
				print( json_encode($response) );
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
		$response = getUser($phone, $mail);
		
		
		if( !$response ){
			
			if(
				isset($_GET['name']) &&
				isset($_GET['plz']) &&
				isset($_GET['pw']) &&
				(isset($_GET['phone']) || isset($_GET['mail']))
			){
			
				// no existing user -> add new one
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
				
				if( $id != null ){
				
					// login user
					$_GET['t'] = "0";
					login();
					if( $ret ){
						return $id;
					}

				}
			
			}
			
		}		
	
	}
	
	return;

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
			
			$response = getUser($phone, $mail);
			
			if( $response ){
				
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

function getUser($phone="", $mail="", $pw=null, $id=null){

	$where = ["OR" => [
			"email" => $mail,
			"phone" => $phone
		]
	];
	
	// check if password is required
	if( $pw != null ){
		$where = ["AND" => [
				"OR" => [
					"email" => $mail,
					"phone" => $phone
				],
				"password" => $pw
			]
		];
	}
	
	// check if only id is required
	if( $id != null ){
		$where = ["id" => $id];
	}
	
	global $db;	
	$response = $db->select('users', '*', $where);
	
	if( $response != null && is_array($response) && count($response) > 0 ){
		$response = $response[0];		
		unset( $response['password'] );
		return $response;		
	}
	
	return null;

}


if( array_key_exists('t', $_GET) ){

	if( $_GET['t'] == "0" ){	
		// LOGIN
		login();
	} else if( $_GET['t'] == "1" ){	
		// REGISTER
		print register();
	} else if( $_GET['t'] == "2"){
		// UPDATE
		update();
	} else {
		// LOGOUT
		logout();
	}

}
