<!-- paste this code into your webpage -->
<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo  base_url() ?>js/tablecloth.js"></script>
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?php echo base_url()?>";
$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_referensi/",'', 'profile_detail_loading', 'content_tengah');
  
});

function update(id){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_referensi/"+id,'', 'profile_detail_loading', 'content_tengah');
}

function daftar_referensi(){
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_referensi/",'', 'profile_detail_loading', 'content_tengah');
}

function reset()
{
	$('#permasalahan').val("");
	$('#upaya').val("");
}

function save_data(id3){
		var tanggal = $("#tanggal").val();
		$.ajax({
			url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/save_ref/'+id3,
			global: false,
			type: 'POST',
			async: false,
			dataType: 'html',
			data:{
				tanggal:tanggal
			},
			success: function (response) {
				daftar_referensi();
			}
		});
		return false;
}
</script>




<div id="tengah">
<div id="judul" class="title">
	Referensi
</div>
<div id="content_tengah">
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

