<div id="tengah">
<div id="judul" class="title"></div>
<div id="content_tengah">
	<form class="appnitro" name="form_feedback" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/manajemen/update_feedback/'.$perintah.'/'.$kd_pengajuan;?>"  onsubmit="return validateForm()">
	  <table width="500" border="1" align="center">
        <tr>
          <td><p>&nbsp;</p>
            <table width="100%" height="1%" cellpadding="0" cellspacing="0">
              <tr>
                <td style="padding-left:10px;"><p>Tanggal</p>
                <p>&nbsp;</p></td>
                  <td><p><input name="tanggal" id="tanggal" type="text" value="<?php echo  $tanggal ?>" /> (hh-bb-tttt)</p></td>
                   <p>&nbsp;  </p>
                </div></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Kode Surat </p>
                <p>&nbsp;</p></td>
                <td><?php echo  form_dropdown('kode_surat',$option_kode_surat, $kode_surat); ?>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Nomor Surat</p>
                <p>&nbsp; </p></td>
                <td><p>
                  <input name="nomor_surat" type="text" size="32" value="<?php echo  $nomor_surat ?>" />
                </p>
                <p>&nbsp; </p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Tahun Surat</p>
                <p>&nbsp; </p></td>
                <td><p>
                  <input name="tahun_surat" type="text" maxlength="4" size="4"  value="<?php echo  $tahun_surat ?>" />
                </p>
                <p>&nbsp; </p></td>
              </tr>
              <tr>
                <td width="19%" style="padding-left:10px;"><p>Hal</p>
                <p>&nbsp;</p></td>
                <td width="81%"><?php echo  $judul; ?>
                  <p>
                    <?php ?>                
                  </p>
                  <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Kepada</p>
                <p>&nbsp;</p></td>
                <td><?php echo  $nmsatker; ?>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Alamat</p>
                <p>&nbsp;</p></td>
                <td><?php echo  $alamat; ?>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Nomor Pengajuan</p>
                <p>&nbsp; </p></td>
                <td><?php echo  $nomor_pengajuan; ?>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Tanggal Pengajuan </p>
                <p>&nbsp;</p></td>
                <td><?php echo  $tanggal_pengajuan; ?>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Perihal Pengajuan </p>
                <p>&nbsp;</p></td>
                <td><?php echo  $perihal; ?>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;">Umpan balik: </td>
                <td><p>
                  <textarea name="umpan_balik"><?php echo  $umpan_balik ?></textarea>
                </p>
                <p style="padding-left:50px;">&nbsp;</p></td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><p>Dari</p>
                <p>&nbsp;</p></td>
                <td><p>drg. Tini Suryanti Suhandi, M. Kes (NIP.195510151982012002)</p>
                <p>&nbsp;</p></td>
              </tr>
			  <?php if($kode_jenis_satker != 3){?>
              <tr>
                <td style="padding-left:10px;"><p>Tembusan</p>
                <p>&nbsp;</p></td>
                <td><p>1 - <?php foreach($this->mm->get_where('ref_unit','KDUNIT',$kode_unit)->result() as $row) echo $row->NMUNIT;?></p>
                <p>&nbsp;</p></td>
              </tr>
			  <?php if($kode_jenis_satker != 2){?>
              <tr>
                <td style="padding-left:10px;">&nbsp;</td>
                <td><p>2 - </p>
                <p>&nbsp;</p></td>
              </tr>
			  <?php } ?>
			  <?php } ?>
            </table> 
            <blockquote>&nbsp;</blockquote></td>
        </tr>
      </table>
	  <p>&nbsp;</p>
	  <blockquote>
	    <p style="padding-left:50px;">
				<input type="button" name="batal" value="Batal" onClick="history.go(-1);" />
		  <input name="preview" type="submit" id="update" value="Update" />
        </p>
      </blockquote>
	</form>
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->
<script type="text/javascript">

$(document).ready(function(){
		$(function() {
			$( "#tanggal" ).datepicker({ dateFormat: "dd-mm-yy" });
		});
	});

function validateForm()
	{
	var a=document.forms["form_feedback"]["tanggal"].value;
	var b=document.forms["form_feedback"]["nomor_surat"].value;
	var c=document.forms["form_feedback"]["tahun_surat"].value;
	var d=document.forms["form_feedback"]["umpan_balik"].value;
	var f=document.forms["form_feedback"]["kode_surat"].value;
	if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="" || f==0 )
	  {
	  alert("Tanggal surat, nomor surat, kode surat, dan umpan balik harus diisi.");
	  return false;
	  }
}
    tinyMCE.init({
        // General options
        mode : "exact",
		elements : "umpan_balik",
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
