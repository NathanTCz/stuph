function process(str) {
xmlHttp=new XMLHttpRequest();

	if (xmlHttp.readyState == 0 || xmlHttp.readyState == 4) {

		xmlHttp.onreadystatechange = processServerResponse;
		
		xmlHttp.open("GET", "/ajax/php/handlesearch.php?q=" + str,true);
		xmlHttp.send();
		}

  if (str.length == 0)
    document.getElementById("trash").style.display="none";
  else
    document.getElementById("trash").style.display="block";
}

function processServerResponse() {
	if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
		document.getElementById("trash").innerHTML=xmlHttp.responseText;
	}
}