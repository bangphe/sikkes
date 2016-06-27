<div id="tengah">
    <div id="judul" class="title">
        Data Proposal
    </div>
    <div id="content_tengah">
        <table width="100%" height="auto" cellpadding="2" cellspacing="0">
            <tr>
                <td width="15%">Sumber Dana</td>
                <td width="85%">
                    <?php
                    foreach ($this->mm->get_where('ref_rencana_anggaran', 'id_rencana_anggaran', $selected_rencana_anggaran)->result() as $row)
                        echo $row->rencana_anggaran;
                    ?>
                </td>
            </tr>
            <tr>
                <td width="15%" style="vertical-align:top;">Nama Satker</td> 
                <td>
                    <?php
                    foreach ($this->mm->get_where('ref_satker', 'kdsatker', $kdsatker)->result() as $row)
                        echo $row->nmsatker;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Propinsi</td>
                <td><?php echo  $provinsi; ?></td>
            </tr>
            <tr>
                <td>Jenis Satker</td>
                <td>
                    <?php
                    foreach ($this->mm->get_where('ref_jenis_satker', 'KodeJenisSatker', $KodeJenisSatker)->result() as $row)
                        echo $row->JenisSatker;
                    ?>
                </td>
            </tr>
            <tr>
                <td width="15%" style="vertical-align:top;">Judul Proposal</td>
                <td width="85%">
                    <?php echo  $judul; ?>
                </td>
            </tr>
            <tr>
                <td width="15%" style="vertical-align:top;">Nomor Surat Pengantar</td>
                <td width="85%">
                    <?php echo  $nomor; ?>
                </td>
            </tr>
            <tr>
                <td style="vertical-align:top;">Tanggal Surat</td>
                <td><p><?php echo  $tanggal_pembuatan; ?></p></td>
            </tr>
            <tr>
                <td width="15%" style="vertical-align:top;">Perihal Surat</td>
                <td width="85%"><?php echo  $perihal; ?></td>
            </tr>
            <tr>
                <td style="vertical-align:top;">Th. Anggaran</td>
                <td><?php echo  $thn_anggaran; ?></td>
            </tr>
        </table>
    </div>
    <div>
        <h3>Feedback</h3>
	<?php echo  form_open($post_action);?>
        <textarea id="feedback_text" name="feedback_text"></textarea>
        <a href="<?php echo  site_url(); ?>/e-planning/manajemen/grid_pengajuan" class="negative">
            <img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Batal
        </a>
        <button type="submit" class="regular" name="save" id="save"> 
            <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/> Kirim 
        </button>
        <?php echo  form_close();?>
    </div>
</div>

<script>
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
