<?php
	// $url = 'http://bidikmisi.dikti.go.id';
	// $output = file_get_contents($url);
	// echo $output;
	$url = "http://monev.anggaran.depkeu.go.id/2015/login";

	$ch = curl_init();    
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	curl_setopt($ch, CURLOPT_URL, $url); 
	$cookie = 'cookies.txt';
	$timeout = 30;

	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT,         10); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,  $timeout );
	curl_setopt($ch, CURLOPT_COOKIEJAR,       $cookie);
	curl_setopt($ch, CURLOPT_COOKIEFILE,      $cookie);

	curl_setopt ($ch, CURLOPT_POST, 1); 
	curl_setopt ($ch,CURLOPT_POSTFIELDS,"user_name=mekl024&user_password=intelpentium");     

	$result = curl_exec($ch);

	/* //OPTIONAL - Redirect to another page after login
	$url = "http://aftabcurrency.com/some_other_page";
	curl_setopt ($ch, CURLOPT_POST, 0); 
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	 */ //end OPTIONAL 

	curl_close($ch); 
	echo $result;
?>