<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>

<?php
echo $graph;
?>
<?php if($kembali == 1){?>
<div class="buttons">
	<button type="submit" class="regular" name="kembali" onClick="daftar_progres(<?php echo  $d_skmpnen_id;?>);">
		<img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>
		Kembali
	</button>
</div>
<?php } ?>
<div id="chartdiv" align="center"> 
</div>
