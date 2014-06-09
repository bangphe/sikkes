<script type="text/javascript">
$(document).ready(function(){
	
		<?php if($eselon == '0'){ ?>
		$('#menu_jabatan').hide();
		<?php } ?>
		<?php /*if($role != '1' && $role != '5' && $role != '4'){ ?>
		$('#menu_jenis_kewenangan').hide();
		<?php } ?>
		<?php if($jenis_kewenangan != '1'){ ?>
		$('#menu_provinsi').hide();
		$('#menu_kabupaten').hide();
		// $('#menu_satker').hide();
		<?php } */ ?>
		
	$('#jns_jabatan').change( function() {
		var $selectjabatan = $(this),selected = $selectjabatan.val();
		if(selected == "eselon") {
		$('#menu_jabatan').show();
		}
		else {
		$('#menu_jabatan').hide(); 
		document.getElementById('jabatan').value = '01';
		}	
	});
});
</script>

<script type="text/javascript">
function cek_username(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/master_data/master_user/cek_username/'+v;
	
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
			var cek;
			var warning;
			var option='';
			
			//$('#jabatan').html('<option>--- Pilih Jabatan ---</option>');
			
			warning = data['warning'];
			cek = data['cek'];
			
		if(cek == false){
			document.getElementById("save").disabled = true;
			document.getElementById('label_warning').innerHTML = warning;
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label_warning').innerHTML ="";
		}
		}
	});	
}
function validate_form()
	{
	var a=document.forms["form_edit_profil"]["nama"].value;
	var b=document.forms["form_edit_profil"]["email"].value;
	var c=document.forms["form_edit_profil"]["alamat"].value;
	var d=document.forms["form_edit_profil"]["telp"].value;
	var e=document.forms["form_edit_profil"]["username"].value;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="" || e==null || e=="")
	  {
	  alert("Username, nama, e-mail, alamat, dan telepon harus diisi.");
	  return false;
	  }
	}
</script>

<div id="tengah">
<div id="judul" class="title">Ubah User</div>
<div id="content_tengah">
	<form class="appnitro" name="form_edit_profil" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/master_data/master_user/update_profil/'; ?>" onsubmit="return validate_form()">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
	<?php //if(isset($warning)){?>
		<tr><td colspan="2"><div name="warning" id="label_warning" style="color:red" ></div></td></tr>
	<?php // } ?>
		<tr>
			<td width="15%">Username*</td>
			<td width="85%"><input name="username" id="username" type="text"value="<?php echo $username; ?>" onchange="cek_username(this.value)" onfocusout="cek_username(this.value)"/></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="15%">Nama*</td>
			<td width="85%"><input name="nama" id="nama" type="text"value="<?php echo $nama; ?>" /></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="15%">Email*</td>
			<td width="85%"><input name="email" id="email" type="text" value="<?php echo $email; ?>"/></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="15%">Telepon*</td>
			<td width="85%"><input name="telp" id="telp" type="text" value="<?php echo $telp; ?>"/></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="15%">Alamat*</td>
			<td width="85%"><textarea name="alamat" id="alamat" cols="72" rows="3"/><?php echo $alamat_user; ?></textarea></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	<?php if($jnskewenangan == '3'){?>
		<tr id="menu_jnsjabatan">
			<td width="15%">Jenis Jabatan*</td>
			<td width="85%"><select id="jns_jabatan" name="jns_jabatan" onchange="" onfocusout="" onfocus="">
            				<option value="eselon" <?php if($eselon != '0') echo 'selected'; ?> >Pegawai Eselon</option>
            				<option value="staf" <?php if($eselon == '0') echo 'selected'; ?> >Staf</option>
                            </select></td>
		</tr>
		<tr id="menu_jabatan">
			<td width="15%">Jabatan*</td>
			<td width="85%"><?php echo form_dropdown('jabatan',$opt_jabatan,$jabatan,'');?>
				<?php echo ' Jabatan sekarang: '.$nmjabatan; ?>
				</td>
		</tr>
	<?php } ?>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
	    <a href="<?php echo site_url(); ?>/master_data/master_user/detail_user" class="negative">
						<img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
						Batal
					 </a>
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Ubah
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>