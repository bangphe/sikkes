<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class General {
    
    // KONVERSI BULAN INDONESIA
    function konversi_bulan($bln){

      switch ($bln){
        case 1:default;
          $bulan =  "JANUARI";
          break;
        case 2:
          $bulan =  "FEBRUARI";
          break;
        case 3:
          $bulan = "MARET";
          break;
        case 4:
          $bulan =  "APRIL";
          break;
        case 5:
          $bulan =  "MEI";
          break;
        case 6:
          $bulan =  "JUNI";
          break;
        case 7: 
          $bulan =  "JULI";
          break;
        case 8:
          $bulan =  "AGUSTUS";
          break;
        case 9:
          $bulan =  "SEPTEMBER";
          break;
        case 10:
          $bulan =  "OKTOBER";
          break;
        case 11:
          $bulan =  "NOVEMBER";
          break;
        case 12:
          $bulan =  "DESEMBER";
          break;
	   }
	   return $bulan;
    }
	
	
	// KONVERSI TANGGAL INDONESIA
	function konversi_tanggal($tgl){
      $tanggal = substr($tgl,8,2);
      $bln    = substr($tgl,5,2);
	  $bulan = ""; $strHari = "";
      $tahun    = substr($tgl,0,4);
              $hari = date("N", mktime(0, 0, 0, $bln, $tanggal, $tahun));

              switch ($hari){
                  case 1:
                      $strHari = "Senin";
                      break;
                  case 2:
                      $strHari = "Selasa";
                      break;
                  case 3:
                      $strHari = "Rabu";
                      break;
                  case 4:
                      $strHari = "Kamis";
                      break;
                  case 5:
                      $strHari = "Jumat";
                      break;
                  case 6:
                      $strHari = "Sabtu";
                      break;
                  case 7:
                      $strHari = "Minggu";
                      break;
              }

      switch ($bln){
        case 1:
          $bulan =  "Januari";
          break;
        case 2:
          $bulan =  "Februari";
          break;
        case 3:
          $bulan = "Maret";
          break;
        case 4:
          $bulan =  "April";
          break;
        case 5:
          $bulan =  "Mei";
          break;
        case 6:
          $bulan =  "Juni";
          break;
        case 7:
          $bulan =  "Juli";
          break;
        case 8:
          $bulan =  "Agustus";
          break;
        case 9:
          $bulan =  "September";
          break;
        case 10:
          $bulan =  "Oktober";
          break;
        case 11:
          $bulan =  "November";
          break;
        case 12:
          $bulan =  "Desember";
          break;
	   } 
	   return $strHari.", ".$tanggal.' '.$bulan.' '.$tahun;
    }
	
	
	// KONVERSI WAKTU SEPERTI TWITTER
	function KonversiWaktu($dt,$precision=2)
	{
		$times=array(	365*24*60*60	=> "tahun",
						30*24*60*60		=> "bulan",
						7*24*60*60		=> "minggu",
						24*60*60		=> "hari",
						60*60			=> "jam",
						60				=> "menit",
						1				=> "detik");

		$passed=time()-$dt;

		if($passed<5)
		{
			$output='5 detik yang lalu';
		}
		else
		{
			$output=array();
			$exit=1;

			foreach($times as $period=>$name)
			{
				if($exit>=$precision || ($exit>1 && $period<60)) break;

				$result = floor($passed/$period);
				if($result>0)
				{
					$output[]=$result.' '.$name.($result==1?'':'');
					$passed-=$result*$period;
					$exit++;
				}
				else if($exit>1) $exit++;
			}

			$output=implode('  ',$output).' yang lalu';
		}

		return $output;
	}
    
}
