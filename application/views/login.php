<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Kementrian Kesehatan</title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>images/icons/depkes.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/style.css">
</head>

<body>
	<img src="<?php echo base_url() ?>images/login/background.jpg" class="bg">

	<div id="page-wrap">
		<form id="form_135599 form_login" name="form_135599" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/login/login_proses'; ?>" onsubmit="return validasi(username.value, password.value)">
		<div class="logo"><img src="<?php echo base_url() ?>images/login/logokementrian.png"></div>
		<div class="content">
			<div style="color:red;" align="center"><?php if(isset($notification1)) echo $notification1; ?></div>
			<div class="tahun_anggaran">
				<h3>TAHUN ANGGARAN</h3>
				<div class="styled-select">
					<?php echo form_dropdown('thn_anggaran',$thn_anggaran,date("Y")); ?>
				</div>
			</div>
			<div class="login">
				
					Username  <input class="span2" name="username" type="text" <?php if(isset($username)) echo 'value="'.$username.'"'; ?> /> </br>
					Password  <input class="span2" name="password" type="password"  />
					<input id="submit-button" class="btn btn-info" type="submit" name="login" value="Login" />
				
			</div>
			<div style="color:blue;" align="center"><?php if(isset($notification3)) echo $notification3; ?></div>
					<div align="center" ><a href="<?php echo site_url().'/login/lupa_password'; ?>"></br>Lupa Password</a></div>
		</div>
		<div class="logo_erenggar"></div>
		</form>
	</div>
	<div class="footer_"><img src="<?php echo base_url() ?>images/login/logoerenggar.png"></div>
	
<script type="text/javascript">
 function validasi(x,y)
	{
	var a=document.forms["form_135599"]["username"].value;
	var b=document.forms["form_135599"]["password"].value;
	if (a==null || a=="")
	  {
	  alert("Username belum diisi.");
	  return false;
	  }
	else if (b==null || b=="")
	  {
	  alert("Password belum diisi.");
	  return false;
	  }
	var url = '<?php echo base_url()?>index.php/login/validate/'+x+'/'+y;
	//alert(v)
	
	};
</script>
</body>
</html>
