<?php global $cfg; ?>
<div class="d-flex justify-content-center p-3">

	<div class="container">
		
		<div class="row">
			<div class="col-md-8 bg-success">
			
				<div class="row">
					<div class="col-md-12 bg-info text-light p-2">
						<h3>Hilfe anbieten</h3>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-4">
				#ADD#
			</div>
			
		</div>
		<div class="row mt-3">
			
			<?php if( !isset($_SESSION['user']) || !validateUserTime() ){ ?>
			<div class="col-md-12">
	
				<div class="row">
					<div class="col-md-12 bg-info text-light p-2">
						<h3>Anmelden</h3>
					</div>
				</div>
				
				<hr />
				
				<div class="m-3">
					<p>
						<small>Sie haben bereits einen Account? Zum <a href="?home"><i class="fas fa-sign-in-alt"></i> Login</a></small>
					</p>
				</div>		
				
				
				
				<!-- Load auth plugin -->
				<?php getJs('auth'); ?>
				<span id="authurl" value="<?php global $php; print $php."auth.php" ?>" hidden></span>
			
				<div class="bg-warning p-3">
					<h4>Pflichtfelder</h4>
				
					<div class="form-group">						
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" aria-describedby="Ihr Name" placeholder="Ihr Name" required>
					</div>
					
					<div class="form-group">						
						<label for="plz">PLZ</label>
						<input type="text" class="form-control" id="plz" aria-describedby="Postleitzahl" placeholder="Postleitzahl" required>
					</div>
					
					<div class="form-group">						
						<label for="pw">Passwort</label>
						<input type="password" class="form-control" id="pw" aria-describedby="Passwort" placeholder="Passwort" required>
					</div>
					
					<hr />
					
					<b>entweder:</b>
					<div class="form-group">						
						<label for="phone">Telefon</label>
						<input type="tel" class="form-control" id="phone" aria-describedby="Ihre Telefonnummer" placeholder="Ihre Telefonnummer">
					</div>	
					
					<b>oder</b>				
					<div class="form-group">					
						<label for="mail">E-Mail Adresse</label>
						<input type="email" class="form-control" id="mail" aria-describedby="E-Mail Adresse" placeholder="E-Mail Adresse">
					</div>
				</div>
					
				<div class="p-3">
					<h4>Freiwillig</h4>
				
					<div class="form-group">						
						<label for="adress">Adresse</label>
						<textarea type="text" class="form-control" id="adress" aria-describedby="Ihre Adresse" placeholder="Ihre Adresse" rows=4></textarea>
					</div>	
					
				</div>	
				
				<div class="mt-3"></div>
				
				<script>
					$(document).ready(function(){
						$(".form-group > input").keypress(function(event){
							if( event.type == "keypress" && event.which == 13 )
								register();
						});
					});
				</script>
				<?php } ?>
				
			</div>			
			
		</div>
		
	</div>

</div>
