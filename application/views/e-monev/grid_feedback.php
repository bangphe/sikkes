<?php $role_open = array(1,4,5,8); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/feedback.css">
<script type="text/javascript">
    
    function save(id_permasalahan){
       // var feedback_text = document.getElementById('tinymce').value;
	   var feedback_text = tinyMCE.activeEditor.getContent({format : 'raw'});
        var reply_from = document.getElementById("reply_from").value;
        var id_user = <?php echo $id_user; ?>;
		        
        $("#buttonSave").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> saving...');
        $.ajax({
            url: '<?= base_url() ?>index.php/e-monev/laporan_monitoring/save_feedback/'+id_permasalahan,
            global: false,
            type: 'POST',
            async: false,
            dataType: 'html',
            data:{
                feedback_text:feedback_text,
				id_user:id_user,
				reply_form:reply_from
            },
            success: function (response) {
                getFeedback(id_permasalahan);
            }
        });
        return false;
    }
    
	function getFeedback(id){
        $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
        get_html_data(base_url+"index.php/e-monev/laporan_monitoring/input_feedback/"+id,'', 'profile_detail_loading', 'content_tengah');
    }
	
	function getMore(id){
		
		var ID = id;
		
		if(ID){
			$("#moro"+ID).html('<img src="<?php echo base_url();?>/images/icons/loading.gif" />');

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/e-monev/laporan_monitoring/load_more/<?php echo $id_permasalahan; ?>",
				data: "id_feedback="+ ID, 
				cache: false,
				success: function(html){
					$("ul.stream").append(html);
					$("#moro"+ID).remove();
				}
			});
		}else{
			$(".morebox").html('The End');
		}
		return false;
	}
	
	function replyFrom(ID){
		var msgID = document.getElementById("msg-stream-"+ID).innerHTML;
		var replyID = document.getElementById("reply_from").value;
		
		if(msgID.length > 160){
			msgID = msgID.substr(0, 160)+"...";
		}
		
		if(replyID != 0){
			document.getElementById("reply-stream-"+replyID).innerHTML="komentar";
			document.getElementById("reply-stream-"+replyID).setAttribute('onclick', 'replyFrom('+replyID+')');
		}
		
		document.getElementById("reply_from").value=ID;
		document.getElementById("msg-reply").style.display="block";
		document.getElementById("tutupAll").style.display="block";
		document.getElementById("msg-reply").innerHTML="<b>Reply :</b><br>"+msgID;
		document.getElementById("reply-stream-"+ID).innerHTML="tutup";
		document.getElementById("reply-stream-"+ID).setAttribute('onclick', 'tutupFrom('+ID+')');
		document.getElementById("tutupAll").setAttribute('onclick', 'tutupFrom('+ID+')');
		document.getElementById("disabled_img").style.display="none";
		document.getElementById("input_feedback_textarea").style.display="block";
		document.getElementById("buttonClass").removeAttribute('disabled');
	}
	
	function tutupFrom(ID){
		document.getElementById("reply_from").value="0";
		document.getElementById("msg-reply").style.display="none";
		document.getElementById("tutupAll").style.display="none";
		document.getElementById("msg-reply").innerHTML="";
		document.getElementById("reply-stream-"+ID).innerHTML="komentar";
		document.getElementById("reply-stream-"+ID).setAttribute('onclick', 'replyFrom('+ID+')');
		document.getElementById("tutupAll").setAttribute('onclick', '');
		document.getElementById("reply-stream-"+ID).setAttribute('href', '#');
		<?php if(!in_array($this->session->userdata("kd_role"), $role_open)){ ?>				
		document.getElementById("disabled_img").style.display="block";
		document.getElementById("input_feedback_textarea").style.display="none";
		document.getElementById("buttonClass").setAttribute('disabled', 'disabled');
		<?php } ?>
	}
</script>

<h2 class="tablecloth">Tahun Anggaran : <?php echo $this->session->userdata('thn_anggaran'); ?></h2>
<h2 class="tablecloth">Bulan : <?php echo $bulan; ?></h2>
<h2 class="tablecloth">Nama Komponen/Sub Komponen : <?php echo $sub_komponen; ?></h2>
<h2 class="tablecloth">Jenis Input : Feedback <?php if(!in_array($this->session->userdata("kd_role"), $role_open)){ echo "(hanya bisa input komentar)"; }?></h2>

<table width=700>
    <tr>
        <td><b>Status</b></td>
        <td><?php echo $data_masalah->status == 0 ? 'Belum Resolved' : 'Sudah Resolved'; ?></td>

        <td><b>Pihak Terkait</b></td>
        <td><?php echo $data_masalah->pihak_terkait == 0 ? 'Internal' : 'Eksternal'; ?></td>
    </tr>
    <tr>
        <td><b>Permasalahan</b></td>
        <td><?php echo $data_masalah->isi_permasalahan; ?></td>
        <td><b>Keterangan Pihak Terkait</b></td>
        <td>
            <?php echo $data_masalah->ket_pihak_terkait; ?>
        </td>
    </tr>
</table>

<br/>
<div>
    <?= anchor(site_url('e-monev/laporan_monitoring/input_masalah/' . $data_masalah->d_skmpnen_id . '#'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Daftar Permasalahan', array('onclick' => 'update(' . $data_masalah->d_skmpnen_id . ',' . $data_masalah->bulan . ', true);;return false;')); ?>
</div>

<div class="clear"></div>
<div class="garis"></div>
<div class="feedback" id="repnow">
	<!-- input feedback -->
	<div class="inputFeedback">
		<div><h3>Input Feedback</h3></div>
		<div id="msg-reply" style="display: none"></div>
		<div id="tutupAll" style="display: none">[ Tutup Komentar ]</div>
		<input type="hidden" name="reply_from" value="0" id="reply_from">
		<input type="hidden" name="id_user" value="<?php echo $id_user;?>"/>
		<?php 
			if(!in_array($this->session->userdata("kd_role"), $role_open)){ 
				$display_input = "block";
				$display_img = "none";
				$disable_button = "";
			}else{
				$display_input = "none";
				$display_img = "block";
				$disable_button = "disabled='disabled'";
			}
		?>
		<div id="input_feedback_textarea" style="display:<?php echo $display_input; ?>">
		<textarea id="feedback_text" name="feedback_text"></textarea>
		</div>
		<img src="<?php echo base_url()."images/main/disabled_feedback.png";?>" width="350" id="disabled_img" style="display:<?php echo $display_img; ?>">
		<div class="clear"></div>
		<div class="right tombol20" id="buttonSave">
			<input type="button" value="Kirim" id="buttonClass" onclick="save(<?php echo $id_permasalahan; ?>)" class="buttonClass" <?php echo $disable_button; ?>>
		</div>
		<br><br><br><br>
		<div class="clear"></div>
	</div>

	<!-- history feedback -->
	<div class="listFeedback">
		<?php if($history->num_rows() > 0):?>
		<div><h3>History</h3></div>
		<ul class="stream">
		<?php $id_feedback = 0; ?>
		<?php foreach ($history->result() as $row):?>
			<li>
				<a href="#"><img class="ava-stream" src="<?php echo base_url();?>images/icons/depkes.png" width="40" height="48" alt="<?php echo $row->USERNAME;?>" /></a>
				<div class="pesan-stream">
					<div class="nama-stream"><?php echo (strtolower($row->USERNAME));?></div>
					<div id="msg-stream-<?php echo $row->ID_FEEDBACK;?>"><?php echo $row->PESAN;?></div>
					<div class="date-stream">
						<a href="#repnow" onclick="javascript:replyFrom(<?php echo $row->ID_FEEDBACK;?>)" class="reply-stream" id="reply-stream-<?php echo $row->ID_FEEDBACK;?>">komentar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a title="<?php echo date("d F Y   H:i ", strtotime($row->TANGGAL));?>WIB" class="time-reply"><?php echo $this->general->KonversiWaktu(strtotime($row->TANGGAL));?></a>
					</div>
				</div>
				<div class="clear"></div>
				<?php $id_feedback = $row->ID_FEEDBACK; ?>
			</li>
			<?php
				if($row->PARENT == 0){
					$parent = $this->fm->get_parent($id_permasalahan, $row->ID_FEEDBACK); 
					foreach ($parent->result() as $brs):
			?>
						<li class="msg-stream-reply">
							<a href="#"><img class="ava-stream-reply" src="<?php echo base_url();?>images/icons/depkes.png" width="30" height="38" alt="<?php echo $brs->USERNAME;?>" /></a>
							<div class="pesan-stream-reply">
								<div class="nama-stream-reply"><?php echo (strtolower($brs->USERNAME));?></div>
								<div><?php echo $brs->PESAN;?></div>
								<div class="date-stream-reply">
									<a title="<?php echo date("d F Y   H:i ", strtotime($brs->TANGGAL));?>WIB"><?php echo $this->general->KonversiWaktu(strtotime($brs->TANGGAL));?></a>
								</div>
							</div>
							<div class="clear"></div>
						</li>
			<?php	
					endforeach; 
				}
			?>
		<?php endforeach;?>
		</ul>     
		<?php endif;?>
		<?php if($history->num_rows() < 5){ ?>
			<br><br><br>
		<?php }else{ ?>
			<!-- load moro -->
			<a href="#" class="moro" id="<?php echo $id_feedback; ?>" onclick="getMore(<?php echo $id_feedback; ?>)">
				<div id="moro<?php echo $id_feedback; ?>" class="morebox">selanjutnya</div>
			</a>
		<?php } ?>
	</div>
</div>
<div class="clear"></div>

<script>
    tinyMCE.init({
        // General options
        mode : "exact",
		elements : "feedback_text",
		theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
 
        // Theme options
        theme_advanced_buttons1 : "undo,redo,|,link,unlink,|,sub,sup,|,charmap,emotions,",
        theme_advanced_buttons2 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
        content_css : "css/content.css",
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",
		width:"100%"
    });
</script>