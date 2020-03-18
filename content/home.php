<?php global $cfg; ?>
<div class="d-flex justify-content-center p-3">

	<div class="container">
	
		<div class="row">
			<div class="col-md-12 bg-primary text-light p-2">
				
				<h1><?php print $cfg['site']['name'];?></h1>
				
			</div>
		</div>
		
		<hr />
		
		<div class="row">
			
			<div class="col-md-9">
				<p>
					<a href="?offer"><button class="btn btn-lg btn-success"><i class="fas fa-plus"></i> Biete Hilfe</button></a>
					<a href=""><button class="btn btn-lg btn-danger"><i class="fa fa-plus fa-fw"></i> Suche Hilfe</button></a>
				</p>
			</div>				
			
			<div class="col-md-3">
			
				<?php
					if( isset($_SESSION['user']) && validateUserTime() ){
						include( $content."user-info.php" );
					} else{
						global $content;
						include( $content."login-form.php" );
					}
				?>
				
			</div>
				
		</div>
	
	</div>

</div>

<hr />

<div class="d-flex justify-content-center p-3">
</div>
