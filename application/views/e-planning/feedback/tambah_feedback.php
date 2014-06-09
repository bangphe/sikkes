<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/feedback.css">
<script type="text/javascript">
	$(function() {
		//More Button
		$('.more').live("click",function() 
		{
		var ID = $(this).attr("id");
		if(ID){
			$("#more"+ID).html('<img src="<?php echo base_url();?>/images/icons/loading.gif" />');

			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/e-planning/feedback/load_more/<?php echo $kdpengajuan; ?>",
				data: "id_feedback="+ ID, 
				cache: false,
				success: function(html){
					$("ul.stream").append(html);
					$("#more"+ID).remove();
				}
			});
		}else{
			$(".morebox").html('The End');
		}
		return false;
		});
	});
	
	function replyFrom(ID){
		var msgID = document.getElementById("msg-stream-"+ID).innerHTML;
		var replyID = document.getElementById("reply_from").value;
		
		if(msgID.length > 160){
			msgID = msgID.substr(0, 160)+"...";
		}
		
		if(replyID != 0){
			document.getElementById("reply-stream-"+replyID).innerHTML="komentar1";
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
		document.getElementById("reply-stream-"+ID).innerHTML="komentar2";
		document.getElementById("reply-stream-"+ID).setAttribute('onclick', 'replyFrom('+ID+')');
		document.getElementById("tutupAll").setAttribute('onclick', '');
		document.getElementById("reply-stream-"+ID).setAttribute('href', '#');
		<?php if(!in_array($this->session->userdata("kd_role"), array(3,8))){ ?>				
		document.getElementById("disabled_img").style.display="block";
		document.getElementById("input_feedback_textarea").style.display="none";
		document.getElementById("buttonClass").setAttribute('disabled', 'disabled');
		<?php } ?>
	}
	
</script>
<div id="tengah">
    <div id="judul" class="title">
        Data Proposal
    </div>
    <div id="content_tengah">
		<table class="tableBase">
			<tr>
				<td>
					<table class="tableInfo">
						<tr>
							<td class="tdInfo">Sumber Dana</td>
							<td>
								<?php
								foreach ($this->mm->get_where('ref_rencana_anggaran', 'id_rencana_anggaran', $selected_rencana_anggaran)->result() as $row)
									echo $row->rencana_anggaran;
								?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Nama Satker</td> 
							<td>
								<?php
								foreach ($this->mm->get_where('ref_satker', 'kdsatker', $kdsatker)->result() as $row)
									echo $row->nmsatker;
								?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Propinsi</td>
							<td><?php echo $provinsi; ?></td>
						</tr>
						<tr>
							<td class="tdInfo">Jenis Satker</td>
							<td>
								<?php
								foreach ($this->mm->get_where('ref_jenis_satker', 'KodeJenisSatker', $KodeJenisSatker)->result() as $row)
									echo $row->JenisSatker;
								?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo">Judul Proposal</td>
							<td>
								<?php echo $judul; ?>
							</td>
						</tr>
					</table>
					<table class="tableInfo">
						<tr>
							<td class="tdInfo">No. Surat Pengantar</td>
							<td>
								<?php echo $nomor; ?>
							</td>
						</tr>
						<tr>
							<td class="tdInfo"">Tanggal Surat</td>
							<td><p><?php echo $tanggal_pembuatan; ?></p></td>
						</tr>
						<tr>
							<td class="tdInfo">Perihal Surat</td>
							<td><?php echo $perihal; ?></td>
						</tr>
						<tr>
							<td class="tdInfo">Th. Anggaran</td>
							<td><?php echo $thn_anggaran; ?></td>
						</tr>
						<tr>
							<td class="tdInfo">Detail Proposal</td>
							<td><? $atts = array(
												'width'      => '800',
												'height'     => '600',
												'scrollbars' => 'yes',
												'status'     => 'yes',
												'resizable'  => 'no',
												'screenx'    => '300',
												'screeny'    => '300'
											);

									echo anchor_popup(base_url().'index.php/e-planning/manajemen/detail_pengajuan/'.$kdpengajuan.'/1/1', 'Klik Disini', $atts); 
							?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
    </div>
	<div class="clear"></div>
	<div class="garis"></div>
	<div class="feedback" id="repnow">
		<!-- input feedback -->
		<div class="inputFeedback">
			<?php echo form_open($post_action);?>		
			<div><h3>Input Feedback</h3></div>
			<div id="msg-reply" style="display: none"></div>
			<div id="tutupAll" style="display: none">[ Tutup Komentar ]</div>
			<input type="hidden" name="reply_from" value="0" id="reply_from">
			<input type="hidden" name="id_user" value="<?php echo $id_user;?>"/>
			<?php if(in_array($this->session->userdata("kd_role"), array(3,8,2,10,9))){ 
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
			<div class="listtembusan">
				<?php $css_tombol = "tombol20"; if($tembusan!=''):?>
				<span class="tembusan">Tembusan</span>
				<table style="width: 100%; margin: 0px;">                
					<tr>
						<?php $no = 1; foreach ($tembusan->result() as $row):?>
						<td width="50%" style="vertical-align: middle;">
							<input type="checkbox" name="tembusan[]" id="tembusan<?php echo $row->USER_ID;?>" value="<?php echo $row->USER_ID;?>"/>
							<label for="tembusan<?php echo $row->USER_ID;?>"><?php echo $row->USERNAME;?></label>
						</td>
						<?php if($no == 3){
							echo "</tr><tr>";
							$css_tombol = "tombol40";
						}
						$no++;
						?>
						<?php endforeach;?>
					</tr>
				</table>
				<?php endif;?>
			</div> 
			<div class="right <?php echo $css_tombol;?>"><input type="submit" value="Kirim" id="buttonClass" class="buttonClass" <?php echo $disable_button; ?>></div>
			<br><br><br><br>
			<div class="clear"></div>
			<?php echo form_close();?>
		</div>
		
		<!-- history feedback -->
		<div class="listFeedback">
			<?php if($history->num_rows() > 0):?>
			<div><h3>History </h3></div>
			<ul class="stream">
			<?php $id_feedback = 0; ?>
			<?php foreach ($history->result() as $row):?>
				<li>
					<a href="#"><img class="ava-stream" src="<?php echo base_url();?>images/icons/depkes.png" width="40" height="48" alt="<?php echo $row->USERNAME;?>" /></a>
					<div class="pesan-stream">
						<div class="nama-stream"><?php echo (strtolower($row->USERNAME));?></div>
						<div id="msg-stream-<?php echo $row->ID_FEEDBACK;?>"><?php echo $row->PESAN;?></div>
						<div class="date-stream">
							<?php if($row->STATUS == 0){ echo "komentar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; } else { ?>
							<a href="#repnow" onclick="javascript:replyFrom(<?php echo $row->ID_FEEDBACK;?>)" class="reply-stream" id="reply-stream-<?php echo $row->ID_FEEDBACK;?>">Beri komentar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php } 
							if(in_array($this->session->userdata('kd_role'), array(3,8,10,9))){ 
								if($row->STATUS == 0){ 
									echo "selesai &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
								}else{
									echo '<a href="'.base_url().'index.php/e-planning/feedback/resolv/'.$row->ID_FEEDBACK.'/'.$kdpengajuan.'" class="resolv-stream">selesai</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
								}
							}
							?>
							<a title="<?php echo date("d F Y   H:i ", strtotime($row->TANGGAL));?>WIB" class="time-reply">
							<?php echo $this->general->KonversiWaktu(strtotime($row->TANGGAL));?></a>
						</div>
					</div>
					<div class="clear"></div>
					<?php $id_feedback = $row->ID_FEEDBACK; ?>
				</li>
				<?php
					if($row->PARENT == 0){
						$parent = $this->fm->get_parent($kdpengajuan, $row->ID_FEEDBACK); 
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
				<!-- load more -->
				<a href="#" class="more" id="<?php echo $id_feedback; ?>">
					<div id="more<?php echo $id_feedback; ?>" class="morebox">selanjutnya</div>
				</a>
			<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
</div>

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
		width:"100%",
		readonly : 0
    });
</script>
