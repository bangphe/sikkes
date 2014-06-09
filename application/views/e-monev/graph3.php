<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>

<?php
echo $graph;
?>
<div class="buttons">
	<button type="submit" class="regular" name="kembali" onClick="daftar_progres_keuangan(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
		Kembali
	</button>
</div>
<div id="chartdiv" align="center"> 
</div>
