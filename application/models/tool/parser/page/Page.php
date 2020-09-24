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
        define('USERNAME', 'sdfg@sfg.com');

//The password of the account.
        define('PASSWORD', 'rterty');

//Set a user agent. This basically tells the server that we are using Chrome
        define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');

//Where our cookie information will be stored (needed for authentication).
        define('COOKIE_FILE', 'cookie.txt');

//URL of the login form.
        define('LOGIN_FORM_URL', 'https://www.example.com/index.php');

//Login action URL. Sometimes, this is the same URL as the login form.
        define('LOGIN_ACTION_URL', 'https://www.example.com/login.php');


//An associative array that represents the required form fields.
//You will need to change the keys / index names to match the name of the form
//fields.
        $postValues = array(
            'email' => USERNAME,
            'userPass' => PASSWORD
        );

//Initiate cURL.
        $curl = curl_init();

//Set the URL that we want to send our POST request to. In this
//case, it's the action URL of the login form.
        curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);

//Tell cURL that we want to carry out a POST request.
        curl_setopt($curl, CURLOPT_POST, true);

//Set our post fields / date (from the array above).
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));

//We don't want any HTTPS errors.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

//Where our cookie details are saved. This is typically required
//for authentication, as the session ID is usually saved in the cookie file.
        curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);

//Sets the user agent. Some websites will attempt to block bot user agents.
//Hence the reason I gave it a Chrome user agent.
        curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);

//Tells cURL to return the output once the request has been executed.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//Allows us to set the referer header. In this particular case, we are
//fooling the server into thinking that we were referred by the login form.
        curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);

//Do we want to follow any redirects?
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        //Execute the login request.
        curl_exec($curl);

//Check for errors!
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        } else {
            //do actions
        }
    }
}