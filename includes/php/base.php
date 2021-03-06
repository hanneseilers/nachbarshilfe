<?php

	// SYSTEM INIT
	// Using Medoo namespace
	use Medoo\Medoo;

	// load site config
	$cfg = parse_ini_file( $includes."config.ini", true );

	// databse init
	global $db;
	$db = db_init($cfg['sql']);

	// FUNCTIONS

	# ---- Error Codes ----
	$err_404 = "Die Seite wurde nicht gefunden.";
	
	# Shows an error
	# $err:		Error text to show
	# $data:	Optional string data to show
	function err($err, $data=""){
		print "# ".$err."<br />";
		if( strlen($data) > 0 ) print " - ".$data."</br >";
	}
	
	# ---- String Functions ----
	
	# Checks if string starts with substring
	# $str:		String to check
	# $sub:		Substring to check for
	# return:	true if $sub is at beginning of $str, false otherwise
	function startsWith( $str, $sub ) {
		return ( substr( $str, 0, strlen( $sub ) ) === $sub );
	}
	
	# Checks if string ends with substring
	# $str:		String to check
	# $sub:		Substring to check for
	# return:	true if $sub is at ends of $str, false otherwise
	function endsWith( $str, $sub ) {
		return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
	}
	
	# Adds extension to url, if not already there
	# $url:		URL to check and add extension
	# $ext:		Extension to add [default: ".php"]
	# return:	$url with extension $ext
	function addExtension($url, $ext=".php"){
		if( endsWith($url, $ext) ){
			return $url;
		}
		
		return $url.$ext;
	}
	
	
	# ---- Content Include Functions ----
	
	# Includes and shows a content site from global $content path
	# Function automaticcally add .php extension
	# $site:	Site name or file to include
	function get($site){
		global $content, $err_404;
		$url = $content.$site;
		$url = addExtension($url);
		
		if( file_exists($url) ) include( $url );
		else err( $err_404, $url );
	}
	
	# Includes and shows a js file from global $js path
	# Function automaticcally add .js extension
	# $site:	Js name or file to include
	function getJs($site){
		global $js, $err_404;
		$url = $js.$site;
		$url = addExtension($url, ".js");
		
		if( file_exists($url) ) {
			print "<script type='text/javascript' src='".$url."'></script>\n";
		} else err( $err_404, $url );
	}
	
	# Includes and shows a css site from global $css path
	# Function automaticcally add .css extension
	# $site:	Css name or file to include
	function getCss($site){
		global $css, $err_404;
		$url = $css.$site;
		$url = addExtension($url, ".css");
		
		if( file_exists($url) ) {
			print "ßn\n<style>\n";
			include( $url );
			print "\n</style>\n";
		}else err( $err_404, $url );
	}
	
	# Shows the link to an assets content from global $assets path
	# $data:		Data file to print link
	function src($data){
		global $assets;
		$url = $assets.$data;
		
		if( file_exists($url) ) print( $url );
		else print "error";
	}
	
	# Prints url to a content page from global $content path
	# Function automaticcally add .php extension
	# $site:		Content page link to show
	function url($site){
		global $content, $err_404;
		$url = $content.$site;
		$url = addExtension($url);
		
		if( file_exists($url) ) print( $url );
		else err( $err_404, $url );
	}
	
	# ---- Link Handling Functions ----
	
	# Gets page name from header informationn (hash map required) send (may a POST or GET).
	# $header:		Array of header information
	# return: 		page name or false if no information found
	#
	# Function extracts key and value pairs in array (hash map). It returns the value if key is 'p' or 'page'.
	# It returns the key if a key has no value.
	function getPage($header){
	
		foreach( $header as  $key => $value ){
		
			if( $key == "page" ) return $value;
			if( $key == "p" ) return $value;
			if( strlen($value) == 0 ) return $key;
		
		}
		
		return false;
	
	}
	
	
	# ---- User Authentification ---
	
	# Updates the login timestamp
	# return:		True if succesfull update, false otherwise
	function updateUserTime($timestamp=null){

		// request users login timestamp	
		global $db;	
		$response = $db->select('users', '*', [
			"id" => $_SESSION['user']['id']
		]);
		
		if( count($response) > 0 ){
			
			// existing user
			if( is_null($timestamp) ){
				$timestamp = time();
			}
			$response = $db->update('users', [
				"login_timestamp" => $timestamp
			], ["id" => $_SESSION['user']['id']]);
			$_SESSION['user']['login_timestamp'] = $timestamp;

			if( $response ){
				return true;
			}
	
		}
				
		return false;

	}
	
	# Validates the current user login time
	# return:		True if user is still logged in, False otherwise.
	function validateUserTime(){

		global $cfg;
		if( isset($_SESSION['user']) && !is_null($_SESSION['user']) ){
			if( (time() - $_SESSION['user']['login_timestamp']) < $cfg['permissions']['max_login_time'])
				return $cfg['permissions']['max_login_time'] - (time() - $_SESSION['user']['login_timestamp']);
		}
		
		return false;

	}
	
	
	// TODO: Annotation
	function getHTMLTable($data, $keys){
	
		$dom = new DOMDocument('1.0');
		$n = count($keys);		
		
	
		// iterate trough rows
		foreach( $data as $row ){
		
			$tr = $dom->createElement( 'tr' );
			$dom->appendChild( $tr );
			
			// iterate trough keys
			for( $i=0; $i<$n; $i++ ){
			
				$key = $keys[$i];
				$callable = null;
				if( is_array($key) ){
					$callable = $key['callable'];
					$key = $key['key'];
				}
				
				$value = $row[ $key ];
				if( $callable != null ){
					$value = $callable( $value );
				}
			
				$td = null;
				
				try{
					if( is_string($value) ){
						$td = $dom->createElement( 'td' );
						appendHTML( $td, $value );						
					} else {
						$td = $dom->createElement( 'td', $value );
					}
					
				
					$dom->appendChild( $td );
				} catch(TypeError $ex){
					var_dump( $ex );
				}
			
			}
		
		}
		
		return $dom;
	
	}
	
	
	// TODO: Annotation
	function getHTMLProgressBar($progress=0){
	
		if( $progress != null ){	
		
			if( !is_string($progress) ){
				$progress = strval($progress);
			}
			
			$dom = "<div class='progress'>\n";
			$dom .= "\t<div class='progress-bar' role='progressbar' style='width: ".$progress."%' aria-valuenow='".$progress."' aria-valuemin='0' aria-valuemax='100'></div>\n";
			$dom .= "</div>";
		
			return $dom;
			
		}
		
		return "";
	
	}
	
	// TODO: Annotation
	function appendHTML(DOMNode $parent, $source) {
		$tmpDoc = new DOMDocument();
		$tmpDoc->loadHTML($source);
		foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
			$node = $parent->ownerDocument->importNode($node, true);
			$parent->appendChild($node);
		}
	}
	
	// TODO: Annotation
	function getHTMLLink($link=null, $text=null, $target=null){
		if( $link != null && $text != null ){
			if( $target != null ){
				return "<a href='".$link."', target='".$target."'>".$text."</a>";
			} else {
				return "<a href='".$link."'>".$text."</a>";
			}
		}
	}
