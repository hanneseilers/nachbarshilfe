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
	
		$response = $db->insert('requests', [
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
	
	if( validateUserTime() && $id != null && getRequest($id) != null ){
	
		global $db;
		$db->delete( 'requests', ['id' => $id] );
		print "true";
			
	}
	
};

function getRequests($print=false, $loggedinuser=false, $plz=Null){

	if( validateUserTime() ){

		global $db;
		$select = [
			'requests.id',
			'requests.user',
			'requests.amount',
			'requests.text',
			'requests.last_updated',
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
				'ORDER' => ['requests.last_updated' => 'DESC']
			];
			$join = [
				'[><]users' => ['user' => 'id']
			];
			
		}
			
		if( $join != null ){
			$response = $db->select('requests', $join, $select, $where);
		} else {
			$response = $db->select('requests', "*", $where);
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
							return getHTMLLink("javascript: deleteRequest(".$data.");", "<i class='fas fa-trash'></i>");
						}
					]
				] )->saveHTML();
			}
			return $response;
		}
		
	}	
	return null;

}

function getRequest($id=null){

	if( validateUserTime() ){

		if( $id != null ){
		
			global $db;
			$response = $db->select('requests', "*", [
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
		// SHOW REQUESTS
		getRequests(true);
	} elseif( $_GET['t'] == "4"){
		// SHOW REQUESTS
		if( isset($_SESSION['user']) ){
			if( isset($_GET['user']) && isset($_GET['plz']) ){
				getRequests(true, $_SESSION['user']['id'], $_GET['plz']);
			} elseif( isset($_GET['user']) ){
				getRequests(true, $_SESSION['user']['id']);
			} elseif( isset($_GET['plz']) ){
				getRequests(true, false, $_GET['plz']);
			} else {
				getRequests(true);
			}
		}
	}
	
	if( isset($_SESSION['user']) ){
		updateUserTime();
	}

}
