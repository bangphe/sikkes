<div id="kiri">
<div id="judul" class="title">
	Telaah Staff
</div>
<div id="content">
	<!--form id="form_telaah_staff" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/telaah/telaah_staff/'.$kd_pengajuan; ?>" > <!--onsubmit="return validate_form()"-->
	<?php echo form_open('e-planning/telaah/telaah_staff/'.$kd_pengajuan); ?>
		<div style="color:red"><?php //echo validation_errors(); ?>
		 <h1><?php if(isset($warning)) echo $warning; ?></h1></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="20%" style="padding-left:10px;vertical-align:top;"><p>Tanggal</p></td>
				<td><p><input name="tanggal" id="tanggal" type="text" value="<?php if(isset($TANGGAL)) echo $TANGGAL; ?>" /> (hh-bb-tttt)</p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;" ><p>Persoalan</p></td>
				<td><p><textarea name="persoalan" id="persoalan" cols="100" rows="7"><?php if(isset($PERSOALAN)) echo $PERSOALAN; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Praanggapan</p></td>
				<td><p><textarea name="praanggapan" id="praanggapan" cols="100" rows="7"><?php if(isset($PRAANGGAPAN)) echo $PRAANGGAPAN; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Fakta yang mempengaruhi</p></td>
				<td><p><textarea name="fakta_yang_mempengaruhi" id="fakta_yang_mempengaruhi" cols="100" rows="7"><?php if(isset($FAKTA_YANG_MEMPENGARUHI)) echo $FAKTA_YANG_MEMPENGARUHI; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Penggunaan sumber daya yang cost efektif</p></td>
				<td><p><textarea name="cost_efektif" id="cost_efektif" cols="100" rows="7"><?php if(isset($COST_EFEKTIF)) echo $COST_EFEKTIF; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Efisien</p></td>
				<td><p><textarea name="efisien" id="efisien" cols="100" rows="7"><?php if(isset($EFISIEN)) echo $EFISIEN; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Feasibilitas (secara teknis, politis dan kendala sosial)</p></td>
				<td><p><textarea name="feasibilitas" id="feasibilitas" cols="100" rows="7"><?php if(isset($FEASIBILITAS)) echo $FEASIBILITAS; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Equity (keadilan)</p></td>
				<td><p><textarea name="equity" id="equity" cols="100" rows="7"><?php if(isset($EQUITY)) echo $EQUITY; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Menutup gap yang ada di daerah</p></td>
				<td><p><textarea name="gap_daerah" id="gap_daerah" cols="100" rows="7"><?php if(isset($GAP_DAERAH)) echo $GAP_DAERAH; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Analisis</p></td>
				<td><p><textarea name="analisis" id="analisis" cols="100" rows="7"><?php if(isset($ANALISIS)) echo $ANALISIS; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="padding-left:10px;vertical-align:top;"><p>Simpulan</p></td>
				<td><p><textarea name="simpulan" id="simpulan" cols="100" rows="7"><?php if(isset($SIMPULAN)) echo $SIMPULAN; ?></textarea></p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Simpan
					</button>
					<button type="button" class="negative" name="batal" onClick="history.go(-1);"> <img src="<?php echo base_url(); ?>images/main/back.png" alt=""/> Batal </button>
				</div>
			</td>
			</tr>
		</table>
	<!--/form-->
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(function() {
			$( "#tanggal" ).datepicker({ dateFormat: "dd-mm-yy" });
		});
	});
	function validate_form()
	{
	var a=document.forms["form_telaah_staff"]["tanggal"].value;
	var b=document.forms["form_telaah_staff"]["persoalan"].value;
	var c=document.forms["form_telaah_staff"]["praanggapan"].value;
	var d=document.forms["form_telaah_staff"]["fakta_yang_mempengaruhi"].value;
	var e=document.forms["form_telaah_staff"]["cost_efektif"].value;
	var f=document.forms["form_telaah_staff"]["efisien"].value;
	var g=document.forms["form_telaah_staff"]["feasibilitas"].value;
	var h=document.forms["form_telaah_staff"]["equity"].value;
	var i=document.forms["form_telaah_staff"]["gap_daerah"].value;
	var j=document.forms["form_telaah_staff"]["analisis"].value;
	var k=document.forms["form_telaah_staff"]["simpulan"].value;
	// var l=document.forms["form_telaah_staff"]["dari"].checked;
	// var m=document.forms["form_telaah_staff"]["kepada"].checked;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="" || e==null || e=="" || f==null || f=="" || g==null || g=="" || h==null || h=="" || i==null || i=="" || j==null || j=="" || k==null || k=="")
	  {
	  alert("Dari dan kepada harus dipilih. Tanggal, persoalan, pra-anggapan, fakta yang memperngaruhi, penggunaan sumber daya yang efektif, feasibilitas, equity, gap daerah, analisis, dan simpulan harus diisi.");
	  return false;
	  }
	}
	tinyMCE.init({
        // General options
        mode : "exact",
		elements : "persoalan,praanggapan,fakta_yang_mempengaruhi,cost_efektif,efisien,feasibilitas,equity,gap_daerah,analisis,simpulan",
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
