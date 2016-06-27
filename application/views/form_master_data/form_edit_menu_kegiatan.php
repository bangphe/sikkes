<div id="tengah">
<div id="judul" class="title">Menu Kegiatan</div>
<div id="content_tengah">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_menu_kegiatan/update_menu_kegiatan/'.$KodeMenuKegiatan; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Program</td>
				<td width="70%">
					<?php
						$js = 'id="program" style="padding:3px; width:50%" onChange="get_keg(this.value)"';
						echo form_dropdown('program', $program,$selected_program,$js); 
					?><?php echo  form_error('program'); ?>
				</td>
			</tr>
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%">
					<?php
						$js = 'id="kegiatan" style="padding:3px; width:50%" onChange="get_ikk_(this.value)"'; 
						echo form_dropdown('kegiatan',$kegiatan,$selected_kegiatan,$js); 
					?><?php echo  form_error('kegiatan'); ?>
				</td>
			</tr>
			<tr>
				<td width="10%">Ikk</td>
				<td width="70%">
					<?php
						$js = 'id="ikk" style="padding:3px; width:70%"'; 
						echo form_dropdown('ikk',$ikk,$selected_ikk,$js); 
					?><?php echo  form_error('ikk'); ?>
				</td>
			</tr>
			<tr>
				<td width="10%">Menu Kegiatan</td>
				<td width="70%"><textarea name="menu_kegiatan" id="menu_kegiatan" style="width:70%; padding:3px" /><?php echo  $menu_kegiatan; ?></textarea><?php echo  form_error('menu_kegiatan'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save">
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_menu_kegiatan/grid_menu_kegiatan"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>

<script>
function get_keg(kdu){
	var url = '<?php echo  base_url()?>index.php/master_data/master_menu_kegiatan/get_keg/'+kdu;	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option;
			var nama;
			$('#kegiatan').html('');
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeKeg'];
				nama = data[i]['NamaKeg'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
			}
  				$('#kegiatan').append(option);
		}
	});	
}
function get_ikk_(kdu){
	var url = '<?php echo  base_url()?>index.php/master_data/master_menu_kegiatan/get_ikk_/'+kdu;
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option;
			var nama;
			$('#ikk').html('');
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIkk'];
				nama = data[i]['Ikk'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
			}
  				$('#ikk').append(option);
		}
	});	
}
</script>