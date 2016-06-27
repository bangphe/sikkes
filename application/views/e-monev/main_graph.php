<!-- paste this code into your webpage -->
<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo  base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?php echo base_url()?>";
var idpaket = <?php echo  $idpaket;?>;
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/grafik/"+idpaket,'','profile_detail_loading', 'grafik1');
});
</script>
<div id="tengah">
<div id="judul" class="title">
	Grafik
</div>
<br />
<div class="buttons">
    <?php echo  anchor(site_url('e-monev/laporan_monitoring/'),img(array('src'=>'images/main/back.png','border'=>'0','alt'=>'')).'Back'); ?>
</div>
<br />
<br />
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<p align="center"><b>Tahun Anggaran : </b><?php echo  $this->session->userdata('thn_anggaran');?></p>
<!-- <p align="center"><b>Nama Komponen/Sub Komponen : </b><?php echo  $sub_komponen;?></p> -->
<br />
<hr />
<div id="grafik1"></div>
<div id="chartdiv" align="center"></div>
</div>
