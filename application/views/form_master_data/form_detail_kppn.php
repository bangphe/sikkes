<div id="master">
<div id="judul" class="title">
	KPPN
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_tambah_kppn" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_kppn/detail/'.$kode_kppn; ?>">

	<table width="80%" height="25%">
            <tr>
				<td width="10%">Kode KPPN</td>
				<td width="70%"><input type="text" name="kode_kppn" id="kode_kppn" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $kode_kppn?>" /><?php echo  form_error('kode_kppn'); ?></td>
			</tr>
            <tr>
				<td width="10%">Tipe KPPN</td>
				<td width="70%"><input type="text" name="tipe_kppn" id="tipe_kppn" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $tipe?>" /><?php echo  form_error('tipe_kppn'); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode KTUA</td>
				<td width="70%"><input type="text" name="kode_ktua" id="kode_ktua" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $kdktua?>" /><?php echo  form_error('kode_ktua'); ?></td>
			</tr>
            <tr>
				<td width="10%">Kanwil</td>
				<td width="70%"><?php $js = 'id="KDKANWIL" style="width:20%; padding:3px" disabled="disabled"'; echo form_dropdown('KDKANWIL', $option_kanwil, $kanwil, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">KDDATIDUA</td>
				<td width="70%"><input type="text" name="KDDATIDUA" id="KDDATIDUA" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $kddatidua?>"/><?php echo  form_error('KDDATIDUA'); ?></td>
			</tr>
            <tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'id="kode_prov" style="width:25%; padding:3px" disabled="disabled"'; echo form_dropdown('kode_prov', $option_prov, $prov, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kota/Kabupaten</td>
				<td width="70%"><input type="text" name="kota" id="kota" style="padding:3px; width:25%" readonly="TRUE" value="<?php echo  $kab?>"/><?php echo  form_error('kota'); ?></td>
			</tr>
            <tr>
				<td width="10%">Nama KPPN</td>
				<td width="70%"><input type="text" name="nama_kppn" id="nama_kppn" style="padding:3px; width:25%" readonly="TRUE" value="<?php echo  $nama?>" /><?php echo  form_error('nama_kppn'); ?></td>
			</tr>
            <tr>
				<td width="10%">Alamat KPPN</td>
				<td width="70%"><textarea name="alamat" id="alamat" style="padding:3px; width:25%" readonly="TRUE"><?php echo  $alamat;?></textarea><?php echo  form_error('alamat'); ?></td>
			</tr>
            <tr>
				<td width="10%">Telpon KPPN</td>
				<td width="70%"><input type="text" name="telpon" id="telpon" style="padding:3px; width:15%" readonly="TRUE" value="<?php echo  $telp?>" /><?php echo  form_error('telpon'); ?></td>
			</tr>
            <tr>
				<td width="10%">Email KPPN</td>
				<td width="70%"><input type="text" name="email" id="email" style="padding:3px; width:15%" readonly="TRUE" value="<?php echo  $email?>" /><?php echo  form_error('email'); ?></td>
			</tr>
            <tr>
				<td width="10%">KDKCBI</td>
				<td width="70%"><input type="text" name="KDKCBI" id="KDKCBI" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $kode_kppn?>" /><?php echo  form_error('KDKCBI'); ?></td>
			</tr>
            <tr>
				<td width="10%">Kode Pos</td>
				<td width="70%"><input type="text" name="kodepos" id="kodepos" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $kodepos?>"/><?php echo  form_error('kodepos'); ?></td>
			</tr>
            <tr>
				<td width="10%">Fax</td>
				<td width="70%"><input type="text" name="fax" id="fax" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $fax?>"/><?php echo  form_error('fax'); ?></td>
			</tr>
            <tr>
				<td width="10%">KDDEFA</td>
				<td width="70%"><input type="text" name="KDDEFA" id="KDDEFA" style="padding:3px; width:10%" readonly="TRUE" value="<?php echo  $kddefa?>"/><?php echo  form_error('KDDEFA'); ?></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_kppn"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>