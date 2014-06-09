<div class="panel">
	<input type="button" name="some_name" value="" id="some_name" onclick="getdata('<?php echo base_url(); ?>index.php/E-Planning/Pendaftaran/tes','kiri'); getdata2('<?php echo base_url(); ?>index.php/E-Planning/Pendaftaran/tes','kanan');"/>
	<a href="javascript:void(0);" onclick="getdata('<?php echo base_url(); ?>index.php/E-Planning/Manajemen/grid_pengajuan','user');">kiri</a>
	<a href="javascript:void(0);" onclick="getdata('<?php echo base_url(); ?>index.php/E-Planning/Pendaftaran/tes','kanan');">kanan</a>
	<a href="javascript:void(0);" onclick="getdata2('<?php echo base_url(); ?>index.php/E-Planning/Pendaftaran/pengajuan_step1/000017/2012','tengah');">tengah</a>
</div>

<div id="kiri"></div>
<div id="user"></div>
<div id="kanan"></div>
<div id="kanan"></div>
<div id="tengah"></div>