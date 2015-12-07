<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crawler
 *
 * @author ARFIAN
 */
include_once 'loginable.php';

class Crawler implements Loginable{

    protected $url;     // url awal crawling
    protected $target = array();  // target untuk diambil value-nya
    protected $linked = null;
    protected $depth = null;    // null untuk depth tidak terbatas
    private $ch;

    function __construct() {
        error_reporting(E_ALL ^ E_DEPRECATED);
        $this->ch = curl_init();
        
        include_once APPPATH . 'third_party/simplehtmldom/simple_html_dom.php';
    }
    
    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getTarget() {
        return $this->target;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function addTarget($selector, $property) {
        $this->target[$selector] = $property;
    }

    public function start() {
        curl_setopt($this->ch, CURLOPT_URL, $this->getUrl());
        $script = curl_exec($this->ch);
        
        $html = str_get_html($script);
        $result = array();
        // echo $script;
        foreach ($this->getTarget() as $target => $attr) {
            foreach ($html->find($target) as $element) {
                $result[$target][] = $element->$attr;
            }
        }
        
        $this->unlinkCookie();
        return $result;
    }
    
    // "http://monev.anggaran.depkeu.go.id/2015/login"
    // user_name=mekl024&user_password=intelpentium
    public function doLogin($url, $params = array()) {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($this->ch, CURLOPT_URL, $url); 
	$cookie = self::COOKIEJAR;
	$timeout = 30;

	curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($this->ch, CURLOPT_TIMEOUT,         10); 
	curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT,  $timeout);
	curl_setopt($this->ch, CURLOPT_COOKIEJAR,       $cookie);
	curl_setopt($this->ch, CURLOPT_COOKIEFILE,      $cookie);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 ( Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1 ) Gecko/20061204 Firefox/2.0.0.1');
        curl_setopt($this->ch, CURLOPT_HEADER, true);

	curl_setopt ($this->ch, CURLOPT_POST, 1);
        
        $loginparam = '';
        foreach ($params as $key => $value) {
            $loginparam .= "$key=$value&";
        }
        
	curl_setopt($this->ch, CURLOPT_POSTFIELDS, trim($loginparam, '&'));
	$result = curl_exec($this->ch);
        
        curl_setopt($this->ch, CURLOPT_REFERER, $url);

	return $result;
    }

    public function unlinkCookie() {
        curl_close($this->ch);
        // unlink(self::COOKIEJAR);
    }

}
