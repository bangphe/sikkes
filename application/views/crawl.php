<style type="text/css">
table.myTable { width:100%; border-collapse:collapse;  }
table.myTable .tes { 
	background-color: #dfe4ea; color:#000; text-align:center;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 12px; font-weight:bold; border:#999 1px solid; padding: 4px;}
table.myTable td { padding:8px; border:#999 1px solid; }

table.myTable tr:nth-child(even) { /*(even) or (2n+0)*/
	background: #fff;
}
table.myTable tr:nth-child(odd) { /*(odd) or (2n+1)*/
	background-color: #f2f5f9;
}
</style>

<div id="tengah">
	<div id="judul" class="title">
		<?php echo  $judul; ?>
	</div>
	<div id="content_tengah">
		<table class="myTable">
			<?php echo  $table; ?>
		</table>
	</div>
</div>