<?php
session_start();

$includes = "../../includes/";
require( "../../config.php" );
require( "Medoo.php" );
require( "db_init.php" );	
require( "base.php" );

function add($user=null, $amount=null, $text=null){

	global $db;

	if( $user != null && $amount != null ){
	
		$response = $db->insert('offers', [
			'user' => $user,
			'amount' => $amount,
			'text' => ($text == null ? "": $text ),
			'last_updated' => time()
		]);
		$id = $db->id();
		
		if( $id != null ){
			print( json_encode( ['id' => $id] ) );
		}
	
	}

};

function update($id=null, $user=null, $amount=null, $text=null){
};

function delete($id=null){
}

function getOffers($print=false){

	global $db;
	$response = $db->select('offers', "*");
	
		if( $response != null && is_array($response) && count($response) > 0 ){
			if( $print ){
				print( json_encode($response) );
			}
			return $response;
		}

}

function getOffer($id=null){

	if( $id != null ){
	
		global $db;
		$response = $db->select('offers', "*", [
			'id' => intval($id)
		]);
		
		if( $response != null && is_array($response) && count($response) > 0 ){
			return $response[0];
		} 	
			
	}
	
	return null;

}


if( array_key_exists('t', $_GET) ){

	$id = null;	
	$user = null;
	$amount = null;
	$text = null;
	
	if( array_key_exists('id', $_GET) )
		$id = $_GET['id'];
	if( array_key_exists('user', $_GET) )
		$user = $_GET['user'];
	if( array_key_exists('amount', $_GET) )
		$amount = $_GET['amount'];
	if( array_key_exists('text', $_GET) )
		$text = $_GET['text'];

	if( $_GET['t'] == "0" ){	
		// ADD
		add( $user, $amount, $text );
	} else if( $_GET['t'] == "1" ){	
		// UPDATE
		update( $id, $user, $amount, $text );
	} else if( $_GET['t'] == "2"){
		// DELETE
		delete( $id );
	}

}
