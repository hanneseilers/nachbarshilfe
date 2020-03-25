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

	if( array_key_exists('phone', $_REQUEST) && array_key_exists('mail', $_REQUEST) && array_key_exists('pw', $_REQUEST) ){
		
		$phone = $_REQUEST['phone'];
		$mail = $_REQUEST['mail'];
		$pw = $_REQUEST['pw'];		
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
	array_key_exists('phone', $_REQUEST) &&
	array_key_exists('mail', $_REQUEST) &&
	array_key_exists('pw', $_REQUEST) &&
	array_key_exists('name', $_REQUEST) &&
	array_key_exists('plz', $_REQUEST) &&
	array_key_exists('pw', $_REQUEST) &&
	array_key_exists('adress', $_REQUEST) ){
	
		global $db;
	
		// request existing user
		$phone = $_REQUEST['phone'];
		$mail = $_REQUEST['mail'];
		$pw = $_REQUEST['pw'];		
		$response = getUser($phone, $mail);
		
		
		if( !$response ){
			
			if(
				isset($_REQUEST['name']) &&
				isset($_REQUEST['plz']) &&
				isset($_REQUEST['pw']) &&
				(isset($_REQUEST['phone']) || isset($_REQUEST['mail'])) &&
				strlen(trim($_REQUEST['name'])) &&
				strlen(trim($_REQUEST['plz'])) &&
				strlen(trim($_REQUEST['pw'])) >= 6 &&
				( strlen(trim($_REQUEST['phone'])) || strlen(trim($_REQUEST['mail'])) )
			){
			
				// no existing user -> add new one
				$response = $db->insert('users', [
					"name" => $_REQUEST['name'],
					"adress" => $_REQUEST['adress'],
					"plz" => base64_decode($_REQUEST['plz']),
					"email" => $_REQUEST['mail'],
					"phone" => $_REQUEST['phone'],
					"password" => $_REQUEST['pw'],
					"last_updated" => time(),
					"login_timestamp" => time()
				]);
				$id = $db->id();
				
				if( $id != null ){
				
					// login user
					$_REQUEST['t'] = "0";
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
		array_key_exists('phone', $_REQUEST) &&
		array_key_exists('mail', $_REQUEST) &&
		array_key_exists('pw', $_REQUEST) &&
		array_key_exists('name', $_REQUEST) &&
		array_key_exists('plz', $_REQUEST) &&
		array_key_exists('pw', $_REQUEST) &&
		array_key_exists('adress', $_REQUEST) &&
		array_key_exists('userid', $_REQUEST) &&
		strlen(trim($_REQUEST['name'])) &&
		strlen(trim($_REQUEST['plz'])) &&
		( strlen(trim($_REQUEST['phone'])) || strlen(trim($_REQUEST['mail'])) ) &&
		validateUserTime() ){
		
			global $db;
			
			// request existing users
			$phone = $_REQUEST['phone'];
			$mail = $_REQUEST['mail'];
			$pw = $_REQUEST['pw'];
			
			if( $pw.length <= 0 ){
				$pw = $_SESSION['user']['password'];
			}
			
			$response = getUser($phone, $mail);
			
			if( $response ){
				
				// existing user
				$response = $db->update('users', [
					"name" => $_REQUEST['name'],
					"adress" => $_REQUEST['adress'],
					"plz" => base64_decode($_REQUEST['plz']),
					"email" => $_REQUEST['mail'],
					"phone" => $_REQUEST['phone'],
					"password" => $_REQUEST['pw'],
					"last_updated" => time(),
					"login_timestamp" => time()
				], ["id" => $_REQUEST['userid']]);
				
				if( $response ){
					// login user
					$_REQUEST['t'] = "0";
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


if( array_key_exists('t', $_REQUEST) ){

	if( $_REQUEST['t'] == "0" ){	
		// LOGIN
		login();
	} else if( $_REQUEST['t'] == "1" ){	
		// REGISTER
		print register();
	} else if( $_REQUEST['t'] == "2"){
		// UPDATE
		update();
	} else {
		// LOGOUT
		logout();
	}

}
