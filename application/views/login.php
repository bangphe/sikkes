
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Kementrian Kesehatan</title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>images/icons/depkes.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/login/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/toastr/toastr.css">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-7">
        	<div class="formLogin">
        		<div class="col-md-offset-3 mgBtm20">
        			<img src="<?php echo base_url() ?>images/login/logoerenggar_old.png" class="img-responsive">
        		</div>
        		 <form id="login" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'index.php/login/login_proses'; ?>" onsubmit="return validasi(username.value, password.value)">
        		 	<div class="tahun_anggaran">
						<h3 class="text-center col-md-offset-3">TAHUN ANGGARAN</h3> <br>
						 <div class="form-group">
	                        <label for="inputEmail3" class="col-sm-2 control-label"></label>
	                        <div class="col-sm-8 col-md-offset-2 pdBtm40">
	                           <div class="styled-select">
									<?php echo form_dropdown('thn_anggaran',$thn_anggaran,date("Y")); ?>
								</div>
	                        </div>
	                        <div class="col-sm-1"></div>
	                        <div class="col-sm-1"></div>
	                    </div>						
					</div>
					<div class="login">
					<div style="color:red;" align="center"><?php if(isset($notification1)) echo $notification1; ?></div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 noBold control-label">
                            Username</label>
                        <div class="col-sm-8">
                            <!-- <input type="email" class="form-control inputCustom" id="inputEmail3" placeholder="Email" required> -->
                            <input class="form-control inputCustom" name="username" type="text" placeholder="Username" <?php if(isset($username)) echo 'value="'.$username.'"'; ?> />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 noBold control-label">
                            Password</label>
                        <div class="col-sm-8">
                            <!-- <input type="password" class="form-control inputCustom" id="inputPassword3" placeholder="Password" required> -->
                            <input class="form-control inputCustom" name="password" type="password" placeholder="Password"  />
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9 pull-right">
                         <button type="submit" name="login" value="Login" style="margin-top:0px;outline:none;" class="customBtnLogin pull-right">
							<img src="<?php echo base_url() ?>css/login/login-btn.png" />
						</button>
                    </div>
                    </div>
                </form>
                <div class="forgetPass">
                	<a href="<?php echo site_url().'/login/lupa_password'; ?>">Lupa password?</a>
                </div>
        	</div>
        </div>
    </div>
</div>

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?2vKzzVCJ3kWq8mimapd9rDzdWNzLSHbf";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>css/toastr/toastr.js"></script>
	
<script type="text/javascript">
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "0",
  "hideDuration": "0",
  "timeOut": "0",
  "extendedTimeOut": "0",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

toastr.success('Periode pengusulan perencanaan 2016 (pagu anggaran) telah dibuka mulai tanggal 04-31 Juli 2015.', 'PENGUMUMAN');
toastr.info('Proses verifikasi pengusulan proposal telah dibuka kembali.', 'PENGUMUMAN');
toastr.error('Apabila ada pertanyaan bisa melalui chatting di bagian kanan bawah.', 'PENGUMUMAN');


 function validasi(x,y)
	{
	var a=document.forms["login"]["username"].value;
	var b=document.forms["login"]["password"].value;
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
