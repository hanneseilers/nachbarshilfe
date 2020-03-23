<?php global $cfg; ?>
<div class="d-flex justify-content-center p-3">
<span id="offerurl" value="<?php global $php; print $php."offer.php" ?>" hidden></span>

	<div class="container">
		
		<div class="row">
			<div class="col-md-8">
			
				<div class="">
					<div class="col-md-12 bg-success text-light p-2">
						<h3><i class="fas fa-hands-helping fa-fw"></i> Hilfe anbieten</h3>
					</div>
					
					<hr />
					
					<div class="form-group">						
						<label for="amount">Menge?</label>
						<select multiple class="form-control" id="amount" aria-describedby="Menge an Hilfe">
							<option value=10 selected>Wenig</option>
							<option value=30>Mittel</option>
							<option value=90>Viel</option>
						</select>
						<small>
							Wenig: ca. 1-2 mal pro Woche insgesamt 5-10 Teile einkaufen. Keine Extra-Touren.<br/>
							Mittel: ca. 2-3 mal pro Woche insgesamt 10-30 Teile einkaufen. Extra-Touren nur wenn unbedingt n&ouml;tig.<br />
							Viel: min. 3 mal pro Woche bis zu 90 Teile einkaufen. Es geht mehr und Extra-Touren.
						</small>
					</div>
					
					<div class="form-group">						
					<label for="description">Beschreibung</label>
					<textarea type="text" class="form-control" id="description" aria-describedby="Ihre Text" placeholder="Beschreibung (optional)" rows=4></textarea>
				</div>	
					
				</div>
				
			</div>
			
			<div class="col-md-4">
				<p>
					<a href="javascript: addOffer();"><button class="btn btn-lg btn-success"><i class="fas fa-plus"></i> Hilfe anbieten</button></a>
				</p>
				<p>
					<i class="fas fa-exclamation"></i> Bitte biete nur Hilfe an, die du auch wirklich leisten kannst. Übernehm dich nicht! Hilf lieber nur ein wenig, daf&uuml;r aber verl&auml;sslich.
				</p>
				<p>
					<small>Falls du noch nicht angemeldet bist, f&uuml;ll einfach das Anmeldformular mit aus.</small>
				</p>
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
				
				<?php
					} else {
						$usr = $_SESSION['user'];
				 ?>
					<span id="userid" value="<?php print $usr['id'] ?>" hidden></span>
				<?php } ?>
				
			</div>			
			
		</div>
		
		<script>
			$(document).ready(function(){
				$(".form-group > input").keypress(function(event){
					if( event.type == "keypress" && event.which == 13 )
						addOffer();
				});
			});
		</script>
		
		<?php getJs('offer.js'); ?>	

	</div>

</div>
