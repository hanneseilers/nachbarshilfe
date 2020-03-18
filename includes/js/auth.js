function getBaseURL(){
	var url = document.location.href;
	return url.substr( 0, url.lastIndexOf('/')+1 );
}

function register(){
}

function login(){
	var url = getBaseURL();
	var phone = document.getElementById('phone').value;
	var mail = document.getElementById('mail').value;
	var pw = md5( document.getElementById('pw').value );
}
