<div id="tengah">
    <div id="judul" class="title">
        Detail Import
    </div>
    <div id="content_tengah">
        <div>
            <table width="100%" height="100%">
                <tr>
                    <td width="15%">Tanggal</td>
                    <td width="85%">
                        <?php if (isset($sdate)){echo $sdate;}?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Nama Operator</td>
                    <td width="85%">
                        <?php if (isset($user_operate)){echo $user_operate;}?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Kode Satker Operator</td>
                    <td width="85%">
                        <?php if (isset($kdsatker_operate)){echo $kdsatker_operate;}?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Nama Satker Operator</td>
                    <td width="85%">
                        <?php if (isset($nmsatker_operate)){echo $nmsatker_operate;}?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Versi</td>
                    <td width="85%">
                        <?php if (isset($version)){echo $version;}?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Keterangan Perubahan</td>
                    <td width="85%">
                            
                                <?php if (isset($description)){echo $description;}?>
                         
                    </td>
                </tr>
            </table>
        </div>
        </form> 
<script type="text/javascript">        
	tinyMCE.init({
        // General options
        mode : "exact",
		elements : "description",
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
    <div id="judul" class="title">
        <?php echo $judul; ?>
    </div>
        <div>
	<?php
		if(isset($added_php)) echo $added_php."</br></br></br>";
		echo $js_grid;
	?>
	<table id="user" style="display:none"></table>
        </div>
        <div id="petunjuk">            
		<?=$this->config->item('petunjuk');?>
		<?=$notification; $this->session->unset_userdata('notification');?>
		<? if (isset($failed_form)) { echo $failed_form; $this->session->unset_userdata('failed_form'); }?>
		<? if(isset($no_asal)) echo $no_asal;?>
	</div>
    </div>
    <?php if (isset($div)){echo $div;}?>
    </div>
    
</div>
