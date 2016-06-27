<!-- paste this code into your webpage -->
<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo  base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo  base_url(); ?>js/accounting.js"></script> <!-- format nominal angka di text input -->
<!-- end -->

<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?php echo base_url()?>";
var thang = "<?php echo  $thang;?>";
var kdjendok = "<?php echo  $kdjendok;?>";
var kdsatker = "<?php echo  $kdsatker;?>";
var kddept = "<?php echo  $kddept;?>";
var kdunit = "<?php echo  $kdunit;?>";
var kdprogram = "<?php echo  $kdprogram;?>";
var kdgiat = "<?php echo  $kdgiat;?>";
var kdoutput = "<?php echo  $kdoutput;?>";
var kdlokasi = "<?php echo  $kdlokasi;?>";
var kdkabkota = "<?php echo  $kdkabkota;?>";
var kddekon = "<?php echo  $kddekon;?>";
var kdsoutput = "<?php echo  $kdsoutput;?>";

$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_rencana/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'', 'profile_detail_loading', 'content_tengah');
});

function update_rencana_kontrak(rencanaid, idpaket, bulan){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_rencana_kontrak/"+rencanaid+"/"+idpaket+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function update_rencana_swakelola(rencanaid, idpaket, bulan){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_rencana_swakelola/"+rencanaid+"/"+idpaket+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function grafik_rencana(idpaket){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/grafik_rencana/"+idpaket,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_rencana(){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_rencana/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'', 'profile_detail_loading', 'content_tengah');
}

// function reset()
// {
// 	$('#fisik').val("");
// 	$('#keuangan').val("");
// }

function save_rencana_kontrak(rencana_id, idpaket){
	var rencana_kontrak = $("#rencana_kontrak").val();
	$.ajax({
		url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/save_rencana_kontrak/'+rencana_id+'/'+idpaket,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'json',
		data:{
			rencana_kontrak:rencana_kontrak
		},
		success: function (response) {
			if(response.result == 'true')
			{
				daftar_rencana(thang, kdjendok, kdsatker, kddept, kdunit, kdprogram, kdgiat, kdoutput, kdlokasi, kdkabkota, kddekon, kdsoutput);
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
			<li class="first"><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_laporan/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:9;"><span></span>Paket</a></li>
			<li><a href="#" onClick="daftar_rencana();" style="z-index:8;">Rencana Fisik</a></li>
			<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_progress/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:7;">Progress Fisik</a></li>
		</ul>
	</div>
</div>
	<br />
	<br />
	<br />
		<div id="content_tengah">	
		</div>
		<div id="tabel_rencana">	
		</div>
	
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

