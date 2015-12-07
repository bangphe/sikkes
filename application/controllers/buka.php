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
        
        $table = $this->addHeader($result[$selector_header]);
        
        $data = array();
        foreach ($result[$selector_body] as $cell => $isi) {
            $data[$result[$selector_header][$cell%$jumlah_kolom]][] = $isi;
            $table .= $this->addCell($isi, $cell%$jumlah_kolom, $jumlah_kolom);
        }
        
        echo "<table>$table</table>";
        
        // var_dump($data);
    }

    private function addCell($data, $index, $max) {
        if (empty($index)) {
            $td = "<tr><td>$data</td>";
        } else {
            $td = "<td>$data</td>";
        }
        
        if ($index == $max) {
            return $td . '</tr>';
        } else {
            return $td;
        }
    }
    
    private function addHeader($header) {
        $tr = '<tr>';
        foreach ($header as $head) {
            $tr .= "<th>$head</th>";
        }
        
        return $tr . '</tr>';
    }

}

//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
