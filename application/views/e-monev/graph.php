<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<script type="text/javascript" src="<?= base_url(); ?>js/FusionCharts.js"></script>

<?php if($kembali == 1){?>
<div class="buttons">
	<button type="submit" class="regular" name="kembali" onClick="daftar_rencana(<?php echo $d_skmpnen_id;?>);">
		<a href="<?php echo base_url();?>index.php/e-monev/laporan_monitoring"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
	</button>
</div>
<?php } ?>
<div id="chartdiv" align="center"> 
</div>

<?php
echo $graph;
?>
