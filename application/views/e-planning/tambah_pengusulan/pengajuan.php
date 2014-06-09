<div id="tengah">
<div id="judul" class="title">
	Tambah Usulan
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/pengajuan'; ?>">
	<ul id="tt" class="easyui-tree"
			url="<?php echo base_url(); ?>index.php/e-planning/pendaftaran/json"
			checkbox="true">
	</ul>
	<h3>Sumber Dana</h3>
	<table width="100%" height="1%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%" style="padding-left:10px;">Sumber Dana</td>
			<td width="85%"><?php echo form_dropdown('rencana_anggaran',$rencana_anggaran, 2); ?></td>
		<tr>
	</table>
	<h3>Rincian Pengusul</h3>
	<table width="100%" height="19%">
		<tr>
			<td width="15%" height="24" style="padding-left:10px;">No Reg Satker</td>
			<td width="85%"><input name="kdsatker" id="kdsatker" readonly="TRUE" value="<?php echo $kdsatker; ?>" /></td>
		<tr>
			<td height="21" style="padding-left:10px;">Nama Satker</td> 
			<td>
				<?php
					if($selected_worker!=NULL) $disabled = "disabled='disabled'";
					else $disabled = 'id="satker" onChange="get_data(this)"'; 
					echo form_dropdown('satker', $satker, $selected_worker, $disabled) 
				?>
				<?php echo form_error('satker'); ?>
			</td>
		</tr>
		<tr>
			<td height="24" style="padding-left:10px;">Propinsi</td>
			<!--<?php echo form_dropdown('provinsi', $provinsi, $selected_state, 'class="element select medium"'); ?>-->
			<td><input name="provinsi" id="provinsi" readonly="TRUE" value="<?php echo $selected_state; ?>" /></td>
		</tr>
		<tr>
			<td style="padding-left:10px;">Jenis Satker</td>
			<td>
				<?php 
					$disabled = 'id="jenis_satker" disabled="disabled"';
					echo form_dropdown('jenis_satker', $jenis_satker, $this->session->userdata('kodejenissatker'), $disabled); 
				?>
			</td>
		</tr>
	</table>
	<h3>Identitas Proposal</h3>
	<table width="100%" height="100%">
		<tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Judul Proposal</td>
			<td width="85%">
				<textarea id="judul_proposal" name="judul_proposal" rows=2 cols=72></textarea>
				<?php echo form_error('judul_proposal'); ?>
			</td>
		</tr>
		<tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Nomor</td>
			<td width="85%">
				<textarea id="nomor_proposal" name="nomor_proposal" rows=1 cols=15></textarea>
				<?php echo form_error('nomor_proposal'); ?>
			</td>
		</tr>
		<tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Tanggal</td>
			
				<td><p><input name="tanggal_proposal" id="tanggal_proposal" type="text" /></p></td>
			</td>
		</tr>
		<tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Perihal</td>
			<td width="85%">
				<textarea id="perihal" name="perihal" rows=3 cols=72></textarea>
				<?php echo form_error('perihal'); ?>
			</td>
		</tr>
		<tr>
			<td height="24" style="padding-left:10px;">Th. Anggaran</td>
			<td><textarea name="thn_anggaran" id="thn_anggaran" rows=1 cols=15 readonly="TRUE"><?php echo $thn_anggaran; ?></textarea></td>
		</tr>
		<tr>
			<td height="24" style="padding-left:10px;">Triwulan</td> 
			<td>
				<textarea name="triwulan" id="triwulan" rows=1 cols=15 readonly="TRUE"><?php echo $this->session->userdata('triwulan'); ?></textarea>
			</td>
		</tr>
	</table>
	<h3>Ringkasan Proposal</h3>
	<table width="100%" height="16%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Latar Belakang</td>
        <td width="85%"><textarea id="latar_belakang" name="latar_belakang"></textarea></td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;"></d>
          Analisis Situasi</td>
        <td width="85%"><textarea id="analisis_situasi" name="analisis_situasi"></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Permasalahan</td>
        <td width="85%"><textarea id="permasalahan" name="permasalahan"></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="6%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Alternatif Solusi</td>
        <td width="85%"><textarea id="alternatif_solusi" name="alternatif_solusi"></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="1%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Tupoksi</td>
        <td width="85%"><?php if(isset($tupoksi)){ foreach ($tupoksi as $row) { ?>
            <input style="width:20px;" id="tupoksi" name="tupoksi[]" type="checkbox" value="<?php echo $row->KodeTupoksi; ?>" />
            <?php echo $row->Tupoksi; ?></br>
            <?php }} ?>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Fokus Prioritas</td>
        <td width="85%"><?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
            <input style="width:20px;" id="<?php echo "fokus_prioritas".$row->idFokusPrioritas; ?>" name="fokus_prioritas[]" type="checkbox" value="<?php echo $row->idFokusPrioritas; ?>" />
            <?php echo $row->FokusPrioritas; ?></br>
            <?php }} ?></td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
		<tr>
			<td width="15%" style="padding-left:10px;vertical-align:top;">Reformasi Kesehatan</td>
			<td width="85%">
				<?php if(isset($reformasi_kesehatan)){ $no=1; foreach($reformasi_kesehatan as $row) { ?>
					<input style="width:20px;" id="<?php echo "reformasi_kesehatan".$row->idReformasiKesehatan; ?>" name="reformasi_kesehatan[]" type="checkbox" value="<?php echo $row->idReformasiKesehatan; ?>" />
                    <?php echo $row->ReformasiKesehatan; ?></br>
				<?php $no++;}} ?>
				<div id="label" style="color:red;"><strong></strong></div>			</td>
		</tr>
	</table>
	<h3>Ringkasan Fungsi</h3>
	<table width="100%" height="44%">
		<div>
		<tr> 
			<td width="15%" height="23" style="padding-left:10px;">Fungsi</td>
			<td>xxxx</td>
		</tr>
		</div>
		<div>
		<tr> 
			<td width="15%" height="21" style="padding-left:10px;">Sub Fungsi</td>
			<td>xxxx</td>
		</tr>
		</div>
		<div>
		<tr> 
			<td width="15%" height="32" style="padding-left:10px;">Program</td>
			<td>xxxx</td>
		</tr>
		</div>
		<div>
		<tr> 
			<td width="15%" height="21" style="padding-left:10px;">IKK</td>
			<td>xxxx</td>
		</tr>
		</div>
		<div>
		<tr> 
			<td width="15%" height="21" style="padding-left:10px;">Kegiatan</td>
			<td>xxxx</td>
		</tr>
		</div>
		<div>
		<tr> 
			<td width="15%" height="30" style="padding-left:10px;">IKU</td>
			<td>xxxx</td>
		</tr>
		</div>
		<div>
		<tr> 
			<td width="15%" style="padding-left:10px;">Aktivitas</td>
			<td>xxxx</td>
		</tr>
		</div>
	</table>
	<h3>Lampiran</h3>
	<table width="100%" height="100%">
		<tr>
			<td width="15%" style="padding-left:10px;">Proposal</td>
			<td width="85%"><input id="file1" name="file1" class="element file" type="file"/></td>
		</tr>
		<tr>
			<td style="padding-left:10px;">TOR</td>
			<td><input id="file2" name="file2" class="element file" type="file"/></td>
		</tr>
		<tr>
			<td style="padding-left:10px;">Data Pendukung Lainnya</td>
			<td><input id="file3" name="file3" class="element file" type="file"/></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Reset
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->
<script type="text/javascript">

$(document).ready(function(){
		$(function() {
			$( "#tanggal_proposal" ).datepicker({ dateFormat: "dd-mm-yy" });
		});
	});
	
	<?php if(isset($reformasi_kesehatan)){foreach($reformasi_kesehatan as $row) { ?>
		$('<?php echo "#biaya_rk_".$row->idReformasiKesehatan; ?>').hide();
	<?php }} ?>
	<?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
		$('<?php echo "#biaya_fp_".$row->idFokusPrioritas; ?>').hide();
	<?php }} ?>
	
	function get_data(kdsatker){
		document.form_pengusulan.kdsatker.value = '';
		document.form_pengusulan.provinsi.value = '';
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/e-planning/pendaftaran/get_alamatSatker",
			global: false,
			type: "POST",
			async: false,
			dataType: "html",
			data: "kdsatker="+ satker.value, //the name of the $_POST variable and its value
			success: function (response) {
				str = response.split(";");
				document.form_pengusulan.kdsatker.value = satker.value;
				document.form_pengusulan.provinsi.value = str[0];
			}          
		});
	  	return false;
	}
	
	function totalRk(){
		var biaya=0;
		<?php if(isset($reformasi_kesehatan)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					foreach($reformasi_kesehatan as $row) {
						if($no>0) echo "+";
						echo "eval(document.form_pengusulan.biaya_rk_".$row->idReformasiKesehatan.".value)";
						$no++;
					}

					echo ";";
				?>
		<?php } ?>
		document.form_pengusulan.total_rk.value = biaya;
		if(document.form_pengusulan.total_rk.value != document.form_pengusulan.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Priortas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	function totalFp(){
		var biaya=0;
		<?php if(isset($fokus_prioritas)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					foreach($fokus_prioritas as $row) {
						if($no>0) echo "+";
						echo "eval(document.form_pengusulan.biaya_fp_".$row->idFokusPrioritas.".value)";
						$no++;
					}
					echo ";";
				?>
		<?php } ?>
		document.form_pengusulan.total_fp.value = biaya;
		if(document.form_pengusulan.total_rk.value != document.form_pengusulan.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Priortas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	<?php if(isset($reformasi_kesehatan)){foreach($reformasi_kesehatan as $row) { ?>
		$('<?php echo "#reformasi_kesehatan".$row->idReformasiKesehatan; ?>').click(function() {
		  if(this.checked){
			$('<?php echo "#biaya_rk_".$row->idReformasiKesehatan; ?>').show();
		  }else{
			$('<?php echo "#biaya_rk_".$row->idReformasiKesehatan; ?>').hide();
			<?php echo "document.form_pengusulan.biaya_rk_".$row->idReformasiKesehatan.".value='0';"; ?>
			totalRk();
		  }
		});
	<?php }} ?>
	<?php if(isset($fokus_prioritas)){foreach($fokus_prioritas as $row) { ?>
		$('<?php echo "#fokus_prioritas".$row->idFokusPrioritas; ?>').click(function() {
		  if(this.checked){
			$('<?php echo "#biaya_fp_".$row->idFokusPrioritas; ?>').show();
		  }else{
			$('<?php echo "#biaya_fp_".$row->idFokusPrioritas; ?>').hide();
			<?php echo "document.form_pengusulan.biaya_fp_".$row->idFokusPrioritas.".value='0';"; ?>
			totalFp();
		  }
		});
	<?php }} ?>
	
    tinyMCE.init({
        // General options
        mode : "exact",
		elements : "latar_belakang,analisis_situasi,permasalahan,alternatif_solusi",
		theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
 
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,undo,redo",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "hr,removeformat,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        content_css : "css/content.css",
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",        
    });
</script>
