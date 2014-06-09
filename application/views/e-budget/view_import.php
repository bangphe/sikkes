<div id="tengah">
    <div id="judul" class="title">
        Import RKA-KL data
    </div>
    <div id="content_tengah">
        <?php ini_set("memory_limit","200M"); echo form_open_multipart(base_url() . 'index.php/e-budget/import/import_action'); ?>
        <div>
            <table width="100%" height="100%">
                <tr>
                    <td width="15%">RKA-KL database dalam bentuk zip</td>
                    <td width="85%">
                        <input type="file" name="zip" value="" />
                    </td>
                </tr>
                <tr>
                    <td width="15%">Versi</td>
                    <td width="85%">
                        <input type="text" name="versi" id="versi"/>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Keterangan Perubahan</td>
                    <td width="85%">
                            <textarea name="description" id="description">
                            
                            </textarea> 
                    </td>
                </tr>
                <?php
                if ($super == "1") {
                ?>
                <tr>
                    <td width="15%">Hapus Semua Data Lama</td>
                    <td width="85%">
                        <input type="checkbox" name="clear" value="clear"/>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td width="15%"></td>
                    <td width="85%">  
                        <div class="buttons">
                            <button type="submit" class="regular" name="submit">
                                <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                                Import
                            </button>
                        </div>
                    </td>
                    <td></td>
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
    </div>
    
</div>
