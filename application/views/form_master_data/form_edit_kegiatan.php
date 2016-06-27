<div id="tengah">
<div id="judul" class="title">
	Kegiatan
</div>
<div id="content_tengah">
	<form name="form_kegiatan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_kegiatan/update_kegiatan/'.$KodeKegiatan; ?>">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Kode Kegiatan</td>
                <td width="70%"><input type="text" name="kdkeg" id="kdkeg" style="padding:3px; width:5%" value="<?php echo  $KodeKegiatan; ?>" readonly="true"/></td>
			</tr>
			<tr>
				<td width="10%">Unit Organisasi</td>
				<td width="70%">
				    <?php 
					$js = 'id="unit_organisasi" onChange="get_program(this.value)" style="width:35%; padding:3px;"';; 
					echo form_dropdown('unit_organisasi', $unit_organisasi, $selected_unit_organisasi, $js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Program</td>
				<td>
				   <?php 
				     $js = 'id="program" class="dynamic3" style="width:75%; padding:3px"'; 
				     echo form_dropdown('program', $program, $selected_program,$js); 
				   ?>
				</td>
			</tr>
			<tr>
				<td width="10%">Fungsi</td>
				<td width="70%">
					<?php
						$js = 'id="fungsi" onChange="get_subfungsi(this)" style="width:35%; padding:3px;"'; 
						echo form_dropdown('fungsi',$fungsi,$selected_fungsi,$js); 
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Sub Fungsi </td>
				<td>
					<?php
						$js = 'id="subfungsi" class="dyamic2" style="width:75%; padding:3px;"';
                        echo form_dropdown('subfungsi',$subfungsi,$selected_subfungsi,$js);
					?>
				</td>
			</tr>
			<tr>
				<td width="10%">Kegiatan</td>
				<td width="70%"><textarea name="kegiatan" id="kegiatan" style="padding:3px;" cols="60" rows="4"><?php echo  $kegiatan; ?></textarea><?php echo  form_error('kegiatan'); ?></td>
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
                        <a href="<?php echo  base_url();?>index.php/master_data/master_kegiatan/grid_kegiatan"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>
<script>
				function get_subfungsi(kd){
					var prp = kd.value;
						$.ajax({
							url: "<?php echo  base_url()?>index.php/master_data/master_kegiatan/get_subfungsi/",
							global: false,
						type: "POST",
							async: false,
							dataType: "html",
							data: "kdfungsi="+ prp, //the name of the $_POST variable and its value
							success: function (response) {
								var dynamic_options2 = $("*").index( $('.dynamic2')[0] );
								$("#subfungsi").html('');
								if ( dynamic_options2 != (-1)) 
									$("#subfungsi").append(response);
									$(".third").attr({selected: ' selected'});
								}          
						});
					  return false;
				}
function get_program(kdu){
	var url = '<?php echo  base_url()?>index.php/master_data/master_kegiatan/getprogram/'+kdu;
	//alert(v)
	
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
			$('#program').html('');
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeProg'];
				nama = data[i]['NamaProg'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
			}
  				$('#program').append(option);
		}
	});	
}
			</script>