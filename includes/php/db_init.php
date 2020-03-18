<?php

	// Using Medoo namespace
	use Medoo\Medoo;

	function db_init($config){
	
		if( $config != null && is_array($config) ){
	
			// MYSQL
			return new Medoo($config);
		}
		
		return false;
	
	}
