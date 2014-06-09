<!-- paste this code into your webpage -->
<link href="<?= base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url(); ?>js/accounting.js"></script> <!-- format nominal angka di text input -->
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?=base_url()?>";
var d_skmpnen_id = <?php if(isset($d_skmpnen_id))echo $d_skmpnen_id;?>;
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_prakontrak/"+d_skmpnen_id,'','profile_detail_loading', 'content_tengah');
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_prakontrak2/"+d_skmpnen_id,'','profile_detail_loading', 'input_jadual');
});

function form_all()
{
	form_prakontrak();
	form_prakontrak2();
	form_prakontrak3();
}

function form_prakontrak(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_prakontrak/"+d_skmpnen_id,'','profile_detail_loading', 'content_tengah');
}

function form_prakontrak2(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_prakontrak2/"+d_skmpnen_id,'','profile_detail_loading', 'input_jadual');
}

function form_prakontrak3(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_prakontrak3/"+d_skmpnen_id,'','profile_detail_loading', 'daftar_jadual');
}


function edit_prakontrak(){
	get_html_data(base_url+"index.php/e-monev/laporan_monitoring/edit_detail_prakontrak/"+d_skmpnen_id,'','profile_detail_loading', 'content_tengah');
}

function save_data_jadual_pelaksanaan(){
	var uraian_kegiatan = $("#uraian_kegiatan").val();
	var tanggal = $("#tanggal").val();
	if (uraian_kegiatan==null || tanggal=="")
	{
	  alert("Uraian dan Tanggal Kegiatan harus diisi !!");
	  return false;
	}
	else
	{
		$.ajax({
		url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/save_data_jadual_pelaksanaan/'+d_skmpnen_id,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'html',
		data:{
			uraian_kegiatan:uraian_kegiatan,
			tanggal:tanggal
		},
		success: function (response) {
			$("#uraian_kegiatan").val('');
			$("#tanggal").val('');
			form_prakontrak3();
		}
	});
	return false;
	}
}

function save_data_detail_prakontrak(){
	var kategori_pengadaan = $("#kategori_pengadaan").val();
	var cara_pengadaan = $("#cara_pengadaan").val();
	var nilai_hps_oe = $("#nilai_hps_oe").val();
	if (nilai_hps_oe==null)
	{
	  alert("Nilai HPS / OE harus diisi !!");
	  return false;
	}
	else
	{
		$.ajax({
		url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/save_data_detail_prakontrak/'+d_skmpnen_id,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'html',
		data:{
			kategori_pengadaan:kategori_pengadaan,
			cara_pengadaan:cara_pengadaan,
			nilai_hps_oe:nilai_hps_oe
		},
		success: function (response) {
			form_prakontrak();
			form_prakontrak2();
			form_prakontrak3();
		}
	});
	return false;
	}
}

function update_detail_prakontrak()
{
	var kategori_pengadaan = $("#kategori_pengadaan").val();
	var cara_pengadaan = $("#cara_pengadaan").val();
	var nilai_hps_oe = $("#nilai_hps_oe").val();
	if (nilai_hps_oe==null)
	{
	  alert("Nilai HPS / OE harus diisi !!");
	  return false;
	}
	else
	{
		$.ajax({
		url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/update_data_detail_prakontrak/'+d_skmpnen_id,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'html',
		data:{
			kategori_pengadaan:kategori_pengadaan,
			cara_pengadaan:cara_pengadaan,
			nilai_hps_oe:nilai_hps_oe
		},
		success: function (response) {
			form_prakontrak();
		}
	});
	return false;
	}
}

function delete_jadual_pelaksanaan(jadual_pelaksanaan_id)
{
	if (confirm("Are you sure you want to delete")) {
		$.ajax({
			url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/delete_jadual_pelaksanaan/'+jadual_pelaksanaan_id,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'html',
			success: function (response) {
				form_prakontrak3();
			}
		});
	}
}

function reset()
{
	$("#uraian_kegiatan").val('');
	$("#tanggal").val('');
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
				<li><a href="#" onClick="form_prakontrak();" style="z-index:8;">Pra Kontrak</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_laporan3/'.$d_skmpnen_id;?>" style="z-index:7;">Kontrak</a></li>
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
<tr>
	<td>
		<div id="input_jadual">
		</div>
	</td>
</tr>
</table>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

