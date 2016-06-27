<!-- paste this code into your webpage -->
<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo  base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo  base_url(); ?>js/accounting.js"></script> <!-- format nominal angka di text input -->
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?php echo base_url()?>";
var d_skmpnen_id = <?php echo  $d_skmpnen_id;?>;
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progres2/<?php echo  $d_skmpnen_id;?>",'', 'profile_detail_loading', 'content_tengah');
});

function update(id2,id, bulan){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progres3/"+id2+"/"+id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function spm(d_skmpnen_id,spm_id, bulan){
    $.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/cek_rencana_progres_keuangan/'+d_skmpnen_id+'/'+bulan,
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
					get_html_data(base_url+"index.php/e-monev/laporan_monitoring/spm/"+d_skmpnen_id+"/"+spm_id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
				}
			}
		});
	//get_html_data(base_url+"index.php/e-monev/laporan_monitoring/spm/"+d_skmpnen_id+"/"+spm_id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_spm(id2){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_spm/"+id2,'','profile_detail_loading', 'daftar_spm');
}

function sp2d(sp2d_id){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/sp2d/"+sp2d_id,'', 'profile_detail_loading', 'content_tengah');
}

function grafik(id){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/grafik3/"+id,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_progres_keuangan(id2){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progres2/"+id2,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_sp2d(id2){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_sp2d/"+id2,'','profile_detail_loading', 'daftar_sp2d');
}

function save_data(id3,id4){
		var nomor_spm = $("#nomor_spm").val();
		var nominal = $("#nominal").val();
		$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/save_progres3/'+id3+'/'+id4,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'json',
			data:{
				nomor_spm:nomor_spm,
				nominal:nominal
			},
			success: function (response) {
				if(response.result == 'true')
				{
					daftar_progres_keuangan(d_skmpnen_id);
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

function save_data_spm(spm_id){
		var nomor_spm = $("#nomor_spm").val();
		var kdakun = $("#akun").val();
		var nominal = $("#nominal").val();
		var alokasi = $("#alokasi_hidden").val();
		if(nomor_spm == '' || kdakun == '' || nominal == ''){
			alert('Semua field harus diisi');
		}else{
			$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/save_data_spm/'+spm_id,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'json',
			data:{
				nomor_spm:nomor_spm,
				kdakun:kdakun,
				nominal:nominal,
				alokasi:alokasi
			},
			success: function (response) {
				if(response.result == 'true')
				{
					$("#nominal_f").val('');
					$("#nominal").val('');
					$("#nomor_spm").val('');
					$("#akun").val('');
					daftar_spm(spm_id);
				}
				else if(response.result == 'false')
				{
					alert("Presentase sudah 100 %");
				}else if(response.result == 'false_alokasi_akun')
				{
					alert("Isian SPM tidak boleh melebihi alokasi akun.");
				}
			}
		});
		return false;
		}
}

function save_data_sp2d(sp2d_id){
		var nomor_sp2d = $("#nomor_sp2d").val();
		var nominal = $("#nominal").val();
		var tot_spm = $("#spm_hidden").val();
		if(nomor_sp2d == '' || nominal == ''){
			alert('Semua field harus diisi');
		}else{
		$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/save_data_sp2d/'+sp2d_id,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'json',
			data:{
				nomor_sp2d:nomor_sp2d,
				nominal:nominal,
				tot_spm:tot_spm
			},
			success: function (response) {
				if(response.result == 'true')
				{
					$("#nominal").val('');
					$("#nominal_f").val('');
					$("#nomor_sp2d").val('');
					daftar_sp2d(sp2d_id);
				}
				else if(response.result == 'exc_spm')
				{
					alert("Isian SP2D tidak boleh melebihi SPM");
				}
			}
		});
		return false;
		}
}

function delete_data_sp2d(sp2d_id,data_sp2d_id){
		$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/delete_sp2d/'+data_sp2d_id,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'html',
			success: function (response) {
				daftar_sp2d(sp2d_id);
			}
		});
		return false;
}

function delete_data_spm(spm_id,sp2d_id){
		$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/delete_spm/'+sp2d_id,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'html',
			success: function (response) {
				daftar_spm(spm_id);
			}
		});
		return false;
}

function reset()
{
	$("#akun").val('');
	$("#nomor_spm").val('');
	$("#nomor_sp2d").val('');
	$("#nominal").val('');
	$("#nominal_f").val('');
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
				<li><a href="#" onClick="daftar_progres_keuangan(<?php echo  $d_skmpnen_id;?>);" style="z-index:5;">Progress Keuangan</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_progres_fisik/'.$d_skmpnen_id;?>" style="z-index:4;">Progress Fisik</a></li>
			</ul>
		</div>
	</div>
	<br />
	<br />
	<br />
		<div id="content_tengah">
		</div>	
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

