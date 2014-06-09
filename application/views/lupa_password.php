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
		<form id="form_lupa_password" name="form_lupa_password" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/login/recovery_password'; ?>" onsubmit="return validasi(email.value)">
		<div class="logo"><img src="<?php echo base_url() ?>images/login/logokementrian.png"></br>
		<?php echo $title; ?>
		</div>
		<div class="content">
			<div style="color:red;" align="center"><?php if(isset($notification1)) echo $notification1; ?></div>
			<div class="login" align="center">
				
					E-MAIL  <input class="span2" name="email" type="text" size="50" <?php if(isset($email)) echo 'value="'.$email.'"'; ?> /> </br></br></br>
					<input id="cancel-button" class="btn btn-info" type="button" name="batal" value="BATAL" onClick="window.location.href='<?php echo base_url(); ?>'"/> <input id="submit-button" class="btn btn-info" type="submit" name="login" value="RESET PASSWORD" />
				
			</div>
		</div>
		<div class="logo_erenggar"></div>
		</form>
	</div>
	<div class="footer_"><img src="<?php echo base_url() ?>images/login/logoerenggar.png"></div>
	
<script type="text/javascript">
 function validasi(x,y)
	{
	var a=document.forms["form_lupa_password"]["email"].value;
	if (a==null || a=="")
	  {
	  alert("Anda harus mengisi alamat e-mail.");
	  return false;
	  }
	var url = '<?php echo base_url()?>index.php/login/validate/'+x+'/'+y;
	//alert(v)
	
	};
</script>
</body>
</html>
