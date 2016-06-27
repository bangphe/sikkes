<div id="tengah">
<div id="judul" class="title">
	Bank
</div>
<div id="content_tengah">
	<form name="form_tambah_bank" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-monev/master_bank/save_bank'; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Nama Bank</td>
				<td width="70%"><input type="text" name="nama_bank" id="nama_bank" style="width:70%; padding:3px" value="<?php echo  set_value('nama_bank');?>"/><?php echo  form_error('nama_bank'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save" id="submit">
							<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
							Save
						</button>
						<button type="reset" class="negative" name="reset">
							<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
							Reset
						</button>
					</div>
				</td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/e-monev/master_bank"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>
