<div id="kiri">
<div id="judul">
	Pengusulan Proposal
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
<div id="kanan" class="fungsi">
<div id="judul">
	Fungsi
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content">
	<?php
		echo $js_grid2;
	?>
	<table id="user2" style="display:none"></table>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".fungsi").hide();
	});
</script>