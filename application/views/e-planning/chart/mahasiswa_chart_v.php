	<script type="text/javascript">
		function chart_onchange(val)
		{
			document.location =  '<?PHP echo site_url(); ?>/login/chart2/' + val;
		}
	</script>
    
    <select onChange="chart_onchange(this.value);">
    	
        <option value="Column3D" <?PHP if($this->uri->segment(3) == 'Column3D') echo 'selected'; ?>>Column 3D</option>
        <option value="Pie3D" <?PHP if($this->uri->segment(3) == 'Pie3D') echo 'selected'; ?>>Pie 3D</option>
        
    </select>
    <div><?PHP echo $chart; ?></div>