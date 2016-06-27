<!--
<div class="panel">
	<input name="masuk" id="masuk"/>
	<input name="klik" id="klik" type="button" value="click me" onclick="TES(5);"/>
	<input name="klik" id="klik" type="button" value="click me" onclick="TES(4);"/>
</div>
-->
<!-- paste this code into your webpage -->
<link href="<?php echo  base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo  base_url() ?>js/tablecloth.js"></script>
<script src="<?php echo base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- end -->
<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?php echo base_url()?>";
var d_skmpnen_id = <?php echo  $d_skmpnen_id;?>;
$(document).ready(function(){
    $("#content_tengah").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_masalah/<?php echo  $d_skmpnen_id;?>",'', 'profile_detail_loading', 'content_tengah');
  
});

function update(id, bulan, loading){
    if (loading)
        $("#content_tengah").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_input_masalah/"+id+"/"+bulan,'', 'profile_detail_loading', 'content_tengah');
}

function kembali(id2){
    $("#content_tengah").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
    get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_masalah/"+id2,'', 'profile_detail_loading', 'content_tengah');
}

</script>




<div id="tengah">
<div id="judul" class="title">
	Input Permasalahan
</div>
<div id="content_tengah"></div>
</div>
