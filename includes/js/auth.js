function getBaseURL(){
	var url = document.location.href;
	return url.substr( 0, url.lastIndexOf('/')+1 );
}

function register(){
}

function login(){
	var url = getBaseURL();
	var	authurl = document.getElementById('authurl').getAttribute('value');
	var phone = document.getElementById('phone').value;
	var mail = document.getElementById('mail').value;
	var pw = md5( document.getElementById('pw').value );
	
	url = url + authurl + "?t=0&phone=" + btoa(phone)
		+ "&mail=" + btoa(mail)
		+ "&pw=" + btoa(pw);
	httpRequest( url, function(response){
		if( response.length > 0 ){
			console.log("login success");
			document.getElementById('err_loginfailed').style.display = 'none';
		} else {
			console.error( "login failed" );
			document.getElementById('err_loginfailed').style.display = '';
		}
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
}
