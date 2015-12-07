<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Buka extends CI_Controller {

    function __construct() {
        parent::__construct();

        include_once APPPATH . 'third_party/penjelajah/crawler.php';
    }

    function index() {
        $selector_header = 'table[id="report"] th';
        $selector_body = 'table[id="report"] td';
        
        $crawl = new Crawler();
        $crawl->setUrl('http://monev.anggaran.depkeu.go.id/2015/kementrian/welcome');
        $crawl->addTarget($selector_header, 'innertext');
        $crawl->addTarget($selector_body, 'innertext');
        $crawl->doLogin('http://monev.anggaran.depkeu.go.id/2015/login', array(
            'user_name' => 'mekl024',
            'user_password' => 'intelpentium'
        ));
        $result = $crawl->start();
        
        // jadikan judul tabel sebagai key array
        $jumlah_kolom = count($result[$selector_header]);
        
        $data = array();
        foreach ($result[$selector_body] as $cell => $isi) {
            $data[$result[$selector_header][$cell%$jumlah_kolom]][] = $isi;
        }
        
        var_dump($data);
    }

    function jelajah() {
        $html = new Simple_html_dom();

        $html->load_file('http://www.google.com');

        foreach ($html->find('img') as $element) {
            echo $element->src . '<br>';
        }
    }

}

//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
