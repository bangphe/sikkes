<div id="tengah">
<div id="judul" class="title">
	IKK
</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_ikk/detail_ikk/'.$KodeIkk ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%"><?php $js = 'id="kegiatan" style="width:80%; padding:3px;" disabled="disabled"'; echo form_dropdown('kegiatan', $kegiatan, $selected_kegiatan, $js); ?></td>
			</tr>
			<tr>
				<td width="10%">Ikk</td>
				<td width="70%"><textarea name="ikk" id="ikk" style="width:50%; padding:3px;" readonly="TRUE"/><?php echo "[".$kodeIkk."] - ".$Ikk ?></textarea></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:3px;" disabled="disabled"'; echo form_dropdown('status',$status,null,$js); ?></td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/master_data/master_ikk/grid_ikk"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
			</tr>
		</table>
	</form>
</div>
</div>