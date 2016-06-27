<div id="master">
<div id="judul" class="title">
	Satker
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_satker" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_satker/detail_satker/'.$kdsatker; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Satker</td>
				<td width="70%"><input type="text" name="kdsatker" id="kdsatker" style="width:14%; padding:4px" readonly="readonly" value="<?php echo  $kdsatker?>" /></td>
			</tr>
			<tr>
				<td width="10%">Kode Induk</td>
				<td width="70%"><input type="text" name="kdinduk" id="kdinduk" style="width:14%; padding:4px"readonly="readonly" value="<?php echo  $kdinduk?>" /></td>
			</tr>
            <tr>
				<td width="10%">Nama Satker</td>
				<td width="70%"><textarea name="nmsatker" id="nmsatker" style="width:25%; padding:4px" rows="3" cols="60" readonly="readonly" /><?php echo  $nmsatker?></textarea></td>
			</tr>
             <tr>
				<td width="10%">Departemen</td>
				<td width="70%"><?php $js = 'id="dept" style="width:42%; padding:3px" disabled="disabled"'; echo form_dropdown('dept',$option_dept, $selected_dept, $js); ?></td>
			</tr>
             <tr>
				<td width="10%">Unit</td>
				<td width="70%"><?php $js = 'id="unit" style="width:42%; padding:3px" disabled="disabled"'; echo form_dropdown('unit',$option_unit, $selected_unit, $js); ?></td>
			</tr>
             <tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'id="prov" style="width:42%; padding:3px" disabled="disabled"'; echo form_dropdown('prov',$option_prov, $selected_loc, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Kabupaten</td>
				<td width="70%"><?php echo  form_dropdown('kab',$opt_kab, $selected_kab, 'disabled="disabled"'); ?></td>
			</tr>
            <tr>
				<td width="10%">Nomor SP</td>
				<td width="70%"><input type="text" name="nomorsp" id="nomorsp" style="width:14%; padding:4px" readonly="readonly" value="<?php echo  $nomorsp?>"/><?php echo  form_error('nomorsp'); ?></td>
			</tr>
            <tr>
				<td width="10%">KPPN</td>
				<td width="70%"><?php $js = 'id="kdkppn" style="padding:3px; width:17%" disabled="disabled"'; echo form_dropdown('kdkppn',$option_kppn, $kppn, $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Jenis Satker</td>
				<td width="70%"><?php $js = 'id="kdjnssat" style="padding:3px; width:17%" disabled="disabled"'; echo form_dropdown('kdjnssat',$option_jnssat, $kdjnssat, $js); ?></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_satker/grid_daftar"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>
