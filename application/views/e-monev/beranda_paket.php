<style>
#ver-minimalist
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	width: 900px;
	text-align: center;
	border-top:1px #333 solid;
	border-left:1px #333 solid;
}

#ver-minimalist td
{
	padding:5px;
	border-right:1px #333 solid;
	border-bottom:1px #333 solid;
	vertical-align:middle;
	color:#333;
}

.text-bold {
    font-weight:bold;
}

.text-title {
    height:30px;
}
</style>

    <div id="tengah">
        <div id="judul" class="title">Progress Satker <?php echo ucwords(strtolower($satkers->nmsatker)); ?></div>
        <br />
    <div>
</div>
	<div id="content_tengah">
	    <table id="ver-minimalist" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="12" class="text-bold text-title">PROGRES SATKER <?php echo $satkers->nmsatker; ?></td>
          </tr>
          <tr>
            <td rowspan="3" class="text-bold">No</td>
            <td rowspan="3" class="text-bold">NAMA PAKET</td>
            <td width="15" rowspan="<?php echo $skmpnen->num_rows()+5; ?>">&nbsp;</td>
            <td colspan="6" class="text-bold">
                <?php 
                    $bulan_angka = $this->uri->segment(5);
                    if($bulan_angka != NULL){
                        if($bulan_angka >= 1 && $bulan_angka <= 12){
                            if($bulan_angka == 1){
                                $bulan_angka_minus = 12;
                                $bulan_angka_plus = $bulan_angka + 1;
                            }elseif($bulan_angka == 12){
                                $bulan_angka_minus = $bulan_angka - 1;
                                $bulan_angka_plus = 1;
                            }else{
                                $bulan_angka_minus = $bulan_angka - 1;
                                $bulan_angka_plus = $bulan_angka + 1;
                            }
                        }else{
                            $bulan_angka_minus = date("n");
                            $bulan_angka_plus = date("n");
                        }
                    }else{
                        $bulan_angka_minus = date("n");
                        $bulan_angka_plus = date("n");
                        $bulan_angka = date("n");;
                    }
                    
                    $bulan_huruf = $this->general->konversi_bulan($bulan_angka);
					$kodeunit = $this->uri->segment(6);
                ?>
                <a href="<?php echo base_url();?>index.php/e-monev/beranda/detail_paket/<?php echo $idsatker; ?>/<?=$bulan_angka_minus;?>/<?=$kodeunit;?>"><<</a> 
                &nbsp; <? echo $bulan_huruf; ?> &nbsp; 
                <a href="<?php echo base_url();?>index.php/e-monev/beranda/detail_paket/<?php echo $idsatker; ?>/<?=$bulan_angka_plus;?>/<?=$kodeunit;?>">>></a>
                </td>
            <td width="15" rowspan="<?php echo $skmpnen->num_rows()+5; ?>">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="text-bold">KEUANGAN</td>
            <td colspan="3" class="text-bold">FISIK</td>
          </tr>
          <tr>
            <td class="text-bold">PROGRES</td>
            <td colspan="2" class="text-bold">KETIDAKSESUAIAN</td>
            <td class="text-bold">PROGRES</td>
            <td colspan="2" class="text-bold">KETIDAKSESUAIAN</td>    
          </tr>
          <?php echo $list_paket; ?>
          <tr>
            <td colspan="2" align="right" class="text-bold">TOTAL</td>
            <td><? echo round($total_keseluruhan_progres_keuangan); ?></td>
            <td><? echo round($total_keseluruhan_ketidaksesuaian_keuangan_plus); ?>%</td>
            <td><?php echo round($total_keseluruhan_ketidaksesuaian_keuangan_minus); ?>%</td>
            <td><?php echo round($total_keseluruhan_progres_fisik); ?>%</td>
            <td><?php echo round($total_keseluruhan_ketidaksesuaian_fisik_plus); ?>%</td>
            <td><?php echo round($total_keseluruhan_ketidaksesuaian_fisik_minus); ?>%</td>
          </tr>
        </table>
        
        <br /><br />
        <div class="buttons">
            <a href="<?php echo base_url();?>index.php/e-monev/beranda/detail_satker/<?php echo $satkers->kdlokasi.'/'.$bulan_angka.'/'.$kodeunit; ?>"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
        </div>
        <?php if($jumlahno > 15){
                echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="#tengah">^ scroll ke Atas</a>';
              }
        ?>
    </div>
</div>
</div>
