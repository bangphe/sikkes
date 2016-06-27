<div id="tengah">
<div id="judul" class="title">
	Detail Usulan
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/pendaftaran/pengajuan_step3'; ?>" onsubmit="return validateForm()">
	<ul id="tt" class="easyui-tree"
			url="<?php echo  base_url(); ?>index.php/e-planning/pendaftaran/json"
			checkbox="true">
	</ul>
	<input type="hidden" name="kd_pengajuan" id="kd_pengajuan" value="<?php echo  $kd_pengajuan; ?>" /></td>
	
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
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					
					<button type="button" class="negative" name="sebelumnya" onClick="history.go(-1);">
						<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
						Sebelumnya
					</button>
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Lanjut
					</button>
				</div>
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->
<script type="text/javascript">
function validateForm()
	{
	var a=document.forms["form_pengusulan"]["latar_belakang"].value;
	var b=document.forms["form_pengusulan"]["analisis_situasi"].value;
	var c=document.forms["form_pengusulan"]["alternatif_solusi"].value;
	var e=document.forms["form_pengusulan"]["file1"].value;
	var f=document.forms["form_pengusulan"]["file2"].value;
	var g=document.forms["form_pengusulan"]["file3"].value;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || e==null || e=="" || f==null || f=="" || g==null || g=="")
	  {
	  if(!confirm("Latar belakang, analisis situasi, dan alternatif solusi belum diisi.\nBelum ada file yang dipilih.\nApakah Anda tetap melanjutkan?"))
	  return false;
	  }
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
