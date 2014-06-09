<div id="kiri_mini">
<div id="judul">
	Penolakan Proposal
</div>
<div id="content">
	<form class="appnitro" name="form_tolak_proposal" id="form_tolak_proposal" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/manajemen/tolak_proposal/'.$kd_pengajuan; ?>">
	<table width="100%" height="auto">
		<tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Keterangan</td>
			<td><textarea id="keterangan" name="keterangan" cols="72" rows="5"></textarea><label id="error"><?php echo form_error('keterangan'); ?></label></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="button" class="negative" name="batal" onClick="history.go(-1);"> <img src="<?php echo base_url(); ?>images/main/back.png" alt=""/> Batal </button>
					<button type="submit" class="regular" name="save">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Tolak
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>