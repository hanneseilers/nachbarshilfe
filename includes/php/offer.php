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

function getOffers($print=false, $loggedinuser=false){

	global $db;
	$where = [ 'ORDER' => ['last_updated' => 'ASC']];
	if( $loggedinuser != false && $loggedinuser != null ){
		$where = [
			'user' => $loggedinuser,
			'ORDER' => ['last_updated' => 'DESC']
		];
	}
		
	$response = $db->select('offers', "*", $where);
	
	if( $response != null && is_array($response) && count($response) > 0 ){
		if( $print ){
			print getHTMLTable( $response, [
				'0' => [
					'key' => 'last_updated',
					'callable' => function($data){
						return round( (time() - $data) / 3600, 2);
					}
				],
				'1' => [
					'key' => 'amount',
					'callable' => function($data){
						return getHTMLProgressBar($data);
					}
				],
				'2' => [
					'key' => 'text',
					'callable' => function($data){
						$data = urldecode(base64_decode( $data ));
						return (strlen($data) > 0 ? $data : "-");
					}
				]
			] )->saveHTML();
		}
		return $response;
	}
	
	return null;

}

function getOffer($id=null){

	return "test";

	if( $id != null ){
	
		global $db;
		$response = $db->debug()->select('offers', "*", [
			'id' => intval($id)
		]);
		
		if( $response != null && is_array($response) && count($response) > 0 ){
			return $response[0];
		} 	
			
	}
	
	return null;

}

function getOffersPLZ($plz=Null){

	if( $plz != null ){
	
	
	
	}

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
	} else if( $_GET['t'] == "3"){
		// SHOW OFFERS
		getOffers(true);
	} else if( $_GET['t'] == "4"){
		// SHOW OFFERS
		if( isset($_SESSION['user']) ){
			getOffers(true, $_SESSION['user']['id']);
		}
	}

}
