function loadOffers(element="#offersBody", plz=null){
	var	offerurl = document.getElementById('offerurl').getAttribute('value');
	var data = { 't': 4 };
	
	if( plz != null ){
		dataPush( data, {
			'user':  1,
			'plz': plz
		});
	} else {
		dataPush( data, { 'user': 1 } );
	}
	
	var url = offerurl;
	//console.log(url);
	$(element).load( url, data );
}

function addOffer(){

	// check if to register first
	var userid = null;
	if( document.getElementById('userid') == null ){
		
		console.log("registering new user");
		_register(function( response ){
		
			if( (typeof response) == "string" && response.length > 0  ){
			
				console.log(response);
				var user = JSON.parse(response);
				_addOffer( Number(user['id']) );
			
			}
		
		});
		
	} else {	
		userid = Number(document.getElementById('userid').getAttribute('value'));
		_addOffer(userid);
	}

}

function _addOffer(userid=null){

	if( userid != null ){
		
		var url = getBaseURL();
		var	offerurl = document.getElementById('offerurl').getAttribute('value');
		var amount = Number( document.getElementById('amount').value );
		var text = btoa( encodeURI(document.getElementById('description').value) );
		
		url = url + offerurl;
		var data = {
			"t": 0,
			"user": userid,
			"amount": amount,
			"text": text };
		//console.log(url);
		
		$.post( url, data, function(response){
			if( response.length > 0 ){
				log_success( "Angebot hinzugefügt." );
			}
		} );
		
	}

}

function deleteOffer(id=null){

	if( id != null ){
	
		var url = getBaseURL();
		var	offerurl = document.getElementById('offerurl').getAttribute('value');
		url = url + offerurl;
		var data = {
			"t": 2,
			"id": id };
		//console.log(url);
		
		$.post( url, data, function(response){
			if( response.length > 0 ){
				log_success( "Eintrag gelöscht" );
				loadOffers();
			}
		} );
		
	}

}
