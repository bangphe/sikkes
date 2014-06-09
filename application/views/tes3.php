<!--
<div class="panel">
	<form>
	<input name="masuk" id="masuk"/>
	<input name="klik" id="klik" type="button" value="click me"/>
	</form>
</div>
-->
<script type="text/javascript">
	$(function() { 
		$('#klik').click( function() { 
			var kode = $('input[name=masuk]').val(); 
			$('#user2').flexOptions({ url: '<?php echo base_url(); ?>index.php/E-Planning/Manajemen/grid_list_fungsi/' + kode }).flexReload(); 
		}); 
	}); 
</script>
<div id="kiri">
<div id="judul">
	Pengusulan Proposal
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content">
	<?php
		echo $js_grid;
	?>
	<table id="user" style="display:none"></table>
</div>
</div>
<div id="kiri">
<div id="judul">
	Pengusulan Proposal
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content">
	<?php
		echo $js_grid2;
	?>
	<table id="user2" style="display:none"></table>
</div>
</div>