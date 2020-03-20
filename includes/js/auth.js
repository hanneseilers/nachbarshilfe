function getBaseURL(){
	var url = document.location.href;
	return url.substr( 0, url.lastIndexOf('/')+1 );
};

function _register(callback=null){

	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	var phone = btoa( document.getElementById('phone').value );
	var mail = btoa( document.getElementById('mail').value );
	var pw = md5(document.getElementById('pw').value );
	var name = btoa( encodeURI(document.getElementById('name').value) );
	var plz = btoa( document.getElementById('plz').value );
	var adress = btoa( encodeURI(document.getElementById('adress').value) );
	
	url = url + authurl
		+ "?t=1&phone=" + phone
		+ "&mail=" + mail
		+ "&pw=" + pw
		+ "&name=" + name
		+ "&plz=" + plz
		+ "&adress=" + adress;
	//console.log( url );
	
	httpRequest( url, function(response){
		if( response.length > 0 && callback != null ){
			callback( response );
		} else {
			alert( "Registrierung fehlgeschlagen!");
		}
	} );

};

function register(){
	_register( function(response){
		console.log( "registered user" );
	});
}

function login(reload=true){
	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	var phone = btoa( document.getElementById('phone').value );
	var mail = btoa( document.getElementById('mail').value );
	var pw = md5( document.getElementById('pw').value );
	
	url = url + authurl + "?t=0&phone=" + phone
		+ "&mail=" + mail
		+ "&pw=" + pw;
	//console.log( url );
		
	httpRequest( url, function(response){
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
	
	url = url + authurl
		+ "?t=2&phone=" + phone
		+ "&mail=" + mail
		+ "&pw=" + pw
		+ "&name=" + name
		+ "&plz=" + plz
		+ "&adress=" + adress
		+ "&userid=" + id;		
	//console.log( url );
	
	httpRequest( url, function(response){
		if( response.length > 0 && callback != null ){			
			callback( response );
		}
	} );

}

function update(){
	_update( function(response){
		location.reload();
	} );
}

function logout(reload=true){

	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	
	url = url + authurl
		+ "?t=-1";		
	//console.log( url );
	
	httpRequest( url, function(){
		console.log( "logged out" );
		
		if( reload )
				location.reload();
	} );

}

function httpRequest(theUrl, callback)
{
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange = function() { 
	
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
		callback(xmlHttp.responseText);
	}
	
	xmlHttp.open("GET", theUrl, true); // true for asynchronous 
	xmlHttp.send(null);
	
	return true;
};
