<div id="tengah">
<div id="judul" class="title">
	Info Umum Proposal
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/pendaftaran/pengajuan'; ?>" onsubmit="return validateForm()" >
	<ul id="tt" class="easyui-tree"
			url="<?php echo base_url(); ?>index.php/e-planning/pendaftaran/json"
			checkbox="true">
	</ul>
	<input type="hidden" name="kd_pengajuan" id="kd_pengajuan" value="<?php echo $kd_pengajuan; ?>" /></td>
	<?php if($error_file != ''){ 
		echo $error_file;
	} ?>
	<h3>Sumber Dana</h3>
	<table width="100%" height="1%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="15%" style="padding-left:10px;">Sumber Dana</td>
			<td width="85%"><?php echo form_dropdown('rencana_anggaran',$rencana_anggaran); ?></td>
		<tr>
	</table>
	<h3>Rincian Pengusul</h3>
	<table width="100%" height="19%">
		<tr>
			<td colspan="2"><input type="hidden" name="kdsatker" id="kdsatker" readonly="TRUE" value="<?php echo $kdsatker; ?>" /></td>
		<tr>
			<td width="15%" height="24" style="padding-left:10px;">Nama Satker</td> 
			<td>
				<?php
					if($selected_worker!=NULL) $disabled = "disabled='disabled' width='85%'";
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
			<td style="padding-left:10px;">Jenis Kewenangan</td>
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
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Judul Proposal*</td>
			<td width="85%">
				<textarea id="judul_proposal" name="judul_proposal" rows=2 cols=72></textarea>
				<?php echo form_error('judul_proposal'); ?>			</td>
		</tr>
		<tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Nomor Surat Pengantar*</td>
			<td width="85%">
				<input type="text" id="nomor_proposal" name="nomor_proposal" />
				<?php echo form_error('nomor_proposal'); ?>			</td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Tanggal Surat*</td>
			<td><p>
			  <input name="tanggal_pembuatan" id="tanggal_pembuatan" type="text" /> (hh-bb-tttt)
			</p></td>
        </tr>
		  <tr>
			<td width="15%" height="37" style="padding-left:10px;vertical-align:top;">Perihal Surat</td>
			<td width="85%"><textarea id="perihal" name="perihal" rows="3" cols="72"></textarea>
				<?php echo form_error('perihal'); ?> </td>
		  </tr>
    
		<tr>
			<td height="24" style="padding-left:10px;">Th. Anggaran</td>
			<td><input type="text"  name="thn_anggaran" id="thn_anggaran"  readonly="TRUE" value="<?php echo $thn_anggaran; ?>"/></td>
		</tr>
		<?php /*<tr>
			<td height="24" style="padding-left:10px;">Triwulan</td> 
			<td>
				<input type="text" name="triwulan" id="triwulan"  readonly="TRUE" value="<?php echo $this->session->userdata('triwulan'); ?>"/>			</td>
		</tr> */ ?>
		<tr>
		  <td style="padding-left:10px;vertical-align:top;">Tupoksi</td>
		  <td><?php if(isset($tupoksi)){ foreach ($tupoksi as $row) { ?>
              <input id="tupoksi" name="tupoksi[]" type="checkbox" value="<?php echo $row->KodeTupoksi; ?>" />
              <?php echo $row->Tupoksi; ?></br>
              <?php }} ?>          </td>
	    </tr>
	
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Fokus Prioritas</td>
			<td><table width="100%" height="100%">
				<?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
				<tr>
				<td>	<input  id="<?php echo "fokus_prioritas".$row->idFokusPrioritas; ?>" name="fokus_prioritas[]" type="checkbox" value="<?php echo $row->idFokusPrioritas; ?>" /> </td>
					<td width="97%"><?php echo $row->FokusPrioritas; ?></td>
				</tr>
				<?php }} ?>
			</table></td>
		</tr>
		<tr>
			<td style="padding-left:10px;vertical-align:top;">Reformasi Kesehatan</td>
			<td><table width="100%" height="100%">
				<?php if(isset($reformasi_kesehatan)){ foreach($reformasi_kesehatan as $row) { ?>
				<tr>
				<td>	<input  id="<?php echo "reformasi_kesehatan".$row->idReformasiKesehatan; ?>" name="reformasi_kesehatan[]" type="checkbox" value="<?php echo $row->idReformasiKesehatan; ?>" /> </td>
				<td width="97%"><?php echo $row->ReformasiKesehatan; ?></td>
				</tr>
				<?php }} ?>
			</table></td>
		</tr>
        
	</table>
	<h3>Waktu Pelaksanaan </h3>
	<table width="100%" height="10%">
      <tr>
        <td width="15%" height="24"style="padding-left:10px;vertical-align:top;">Tanggal Mulai*</td>
        <td><p>
          <input name="tanggal_mulai" id="tanggal_mulai" type="text"/> (hh-bb-tttt)
        </p></td>
        </tr>
      <tr>
        <td style="padding-left:10px;vertical-align:top;">Tanggal Selesai*</td>
        <td><p>
          <input name="tanggal_selesai" id="tanggal_selesai" type="text" /> (hh-bb-tttt)
        </p></td>
        </tr>
    </table>
	<h3>Ringkasan Proposal</h3>
	<table width="100%" height="16%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Latar Belakang*</td>
        <td width="85%"><textarea id="latar_belakang" name="latar_belakang"></textarea></td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Analisis Situasi*</td>
        <td width="85%"><textarea id="analisis_situasi" name="analisis_situasi"></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Permasalahan*</td>
        <td width="85%"><textarea id="permasalahan" name="permasalahan"></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<table width="100%" height="6%">
      <tr>
        <td width="15%" style="padding-left:10px;vertical-align:top;">Alternatif Pemecahan Masalah*</td>
        <td width="85%"><textarea id="alternatif_solusi" name="alternatif_solusi"></textarea>
        </td>
      </tr>
    </table>
	<p>&nbsp;</p>
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
	</table>
	<p>&nbsp;</p>
	<h3>Ringkasan Fungsi</h3>
	<table width="100%" height="3%">
      <div>
        <tr>
          <td width="15%" height="23" style="padding-left:10px;">Fungsi*</td>
          <td width="85%"><select id="fungsi" name="fungsi" onchange="get_sub(this.value);">
            				<option value="0">--- Pilih Fungsi ---</option>
                            <?php
							  foreach($fungsi->result() as $row)
							  {
								  echo '<option value="'.$row->KodeFungsi.'">['.$row->KodeFungsi.'] '.$row->NamaFungsi.'</option>';
							  }
							  ?>
              </select>
			</td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
      
		<tr >
			<td width="15%"  style="padding-left:10px;">Sub Fungsi*</td>
			<td width="85%"><select id="subfungsi_" name="subfungsi_"  >
            <option value="0">--- Pilih Sub Fungsi ---</option></select></td>
		</tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
        <tr>
          <td width="15%" style="padding-left:10px;">Program*</td>
          <td><label>
           <select id="program" name="program" onchange="get_keg(this.value); get_outcome(this.value), get_iku(this.value) ">
			<option value="0">--- Pilih Program ---</option>
            <?php
			  foreach($program->result() as $row)
			  {
				  echo '<option value="'.$row->KodeProgram.'">['.$row->KodeProgram.'] '.$row->NamaProgram.'</option>';
			  }
			  ?>
              </select>
          </label></td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
        <tr>
          <td width="15%" height="32" style="padding-left:10px;vertical-align:top;">Outcome</td>
          <td name="outcome" id="outcome" >
            --- Pilih Program Terlebih Dahulu ---
          </td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="23%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">IKU</td>
          <td style="padding-left:10px;" id="iku" name="iku">
					--- Pilih Program Terlebih Dahulu ---</td>

          </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="8%">
	  <div>
       
		<tr>
          <td width="15%" height="21" style="padding-left:10px;">Kegiatan*</td>
          <td><label>
            <select id="kegiatan_" name="kegiatan_" onchange="get_output(this.value); get_ikk(this.value)">
            <option selected="true" value="0">--- Pilih Kegiatan ---</option></select></select>
          </label></td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="4%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">Output</td>
          <td name="output" id="output" >
		  --- Pilih Kegiatan Terlebih Dahulu ---
		  </td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="23%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">IKK</td>
          <td style="padding-left:10px;" id="ikk" name="ikk">
					--- Pilih Kegiatan Terlebih Dahulu ---</td>
				
          </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%"><tr><td  width="100%" style="text-align:center">
	<div class="buttons">
	  <a href="<?php echo site_url(); ?>/e-planning/manajemen/grid_pengajuan" class="negative">
						<img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
						Batal
					 </a>
      <button type="submit" class="regular" name="save" id="save"> <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/> Simpan </button>
	  </div>
	 </td></tr></table>
	<p>&nbsp;</p>
	</form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
		$(function() {
			$("#tanggal_pembuatan").datepicker({dateFormat:"dd-mm-yy"});
			$("#tanggal_mulai").datepicker({dateFormat:"dd-mm-yy"});
			$("#tanggal_selesai").datepicker({dateFormat:"dd-mm-yy"});
		});
	});

function get_sub(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_sub/'+v;
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
			
			$('#subfungsi_').html('<option value="0">--- Pilih Sub Fungsi ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeSub'];
				nama = data[i]['NamaSub'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
			}
  				$('#subfungsi_').append(option);
		}
	});	
}
function get_keg(x)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_keg/'+x;
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
			
			$('#kegiatan_').html('<option value="0">--- Pilih Kegiatan ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeKeg'];
				nama = data[i]['NamaKeg'];
				option += '<option value="'+id+'">['+id+'] '+nama+'</option>';
				
			}
  				$('#kegiatan_').append(option);
		}
	});	
}
function get_outcome(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_outcome/'+v;
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
			var option='';
			var nama;
			
			//$('#testing').html('');
			
			$('#outcome').html('');
			
			for(var i=0; i< data.length;i++)
			{
				nama = data[i]['OutComeProgram'];
				option += nama+'</br>';
			}
  				$('#outcome').append(option);
		}
	});	
}
function get_iku(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_iku/'+v;
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
			var option='';
			var nama;
			var target;
			var idtarget;
			//$('#testing').html('');
			
			$('#iku').html('<tr><td></td><td></td><td  align="center"><b>Target Nasional</b></td><td  align="center"><b>Jumlah</b></td></tr>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIku'];
				idtarget = id.replace(/\./g, '_');
				nama = data[i]['Iku'];
				target = data[i]['TargetNasional'];
				option += '<tr><td><input type="checkbox" name="iku_[]" value="'+id+'"/></></td><td>['+id+'] '+nama+'</td><td width="17%"><iwidth="17%"><input readonly="true" type="text" name="nasional_iku_'+i+'" value="'+target+'" style="text-align:center"/></td><td width="17%"><input type="text" style="text-align:center" name="target_iku_'+idtarget+'" id="target_iku_'+id+'"/></td></tr>';
			}
  				$('#iku').append(option);
		}
	});	
}
function get_output(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_output/'+v;
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
			var option='';
			var nama;
			
			//$('#testing').html('');
			
			$('#output').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeOutput'];
				nama = data[i]['Output'];
				option += nama+'</br>';
			}
  				$('#output').html(option);
		}
	});	
}
function get_ikk(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/pendaftaran/get_ikk/'+v;
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
			var option='';
			var nama;
			var target;
			var idtarget;
			//$('#testing').html('');
			
			$('#ikk').html('<tr><td></td><td></td><td  align="center"><b>Target Nasional</b></td><td align="center"><b>Jumlah</b></tr>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIkk'];
				idtarget = id.replace(/\./g, '_');
				nama = data[i]['Ikk'];
				target = data[i]['TargetNasional'];
				option +=  '<tr><td><input type="checkbox" name="ikk_[]" value="'+id+'"/></></td><td>['+id+'] '+nama+'</td><td width="17%"><iwidth="17%"><input readonly="true" type="text" name="nasional_ikk_'+i+'" value="'+target+'" style="text-align:center"/></td><td width="17%"><input type="text" style="text-align:center" name="target_ikk_'+idtarget+'" id="target_ikk_'+id+'"/></td></tr>';
			}
  				$('#ikk').append(option);
		}
	});	
}
function validateForm()
	{
	var a=document.forms["form_pengusulan"]["judul_proposal"].value;
	var b=document.forms["form_pengusulan"]["nomor_proposal"].value;
	var c=document.forms["form_pengusulan"]["tanggal_pembuatan"].value;
	var d=document.forms["form_pengusulan"]["tanggal_mulai"].value;
	var e=document.forms["form_pengusulan"]["tanggal_selesai"].value;
	var f=document.forms["form_pengusulan"]["fungsi"].value;
	var g=document.forms["form_pengusulan"]["subfungsi_"].value;
	var h=document.forms["form_pengusulan"]["program"].value;
	var i=document.forms["form_pengusulan"]["kegiatan_"].value;
	var j=document.forms["form_pengusulan"]["latar_belakang"].value;
	var k=document.forms["form_pengusulan"]["analisis_situasi"].value;
	var l=document.forms["form_pengusulan"]["permasalahan"].value;
	var m=document.forms["form_pengusulan"]["alternatif_solusi"].value;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="" || e==null || e=="" || f==0 || g==0 || h==0 || i==0  || j==""  || j=="<p></p>" || k=="" || k=="<p></p>" || l=="" || l=="<p></p>" || m=="" || m=="<p></p>" )
	  {
	  alert("Judul, nomor, tanggal pembuatan, tanggal mulai, tanggal selesai, latar belakang, analisis situasi, permasalahan, dan alternatif pemecahan masalah harus diisi.\nFungsi, subfungsi, program, dan kegiatan harus diisi.");
	  return false;
	  }
}

function validateIk()
{
	for (i=0; i<document.test.iku_.length; i++){
		iku[i] = document.forms["form_pengusulan"]["target_iku"+i].value;
		if (document.test.iku_[i].checked==true){
			if (iku[i] == "0" || iku[i] == 0){
				alert("Jumlah IKU yang terpilih harus diisi.")
				return false;
				}
		}
	}
	for (i=0; i<document.test.ikk_.length; i++){
		ikk[i] = document.forms["form_pengusulan"]["target_ikk"+i].value;
		if (document.test.ikk_[i].checked==true){
			if (ikk[i] == "0" || ikk[i] == 0){
				alert("Jumlah IKK yang terpilih harus diisi.")
				return false;
				}
		}
	}
	}

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
	
	function hitungJumlah(){
		biaya = eval(document.form_pengusulan.volume.value)*eval(document.form_pengusulan.harga_satuan.value);
		document.form_pengusulan.jumlah.value = biaya;
	}
	tinyMCE.init({
        // General options
        mode : "exact",
		elements : "latar_belakang,analisis_situasi,permasalahan,alternatif_solusi",
		theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
 
        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,undo,redo",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "hr,removeformat,|,sub,sup,|,charmap,emotions,iespell,image,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
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
