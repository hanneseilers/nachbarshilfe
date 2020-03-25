function dataPush(dict, data){
	for( var key in data ){
		dict[key] = data[key];
	}
}

function getBaseURL(){
	var url = document.location.href;
	return url.substr( 0, url.lastIndexOf('/')+1 );
};
