<!--
<div class="panel">
	<input name="masuk" id="masuk"/>
	<input name="klik" id="klik" type="button" value="click me" onclick="TES(5);"/>
	<input name="klik" id="klik" type="button" value="click me" onclick="TES(4);"/>
</div>
-->
<script type="text/javascript">
$(document).ready(function(){
    $("#dialog").dialog({
		autoOpen: false,
		resizable: false,
		draggable: false,
		height:350,
		maxHeight:600,
		width:700,
		show: { effect: "fade", duration: 350 },
		modal: true,
	});
	$("#konfirmasi").dialog({
		autoOpen: false,
		resizable: false,
		draggable: false,
		height:200,
		width:350,
		show: { effect: "fade", duration: 350 },
		modal: true,
	});
});
function ikk(kdpengajuan){
	var path = '<?php echo base_url();?>index.php/e-planning/manajemen/tampil_ikk/'+kdpengajuan;
	$.ajax({
		url:path,
		type:'get',
		data:'',
		beforeSend:function(){
			$("#dialog").dialog("open");
			$("#dialog-body").html('Sedang memuat...');
		},
		success: function(data){
			$("#dialog-body").html(data);
		}
	});
	//$("#dialog").dialog("open");
}
function iku(kdpengajuan){
	var path = '<?php echo base_url();?>index.php/e-planning/manajemen/tampil_iku/'+kdpengajuan;
	$.ajax({
		url:path,
		type:'get',
		data:'',
		beforeSend:function(){
			$("#dialog").dialog("open");
			$("#dialog-body").html('Sedang memuat...');
		},
		success: function(data){
			$("#dialog-body").html(data);
		}
	});
}
function setStatus(val,kdpengajuan){
	//alert(val);
	var path = '<?php echo base_url();?>index.php/e-planning/manajemen/check_status/'+val+'/'+kdpengajuan;
	$.ajax({
		url:path,
        type:'get',
        data:'',
        beforeSend: function(){
        },
        success: function(data){
        	$("#konfirmasi").dialog("open");
        }
	});
}
</script>

<!-- TARGET NASIONAL - RENJA K/L -->
<div id="dialog" title="Target Nasional - Renja KL">
  <p id="dialog-body"></p>
</div>

<div id="tengah">
<div id="judul" class="title">
	<?php echo $judul; ?>
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content_tengah">
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
<?php if (isset($div2)){echo $div2;}?>
<?php if (isset($div3)){echo $div3;}?>