<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistem Informasi Kementrian Kesehatan</title>
	
	<!-- FAVICON -->
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>images/icons/depkes.png" />
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/main.css" media="screen, tv, projection" title="Default" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/flexigrid.css" media="screen, tv, projection" title="Default" />
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/ui.jqgrid.css" media="screen, tv, projection" title="Default" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery-ui-1.8.18.custom.css" media="screen, tv, projection" title="Default" />
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- JAVASCRIPT -->
	
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.jqGrid.src.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/grid.locale-en.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url() ?>js/ajax.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.all.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.layout.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/flexigrid.pack.js"></script>
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<?if (isset($added_js)){echo $added_js;}?> <!-- attach js flexigrid (jika ada) -->
	<?if (isset($added_js2)){echo $added_js2;}?> <!-- attach js flexigrid (jika ada) -->
	<?if (isset($added_js3)){echo $added_js3;}?> <!-- attach js flexigrid (jika ada) -->
	<?if (isset($added_js4)){echo $added_js4;}?> <!-- attach js flexigrid (jika ada) -->
</head>
<body>
	
	<!-- HEADER -->
	
	<div class="panel_atas">
		<div id="head">
			Selamat Datang
			<label id="submenu"><?php echo $this->session->userdata('nama_user'); ?></label>
			<label id="pilihan"><strong>|</strong> <a href="#" ><img src="<?php echo base_url() ?>images/icons/icon settings.png" />Pengaturan <strong>|</strong></a></label>
			<label id="pilihan"><a href="<?php echo base_url(); ?>index.php/Login/logout" ><img src="<?php echo base_url() ?>images/icons/icon logout.png" />Logout</a></label>
		</div>
	</div>
	
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- BREADCUMB -->
	
	<div class="breadcumb">
		<ul>
			<li><a href="#" >SIKKes</a></li>
			<li>>> Manajemen E-Planning</li>
		</ul>
	</div>
	
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- MENU -->
	
	<div class="menu">
		<ul>
			<li><a href="#" >Dashboard</a></li>
			<li><a href="#" >Strategy Map</a></li>
			<li><a href="#" class="current">E-Planning</a>
				<ul>
					<li><a href="<?php echo base_url(); ?>index.php/E-Planning/Pendaftaran/pengajuan_step1">Pendaftaran</a></li>
					<li><a href="<?php echo base_url(); ?>index.php/E-Planning/Manajemen/grid_pengajuan">Manajemen</a></li>
					<li><a href="<?php echo base_url(); ?>index.php/E-Planning/Manajemen/grid_persetujuan">Persetujuan</a></li>
					<li><a href="<?php echo base_url(); ?>index.php/E-Planning/Filtering">Filtering</a></li>
			   </ul>
		  </li>
		  <li><a href="#">E-Budgeting</a>
		  		<ul>
					<li><a href="#">Pendaftaran</a></li>
					<li><a href="#">Manajemen</a></li>
					<li><a href="#">Filter</a></li>
			   </ul>
		  </li>
		  <li><a href="#">E-Monev</a>
		  		<ul>
					<li><a href="#">Pendaftaran</a></li>
					<li><a href="#">Manajemen</a></li>
					<li><a href="#">Filter</a></li>
			   </ul>
		  </li>
		  <li><a href="#">Manajemen Pengguna</a>
		  		<ul>
					<li><a href="#">Pendaftaran</a></li>
					<li><a href="#">Manajemen</a></li>
					<li><a href="#">Filter</a></li>
			   </ul>
		  </li>
<<<<<<< .mine
		  <li><a href="#" >Master Data</a>
		  <ul>
		  <li><a href="<?php echo base_url(); ?>index.php/master_data/master_departemen">Departemen</a></li>
=======
		  <li><a href="#">Tabel Referensi</a>
		  		<ul>
					<li><a href="#">Visi</a></li>
					<li><a href="#">Misi</a></li>
					<li><a href="#">Tujuan</a></li>
					<li><a href="#">Sasaran strategis</a></li>
					<li><a href="#">Periode</a></li>
			   </ul>
		  </li>
		  <li><a href="/contact/contact.php">Utility</a></li>
>>>>>>> .r66
		</ul>
		</li>
	</div>
	
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- CONTENT -->
	
	<div id="isi">
		<?php echo $content ?>
		<p class="render">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
	</div>
	
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	<!-- FOOTER -->
	
	<div class="bawah"></div>
	
	<!----------------------------------------------------------------------------------------------------------------------------------------->
	
</body>
</html>