<h3><?php print( base64_decode( $_SESSION['user']['name'] ) ); ?></h3>
<hr />

<!-- Load auth plugin -->
<?php getJs('auth'); ?>
<span id="authurl" value="<?php global $php; print $php."auth.php" ?>" hidden></span>

<p>

	<?php $usr = $_SESSION['user'] ?>
	
	<small>*Plichtangaben</small>
	
	<span id="userid" value="<?php print $usr['id'] ?>" hidden></span>
	
	<div class="form-group">						
		<label for="name">Name*</label>
		<input type="text" class="form-control" id="name" aria-describedby="Ihr Name" placeholder="Ihr Name"
			value="<?php print( base64_decode($usr['name']) );?>" required>
	</div>
	
	<div class="form-group">						
		<label for="plz">PLZ*</label>
		<input type="text" class="form-control" id="plz" aria-describedby="Postleitzahl" placeholder="Postleitzahl"
			value="<?php print( base64_decode($usr['plz']) );?>" required>
	</div>
	
	<div class="form-group">						
		<label for="pw">Passwort*</label>
		<input type="password" class="form-control" id="pw" aria-describedby="Passwort" placeholder="Passwort" required>
	</div>
	
	<hr />
	
	<b>entweder*:</b>
	<div class="form-group">						
		<label for="phone">Telefon</label>
		<input type="tel" class="form-control" id="phone" aria-describedby="Ihre Telefonnummer" placeholder="Ihre Telefonnummer"
			value="<?php print( base64_decode($usr['phone']) );?>">
	</div>	
	
	<b>oder*</b>				
	<div class="form-group">					
		<label for="mail">E-Mail Adresse</label>
		<input type="email" class="form-control" id="mail" aria-describedby="E-Mail Adresse" placeholder="E-Mail Adresse"
			value="<?php print( base64_decode($usr['mail']) );?>">
	</div>
	
	<hr />
	
	<div class="form-group">						
		<label for="adress">Adresse</label>
		<textarea type="text" class="form-control" id="adress" aria-describedby="Ihre Adresse" placeholder="Ihre Adresse" rows=4
			value="<?php print( base64_decode($usr['adress']) );?>"></textarea>
	</div>	
		
</p>	
<p>
	
	<button class="btn btn-info" onClick="login();"><i class="fas fa-save"></i> Spreichern</button>
	
	<script>
		$(document).ready(function(){
			$(".form-group > input").keypress(function(event){
				if( event.type == "keypress" && event.which == 13 ){
					// TODO
				
				}
			});
		});
	</script>					
</p>		
