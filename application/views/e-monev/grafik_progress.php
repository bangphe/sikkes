<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<script type="text/javascript" src="<?php echo  base_url(); ?>js/FusionCharts.js"></script>

<div class="buttons">
	<button type="submit" class="regular" name="daftar_progress_kontraktual" onclick="daftar_progress_fisik()">
		<img src="<?php echo  base_url(); ?>images/icon/doc.png" alt=""/>
		Daftar Progress
	</button>
</div>

<div class="buttons">
	<div id="chartdiv" align="center"> 
	</div>
</div>

<?php echo  $graph;?>
