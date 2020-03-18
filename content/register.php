<?php global $cfg; ?>
<div class="d-flex justify-content-center p-3">

	<div class="container">
	
		<div class="row">
			<div class="col-md-12 bg-info text-light p-2">
				<h1>Anmelden</h1>
			</div>
		</div>
		
		<hr />
		
		<div class="m-3">
			<p>
				<small>Sie haben bereits einen Account? Zum <a href="?home"><i class="fas fa-sign-in-alt"></i> Login</a></small>
			</p>
		</div>		
		
		<form>	
			<div class="row">
			
				<div class="col-md-5 bg-warning p-3">
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
						<input type="password" class="form-control" id="plz" aria-describedby="Passwort" placeholder="Passwort" required>
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
				
				<div class="col-md-5 p-3">
					<h4>Freiwillig</h4>
				
					<div class="form-group">						
						<label for="address">Adresse</label>
						<input type="text" class="form-control" id="phone" aria-describedby="Ihre Adresse" placeholder="Ihre Adresse">
					</div>	
					
				</div>
				
			</div>		
		</form>
		<div class="mt-3"></div>
		
		<p>
			<button class="btn btn-warning btn-lg"><i class="fas fa-chevron-right"></i> Anmelden</button>
		</p>
		
	</div>

</div>
