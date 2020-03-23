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
	// TODO
};

function delete($id=null){
	
	if( validateUserTime() && $id != null && getOffer($id) != null ){
	
		global $db;
		$db->delete( 'offers', ['id' => $id] );
		print "true";
			
	}
	
};

function getOffers($print=false, $loggedinuser=false, $plz=Null){

	if( validateUserTime() ){

		global $db;
		$select = [
			'offers.id',
			'offers.user',
			'offers.amount',
			'offers.text',
			'offers.last_updated',
			'users.plz',
			'users.name',
			'users.adress',
			'users.email',
			'users.phone',
			'users.valid'
		];
		$where = [ 'ORDER' => ['last_updated' => 'DESC']];
		$join = null;
		if( $plz != null && $loggedinuser != false && $loggedinuser != null ){
			$where = [
				'user[!]' => $loggedinuser,
				'plz[~]' => $plz,
				'ORDER' => ['last_updated' => 'DESC']
			];
			$join = [
				'[><]users' => ['user' => 'id']
			];
		} elseif( $loggedinuser != false && $loggedinuser != null ){
			$where = [
				'user' => $loggedinuser,
				'ORDER' => ['last_updated' => 'DESC']
			];
			$select = "*";
		} elseif( $plz != null ){
			$where = [
				'plz[~]' => $plz,
				'ORDER' => ['offers.last_updated' => 'DESC']
			];
			$join = [
				'[><]users' => ['user' => 'id']
			];
			
		}
			
		if( $join != null ){
			$response = $db->select('offers', $join, $select, $where);
		} else {
			$response = $db->select('offers', "*", $where);
		}
		
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
					],
					'3' => [
						'key' => 'id',
						'callable' => function($data){
							return getHTMLLink("javascript: deleteOffer(".$data.");", "<i class='fas fa-trash'></i>");
						}
					]
				] )->saveHTML();
			}
			return $response;
		}
		
	}	
	return null;

}

function getOffer($id=null){

	if( validateUserTime() ){

		if( $id != null ){
		
			global $db;
			$response = $db->select('offers', "*", [
				'id' => intval($id)
			]);
			
			if( $response != null && is_array($response) && count($response) > 0 ){
				return $response[0];
			} 	
				
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
	} elseif( $_GET['t'] == "1" ){	
		// UPDATE
		update( $id, $user, $amount, $text );
	} elseif( $_GET['t'] == "2"){
		// DELETE
		delete( $id );
	} elseif( $_GET['t'] == "3"){
		// SHOW OFFERS
		getOffers(true);
	} elseif( $_GET['t'] == "4"){
		// SHOW OFFERS
		if( isset($_SESSION['user']) ){
			if( isset($_GET['user']) && isset($_GET['plz']) ){
				getOffers(true, $_SESSION['user']['id'], $_GET['plz']);
			} elseif( isset($_GET['user']) ){
				getOffers(true, $_SESSION['user']['id']);
			} elseif( isset($_GET['plz']) ){
				getOffers(true, false, $_GET['plz']);
			} else {
				getOffers(true);
			}
		}
	}
	
	if( isset($_SESSION['user']) ){
		updateUserTime();
	}

}
