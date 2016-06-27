<!--div id="judul" class="title"><p align="center">DASHBOARD PROPINSI <?php //echo $namaProv.' '.$thang; ?></p></div-->
<?php  
	$bulan_angka = date("n")-1;
	$bulan_huruf = $this->general->konversi_bulan($bulan_angka);
?>  
<style type="text/css">
.darkgreen {
	color: #FFF;
	text-align:center;
}
</style>
<div id="content">
	
<table width="100%" border="0" cellpadding="1">
  <tr>
    <td rowspan="3" bgcolor="#339900"><span class="darkgreen">Satker</span></td>
    <td rowspan="3" bgcolor="#339900"><span class="darkgreen">Total Proposal</span></td>
    <td colspan="8" bgcolor="#339900"><span class="darkgreen">Posisi Proposal</span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#339900"><span class="darkgreen">Satker (Draft)</span></td>
    <td colspan="2" bgcolor="#339900"><span class="darkgreen">Provinsi</span></td>
    <td colspan="2" bgcolor="#339900"><span class="darkgreen">Unit Utama</span></td>
    <td colspan="2" bgcolor="#339900"><span class="darkgreen">Kementerian</span></td>
  </tr>
  <tr>
    <td bgcolor="#339900"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900"><span class="darkgreen">Nilai</span></td>
  </tr>
  <tr>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
    <td bgcolor="#C1FFA4">&nbsp;</td>
  </tr>
</table>
</div>