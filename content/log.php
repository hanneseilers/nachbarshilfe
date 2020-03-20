<div id="logmsg" class="overlay">

	<div class="alert alert-info" id="log_info" onClick="log_off('log_info');">
	</div>
	
	<div class="alert alert-warning" id="log_warning"onClick="log_off('log_warning');">
	</div>
	
	<div class="alert alert-danger" id="log_danger"onClick="log_off('log_danger');">
	</div>
	
	<div class="alert alert-success" id="log_success"onClick="log_off('log_success');">
	</div>
	
</div>

<script>	
	function log_on(id="") {
	  document.getElementById(id).style.display = "block";
	}

	function log_off(id='') {
	  document.getElementById(id).style.display = "none";
	}
	
	function log_info(msg=""){
		document.getElementById('log_info').innerHTML = msg;
		log_on('log_info');
	}
	
	function log_warn(msg=""){
		document.getElementById('log_warning').innerHTML = msg;
		log_on('log_warning');
	}
	
	function log_err(msg=""){
		document.getElementById('log_danger').innerHTML = msg;
		log_on('log_danger');
	}
	
	function log_success(msg=""){
		document.getElementById('log_success').innerHTML = msg;
		log_on('log_success');
	}
</script>
