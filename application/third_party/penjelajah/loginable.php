<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author ARFIAN
 */
interface Loginable {
    
    const COOKIEJAR = 'cookies.txt';
    
    public function unlinkCookie();
    public function doLogin($url, $params);
    
}
