<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.all.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.layout.js"></script>
<div id="container">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="4">
		<form id="form_1" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/Login/login'; ?>">
			<h1>Rincian Pengusul</h1>
			<div id="body">
				<input id="detail1" name="detail1" readonly="true"/>
				<input id="detail2" name="detail2" readonly="true"/>
				<input id="submit-button" type="submit" name="batal" value="<< Batal" />
				<input id="submit-button" type="submit" name="lanjut" value="Lanjut >>" onclick="window.open('<?php echo base_url(); ?>index.php/pendaftaran/sub_fungsi/01',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/>
			</div>
			<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</form>	
	</td>
  </tr>
</table>
</div>
<script>
	//$(document).ready(function(){
	//	$('#form_2_1').hide();
	//	$('#form_2_2').hide();
	//});\
	
	Function awal(){
		$('#form_2_1').hide();
		$('#form_2_2').hide();
	}
</script>