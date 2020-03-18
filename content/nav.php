<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="?home">Nachbarshilfe</a>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<div class="navbar-nav mr-auto">
			<a class="nav-item nav-link" href="?home">Home</a>
			<a class="nav-item nav-link" href="?offer">Biete</a>
			<a class="nav-item nav-link" href="?search">Suche</a>
		</div>
		<div class="navbar-nav pull-right">
			<?php if( isset($_SESSION['user']) && validateUserTime() ){ ?>
				<a class="nav-item nav-link" href="javascript: logout();"><i class="fas fa-sign-out-alt"></i> Logout</a>
			<?php } else { ?>
				<a class="nav-item nav-link" href="?register"><i class="fa fa-plus fa-fw"></i> Anmelden</a>
			<?php } ?>
		</div>
	</div>
</nav>
