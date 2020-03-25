function _register(callback=null){

	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	var phone = btoa( document.getElementById('phone').value );
	var mail = btoa( document.getElementById('mail').value );
	var pw = md5(document.getElementById('pw').value );
	var name = btoa( encodeURI(document.getElementById('name').value) );
	var plz = btoa( document.getElementById('plz').value );
	var adress = btoa( encodeURI(document.getElementById('adress').value) );
	
	url = url + authurl;
	var data = {
		"t": 1,
		"phone": phone,
		"mail": mail,
		"pw": pw,
		"name": name,
		"plz": plz,
		"adress": adress };
	//console.log( url );
	//console.log(data);
	
	$.post( url, data, function(response){
		console.log(response);
		if( response.length > 0 && callback != null ){
			callback( response );
			log_success( "Anmeldung erfolgreich!" );
		} else {
			log_err( "Registrierung fehlgeschlagen!");
		}
	} );

};

function register(){
	_register( function(response){
		console.log( "registered user" );
		// TODO
	});
}

function login(reload=true){
	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	var phone = btoa( document.getElementById('phone').value );
	var mail = btoa( document.getElementById('mail').value );
	var pw = md5( document.getElementById('pw').value );
	
	url = url + authurl ;
	var data = {
		"t": 0,
		"phone": phone,
		"mail": mail,
		"pw": pw };
	//console.log( url );
		
	$.post( url, data, function(response){
		if( response.length > 0 ){
			console.log( "login successfull" );
			document.getElementById('err_loginfailed').style.display = 'none';
			if( reload ){
				log_success( "Login erfolgreich. Bitte warten ..." );
				location.reload();
			}
		} else {
			log_err( "Login fehlgeschlagen!" );
		}
	} );
};

function _update( callback=null){

	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	var phone = btoa( document.getElementById('phone').value );
	var mail = btoa( document.getElementById('mail').value );
	var pw = md5(document.getElementById('pw').value );
	var name = btoa( encodeURI( document.getElementById('name').value ) );
	var plz = btoa( document.getElementById('plz').value );
	var adress = btoa( encodeURI( document.getElementById('adress').value ) );
	var id = document.getElementById('userid').getAttribute('value');
	
	url = url + authurl;
	var data = {
		"t": 2,
		"phone": phone,
		"mail": mail,
		"pw": pw,
		"name": name,
		"plz": plz,
		"adress": adress,
		"userid": id };		
	//console.log( url );
	
	$.post( url, data, function(response){
		if( response.length > 0 && callback != null ){			
			callback( response );
		}
	} );

}

function updateUserInfo(){
	_update( function(response){
		location.reload();
	} );
}

function logout(reload=true){

	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	
	url = url + authurl;
	var data = { "t": -1 };
	//console.log( url );
	
	$.post( url, data, function(){
		console.log( "logged out" );
		
		if( reload )
				location.reload();
	} );

}
