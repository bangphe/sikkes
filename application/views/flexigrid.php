	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/flexigrid.css" media="screen, tv, projection" title="Default" />
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- JAVASCRIPT -->
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.all.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.layout.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/flexigrid.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/ajax.js"></script>
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	
	<?if (isset($added_js)){echo $added_js;}?> <!-- attach js flexigrid (jika ada) -->
	
		<?php echo $content ?>
		<p class="render">Page rendered in <strong>{elapsed_time}</strong> seconds</p>