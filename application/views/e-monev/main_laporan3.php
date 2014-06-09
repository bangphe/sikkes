<!-- paste this code into your webpage -->
<link href="<?= base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url(); ?>js/accounting.js"></script> <!-- format nominal angka di text input -->
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
<?php if(isset($added_script))echo $added_script;?>
<?php if(isset($added_script2))echo $added_script2;?>
<?php if(isset($added_script3))echo $added_script3;?>
var base_url = "<?=base_url()?>";
var d_skmpnen_id = <?php if(isset($d_skmpnen_id))echo $d_skmpnen_id;?>;
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_kontrak/"+d_skmpnen_id,'','profile_detail_loading', 'content_tengah');
});

function form_kontrak(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_kontrak/"+d_skmpnen_id,'','profile_detail_loading', 'content_tengah');
}

function edit_kontrak(){
	get_html_data(base_url+"index.php/e-monev/laporan_monitoring/edit_detail_kontrak/"+d_skmpnen_id,'','profile_detail_loading', 'content_tengah');
}
</script>
<div id="tengah">
<div id="judul" class="title">
	Input Laporan
</div>
<br />
<div>
	<?= anchor(site_url('e-monev/laporan_monitoring/'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Laporan Monitoring'); ?>
</div>
<br />
<table>
<tr>
	<td>
		<div id="breadcrumb">
			<ul class="crumbs">
				<li class="first"><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_laporan/'.$d_skmpnen_id;?>" style="z-index:9;"><span></span>Paket</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_laporan2/'.$d_skmpnen_id;?>" style="z-index:8;">Pra Kontrak</a></li>
				<li><a href="#" onClick="form_kontrak();" style="z-index:7;">Kontrak</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$d_skmpnen_id;?>" style="z-index:6;">Rencana</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_progres_keuangan/'.$d_skmpnen_id;?>" style="z-index:5;">Progress Keuangan</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_progres_fisik/'.$d_skmpnen_id;?>" style="z-index:4;">Progress Fisik</a></li>
			</ul>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div id="content_tengah">	
		</div>
	</td>
</tr>
</table>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

