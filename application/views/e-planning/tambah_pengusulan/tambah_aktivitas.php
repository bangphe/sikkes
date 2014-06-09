<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistem Informasi Kementrian Kesehatan</title>
	
<!-- ICON -->
		<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>images/icons/depkes.png" />
		
		<!-- Link CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/flexigrid.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/shortcut.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/main.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/default/jquery.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/button.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/accordion.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/form/form.css" media="screen, tv, projection" title="Default" />	
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/tab_view/tab-view.css" media="screen, tv, projection" title="Default" />	
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/datepicker.css" media="screen, tv, projection" title="Default" />	
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/ext-all.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery-ui-1.8.18.custom.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery.tree.css" media="screen, tv, projection" title="Default" />

		
			
		
		
		<!-- JAVASCRIPT -->
		<script type="text/javascript" src="<?= base_url() ?>js/jquery.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js/jquery.ui.all.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>form_attribute/view.js"></script>
		<!--
		<script type="text/javascript" src="<?= base_url() ?>js/datepicker.js"></script>
		-->
		<script type="text/javascript" src="<?= base_url() ?>js/wufoo.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url() ?>js/ajax.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.all.js"></script>
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.layout.js"></script>
		
		
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.autocomplete.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.tree.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.treeajax.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.treecheckbox.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.treecollapse.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.treecontextmenu.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.treednd.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.treeselect.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/flexigrid.pack.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url() ?>js/FusionCharts.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>js/tiny_mce/tiny_mce.js"></script>
		
		<script type="text/javascript">
			<!-- <MENU_KANAN>
			//  Developed by Roshan Bhattarai 
			//  Visit http://roshanbh.com.np for this script and more.
			//  This notice MUST stay intact for legal use
			-->
			$(document).ready(function()
			{
				//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
				$("#firstpane p.menu_head").click(function()
				{
					$(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
				});
				//slides the element with class "menu_body" when mouse is over the paragraph
				$("#secondpane p.menu_head").mouseover(function()
				{
					 $(this).css({backgroundImage:"url(<?= base_url() ?>images/main/down.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
					 $(this).siblings().css({backgroundImage:"url(<?= base_url() ?>images/main/left.png)"});
				});
			});
		</script>
		<script type="text/javascript">
			<!-- <BORDER_LAYOUT> -->
			var outerLayout; 
			$(document).ready(function () { 
				outerLayout = $('body').layout({ 
					center__paneSelector:	".outer-center" 
				,	west__paneSelector:		".outer-west" 
				,	west__size:				185 
				,	spacing_open:			10 
				,	spacing_closed:			10
				,	north__spacing_open:	0
				,	south__spacing_open:	0
				,	resizable:				false
				,	togglerTip_open:		"Tutup"
				,	togglerTip_closed:		"Buka"
				,	sliderTip:				"Buka Slide"
				}); 
			}); 
		</script> 
		<?php if(isset($added_js)) echo $added_js; ?>
		<?php if(isset($added_js2)) echo $added_js2; ?>
		<?php if(isset($added_js3)) echo $added_js3; ?>
	    <style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
        </style>
</head>

	<body>

<div class="content_panel"  id="tengah">
	<div class="style2" id="judul">Tambah Aktivitas</div>
<div id="content_tengah">
	<form id="form_tambah_aktivitas" name="form_tambah_aktivitas" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/save_aktivitas'; ?>" onsubmit="return validateForm()"  >
	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<input type="hidden" name="kd_pengajuan" id="kd_pengajuan" value="<?php echo $kd_pengajuan; ?>" /></td>
		<input type="hidden" name="rencana_anggaran" id="rencana_anggaran" value="<?php echo $rencana_anggaran; ?>" /></td>
		</tr>
			<tr>
				<td width="15%">Jenis Usulan*</td>
				<td>
					<?php
						// if(isset($jenis_usulan)) 
						echo form_dropdown('jenis_usulan',$jenis_usulan); 
						// if(isset($notif)){
							// echo "<div id=\"label\" style=\"color:red;\"><strong>".$notif."</strong></div>";
						// }
						// echo form_error('jenis_usulan');
					?>
				</td>

			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>Judul Usulan*</td>
				<td><textarea  rows="2" cols="72" name="judul_usulan"></textarea><?php echo form_error('judul_usulan'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>Perincian*</td>
				<td><textarea rows="5" cols="72" name="perincian"></textarea><?php echo form_error('perincian'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>volume*</td>
				<td><input type="text" name="volume" id="volume"  onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';" value="0" style="text-align:right" onChange="hitungJumlah();" onfocusout="hitungJumlah();" onfocusin="this.value='';" /><?php echo form_error('volume'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>Satuan*</td>
				<td><?php echo form_dropdown('satuan',$satuan); ?><?php echo form_error('satuan'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>Harga Satuan*</td>
				<td><input type="text" name="harga_satuan" id="harga_satuan"  onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';" value="0" style="text-align:right" onChange="hitungJumlah();" onfocusout="hitungJumlah();" onfocusin="this.value='';" /><?php echo form_error('harga_satuan'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>Jumlah*</td>
				<td><input type="text" name="jumlah" id="jumlah"  onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';" value="0" style="text-align:right" readonly="true" /><?php echo form_error('jumlah'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
				<td>Jenis Pembiayaan*</td>
				<td><?php if(isset($jenis_pembiayaan)) echo form_dropdown('jenis_pembiayaan',$jenis_pembiayaan); ?><?php echo form_error('jenis_pembiayaan'); ?></td>
			</tr><tr><td>&nbsp;</td></tr>
			<tr>
			<td>Fokus Prioritas</td>
			<td>
				<?php if(isset($fokus_prioritas)){
					for($i=0; $i<count($fokus_prioritas);$i++){ 
					foreach($this->pm->get_where('fokus_prioritas',$fokus_prioritas[$i]['idFokusPrioritas'], 'idFokusPrioritas')->result() as $row) { ?>
						<input type="checkbox"  name="fokus_prioritas[]" id="fokus_prioritas" value="<?php echo $fokus_prioritas[$i]['idFokusPrioritas']; ?>" /><?php echo $row->FokusPrioritas; ?></br>
						 <?php } } } else echo 'Tidak ada fokus prioritas yang dipilih</br>'; ?>
			</td>
		</tr><tr><td>&nbsp;</td></tr>
		<tr>
			<td>Reformasi Kesehatan</td>
			<td>
				<?php if(isset($reformasi_kesehatan)){
					for($i=0; $i<count($reformasi_kesehatan);$i++){ 
					foreach($this->pm->get_where('reformasi_kesehatan',$reformasi_kesehatan[$i]['idReformasiKesehatan'], 'idReformasiKesehatan')->result() as $row) { ?>
						<input type="checkbox"  name="reformasi_kesehatan[]" id="reformasi_kesehatan" value="<?php echo $reformasi_kesehatan[$i]['idReformasiKesehatan']; ?>" /><?php echo $row->ReformasiKesehatan; ?></br>
						 <?php } } } else echo 'Tidak ada reformasi kesehatan yang dipilih</br>'; ?>
			</td>
		</tr><tr><td>&nbsp;</td></tr>
			<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="save" onClick="parent.opener.location.reload();window.close();">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="button" name="batal" onClick="self.close()"> 
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Batal
					</button>
				</div>
			</td>
		</tr><tr><td>&nbsp;</td></tr>
	  </table>
	</form>
</div>
</div>
<script type="text/javascript">
	function hitungJumlah(){
		biaya = eval(document.form_tambah_aktivitas.volume.value)*eval(document.form_tambah_aktivitas.harga_satuan.value);
		document.form_tambah_aktivitas.jumlah.value = biaya;
	}
	
	function validateForm()
	{
	var a=document.forms["form_tambah_aktivitas"]["judul_usulan"].value;
	var b=document.forms["form_tambah_aktivitas"]["perincian"].value;
	var c=document.forms["form_tambah_aktivitas"]["volume"].value;
	var d=document.forms["form_tambah_aktivitas"]["harga_satuan"].value;
	if (a==null || a=="" || b==null || b=="" || c==0 || d==0)
	  {
	  alert("Semua harus diisi");
	  return false;
	  }
	}
</script>

</body>
</html>
