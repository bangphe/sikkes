<link href="<?= base_url() ?>css/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>
<!-- JGROWL NOTIFICATION -->
<script type="text/javascript" src="<?= base_url() ?>js/jgrowl/jquery.jgrowl.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/jgrowl/jquery.jgrowl.css"/>
<!-- format nominal angka di text input -->
<script src="<?php echo base_url(); ?>js/accounting.js" type="text/javascript" language="javascript"></script> 

<!--script BEGIN-->
<script type="text/javascript">
var base_url = "<?=base_url()?>";
var thang = "<?php echo $thang;?>";
var kdjendok = "<?php echo $kdjendok;?>";
var kdsatker = "<?php echo $kdsatker;?>";
var kddept = "<?php echo $kddept;?>";
var kdunit = "<?php echo $kdunit;?>";
var kdprogram = "<?php echo $kdprogram;?>";
var kdgiat = "<?php echo $kdgiat;?>";
var kdoutput = "<?php echo $kdoutput;?>";
var kdlokasi = "<?php echo $kdlokasi;?>";
var kdkabkota = "<?php echo $kdkabkota;?>";
var kddekon = "<?php echo $kddekon;?>";
var kdsoutput = "<?php echo $kdsoutput;?>";
var kdkmpnen = "<?php echo $kdkmpnen;?>";
var kdskmpnen = "<?php echo $kdskmpnen;?>";

$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_paket/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen,'','profile_detail_loading', 'content_tengah');
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/daftar_alokasi/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen,'','profile_detail_loading', 'daftar_alokasi');
});

function form_paket(){
	get_html_data(base_url+"index.php/e-monev/laporan_monitoring/form_paket/"+thang+"/"+kdjendok+"/"+kdsatker+"/"+kddept+"/"+kdunit+"/"+kdprogram+"/"+kdgiat+"/"+kdoutput+"/"+kdlokasi+"/"+kdkabkota+"/"+kddekon+"/"+kdsoutput+"/"+kdkmpnen+"/"+kdskmpnen,'','profile_detail_loading', 'content_tengah');
}

function simpanJenisItem(noitem)
{
	var kdjnsitem = $('#idjnsitem_'+noitem).val();
	var nilaikontrak = $('#nilai_kontrak_'+noitem).val();
	var alokasi = $('#alokasi_'+noitem).val();
	var no_item = $('#noitem_'+noitem).val();
	var kdakun = $('#kdakun_'+noitem).val();

	if(kdjnsitem == '' || nilaikontrak == '') {
		alert('Semua field harus diisi');
	}
	else {
		$.ajax({
	        url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/simpanitem/'+thang+'/'+kdjendok+'/'+kdsatker+'/'+kddept+'/'+kdunit+'/'+kdprogram+'/'+kdgiat+'/'+kdoutput+'/'+kdlokasi+'/'+kdkabkota+'/'+kddekon+'/'+kdsoutput+'/'+kdkmpnen+'/'+kdskmpnen+'/'+noitem+'/'+kdjnsitem+'/'+nilaikontrak+'/'+alokasi+'/'+no_item+'/'+kdakun,
	        data:'',
	        type: 'post',
	        beforeSend: function(){
	            $("#idjnsitem_"+noitem).attr('disabled',false);
	        },
	        success:function(data)
	        {
	        	var response = $.parseJSON(data);
	        	if (response.result == 'true') {
	        		$("#idjnsitem_"+noitem).removeAttr('disabled');
	        		//$("#nilaikontrak").val(data);

	        		//apabila paketnya swakelola, nilai kontrak = alokasi
	        		// if (kdjnsitem == 1) {
	        		// 	//$('#nilai_kontrak_'+noitem).val('0');
	        		// 	$('#nilai_kontrak_'+noitem).val(alokasi);
	        		// }
	        		// //apabila paketnya kontrak, nginputin sendiri nilainya
	        		// else {
	        		// 	$('#nilai_kontrak_'+noitem).val(nilaikontrak);
	        		// }
	        		$('#nilai_kontrak_'+noitem).val(nilaikontrak);
	            	$.jGrowl("Data berhasil disimpan!");
	        	}
	        	else if(response.result == 'false')
				{
					$('#nilai_kontrak_'+noitem).val(nilaikontrak);
					alert("Isian nilai kontrak tidak boleh melebihi alokasi akun.");
				}
	        }
	    });
	    return false;
	}
}

function get_alokasi_akun(noitem){
	$.ajax({
		url: '<?php echo base_url()?>index.php/e-monev/laporan_monitoring/alokasi/'+thang+'/'+kdjendok+'/'+kdsatker+'/'+kddept+'/'+kdunit+'/'+kdprogram+'/'+kdgiat+'/'+kdoutput+'/'+kdlokasi+'/'+kdkabkota+'/'+kddekon+'/'+kdsoutput+'/'+kdkmpnen+'/'+kdskmpnen+'/'+noitem,
		global: false,
		type: 'POST',
		async: false,
		dataType: 'html',
		data:{
		},
		success: function (response) {
			$("#nilaikontrak").val(response);
		}
	});
}
</script>

<div id="tengah">
<div id="judul" class="title">
	Input Laporan
</div>
<br />
<div>
	<?= anchor(site_url('e-monev/laporan_monitoring/'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Laporan Monitoring'); ?>
</div>
<br />
<table>
<tr>
	<td>
		<div id="breadcrumb">
			<ul class="crumbs">
				<li class="first"><a href="#" onclick="form_paket();" style="z-index:9;"><span></span>Paket</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput.'/'.$kdkmpnen.'/'.$kdskmpnen;?>" style="z-index:8;">Rencana Fisik</a></li>
				<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_progress/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput.'/'.$kdkmpnen.'/'.$kdskmpnen;;?>" style="z-index:7;">Progress Fisik</a></li>
			</ul>
		</div>
	</td>
</tr>
<tr>
	<td>
		<div id="content_tengah">	
		</div>
		<div id="daftar_alokasi">	
		</div>
	</td>
</tr>
</table>

</div>
