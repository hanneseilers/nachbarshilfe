<h3>Login</h3>
<div class="alert alert-danger" id = "err_loginfailed" style="display: none;"><small>Login fehlgeschlagen</small></div>
<hr />

<p>				
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

</p>	
<p>
	
	<button class="btn btn-info" onClick="login();"><i class="fas fa-sign-in-alt"></i> Login</button>
	
	<script>
		$(document).ready(function(){
			$(".form-group > input").keypress(function(event){
				if( event.type == "keypress" && event.which == 13 )
					login();
			});
		});
	</script>					
</p>		

<hr />

<p>
	Noch keinen Account? Jetzt anmelden und helfen!
</p>

<p>
	<a href="?register"><button class="btn btn-info"><i class="fa fa-plus fa-fw"></i> Anmelden</button></a>
</p>
