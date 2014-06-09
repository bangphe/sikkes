<script language="javascript">   
    function validate() {
        if (document.addsinonim.feedback_text.value == "") {
            alert(" Harap masukan Feedback !");
            document.addsinonim.feedback_text.focus();
            return false;
        }
        return true;
    }
</script>
<div id="tengah">
    <div id="judul" class="title">
        <?php echo $judul; ?>
    </div>
    <div id="content_tengah">
        <form class="appnitro" name="addsinonim" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'index.php/e-budget/feedback/add_feedback_action/'.$kdunit.'/'.$satker.'/'.$page.'/'.$key_back.'/'.$key; ?>" onsubmit="return validate();">
            <div>
                <table width="100%" height="100%">
                    <tr>
                        <td width="15%"><?php echo $label; ?></td>
                        <td width="85%">
                            <textarea name="feedback_text" id="feedback_text">
                            
                            </textarea> 
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%">  
                            <div class="buttons">
                                <button type="submit" class="regular" name="submit">
                                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                                    Tambah
                                </button>
                            </div>
                            <a href='<?php echo site_url().'/e-budget/feedback/feedback_edit/'.$kdunit.'/'.$satker.'/'.$page.'/'.$key_back.'/'.$key ;?>'>
                                <div class="buttons">
                                    <button type="button" class="regular" name="submit">
                                        <img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
                                        Kembali
                                    </button>
                                </div>
                            </a>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $error; ?></td>
                        <td width="85%">

                        </td>
                    </tr>
                </table>
            </div>
        </form>   
<script type="text/javascript">        
	tinyMCE.init({
        // General options
        mode : "exact",
		elements : "feedback_text",
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
    </div>
</div>

