<!DOCTYPE HTML>

<?php
	session_start();
	
	require( "config.php" );
	require( $php."Medoo.php" );
	require( $php."db_init.php" );
	require( $php."base.php" );
	
	getJs('base.js');
	
	# handle automatic user login time update
	if( isset($_SESSION['user']) && validateUserTime() ){
		updateUserTime();
	}
?>

<html>
	<head>
	
		<?php get("header"); ?>
		
		<link rel="shortcut icon" href="favicon.ico" />
		
	</head>
	<body>
	
		<?php get( "log" ); ?>
	
		<?php get( "nav" ); ?>

		<?php
		
			# get page content
			# following page specification is allowed:
			# <URL>?page=<PAGE>
			# <URL>?p=<PAGE>
			# <URL>?<PAGE>
			# where <URL> is the site url and <PAGE> the page name
			# if no page is selected. 'home' will be shown.
			$page = getPage( $_GET );
			if( $page ) get($page);
			else get( "home" );
			
		?>
		
		<?php get( "footer" ); ?>

	</body>
</htm
