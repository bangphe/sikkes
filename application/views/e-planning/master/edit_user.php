<!--script type="text/javascript">
$(document).ready(function(){
	$('#menu_jabatan').hide();
	$('#peran').change( function() {
		var $select = $( this ), selected = $select.val();
		if(selected == "3" || selected == "4") $('#menu_jabatan').show('slow');
		else $('#menu_jabatan').hide('slow');
	});
});
</script-->

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
		
	$('#role').change( function() {
		var $selectrole = $(this),selected = $selectrole.val();
		if(selected == "1" || selected == "5" || selected== "3" || selected== "4") {
		$('#menu_jenis_kewenangan').show();
		// $('#menu_unit_utama').show();
		// $('#menu_provinsi').show();
		// $('#menu_kabupaten').show();
		// $('#menu_satker').show();
		$('#menu_jnsjabatan').hide();
		}
		else {
		$('#menu_jenis_kewenangan').hide(); 
		// $('#menu_unit_utama').hide(); 
		$('#menu_provinsi').hide();
		$('#menu_kabupaten').hide();
		$('#menu_satker').hide();
		$('#menu_jnsjabatan').show();
		}	
	});
	
	$('#peran').change( function() {
		var $selectperan = $(this),selected = $selectperan.val();
		if(selected == "3" || selected == "2" || selected == "4" || selected == "5") {
		$('#menu_provinsi').hide();
		$('#menu_kabupaten').hide();
		$('#menu_satker').show();
			if(selected == "3"){
			$('#menu_jnsjabatan').show();
			}
			else{
			$('#menu_jnsjabatan').hide();
			document.getElementById('jns_jabatan').value = 'staf';
			}
		}
		else {
		$('#menu_provinsi').show();
		$('#menu_kabupaten').show();
		$('#menu_satker').show();
		document.getElementById('jns_jabatan').value = 'staf';
		}	
	});
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
function get_jenis_kewenangan_penyetuju()
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_jenis_kewenangan_penyetuju/';
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
			
			//$('#testing').html('');
			
			$('#peran').html('<option>--- Pilih Jenis Kewenangan ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeJenisKewenangan'];
				nama = data[i]['JenisKewenangan'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#peran').append(option);
		}
	});	
}
function get_jenis_kewenangan()
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_jenis_kewenangan/';
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
			
			//$('#testing').html('');
			
			$('#peran').html('<option>--- Pilih Jenis Kewenangan ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeJenisKewenangan'];
				nama = data[i]['JenisKewenangan'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#peran').append(option);
		}
	});	
}
function get_kab(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_kab/'+v;
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
			
			//$('#testing').html('');
			
			$('#kabupaten').html('<option>--- Pilih Kabupaten ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeKabupaten'];
				nama = data[i]['NamaKabupaten'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#kabupaten').append(option);
		}
	});	
}
function get_satker(v,x)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_satker/'+v+'/'+x;
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
			
			//$('#testing').html('');
			
			$('#satker_').html('<option>--- Pilih Satuan Kerja ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kdsatker'];
				nama = data[i]['nmsatker'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#satker_').append(option);
		}
	});	
}
function get_satker_unit_utama()
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_satker_unit_utama';
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
			
			//$('#testing').html('');
			
			$('#satker_').html('<option>--- Pilih Satuan Kerja ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kdsatker'];
				nama = data[i]['nmsatker'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#satker_').append(option);
		}
	});	
}
function get_satker_dekon()
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_satker_dekon';
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
			
			//$('#testing').html('');
			
			$('#satker_').html('<option>--- Pilih Satuan Kerja ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kdsatker'];
				nama = data[i]['nmsatker'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#satker_').append(option);
		}
	});	
}
function get_satker_kp()
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_satker_kp';
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
			
			//$('#testing').html('');
			
			$('#satker_').html('<option>--- Pilih Satuan Kerja ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kdsatker'];
				nama = data[i]['nmsatker'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#satker_').append(option);
		}
	});	
}
function get_satker_kd()
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_satker_kd';
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
			
			//$('#testing').html('');
			
			$('#satker_').html('<option>--- Pilih Satuan Kerja ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kdsatker'];
				nama = data[i]['nmsatker'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#satker_').append(option);
		}
	});	
}

function get_jabatan(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/get_jabatan/'+v;
	alert(v)
	
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
			
			//$('#testing').html('');
			
			$('#jabatan').html('<option>--- Pilih Jabatan ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['kodeJabatan'];
				nama = data[i]['namaJabatan'];
				option += '<option value="'+id+'">'+nama+'</option>';
				
			}
  				$('#jabatan').append(option);
		}
	});	
}
function pass_check (){
	if(document.form_edit_user.password.value != document.form_edit_user.confpass.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Password dan Confirm Password harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
}
function validate_form()
	{
	var a=document.forms["form_edit_user"]["nama"].value;
	var b=document.forms["form_edit_user"]["email"].value;
	var c=document.forms["form_edit_user"]["alamat"].value;
	var d=document.forms["form_edit_user"]["telp"].value;
	var e=document.forms["form_edit_user"]["username"].value;
	var f=document.forms["form_edit_user"]["password"].value;
	var g=document.forms["form_edit_user"]["jns_jabatan"].value;
	// var h=document.forms["form_edit_user"]["jabatan"].value;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="" || e==null || e=="" || f==null || f=="" || g=="0" || g==0)
	  {
	  alert("Nama, e-mail, alamat, telepon, username, dan password harus diisi. Jenis jabatan/jabatan harus dipilih.");
	  return false;
	  }
	}
</script>

<div id="tengah">
<div id="judul" class="title">Ubah User</div>
<div id="content_tengah">
	<form class="appnitro" name="form_edit_user" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_user/update/'.$user; ?>" onsubmit="return validate_form()">
	<ul id="tt" class="easyui-tree"
			url="<?php echo  base_url(); ?>index.php/e-planning/pendaftaran/json"
			checkbox="true">
	</ul>
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%">Peran*</td>
			<td width="85%">
			<?php $attr1='id="role" onchange="if(this.value == 3)get_jenis_kewenangan_penyetuju();if(this.value != 3)get_jenis_kewenangan();" onfocusout="if(this.value == 3)get_jenis_kewenangan_penyetuju();if(this.value != 3)get_jenis_kewenangan();" onfocus="if(this.value == 3)get_jenis_kewenangan_penyetuju();if(this.value != 3)get_jenis_kewenangan();" ';
			echo form_dropdown('role', $opt_role, $role,$attr1); ?></td>
		</tr>
		<tr id="menu_jenis_kewenangan">
			<td width="15%">Jenis Kewenangan*</td>
			<td width="85%">
			<?php
				$attr='id="peran"  onchange="if(this.value == 1)get_satker(kabupaten.value, provinsi.value); if(this.value == 3)get_satker_unit_utama();if(this.value == 2)get_satker_dekon();if(this.value == 4)get_satker_kp();if(this.value == 5)get_satker_kd();" onfocusout="if(this.value == 1)get_satker(kabupaten.value, provinsi.value); if(this.value == 3)get_satker_unit_utama();if(this.value == 2)get_satker_dekon();if(this.value == 4)get_satker_kp();if(this.value == 5)get_satker_kd();" onfocus="if(this.value == 1)get_satker(kabupaten.value, provinsi.value); if(this.value == 3)get_satker_unit_utama();if(this.value == 2)get_satker_dekon();if(this.value == 4)get_satker_kp();if(this.value == 5)get_satker_kd();"';
				echo form_dropdown('peran',$opt_kewenangan,$jenis_kewenangan,$attr);
			?>
			</td>
		</tr>
		<?php /* <tr id="menu_unit_utama">
			<td width="15%">Unit Utama*</td>
			<td width="85%"><?php $attr_u='id="unit" id="unit" onchange="get_jabatan(this.value); if(peran.value == 1)get_satker(kabupaten.value, provinsi.value, this.value)"'; echo form_dropdown('unit_utama', $unit_utama, NULL, $attr_u);  ?>
							</td>
		</tr> */ ?>
		<tr id="menu_provinsi">
		<?php if($jenis_kewenangan == '1') { ?>
			<td width="15%">Provinsi*</td>
			<td width="85%"><?php
				$attrp='id="provinsi" onchange="get_kab(this.value); if(peran.value == 1)get_satker(kabupaten.value, this.value); if(peran.value == 3)getKabKDKP(this.value, satker_.value)" onfocusout="get_kab(this.value); if(peran.value == 1)get_satker(kabupaten.value, this.value); if(peran.value == 3)getKabKDKP(this.value, satker_.value)" onfocus="get_kab(this.value); if(peran.value == 1)get_satker(kabupaten.value, this.value); if(peran.value == 3)getKabKDKP(this.value, satker_.value)"';
				echo form_dropdown('provinsi',$opt_prov,$provinsi,$attrp);
			?>
			</td>
		</tr>
		<tr id="menu_kabupaten">
			<td width="15%">Kota/Kabupaten*</td>
			<td width="85%"><?php
				$attrk='id="kabupaten" onchange="if(peran.value == 1)get_satker(this.value, provinsi.value)" onfocusout="if(peran.value == 1)get_satker(this.value, provinsi.value)" onfocus="if(peran.value == 1)get_satker(this.value, provinsi.value)"';
				echo form_dropdown('kabupaten',$opt_kab,$kabupaten,$attrk);
			?>
			</td>
			<?php } ?>
		</tr>
		<tr id="menu_satker">
			<td width="15%">Nama Satker*</td>
			<td width="85%"><?php $attr_s='id="satker_" id="satker_"'; echo form_dropdown('satker_', $opt_satker, $satker, $attr_s);  ?></td>
		</tr>
		<tr>
			<td width="15%">Nama*</td>
			<td width="85%"><input name="nama" id="nama" type="text"value="<?php echo  $nama; ?>" /></td>
		</tr>
		<tr>
			<td width="15%">Email*</td>
			<td width="85%"><input name="email" id="email" type="text" value="<?php echo  $email; ?>"/></td>
		</tr>
		<tr>
			<td width="15%">Telepon*</td>
			<td width="85%"><input name="telp" id="telp" type="text" value="<?php echo  $telp; ?>"/></td>
		</tr>
		<tr>
			<td width="15%">Alamat*</td>
			<td width="85%"><textarea name="alamat" id="alamat" cols="72" rows="3"/><?php echo  $alamat_user; ?></textarea></td>
		</tr>
		<tr id="menu_jnsjabatan">
			<td width="15%">Jenis Jabatan*</td>
			<td width="85%"><select id="jns_jabatan" name="jns_jabatan" onchange="" onfocusout="" onfocus="">
            				<option value="0">--- Pilih Jenis Jabatan ---</option>
            				<option value="eselon" <?php if($eselon != '0') echo 'selected'; ?> >Pegawai Eselon</option>
            				<option value="staf" <?php if($eselon == '0') echo 'selected'; ?> >Staf</option>
                            </select></td>
		</tr>
		<tr id="menu_jabatan">
			<td width="15%">Jabatan*</td>
			<td width="85%"><?php echo  form_dropdown('jabatan',$opt_jabatan,$jabatan,'');?>
				<?php echo  ' Jabatan sekarang: '.$nmjabatan; ?>
				</td>
		</tr>
		<tr>
			<td width="15%">Username*</td>
			<td width="85%"><input name="username" id="username" type="text" value="<?php echo  $username; ?>"/></td>
		</tr>
		<tr>
			<td width="15%">Password*</td>
			<td width="85%"><input name="password" id="password" type="password" onchange="pass_check()" onfocusout="pass_check()"/><?php echo  form_error('password'); ?></td>
		</tr>
		<tr>
			<td width="15%">Confirm Password*</td>
			<td width="85%"><input name="confpass" id="confpass" type="password" onchange="pass_check()" onfocusout="pass_check()"/><?php echo  form_error('confpass'); ?><div id="label" style="color:red;"></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
	    <a href="<?php echo  site_url(); ?>/master_data/master_user/grid_user" class="negative">
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