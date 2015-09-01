<link href="<?= base_url() ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
<script src="<?=base_url()?>js/functions.js" type="text/javascript" language="javascript"></script>

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

$(document).ready(function(){
  get_html_data(base_url+"index.php/e-monev/laporan_monitoring/data_tree/",'','profile_detail_loading', 'content_tengah');
});

function form_paket(){
	get_html_data(base_url+"index.php/e-monev/laporan_monitoring/data_tree/",'','profile_detail_loading', 'content_tengah');
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
						<li class="first"><a href="#" onclick="form_paket();" style="z-index:9;"><span></span>Output</a></li>
						<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_rencana/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:8;">Rencana Fisik</a></li>
						<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/input_progress/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>" style="z-index:7;">Progress Fisik</a></li>
						<li><a href="<?php echo base_url().'index.php/e-monev/laporan_monitoring/tree/';?>" style="z-index:6;">Tree</a></li>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<td>

			</td>
		</tr>
	</table>

	<div id="content">
		<table title="" class="easyui-treegrid" style="width:850px;"  
	            url="<?php echo base_url().'index.php/e-monev/laporan_monitoring/treeList/'.$thang.'/'.$kdjendok.'/'.$kdsatker.'/'.$kddept.'/'.$kdunit.'/'.$kdprogram.'/'.$kdgiat.'/'.$kdoutput.'/'.$kdlokasi.'/'.$kdkabkota.'/'.$kddekon.'/'.$kdsoutput;?>"
	            rownumbers="true" showFooter="true" 
	            idField="id" treeField="name" animate:"true">  
	        <thead frozen="true">  
	            <tr>
	                <th field="name" width="600">Nama</th>
	                <th field="alokasi" width="600">Alokasi</th>
	            </tr>
	        </thead>  
	    </table> 
	</div>


</div>