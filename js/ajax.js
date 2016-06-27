// here we define global variable
var ajaxdestination="";
var ajaxdestination2="";
var ajaxdestination3="";
var ajaxdestination4="";

function getdata(what,where) { // get data from source (what)
	 try {
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest():
			new ActiveXObject("Microsoft.XMLHTTP");
	 }
	 catch (e) { /* do nothing */ }
	
	 document.getElementById(where).innerHTML ="<center style='margin-top: 10%'><img src='http://localhost/depkes/Depkes/images/main/loading.gif'></center>";
	// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
	 ajaxdestination=where;
	 xmlhttp.onreadystatechange = triggered; // when request finished, call the function to put result to destination DIV
	 xmlhttp.open("GET", what);
	 xmlhttp.send(null);
	 return false;
}
		
function triggered() { // put data returned by requested URL to selected DIV
	if (xmlhttp.readyState == 4) if (xmlhttp.status == 200) document.getElementById(ajaxdestination).innerHTML =xmlhttp.responseText;
}

function getdata2(what,where) { // get data from source (what)
	try {
		xmlhttp_two = window.XMLHttpRequest?new XMLHttpRequest():
			new ActiveXObject("Microsoft.XMLHTTP");
	 }
	 catch (e) { /* do nothing */ }
			
	 document.getElementById(where).innerHTML ="<center style='margin-top: 10%'><img src='http://localhost/depkes/Depkes/images/main/loading.gif'></center>";
	// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
	 ajaxdestination2=where;
	 xmlhttp_two.onreadystatechange = triggered2; // when request finished, call the function to put result to destination DIV
	 xmlhttp_two.open("GET", what);
	 xmlhttp_two.send(null);
	 return false;
}

function triggered2() { // put data returned by requested URL to selected DIV
	if (xmlhttp_two.readyState == 4) if (xmlhttp_two.status == 200) document.getElementById(ajaxdestination2).innerHTML =xmlhttp_two.responseText;
}

function getdata3(what,where) { // get data from source (what)
	 try {
	   xmlhttp_three = window.XMLHttpRequest?new XMLHttpRequest():
	  		new ActiveXObject("Microsoft.XMLHTTP");
	 }
	 catch (e) { /* do nothing */ }
	
	 document.getElementById(where).innerHTML ="<center style='margin-top: 10%'><img src='http://localhost/depkes/Depkes/images/main/loading.gif'></center>";
	// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
	 ajaxdestination3=where;
	 xmlhttp_three.onreadystatechange = triggered3; // when request finished, call the function to put result to destination DIV
	 xmlhttp_three.open("GET", what);
	 xmlhttp_three.send(null);
	 return false;
}
	
function triggered3() { // put data returned by requested URL to selected DIV
	if (xmlhttp_three.readyState == 4) if (xmlhttp_three.status == 200) document.getElementById(ajaxdestination3).innerHTML =xmlhttp_three.responseText;
}
	
function getdata4(what,where) { // get data from source (what)
	 try {
	   xmlhttp_four = window.XMLHttpRequest?new XMLHttpRequest():
	  		new ActiveXObject("Microsoft.XMLHTTP");
	 }
	 catch (e) { /* do nothing */ }
		
	 document.getElementById(where).innerHTML ="<center style='margin-top: 10%'><img src='http://localhost/depkes/Depkes/images/main/loading.gif'></center>";
	// we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
	 ajaxdestination4=where;
	 xmlhttp_four.onreadystatechange = triggered4; // when request finished, call the function to put result to destination DIV
	 xmlhttp_four.open("GET", what);
	 xmlhttp_four.send(null);
	 return false;
}
		
function triggered4() { // put data returned by requested URL to selected DIV
	if (xmlhttp_four.readyState == 4) if (xmlhttp_four.status == 200) document.getElementById(ajaxdestination4).innerHTML =xmlhttp_four.responseText;
}