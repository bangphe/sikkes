<!--div id="judul" class="title"><p align="center">DASHBOARD PROPINSI <?php //echo $namaProv.' '.$thang; ?></p></div-->
<?php  
	$bulan_angka = date("n")-1;
	$bulan_huruf = $this->general->konversi_bulan($bulan_angka);
?>  

<style type="text/css">
.darkgreen {
	color: #FFF;
}
</style>
<div id="content">
<table width="100%" border="0" cellpadding="1">
  <tr>
    <td rowspan="2" bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Satker</span></td>
    <td rowspan="2" bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Total Proposal</span></td>
    <td colspan="2" bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Proposal Dibuat</span></td>
    <td colspan="2" bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Proposal Diajukan</span></td>
  </tr>
  <tr>
    <td bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nominal</span></td>
    <td bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#669900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nominal</span></td>
  </tr>
  <?php for($i=1; $i<=$count; $i++){ ?>
  <tr>
    <td bgcolor="#C1FFA4"><?php echo  $name[$i]; ?></td>
    <td bgcolor="#C1FFA4" align="center"><?php echo  $total_prop[$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $draft['jml'][$i];?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($draft['nil'][$i]);?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $terkirim['jml'][$i];?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($terkirim['nil'][$i]);?></td>
  </tr>
  <?php } ?>
</table>
</div>