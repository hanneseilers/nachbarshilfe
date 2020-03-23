<?php global $cfg; ?>


<?php
	if( isset($_SESSION['user']) && validateUserTime() ){
	
		getJs('user.js');
		getJs('offer.js');
		getJs('request.js');
?>

	<span id="userurl" value="<?php global $php; print $php."user.php" ?>" hidden></span>
	<span id="offerurl" value="<?php global $php; print $php."offer.php" ?>" hidden></span>
	<span id="requesturl" value="<?php global $php; print $php."request.php" ?>" hidden></span>

<?php
}
?>
<div class="d-flex justify-content-center p-3">

	<div class="container">
	
		<div class="row">
			<div class="col-md-12 bg-primary text-light p-2">
				
				<h1><i class="fas fa-hands-helping fa-fw"></i> <?php print $cfg['site']['name'];?></h1>
				
			</div>
		</div>
		
		<hr />
		
		<div class="row">
			
			<div class="col-md-9">
				<p>
					<a href="?offer"><button class="btn btn-lg btn-success"><i class="fas fa-plus"></i> Biete Hilfe</button></a>
					<a href="?request"><button class="btn btn-lg btn-danger"><i class="fa fa-plus fa-fw"></i> Suche Hilfe</button></a>
				</p>
				
				<hr />
				
				
				<?php
					if( isset($_SESSION['user']) && validateUserTime() ){
				?>
				<!-- ACCORDION START -->
				
				<div id="accordion">
				
					<div class="card">
						<div class="card-header" id="offersHead">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed text-success" data-toggle="collapse" data-target="#offers" aria-expanded="false" aria-controls="offers">
<i class="event-toggle fa fa-fw fa-chevron-down" id="offersToggle"></i> Meine Angebote
								</button>
							</h5>
						</div>

						<div id="offers" class="collapse" aria-labelledby="offersHead" data-parent="#accordion">
							<script>
								$(document).ready( function(){ loadOffers("#offersBody"); } );									
							</script>
							<div class="card-body"></div>
								<table class="table">
									<thead>
										<tr>
											<th>aktiv seit ? Stunden</th>
											<th>Menge</th>
											<th>Text</th>
										</tr>
									</thead>
									<tbody id="offersBody">
									</tbody>
								</table>
						</div>
					</div>
					
					<div class="card">
						<div class="card-header" id="reqestsHead">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed text-danger" data-toggle="collapse" data-target="#requests" aria-expanded="false" aria-controls="requests">
									<i class="event-toggle fa fa-fw fa-chevron-down" id="requestToggle"></i> Meine Hilfegesuche
								</button>
							</h5>
						</div>
						<div id="requests" class="collapse" aria-labelledby="reqestsHead" data-parent="#accordion">
							<script>
								$(document).ready( function(){ loadRequests("#requestsBody"); } );									
							</script>
							<div class="card-body">
								<table class="table">
									<thead>
										<tr>
											<th>aktiv seit ? Stunden</th>
											<th>Menge</th>
											<th>Text</th>
										</tr>
									</thead>
									<tbody id="requestsBody">
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="card">
						<div class="card-header" id="tasksHead">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#tasks" aria-expanded="true" aria-controls="tasks">
									<i class="event-toggle fa fa-fw fa-chevron-down" id="tasksToggle"></i> <i class="fas fa-tasks"></i> Meine Aufgaben
								</button>
							</h5>
						</div>
						<div id="tasks" class="collapse" aria-labelledby="tasksHead" data-parent="#accordion">
							<div class="card-body">
								TASKS
							</div>
						</div>
					</div>
					
				</div>
				<!-- ACCORDION END -->
				
				<hr />
				
				<!-- ACCORDION START -->
				<div id="accordion">
				
					<div class="card">
						<div class="card-header" id="offersPLZHead">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed text-success" data-toggle="collapse" data-target="#offersPLZ" aria-expanded="false" aria-controls="offersPLZ">
<i class="event-toggle fa fa-fw fa-chevron-down" id="offersToggle"></i> <i class="fas fa-search"></i> Anfragen in der N&auml;he
								</button>
							</h5>
						</div>

						<div id="offersPLZ" class="collapse" aria-labelledby="offersPLZHead" data-parent="#accordion">
							<script>
								$(document).ready( function(){									
									getUserData( function(userdata)
										{ loadOffers("#users_plz_offersBody", userdata['plz'] ); }
									);						
								});									
							</script>
							<div class="card-body"></div>
								<table class="table">
									<thead>
										<tr>
											<th>aktiv seit ? Stunden</th>
											<th>Menge</th>
											<th>Text</th>
										</tr>
									</thead>
									<tbody id="users_plz_offersBody">
									</tbody>
								</table>
						</div>
					</div>
					
				</div>
				<!-- ACCORDION END -->
				
				<?php } ?>
				
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
