    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['table']});
    </script>
    <script type="text/javascript">
    function drawVisualization() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable([
        ['Name', 'Height', 'Smokes'],
        ['Tong Ning mu', 174, true],
        ['Huang Ang fa', 523, false],
        ['Teng nu', 86, true]
      ]);
    
      // Create and draw the visualization.
      visualization = new google.visualization.Table(document.getElementById('table'));
      visualization.draw(data, null);
    }
    

    google.setOnLoadCallback(drawVisualization);
    </script>
    <div id="table"></div>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>JqGrid Demo</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/main.css" media="screen, tv, projection" title="Default" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/flexigrid.css" media="screen, tv, projection" title="Default" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/ui.jqgrid.css" media="screen, tv, projection" title="Default" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery-ui-1.8.18.custom.css" media="screen, tv, projection" title="Default" />
-->
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- JAVASCRIPT -->
<!--
	<script type="text/javascript" src="<?php echo base_url() ?>js/ajax.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.jqGrid.src.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/grid.locale-en.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.all.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.layout.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/flexigrid.pack.js"></script>
</head>
<body>
<table id="grid"></table>
<div id="pager"></div>
<?php echo $customerGrid; ?>
</body>
</html>
	
	
	
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<div id="judul">
		TES
		<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
		<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	</div>
		<div id="content">
			<div id="table"></table>
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss
			tessss<br/>
			tessss
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss<br/>
			tessss
		</div>
	</div>
	<script type="text/javascript">
		function drawVisualization() {
		  // Create and populate the data table.
		  var data = google.visualization.arrayToDataTable([
		    ['Name', 'Height', 'Smokes'],
		    ['Tong Ning mu', 174, true],
		    ['Huang Ang fa', 523, false],
		    ['Teng nu', 86, true]
		  ]);
		
		  // Create and draw the visualization.
		  visualization = new google.visualization.Table(document.getElementById('table'));
		  visualization.draw(data, null);
		}
	</script>
	-->