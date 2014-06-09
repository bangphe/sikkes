<div id="master">
<div id="judul" class="title">
	Kanwil
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form class="appnitro" name="form_detail_kanwil" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_kanwil/update_kanwil/'.$KDKANWIL ?>">

	<table width="80%" height="25%">
		<tr>
				<td width="12%">Kode Kanwil</td>
				<td width="70%"><input type="text" name="KDKANWIL" id="KDKANWIL" style="width:10%; padding:4px" value="<?php echo $KDKANWIL;?>" /></td>
			</tr>
        <tr>
				<td width="10%">Nama Kanwil</td>
				<td width="70%"><input type="text" name="NMKANWIL" id="NMKANWIL" style="width:24%; padding:4px" value="<?php echo $NMKANWIL;?>" /></td>
			</tr>
             <tr>
				<td width="10%">Kode Romawi</td>
				<td width="70%"><input type="text" name="KDROMAWI" id="KDROMAWI" style="width:24%; padding:4px" value="<?php echo $KDROMAWI;?>" /></td>
			</tr>
            <tr>
				<td width="10%">Provinsi</td>
				<td width="70%"><?php $js = 'id="KDPROVINSI" style="width:25%; padding:3px"'; echo form_dropdown('KDPROVINSI', $provinsi, $KDPROV, $js); ?></td>
			</tr>
            <tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save">
							<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
							Save
						</button>
						<button type="reset" class="negative" name="reset">
							<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
							Reset
						</button>
					</div>
				</td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_kanwil/grid_kanwil"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
	</table>
	</form>
</div>
</div>