<!-- paste this code into your webpage -->
<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo  base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?php echo base_url()?>";
var d_skmpnen_id = <?php echo  $d_skmpnen_id;?>;
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progres/<?php echo  $d_skmpnen_id;?>",'', 'profile_detail_loading', 'content_tengah');
});

function update(id2,id, bulan){
    $.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/cek_rencana_progres_fisik/'+id2+'/'+bulan,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'json',
			success: function (response) {
				if(response.result == 'rencana_0')
				{
					alert('Rencana bulan ini 0%, progres tidak perlu diisi.');
				}
				else if(response.result == 'true')
				{
					get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progres/"+id2+"/"+id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
				}
			}
		});
	//get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progres/"+id2+"/"+id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function update3(d_skmpnen_id,id, bulan){
    $.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/cek_rencana_progres_fisik/'+d_skmpnen_id+'/'+bulan,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'json',
			success: function (response) {
				if(response.result == 'rencana_0')
				{
					alert('Rencana bulan ini 0%, progres tidak perlu diisi.');
				}
				else if(response.result == 'true')
				{
					get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progres2/"+d_skmpnen_id+"/"+id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
				}
			}
		});
	//get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progres2/"+d_skmpnen_id+"/"+id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function grafik(id){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/grafik2/"+id,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_progres(id2){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progres/"+id2,'', 'profile_detail_loading', 'content_tengah');
}

function save_data(d_skmpnen_id,progres_id){
		var persiapan = $("#persiapan").val();
		var pelaksanaan = $("#pelaksanaan").val();
		var pembuatan_laporan = $("#pembuatan_laporan").val();
		var dokumen_laporan = $("#dokumen_laporan").val();
		if(persiapan == '' || pelaksanaan == '' || pembuatan_laporan == '' || dokumen_laporan == ''){
			alert('Semua field harus diisi');
		}else{
			$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/save_progres2/'+d_skmpnen_id+'/'+progres_id,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'json',
			data:{
				persiapan:persiapan,
				pelaksanaan:pelaksanaan,
				pembuatan_laporan:pembuatan_laporan,
				dokumen_laporan:dokumen_laporan
			},
			success: function (response) {
				if(response.result == 'true')
				{
					daftar_progres(d_skmpnen_id);
				}
				else if(response.result == 'false')
				{
					alert("Presentase sudah 100 %");
				}
				else if(response.result == 'exc_100')
				{
					alert("Presentase tidak boleh melebihi 100 %");
				}
			}
		});
		return false;
		}
}
</script>
<div id="tengah">
<div id="judul" class="title">
	Input Laporan
</div>
<br />
<div>
	<?php echo  anchor(site_url('e-monev/laporan_monitoring/'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Laporan Monitoring'); ?>
</div>
<br />
<div>
		<div id="breadcrumb">
			<ul class="crumbs">
				<li class="first"><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_laporan/'.$d_skmpnen_id;?>" style="z-index:9;"><span></span>Paket</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_laporan2/'.$d_skmpnen_id;?>" style="z-index:8;">Pra Kontrak</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_laporan3/'.$d_skmpnen_id;?>" style="z-index:7;">Kontrak</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$d_skmpnen_id;?>" style="z-index:6;">Rencana</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_progres_keuangan/'.$d_skmpnen_id;?>" style="z-index:5;">Progress Keuangan</a></li>
				<li><a href="#" onClick="daftar_progres(<?php echo  $d_skmpnen_id;?>);" style="z-index:4;">Progress Fisik</a></li>
			</ul>
			
		</div>
		<br />
		<br />
		<?php echo  $this->session->flashdata('error_progres'); ?>
	</div>
	<br />
		<div id="content_tengah">	
		<?php if(isset($content1)) echo $content1;?>
		</div>	
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

