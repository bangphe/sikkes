<div id="master">
<div id="judul" class="title">
	Detail Filtering
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_filtering" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/filtering/detail/'.$kd; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">Nama Satker</td>
				<td width="70%"><textarea name="KDDEPT" id="KDDEPT" style="width:35%" readonly="TRUE"/><?php echo  $KDDEPT; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Judul Proposal</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%" readonly="TRUE" /><?php echo  $NMDEPT; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Tanggal Pembuatan</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%" readonly="TRUE" /><?php echo  $NMDEPT; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Tanggal Surat</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%" readonly="TRUE" /><?php echo  $NMDEPT; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Kota</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%" readonly="TRUE" /><?php echo  $NMDEPT; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Judul Proporsal</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%" readonly="TRUE" /><?php echo  $NMDEPT; ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Judul Proporsal</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%" readonly="TRUE" /><?php echo  $NMDEPT; ?></textarea></td>
			</tr>
			<tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_departemen/grid_daftar"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>