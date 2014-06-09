<div id="master">
<div id="judul" class="title">
	Pegawai
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_pegawai" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_pegawai/detail/'.$id; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">NIP Pegawai</td>
				<td width="70%"><input name="nip" id="nip" style="width:20%; padding:3px" readonly="TRUE" value="<?php echo $nip; ?>" /></td>
			</tr>
            <tr>
				<td width="10%">Nama Pegawai</td>
				<td width="70%"><input name="nama_peg" id="nama_peg" style="width:20%; padding:3px" readonly="TRUE" value="<?php echo $nama_peg; ?>" /></td>
			</tr>
            <tr id="menu_satker">
			<td width="15%">Nama Satker</td>
			<td width="85%"><?php $css = 'id="satker" style="padding:3px; width:48%" disabled="disabled"'; echo form_dropdown('satker', $opt_satker, $satker, $css); ?></td>
		</tr>
        <tr id="menu_unit_utama">
			<td width="15%">Unit Utama</td>
			<td width="85%"><?php $css = 'id="unit_utama" style="padding:3px; width:48%" disabled="disabled'; echo form_dropdown('unit_utama', $opt_unit_utama, $unit, $css); ?></td>
		</tr>
        <tr>
				<td width="10%">Jabatan</td>
				<td width="70%"><input name="jabatan" id="jabatan" style="width:47%; padding:3px" readonly="TRUE" value="<?php echo $jabatan; ?>" /></td>
			</tr>
			<tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_pegawai/grid_pegawai"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>