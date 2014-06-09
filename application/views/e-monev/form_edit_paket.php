<script type="text/javascript">
$(document).ready(function(){
  get_data1();
  get_kabupaten1();
  get_posisi_kontrak1();
});

function get_data1(){
		var prp = "<?php echo $paket_pengerjaan_dipilih;?>";
			$.ajax({
				url: "<?=base_url();?>index.php/e-monev/laporan_monitoring/get_jenis_paket/",
				global: false,
				type: "POST",
				async: false,
				dataType: "html",
				data: "data_post="+ prp, //the name of the $_POST variable and its value
				success: function (response) {
					var dynamic_options = $("*").index( $('.dynamic_data_jenis_paket')[<?php echo $jenis_paket_dipilih;?>] );
					if ( dynamic_options != (-1)) 
						$(".dynamic_data_jenis_paket").remove();
						$("#jenis_paket").append(response);
						$(".dynamic_data_jenis_paket").eq("<?php echo $jenis_paket_dipilih;?>").attr({selected: ' selected'});
				}          
			});
		  return false;
	}
	
function get_data(data1){
		var prp = data1.value;
			$.ajax({
				url: "<?=base_url();?>index.php/e-monev/laporan_monitoring/get_jenis_paket/",
				global: false,
				type: "POST",
				async: false,
				dataType: "html",
				data: "data_post="+ prp, //the name of the $_POST variable and its value
				success: function (response) {
					var dynamic_options = $("*").index( $('.dynamic_data_jenis_paket')[0] );
					if ( dynamic_options != (-1)) 
						$(".dynamic_data_jenis_paket").remove();
						$("#jenis_paket").append(response);
						$(".third").attr({selected: ' selected'});
				}          
			});
		  return false;
	}
	
function get_posisi_kontrak1(){
		var prp = "<?php echo $paket_pengerjaan_dipilih;?>";
			$.ajax({
				url: "<?=base_url();?>index.php/e-monev/laporan_monitoring/get_posisi_kontrak/",
				global: false,
				type: "POST",
				async: false,
				dataType: "html",
				data: "data_post="+ prp, //the name of the $_POST variable and its value
				success: function (response) {
					var dynamic_options = $("*").index( $('.dynamic_data_posisi_kontrak')[<?php echo $posisi_kontrak_dipilih;?>] );
					if ( dynamic_options != (-1)) 
						$(".dynamic_data_posisi_kontrak").remove();
						$("#posisi_kontrak").append(response);
						$(".dynamic_data_posisi_kontrak").eq("<?php echo $posisi_kontrak_dipilih;?>").attr({selected: ' selected'});
				}          
			});
		  return false;
	}

function get_posisi_kontrak(data){
		var prp = data.value;
			$.ajax({
				url: "<?=base_url();?>index.php/e-monev/laporan_monitoring/get_posisi_kontrak/",
				global: false,
				type: "POST",
				async: false,
				dataType: "html",
				data: "data_post="+ prp, //the name of the $_POST variable and its value
				success: function (response) {
					var dynamic_options = $("*").index( $('.dynamic_data_posisi_kontrak')[0] );
					if ( dynamic_options != (-1)) 
						$(".dynamic_data_posisi_kontrak").remove();
						$("#posisi_kontrak").append(response);
						$(".third").attr({selected: ' selected'});
				}          
			});
		  return false;
	}

function get_kabupaten1(){
		var prp = "<?php echo $provinsi_dipilih;?>";
			$.ajax({
				url: "<?=base_url();?>index.php/e-monev/laporan_monitoring/get_kabupaten/",
				global: false,
				type: "POST",
				async: false,
				dataType: "html",
				data: "data_post="+ prp, //the name of the $_POST variable and its value
				success: function (response) {
					var dynamic_options = $("*").index( $('.dynamic_data_kabupaten')["<?php echo $provinsi_dipilih;?>"] );
					if ( dynamic_options != (-1)) 
						$(".dynamic_data_kabupaten").remove();
						$("#kabupaten").append(response);
						$(".dynamic_data_kabupaten").eq("<?php echo $provinsi_dipilih;?>").attr({selected: ' selected'});
				}          
			});
		  return false;
	}
	
function get_kabupaten(data2){
		var prp = data2.value;
			$.ajax({
				url: "<?=base_url();?>index.php/e-monev/laporan_monitoring/get_kabupaten/",
				global: false,
				type: "POST",
				async: false,
				dataType: "html",
				data: "data_post="+ prp, //the name of the $_POST variable and its value
				success: function (response) {
					var dynamic_options = $("*").index( $('.dynamic_data_kabupaten')[0] );
					if ( dynamic_options != (-1)) 
						$(".dynamic_data_kabupaten").remove();
						$("#kabupaten").append(response);
						$(".third").attr({selected: ' selected'});
				}          
			});
		  return false;
	}
</script>

<center><h1>Form Paket</h1></center>
<br />
	<table width=auto>
		<tr>
			<td width="60%">Nama Satker :</td>
			<td width="40%">
				<?php echo $nmsatker;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Program :</td>
			<td width="40%">
				<?php echo $nmprogram;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Kegiatan :</td>
			<td width="40%">
				<?php echo $nmgiat;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Output :</td>
			<td width="40%">
				<?php echo $nmoutput;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Suboutput :</td>
			<td width="40%">
				<?php echo $ursoutput;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Nama Komponen :</td>
			<td width="40%">
				<?php echo $urkmpnen;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Nama Sub Komponen :</td>
			<td width="40%">
				<?php echo $sub_komponen;?>
			</td>
		</tr>
		<tr>
			<td width="60%">Paket Pengerjaan :</td>
			<td width="40%">
				<?php
					$paket_pengerjaan = array('Kontraktual','Swakelola');
					echo form_dropdown('paket_pengerjaan',$paket_pengerjaan, $paket_pengerjaan_dipilih,'id="paket_pengerjaan" onChange="get_data(this); get_posisi_kontrak(this);"');
				?>
			</td>
		</tr>
		<tr>
			<td width="60%">Jenis Paket :</td>
			<td width="40%">
				<select name="jenis_paket" id="jenis_paket">
				<?php 
				if (isset($data)){													
					foreach ($data as $key=>$value){ ?>
						<option class="dynamic_data_jenis_paket" value="<?php echo $key; ?>"
						<?php if( set_value('jenis_paket') == $key){ echo "selected=''";}?>><?=$value?></option>';
					<?php }}
				?>									
			</select>
			</td>
		</tr>
		<tr>
			<td width="60%">Kelompok Pengerjaan :</td>
			<td width="40%">
				<?php
					echo form_dropdown('kelompok_pengerjaan',$data_kelompok_pengerjaan, $kelompok_pengerjaan_dipilih,'id="kelompok_pengerjaan"');
				?>
			</td>
		</tr>
		<tr>
			<td width="60%">Posisi Kontrak :</td>
			<td width="40%">
			<select name="posisi_kontrak" id="posisi_kontrak">
				<?php 
				if (isset($data)){													
					foreach ($data as $key=>$value){ ?>
						<option class="dynamic_data_posisi_kontrak" value="<?php echo $key; ?>"
						<?php if( set_value('posisi_kontrak') == $key){ echo "selected=''";}?>><?=$value?></option>';
					<?php }}
				
				?>
            </select>
			</td>
		</tr>
		<tr>
			<td width="60%">Provinsi :</td>
			<td width="40%">
				<?php
					echo form_dropdown('provinsi',$data_provinsi, $provinsi_dipilih,'id="provinsi" onChange="get_kabupaten(this);"');
				?>
			</td>
		</tr>
		<tr>
			<td width="60%">Kabupaten / Kota :</td>
			<td width="40%">
				<select name="kabupaten" id="kabupaten">
				<?php 
				if (isset($data)){													
					foreach ($data as $key=>$value){ ?>
						<option class="dynamic_data_kabupaten" value="<?php echo $key; ?>"
						<?php if( set_value('kabupaten') == $key){ echo "selected=''";}?>><?=$value?></option>';
					<?php }}
				
				?>												
			</select>
			</td>
		</tr>
		<tr>
			<td width="60%">KPPN :</td>
			<td width="40%">
				<?php
					echo form_dropdown('kppn',$kppn, $kppn_detail_dipilih,'id="kppn"');
				?>
			</td>
		</tr>
		<tr>
			<td width="60%">Paket Lanjutan Tahun Sebelumnya :</td>
			<td width="40%">
				<?php
					$paket_lanjutan = array('Ya','Tidak');
					echo form_dropdown('paket_lanjutan',$paket_lanjutan, $paket_lanjutan_dipilih,'id="paket_lanjutan"');
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit" onClick="cek_jenis_paket();">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="form_paket();">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>
