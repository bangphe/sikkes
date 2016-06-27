<?php if(isset($panel)) echo $panel; ?>
<?php if (isset($div)){echo $div;}?>
<?php if (isset($div2)){echo $div2;}?>
<?php if (isset($div3)){echo $div3;}?>
<div id="kiri">
<div id="judul" class="title">
	<?php echo  $judul; ?>
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content">
	<?php
		echo $js_grid;
	?>
	<table id="user" style="display:none"></table>
</div>
</div>