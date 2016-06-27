<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo  base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- JGROWL NOTIFICATION -->
<script type="text/javascript" src="<?php echo  base_url() ?>js/jgrowl/jquery.jgrowl.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>js/jgrowl/jquery.jgrowl.css"/>
<!-- format nominal angka di text input -->
<script src="<?php echo  base_url(); ?>js/accounting.js" type="text/javascript" language="javascript"></script> 

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
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_paket/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'','profile_detail_loading', 'content_tengah');
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_alokasi/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'','profile_detail_loading', 'daftar_alokasi');
});

function form_paket(){
	get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_paket/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput,'','profile_detail_loading', 'content_tengah');
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
<table>
<tr>
	<td>
		<div id="breadcrumb">
			<ul class="crumbs">
				<li class="first"><a href="#" onclick="form_paket();" style="z-index:9;"><span></span>Paket</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:8;">Rencana Fisik</a></li>
				<li><a href="<?php echo  base_url().'index.php/e-monev/laporan_monitoring/input_progress/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:7;">Progress Fisik</a></li>
			</ul>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div id="content_tengah">	
		</div>
		<div id="daftar_alokasi">	
		</div>
	</td>
</tr>
</table>

</div>
