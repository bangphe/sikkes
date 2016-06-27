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
    <td rowspan="3" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Satker</span></td>
    <td rowspan="3" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Total Proposal</span></td>
    <td colspan="14" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Posisi Proposal</span></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Satker (Draft)</span></td>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Provinsi</span></td>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Unit Utama</span></td>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Kementerian</span></td>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Disetujui</span></td>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Ditolak</span></td>
    <td colspan="2" bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Dipertimbangkan</span></td>
  </tr>
  <tr>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Jumlah</span></td>
    <td bgcolor="#339900" align="center" style="vertical-align:middle;"><span class="darkgreen">Nilai</span></td>
  </tr>
  <?php for($i=1; $i<=$count; $i++){ ?>
  <tr>
    <td bgcolor="#C1FFA4"><a href="<?php echo  site_url().'/e-planning/dashboard2/view/'.$id[$i]; ?>"><?php echo  $name[$i]; ?></a></td>
    <td bgcolor="#C1FFA4" align="center"><?php echo  $total_prop[$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $satker['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($satker['nil'][$i]); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $prov['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($prov['nil'][$i]); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $unit['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($unit['nil'][$i]); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $roren['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($roren['nil'][$i]); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $setuju['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($setuju['nil'][$i]); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tolak['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tolak['nil'][$i]); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $timbang['jml'][$i]; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($timbang['nil'][$i]); ?></td>
  </tr>
  <?php } ?>
  <!--tr>
    <td bgcolor="#C1FFA4" align="center">Total</td>
    <td bgcolor="#C1FFA4" align="center"><?php echo  $total; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_satker['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_satker['nil']); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_prov['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_prov['nil']); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_unit['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_unit['nil']); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_roren['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_roren['nil']); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_setuju['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_setuju['nil']); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_tolak['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_tolak['nil']); ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  $tot_timbang['jml']; ?></td>
    <td bgcolor="#C1FFA4" align="right"><?php echo  'Rp '.number_format($tot_timbang['nil']); ?></td>
  </tr-->
</table>
</div>