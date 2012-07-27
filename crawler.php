<?php

/**
 * Code example
 *
 * More info available in http://dev.juokaz.com/
 *
 * @author Juozas Kaziukenas <juozas@juokaz.com>
 */

class Secure_Crawler {

    private $loginUrl = 'http://www.virginmobile.com.au/selfcare/MyAccount/LogoutLoginPre.jsp';

    private $options = array( );

    private $connected = false;

    function __construct () {

        $cookies = 'cookies_path.txt';

        $this->options = array(
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)',
            CURLOPT_HEADER => 'Referer: http://www.virginmobile.com.au/index.html',
            CURLOPT_RETURNTRANSFER => true, // Add html to return 
            CURLOPT_COOKIEJAR  => $cookies,
            CURLOPT_COOKIEFILE => $cookies,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT => 20,

         );

	// Reset cookies
        @ unlink($cookies);
    }

    function login ($username, $password) {

        $ch = curl_init();

	$options = $this->options;
        $options[CURLOPT_URL] = $this->loginUrl;
        $options[CURLOPT_POST] = true;
	// Login form fields
        $options[CURLOPT_POSTFIELDS] = $this->getPostFields(
		array(
			'username' =>  $username, 
			'password' => $password
		));
        $options[CURLOPT_FOLLOWLOCATION] = false;
        curl_setopt_array($ch, $options);
        curl_exec($ch);

        //Close curl session
        curl_close($ch);

        $this->connected = true;
    }

    function get ($url) {

        if (!$this->connected)
            throw new Excetion("Not connected");

        $ch = curl_init();

        //Get
        $options = $this->options;
        $options[CURLOPT_URL] = $url;
        curl_setopt_array($ch, $options);
        $results = curl_exec($ch);

        //Close curl session
        curl_close($ch);

	return $results;
    }

    private function getPostFields ($data) {

        $return = array();

        foreach ($data as $key => $field) {
            $return[] = $key . '=' . urldecode($field);
        }

        return implode('&', $return);
    }
}

?>