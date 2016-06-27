
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Kementrian Kesehatan</title>
	<link rel="icon" type="image/x-icon" href="<?php echo  base_url() ?>images/icons/depkes.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/login/style.css">
	<link rel="stylesheet" type="text/css" href="http://e-renggar.depkes.go.id/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-7">
        	<div class="formLogin">
        		<div class="col-md-offset-3 mgBtm20">
        			<img src="<?php echo  base_url() ?>images/login/logoerenggar_old.png" class="img-responsive">
        		</div>
        		 <form id="lupa-password" class="form-horizontal" role="form" method="post" action="<?php echo  base_url().'index.php/login/recovery_password'; ?>" onsubmit="return validasi(email.value)">
        		 	<div class="tahun_anggaran">
						<h3 class="text-center col-md-offset-3">MASUKKAN EMAIL</h3> <br>					
					</div>
					<div class="login">
					<div style="color:red;" align="center"><?php if(isset($notification1)) echo $notification1; ?></div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <!-- <input type="email" class="form-control inputCustom" id="inputEmail3" placeholder="Email" required> -->
                            <input class="form-control inputCustom" name="email" type="text" placeholder="Email" <?php if(isset($email)) echo 'value="'.$email.'"'; ?> />
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-6">
	                         <button name="login" type="button" value="Login" style="margin-top:0px;outline:none;" class="customBtnLogin pull-right" onClick="window.location.href='<?php echo  base_url(); ?>'">
								<img src="<?php echo  base_url() ?>css/login/batal-btn.png" />
							</button>
						</div>
						<div class="col-sm-6">
							<button type="submit" name="login" value="Login" style="margin-top:0px;outline:none;" class="customBtnLogin pull-right">
								<img src="<?php echo  base_url() ?>css/login/reset-btn.png" />
							</button>
                    	</div>
                    </div>
                </form>
        	</div>
        </div>
    </div>
</div>

<script type="text/javascript">
 function validasi(x,y)
	{
	var a=document.forms["lupa-password"]["email"].value;
	if (a==null || a=="")
	  {
	  alert("Anda harus mengisi alamat e-mail.");
	  return false;
	  }
	var url = '<?php echo  base_url()?>index.php/login/validate/'+x+'/'+y;
	//alert(v)
	
	};
</script>

</body>
</html>
