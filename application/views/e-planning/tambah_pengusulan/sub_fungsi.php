<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.all.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.layout.js"></script>
<div id="container">
	<h1>Rincian Pengusul</h1>
	<div id="body">
		<form id="tes" onsubmit="window.opener.document.getElementById('detail1').value=document.getElementById('volume').value; window.close();" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><p>No</p></td>
				<td><p>Kode Sub Fungsi</p></td>
				<td><p>Nama Sub Fungsi</p></td>
			</tr>
			<?php 
				$no=1;
				foreach($sub_fungsi->result() as $row){
			?>
			<tr style="cursor: hand" onmouseover="this.style.backgroundColor='#ffff00';" onmouseout="this.style.backgroundColor='#ffffff';" onclick="window.opener.document.getElementById('detail1').value=<?php echo $row->KodeSubFungsi; ?>; window.opener.document.getElementById('detail2').value='<?php echo $row->NamaSubFungsi; ?>'; window.close();">
				<td><p><?php echo $no; ?></p></td>
				<td><p><?php echo $row->KodeSubFungsi; ?></p></td>
				<td><p><?php echo $row->NamaSubFungsi; ?></p></td>
			</tr>
			<?php
					$no++;
				} 
			?>
		</table>
		</form>
	</div>
</div>