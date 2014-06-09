<script type="text/javascript">
	$(function() { 
		$('#klik').click( function() { 
			var report_cell = $('input[name=masuk]').val(); 
			$('#user').flexOptions({ url: '<?php echo base_url(); ?>index.php/E-Planning/Manajemen/grid_list_fungsi/' + report_cell }).flexReload(); 
		}); 
	}); 
</script>