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

$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progress_fisik/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'', 'profile_detail_loading', 'content_tengah');
});

function update_progress_fisik(progress_id,idpaket, bulan){
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
				get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_progress_fisik/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+progress_id+"/"+idpaket+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
			}
		}
	});
}

function grafik_progress(idpaket){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/grafik_progress/"+idpaket,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_progress_fisik(){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_progress_fisik/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'', 'profile_detail_loading', 'content_tengah');
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
<div>
		<div id="breadcrumb">
			<ul class="crumbs">
				<li class="first"><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_laporan/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:9;"><span></span>Output</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:8;">Rencana Fisik</a></li>
				<li><a href="#" onClick="daftar_progress_fisik();" style="z-index:4;">Progress Fisik</a></li>
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

