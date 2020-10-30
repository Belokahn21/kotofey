<?php

namespace app\models\tool\parser\page;


use app\modules\site\models\tools\Debug;
use Exception;

class Page
{
    public $login_url;
    public $url;
    public $auth_data = array();
    public $use_ajax = false;
    public $userAgent;
    public $cookieFile;
    public $loginFormUrl;
    public $loginActionUrl;

    public function __construct($url, $auth_data, $use_ajax = false)
    {
        $this->login_url = $url;
        $this->auth_data = $auth_data;
        $this->use_ajax = $use_ajax;
    }

    public function content($url_content)
    {
        $this->userAgent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36';
//        $this->cookieFile = 'D:\OpenServer\domains\local.kotofey.store\application\web\cookie.txt';
        $this->cookieFile = \Yii::getAlias("@webroot/cookie.txt");
        $this->loginFormUrl = 'http://www.sat-altai.ru/';
        $this->loginActionUrl = 'http://www.sat-altai.ru/';

//        $postValues = array(
//            'login' => USERNAME,
//            'password' => PASSWORD
//        );

        $postValues = $this->auth_data;

        $curl = curl_init();

        //Set the URL that we want to send our POST request to. In this
        //case, it's the action URL of the login form.
        curl_setopt($curl, CURLOPT_URL, $this->loginActionUrl);

        //Tell cURL that we want to carry out a POST request.
        curl_setopt($curl, CURLOPT_POST, true);

        //Set our post fields / date (from the array above).
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));

        //We don't want any HTTPS errors.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //Where our cookie details are saved. This is typically required
        //for authentication, as the session ID is usually saved in the cookie file.
        curl_setopt($curl, CURLOPT_COOKIEJAR, $this->cookieFile);

        //Sets the user agent. Some websites will attempt to block bot user agents.
        //Hence the reason I gave it a Chrome user agent.
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);

        //Tells cURL to return the output once the request has been executed.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //Allows us to set the referer header. In this particular case, we are
        //fooling the server into thinking that we were referred by the login form.
        curl_setopt($curl, CURLOPT_REFERER, $this->loginFormUrl);

        //Do we want to follow any redirects?
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_COOKIE, 'beget=begetok');

        //Execute the login request.
        curl_exec($curl);

//        Debug::p(curl_exec($curl));
//
        //Check for errors!
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        } else {
            $ch = curl_init($url_content);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
            curl_setopt($ch, CURLOPT_COOKIE, 'beget=begetok');
            $html = curl_exec($ch);
            curl_close($ch);
            return $html;
        }
    }
}