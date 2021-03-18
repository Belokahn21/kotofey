<?php
//$str = "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";
////echo (base64_decode($str));
////echo gzdecode(base64_decode($str));
//
//$url = "http://www.dealstan.com";
//$url = "https://api.edadeal.ru/web/search/offers?count=30&locality=barnaul&page=1&retailer=maria-ra";
//
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url); // Define target site
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Return page in string
//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2');
//curl_setopt($ch, CURLOPT_ENCODING, "gzip");
//curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // Follow redirects
//
//$return = curl_exec($ch);
//$info = curl_getinfo($ch);
//curl_close($ch);
//
//$return = gzdecode(substr($return, 10));
////$return = gzinflate($return);
////$return = gzdecode(stripslashes($str));
//print_r($return);
