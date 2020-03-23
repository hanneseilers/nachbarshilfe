function getUserData(callback=null){

	var url = getBaseURL();
	var	offerurl = document.getElementById('userurl').getAttribute('value');
	
	url = url + offerurl + "?t=0";
	//console.log(url);
	
	httpRequest( url, function(response){
		if( response.length > 0 && callback != null ){
			callback( JSON.parse(response) );
		}
	} );

}
