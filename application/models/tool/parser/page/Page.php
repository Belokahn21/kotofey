<?php

namespace app\models\tool\parser\page;


use app\models\tool\Debug;
use Exception;

class Page
{
	public $login_url;
	public $url;
	public $auth_data = array();
	public $use_ajax = false;

	public function __construct($url, $auth_data, $use_ajax = false)
	{
		$this->login_url = $url;
		$this->auth_data = $auth_data;
		$this->use_ajax = $use_ajax;
	}

	public function content($url_content)
	{
		//The username or email address of the account.
		define('USERNAME', 'popugau@gmail.com');

		//The password of the account.
		define('PASSWORD', '123qweR%');

		//Set a user agent. This basically tells the server that we are using Chrome ;)
		define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');

		//Where our cookie information will be stored (needed for authentication).
		define('COOKIE_FILE', 'cookie.txt');

		//URL of the login form.
		define('LOGIN_FORM_URL', $this->login_url);

		//Login action URL. Sometimes, this is the same URL as the login form.
		define('LOGIN_ACTION_URL', $this->login_url);


		//An associative array that represents the required form fields.
		//You will need to change the keys / index names to match the name of the form
		//fields.
		$postValues = array(
			'login' => USERNAME,
//            'User[email]' => USERNAME,
			'password' => PASSWORD,
//            'User[password]' => PASSWORD,
		);

		//Initiate  cURL.
		$curl = curl_init();

		//Set the URL that we want to send our POST request to. In this
		//case, it's the action URL of the login form.
		curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);

		//Tell cURL that we want to carry out a POST request.
		curl_setopt($curl, CURLOPT_POST, true);


		//We don't want any HTTPS errors.
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		//Where our cookie details are saved. This is typically required
		//for authentication, as the session ID is usually saved in the cookie file.
		curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Host: www.sat-altai.ru',
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:76.0) Gecko/20100101 Firefox/76.0',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
			'Accept-Encoding: gzip, deflate',
			'Content-Type: application/x-www-form-urlencoded',
			'Content-Length: 45',
			'Origin: http://www.sat-altai.ru',
			'Connection: keep-alive',
			'Referer: http://www.sat-altai.ru/',
			'Cookie: beget=begetok; 5cb57b4bc74b3f10cb5443577b2a72b2=d0615c8e0e67c51b88abb7d7d89a9331; 4c2a708a161855a77150c97cad9c3b16=4d8bbe3d4fc4404993fd82fc8769b242',
			'Upgrade-Insecure-Requests: 1',
			'Pragma: no-cache',
			'Cache-Control: no-cache',
		));

//		curl_setopt($curl, CURLOPT_COOKIE, "Cookie: beget=begetok");

		//Sets the user agent. Some websites will attempt to block bot user agents.
		//Hence the reason I gave it a Chrome user agent.
		curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);

		//Tells cURL to return the output once the request has been executed.
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//Allows us to set the referer header. In this particular case, we are
		//fooling the server into thinking that we were referred by the login form.
		curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);

		//Do we want to follow any redirects?
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

		//Set our post fields / date (from the array above).
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->auth_data));


		//Execute the login request.
		print_r(curl_exec($curl));

		exit();

		//Check for errors!
		if (curl_errno($curl)) {
			throw new Exception(curl_error($curl));
		}

		//We should be logged in by now. Let's attempt to access a password protected page
		curl_setopt($curl, CURLOPT_URL, $url_content);

		//Use the same cookie file.
		curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
		curl_setopt($curl, CURLOPT_COOKIE, "beget=begetok;");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Cookie: beget=begetok',
		));

		//Use the same user agent, just in case it is used by the server for session validation.
		curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);

		//We don't want any HTTPS / SSL errors.
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//Execute the GET request and print out the result.
//		print_r(curl_exec($curl));
		return curl_exec($curl);
	}
}