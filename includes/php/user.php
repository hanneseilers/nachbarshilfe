<?php
session_start();

$includes = "../../includes/";
require( "../../config.php" );
require( "Medoo.php" );
require( "db_init.php" );	
require( "base.php" );

function getUserData($print=false){

	if( validateUserTime() ){
	
		$user = $_SESSION['user'];
		unset( $user['password'] );
		
		if( $print ){
			print json_encode( $user );
		}
		
		return $user;
	
	}

}

if( array_key_exists('t', $_REQUEST) ){

	if( $_REQUEST['t'] == "0" ){	
		// GET USER DATA
		getUserData(true);
	}
	
	if( isset($_SESSION['user']) ){
		updateUserTime();
	}

}
