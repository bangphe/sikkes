<div id="master">
<div id="judul" class="title">
	Master Departemen
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_master">
	<form name="form_departemen" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_departemen/update_departemen/'.$KDDEPT; ?>">


	<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Departemen</td>
				<td width="70%"><input type="text" name="KDDEPT" id="KDDEPT" style="padding:3px; width:5%" value="<?php echo $KDDEPT; ?>" readonly="readonly" /></td>
			</tr>
            <tr>
				<td width="10%">Nama Departemen</td>
				<td width="70%"><textarea name="NMDEPT" id="NMDEPT" style="width:35%"/><?php echo $NMDEPT; ?></textarea><?php echo form_error('NMDEPT'); ?></td>
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
                      <a href="<?php echo base_url();?>index.php/master_data/master_departemen/grid_daftar"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                  </div>
              </td>
            </tr>
	</table>
	</form>
</div>
</div>