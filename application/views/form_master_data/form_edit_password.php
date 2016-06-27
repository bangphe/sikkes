<script type="text/javascript">
function pass_check (){
	if(document.form_edit_password.password.value != document.form_edit_password.confpass.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Password dan Confirm Password harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
}
function validate_form()
	{
	var a=document.forms["form_edit_password"]["password"].value;
	if (a==null || a=="")
	  {
	  alert("Password harus diisi..");
	  return false;
	  }
	}
</script>

<div id="tengah">
<div id="judul" class="title">Ubah Kata Kunci</div>
<div id="content_tengah">
	<form class="appnitro" name="form_edit_password" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_user/update_password'; ?>" onsubmit="return validate_form()">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%">Password*</td>
			<td width="85%"><input name="password" id="password" type="password" onchange="pass_check()" onfocusout="pass_check()"/><?php echo  form_error('password'); ?></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="15%">Confirm Password*</td>
			<td width="85%"><input name="confpass" id="confpass" type="password" onchange="pass_check()" onfocusout="pass_check()"/><?php echo  form_error('confpass'); ?><div id="label" style="color:red;"></div></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
	    <a href="<?php echo  site_url(); ?>/master_data/master_user/detail_user" class="negative">
						<img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>
						Batal
					 </a>
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Ubah
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>