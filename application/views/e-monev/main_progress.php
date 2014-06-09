<!-- paste this code into your webpage -->
<link href="<?= base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->

<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?=base_url()?>";
var thang = "<?php echo $thang;?>";
var kdjendok = "<?php echo $kdjendok;?>";
var kdsatker = "<?php echo $kdsatker;?>";
var kddept = "<?php echo $kddept;?>";
var kdunit = "<?php echo $kdunit;?>";
var kdprogram = "<?php echo $kdprogram;?>";
var kdgiat = "<?php echo $kdgiat;?>";
var kdoutput = "<?php echo $kdoutput;?>";
var kdlokasi = "<?php echo $kdlokasi;?>";
var kdkabkota = "<?php echo $kdkabkota;?>";
var kddekon = "<?php echo $kddekon;?>";
var kdsoutput = "<?php echo $kdsoutput;?>";
var kdkmpnen = "<?php echo $kdkmpnen;?>";
var kdskmpnen = "<?php echo $kdskmpnen;?>";

$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progress_kontraktual/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen,'', 'profile_detail_loading', 'content_tengah');
});

function update_progress_kontraktual(progress_id,idpaket, bulan){
var progress = $("#progress").val();
$.ajax({
		url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/cek_rencana_kontraktual/'+idpaket+'/'+bulan,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'json',
		data:{
			progress:progress
		},
		success: function (response) {
			if(response.result == 'rencana_0')
			{
				alert('Rencana bulan ini 0%, progress tidak perlu diisi.');
			}
			else if(response.result == 'true')
			{
				get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progress_kontraktual/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen+"/"+progress_id+"/"+idpaket+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
			}
		}
	});
}

function update_progress_swakelola(progress_id,idpaket, bulan){
var progress = $("#progress").val();
$.ajax({
		url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/cek_rencana_swakelola/'+idpaket+'/'+bulan,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'json',
		data:{
			progress:progress
		},
		success: function (response) {
			if(response.result == 'rencana_0')
			{
				alert('Rencana bulan ini 0%, progress tidak perlu diisi.');
			}
			else if(response.result == 'true')
			{
				get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progress_swakelola/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen+"/"+progress_id+"/"+idpaket+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
			}
		}
	});
}

function grafik_progress(idpaket){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/grafik_progress/"+idpaket,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_progress_kontraktual(){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progress_kontraktual/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_progress_swakelola(){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progress_swakelola/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen,'', 'profile_detail_loading', 'content_tengah');
}

// function save_data(d_skmpnen_id,progres_id){
// 		var persiapan = $("#persiapan").val();
// 		var pelaksanaan = $("#pelaksanaan").val();
// 		var pembuatan_laporan = $("#pembuatan_laporan").val();
// 		var dokumen_laporan = $("#dokumen_laporan").val();
// 		if(persiapan == '' || pelaksanaan == '' || pembuatan_laporan == '' || dokumen_laporan == ''){
// 			alert('Semua field harus diisi');
// 		}else{
// 			$.ajax({
// 			url: '<?=base_url()?>index.php/e-monev/laporan_monitoring/save_progres2/'+d_skmpnen_id+'/'+progres_id,
// 			global: false,
// 			type: 'POST',
// 			async: false,
// 			dataType: 'json',
// 			data:{
// 				persiapan:persiapan,
// 				pelaksanaan:pelaksanaan,
// 				pembuatan_laporan:pembuatan_laporan,
// 				dokumen_laporan:dokumen_laporan
// 			},
// 			success: function (response) {
// 				if(response.result == 'true')
// 				{
// 					daftar_progres(d_skmpnen_id);
// 				}
// 				else if(response.result == 'false')
// 				{
// 					alert("Presentase sudah 100 %");
// 				}
// 				else if(response.result == 'exc_100')
// 				{
// 					alert("Presentase tidak boleh melebihi 100 %");
// 				}
// 			}
// 		});
// 		return false;
// 		}
// }
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
<div>
		<div id="breadcrumb">
			<ul class="crumbs">
				<li class="first"><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_laporan/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput.'/'.$kdkmpnen.'/'.$kdskmpnen;?>" style="z-index:9;"><span></span>Paket</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput.'/'.$kdkmpnen.'/'.$kdskmpnen;?>" style="z-index:8;">Rencana Fisik</a></li>
				<li><a href="#" onClick="daftar_progress_kontraktual();" style="z-index:4;">Progress Fisik</a></li>
			</ul>
			
		</div>
		<br />
		<br />
		<?php echo $this->session->flashdata('error_progres'); ?>
	</div>
	<br />
		<div id="content_tengah">	
		<?php if(isset($content1)) echo $content1;?>
		</div>	
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

