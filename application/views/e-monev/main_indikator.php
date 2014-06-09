<!--
<div class="panel">
	<input name="masuk" id="masuk"/>
	<input name="klik" id="klik" type="button" value="click me" onclick="TES(5);"/>
	<input name="klik" id="klik" type="button" value="click me" onclick="TES(4);"/>
</div>
-->
<!-- paste this code into your webpage -->
<link href="<?= base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>js/tablecloth.js"></script>
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?=base_url()?>";
var kodeikk = <?php echo $kodeikk;?>;
var thn = <?php echo $thn;?>;
$(document).ready(function(){
    $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
  get_html_data(base_url+"index.php/e-monev/laporan_kinerja/daftar_indikator/<?php echo $kodeikk;?>/<?php echo $thn;?>",'', 'profile_detail_loading', 'content_tengah');
  
});

function update_rencana(id, bln, thn, loading){
    if (loading)
        $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
    get_html_data(base_url+"index.php/e-monev/laporan_kinerja/input_rencana_indikator/"+id+"/"+bln+"/"+thn,'', 'profile_detail_loading', 'content_tengah');
}

function update_realisasi(id, thn, loading){
    if (loading)
        $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
    get_html_data(base_url+"index.php/e-monev/laporan_kinerja/input_realisasi_indikator/"+id+"/"+thn,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_indikator(id, thn){
    $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
    get_html_data(base_url+"index.php/e-monev/laporan_kinerja/daftar_indikator/"+id+"/"+thn,'', 'profile_detail_loading', 'content_tengah');
}

function save_rencana(id, bln, thn){
    $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
    get_html_data(base_url+"index.php/e-monev/laporan_kinerja/save_rencana_indikator/"+id+"/"+bln+"/"+thn,'', 'profile_detail_loading', 'content_tengah');
}

function save_rencana_indikator(id,bln,thn){
	var rencana = $("#rencana").val();
	$.ajax({
		url: '<?=base_url()?>index.php/e-monev/laporan_kinerja/save_rencana_indikator/'+id+'/'+bln+'/'+thn,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'json',
		data:{
			rencana:rencana
		},
		success: function (response) {
			if(response.result == 'true')
			{
				daftar_indikator(id,thn);
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
	Input Target & Realisasi Indikator
</div>
<div id="content_tengah"></div>
</div>
