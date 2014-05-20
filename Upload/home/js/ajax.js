
function ajax_load(url, id){
	var loading = "<div align='center'><img src='img/loading.gif'></div>";
	var ajax = new AJAX_Handler();
	ajax.onreadystatechange(get_done);
	ajax.send(url);
	document.getElementById(id).innerHTML = loading;
	function get_done(){
		if(ajax.handler.readyState == 4 && ajax.handler.status == 200){
			document.getElementById(id).innerHTML = ajax.handler.responseText;
		}
	}

}



var AJAX_Handler=function()
{this.xmlHttp=false;try{this.xmlHttp=new XMLHttpRequest();}catch(e){try{this.xmlHttp=new ActiveXObject('Microsoft.XMLHTTP');}catch(e){try{this.xmlHttp=new ActiveXObject('Msxml2.XMLHTTP');}catch(e){alert('Your browser does not support AJAX');return;}}}
this.onreadystatechange=function(updateFunc){this.updateFunc=updateFunc;}
this.send=function(url,param){param=param?param:"";this.xmlHttp.onreadystatechange=this.updateFunc;this.xmlHttp.open("POST",url,true);this.xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");this.xmlHttp.setRequestHeader("Content-length",param.length);this.xmlHttp.setRequestHeader("Connection","close");this.xmlHttp.send(encodeURI(param));this.handler=this.xmlHttp;}}