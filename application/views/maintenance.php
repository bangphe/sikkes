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
		<!-- <h1><center>Sistem sedang dalam perbaikan. Sistem akan kembali dapat diakses pukul 12.00 WIB.</center></h1> -->
		<h1><center>PENGUMUMAN!!</center></h1>
		<h1><center>Pengajuan Proposal Telah DITUTUP.</center></h1>
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
