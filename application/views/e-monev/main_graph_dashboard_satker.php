<!-- paste this code into your webpage -->
<link href="<?= base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?=base_url()?>";
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/dashboard_satker/grafik",'','profile_detail_loading', 'grafik1');
});
</script>
<div id="tengah">
<div id="judul" class="title">
	GRAFIK LAPORAN MONITORINGs <?php echo $nmsatker;?> <?php echo $this->general->konversi_bulan($bulan).' '.$thang; ?>
</div>
<br />
<div class="buttons">
    <?= anchor(site_url('e-monev/dashboard_satker/'),img(array('src'=>'images/main/back.png','border'=>'0','alt'=>'')).'Back'); ?>
</div>
<br />
<br />
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<div id="grafik1"></div>
<div id="chartdiv" align="center"></div>
</div>
