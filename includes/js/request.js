function loadRequests(element="#requestsBody", plz=null){
	var	requesturl = document.getElementById('requesturl').getAttribute('value');
	var request = "";
	
	if( plz != null ){
		request = "&user=1&plz=" + plz;
	} else {
		request = "&user=1";
	}
	
	var url = requesturl + "?t=4" + request;
	//console.log(url);
	$(element).load( url );
}

function addRequest(){

	// check if to register first
	var userid = null;
	if( document.getElementById('userid') == null ){
		
		console.log("registering new user");
		_register(function( response ){
		
			if( (typeof response) == "string" && response.length > 0  ){
			
				console.log(response);
				var user = JSON.parse(response);
				_addRequest( Number(user['id']) );
			
			}
		
		});
		
	} else {	
		userid = Number(document.getElementById('userid').getAttribute('value'));
		_addRequest(userid);
	}

}

function _addRequest(userid=null){

	if( userid != null ){
		
		var url = getBaseURL();
		var	requesturl = document.getElementById('requesturl').getAttribute('value');
		var amount = Number( document.getElementById('amount').value );
		var text = btoa( encodeURI(document.getElementById('description').value) );
		
		url = url + requesturl + "?t=0&user=" + userid
			+ "&amount=" + amount
			+ "&text=" + text;
		//console.log(url);
		
		httpRequest( url, function(response){
			if( response.length > 0 ){
				log_success( "Anfrage hinzugefügt." );
			}
		} );
		
	}

}

function deleteRequest(id=null){

	if( id != null ){
	
		var url = getBaseURL();
		var	requesturl = document.getElementById('requesturl').getAttribute('value');
		url = url + requesturl + "?t=2&id=" + id;
		//console.log(url);
		
		httpRequest( url, function(response){
			if( response.length > 0 ){
				log_success( "Eintrag gelöscht" );
				loadRequests();
			}
		} );
		
	}

}
