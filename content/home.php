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
					<a href=""><button class="btn btn-lg btn-success"><i class="fas fa-plus"></i> Biete Hilfe</button></a>
					<a href=""><button class="btn btn-lg btn-danger"><i class="fa fa-plus fa-fw"></i> Suche Hilfe</button></a>
				</p>
			</div>				
			
			<div class="col-md-3">
				<?php getJs('auth'); ?>
				<form>
				
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
					
					<hr />
					
					<div class="form-group">						
						<label for="pw">Passwort</label>
						<input type="password" class="form-control" id="pw" aria-describedby="Passwort" placeholder="Passwort" required>
					</div>
					
					<p>
					<button class="btn btn-info" onClick="login();"><i class="fas fa-sign-in-alt"></i> Login</button>
				</p>
				
				</form>
				
				<hr />
				
				<p>
					Noch keinen Account? Jetzt anmelden und helfen!
				</p>
				
				<p>
					<button class="btn btn-info"><i class="fa fa-plus fa-fw"></i> Anmelden</button>
				</p>
				
			</div>
				
		</div>
	
	</div>

</div>

<hr />

<div class="d-flex justify-content-center p-3">
</div>
