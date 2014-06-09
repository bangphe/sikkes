<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<script type="text/javascript" src="<?= base_url(); ?>js/FusionCharts.js"></script>

<div class="buttons">
	<button type="submit" class="regular" name="daftar_rencana" onclick="daftar_rencana()">
		<img src="<?php echo base_url(); ?>images/icon/doc.png" alt=""/>
		Daftar Rencana
	</button>
</div>

<div class="buttons">
	<div id="chartdiv" align="center"> 
	</div>
</div>

<?php echo $graph;?>
