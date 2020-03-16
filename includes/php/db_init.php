<?php

	// Using Medoo namespace
	use Medoo\Medoo;

	function db_init(){
	
		// MYSQL
		return new Medoo([
			'database_type' => 'mysql',
			'database_name' => 'name',
			'server' => 'localhost',
			'username' => 'your_username',
			'password' => 'your_password'
		]);
			
		// SQLITE
		/*
		return new Medoo([
			'database_type' => 'sqlite',
			'database_file' => 'my/database/path/database.db'
		]);
		*/
	
	}
