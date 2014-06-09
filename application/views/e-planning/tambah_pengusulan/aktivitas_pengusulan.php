<div id="tengah">
	<div id="judul" class="title">Tambah RAB</div>
<div id="content_tengah">
	<form id="form_tambah_aktivitas" name="form_tambah_aktivitas" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/aktivitas/save_aktivitas/'.$idRencanaAnggaran.'/'.$KD_PENGAJUAN; ?>" onsubmit="return validate_form()">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		<div>
			<tr><td><label>Rincian Kegiatan*</label>
			</td>
			<td><input type="radio" name="rincian" id="rincian1" value="1" onchange="change(this)" checked/>
				<?php
						if(isset($rincian_kegiatan)) echo form_dropdown('rincian_kegiatan',$rincian_kegiatan, null,'id="rincian_kegiatan" class="chosen-select" '); 
						echo form_error('rincian_kegiatan');
					?>
			</td>
			</tr>
		</div>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;" ></td>
				<td><input type="radio" name="rincian" id="rincian2" value="2" onchange="change(this)" />Rincian lain:<p></p>
				<textarea name="judul_usulan" id="judul_usulan" rows="2" cols="72" disabled></textarea><?php echo form_error('judul_usulan'); ?>
				</td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td>Jenis Usulan*<?php echo form_error(); ?></td>
				<td>
					<?php $attr = 'id="jenis_usulan" onchange="get_rk(this.value);get_fp(this.value);" onfocusout="get_rk(this.value);get_fp(this.value);" readonly="true"';
						if(isset($jenis_usulan)) echo form_dropdown('jenis_usulan',$jenis_usulan, null,$attr); 
						echo form_error('jenis_usulan');
					?>
				</td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<tr>
				<td style="vertical-align:top;" >Perincian*</td>
				<td> <input name="rinci_1" size="3"  style="text-align:right" onChange="totalRincian();hitungJumlah()" onfocusout="totalRincian();hitungJumlah()" /> 
				<input name="rinci_2" size="5"/> 
				x <input name="rinci_3" size="3" style="text-align:right" onChange="totalRincian();hitungJumlah()" onfocusout="totalRincian();hitungJumlah()"  /> 
				<input name="rinci_4" size="5" /> 
				x <input name="rinci_5" size="3" style="text-align:right" onChange="totalRincian();hitungJumlah()" onfocusout="totalRincian();hitungJumlah()" /> 
				<input name="rinci_6" size="5" /> 
				x <input name="rinci_7" size="3" style="text-align:right" onChange="totalRincian();hitungJumlah()" onfocusout="totalRincian();hitungJumlah()" /> 
				<input name="rinci_8" size="5" />
				</td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;" >Volume*</td>
				<td><input type="text" name="volume"  id="volume"  style="text-align:right;vertical-align:top;"    onChange="hitungJumlah();" onfocusout="hitungJumlah();"  readonly="true" />
				<!--input name="satuan_rinci" size="5" />-->
				<?php echo form_dropdown('satuan',$satuan); ?><?php echo form_error('satuan'); ?></td>
			</tr>
		<?php /*<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;" >Satuan*</td>
				<td><?php echo form_dropdown('satuan',$satuan); ?><?php echo form_error('satuan'); ?></td>
			</tr> */ ?>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;" >Harga Satuan*</td>
				<td><input type="text" name="harga_satuan" id="harga_satuan"   style="text-align:right;vertical-align:top;" onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';"  value="0" onChange="hitungJumlah();" onfocusout="hitungJumlah();" /><?php echo form_error('harga_satuan'); ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;" >Jumlah*</br>(Volume * Harga Satuan)</td>
				<td><input type="text" name="jumlah" id="jumlah"  style="text-align:right;vertical-align:top;" value="0" readonly="true" /><?php echo form_error('jumlah'); ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
				<td style="vertical-align:top;" >Jenis Pembiayaan*</td>
				<td><?php if(isset($jenis_pembiayaan)) echo form_dropdown('jenis_pembiayaan',$jenis_pembiayaan); ?><?php echo form_error('jenis_pembiayaan'); ?></td>
			</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
			<td style="vertical-align:top;" >Fokus Prioritas*</td>
			<td id="fp" name="fp">
				---
			</td>
		</tr>
		<tr><td><p>&nbsp;</p></td><tr>
		<tr>
			<td style="vertical-align:top;" >Reformasi Kesehatan*</td>
			<td id="rk" name="rk">
				---
			</td>
		</tr>
		<tr><td><p>&nbsp;</p></td><tr>
			<tr>
			<td></td>
			<td>
				<div class="buttons">
					<input type="hidden" name="KodeFungsi" value="<?php echo $KodeFungsi; ?>" />
					<input type="hidden" name="KodeSubFungsi" value="<?php echo $KodeSubFungsi; ?>" />
					<input type="hidden" name="KodeProgram" value="<?php echo $KodeProgram; ?>" />
					<input type="hidden" name="KodeKegiatan" value="<?php echo $KodeKegiatan; ?>" />
					<button type="button" class="negative" onClick="history.go(-1);" name="batal">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Batal
					</button>
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Simpan
					</button>
				</div>
			</td>
		</tr>
		</table>
	</form>
</div>
</div>
		<!-- Script for searchable combobox -->
		<script type="text/javascript">
		$(".chosen-select").chosen({no_results_text: "Data yang dicari tidak ditemukan"});
		</script>
<script type="text/javascript">

$(document).ready(function(){
$("#rincian_kegiatan").change( function() {
	var v = document.getElementById('rincian_kegiatan').value;
	var url = '<?php echo base_url()?>index.php/e-planning/aktivitas/get_jns_usulan/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option='';
			var nama;
			var att;
  				
			
				id = data['KodeJenisUsulan'];
				nama = data['JenisUsulan'];
  				// document.form_tambah_aktivitas.jenis_usulan.value = id;
  				$('#jenis_usulan').val(id).attr("selected", "selected");
				
					var v2 = id;
					var url2 = '<?php echo base_url()?>index.php/e-planning/aktivitas/get_fp/<?php echo $KD_PENGAJUAN;?>/'+v2;
					//alert(v)
					
					$.ajax({
						//alert('test')
						url: url2,
						data: '',
						type: 'GET',
						dataType: 'json',
						beforeSend: function()
						{
						},
						success: function(data){
							var id;
							var option='';
							var nama;
							var att;
							
							$('#fp').html('');
							
							for(var i=0; i< data.length;i++){
								id = data[i]['idFokusPrioritas'];
								nama = data[i]['FokusPrioritas'];
								att = data[i]['Attributes'];
								if (i == 0) option += '<input '+att+' value="'+id+'" name="fokus_prioritas" checked/>'+nama+'</br>';
								else option += '<input '+att+' value="'+id+'" name="fokus_prioritas"/>'+nama+'</br>';
							}
							$('#fp').append(option);
						}
					});	
						$("#fp").trigger("liszt:updated");
						
						var url = '<?php echo base_url()?>index.php/e-planning/aktivitas/get_rk/<?php echo $KD_PENGAJUAN;?>/'+v2;
						//alert(v)
						
						$.ajax({
							//alert('test')
							url: url,
							data: '',
							type: 'GET',
							dataType: 'json',
							beforeSend: function()
							{
							},
							success: function(data)
							{
								var id;
								var option='';
								var nama;
								var att;
								
								//$('#testing').html('');
								
								$('#rk').html('');
								
								for(var i=0; i< data.length;i++)
								{
									id = data[i]['idReformasiKesehatan'];
									nama = data[i]['ReformasiKesehatan'];
									att = data[i]['Attributes'];
									if (i== 0) option += '<input '+att+' value="'+id+'" name="reformasi_kesehatan" checked/>'+nama+'</br>';
									else option += '<input '+att+' value="'+id+'" name="reformasi_kesehatan"/>'+nama+'</br>';
								}
									$('#rk').append(option);
							}
						});	
						$("#rk").trigger("liszt:updated");
		}
	});	
		$("#jenis_usulan").trigger("liszt:updated");
		return false;
});

});


function change(option) {
	if (option.value==1) {
		$('#rincian_kegiatan').prop('disabled', false).trigger("liszt:updated");
            document.form_tambah_aktivitas.judul_usulan.disabled = "disabled";
		// alert(option.value);
	}
	else if (option.value ==2 ){
		$('#rincian_kegiatan').prop('disabled', true).trigger("liszt:updated");
            document.form_tambah_aktivitas.judul_usulan.disabled = "";
	}
}
	function hitungJumlah(){
		biaya = eval(document.form_tambah_aktivitas.volume.value)*eval(document.form_tambah_aktivitas.harga_satuan.value);
		document.form_tambah_aktivitas.jumlah.value = biaya;
	}
	function totalRincian(){
		var a = eval(document.form_tambah_aktivitas.rinci_1.value);
		var b = eval(document.form_tambah_aktivitas.rinci_3.value);
		var c = eval(document.form_tambah_aktivitas.rinci_5.value);
		var d = eval(document.form_tambah_aktivitas.rinci_7.value);
		if (document.form_tambah_aktivitas.rinci_1.value == "" || document.form_tambah_aktivitas.rinci_1.value == null)
			a =1;
		if (document.form_tambah_aktivitas.rinci_3.value == "" || document.form_tambah_aktivitas.rinci_3.value == null)
			b =1;
		if (document.form_tambah_aktivitas.rinci_5.value == "" || document.form_tambah_aktivitas.rinci_5.value == null)
			c =1;
		if (document.form_tambah_aktivitas.rinci_7.value == "" || document.form_tambah_aktivitas.rinci_7.value == null)
			d =1;
		
		biaya = a*b*c*d;
		document.form_tambah_aktivitas.volume.value = biaya;
	}
function get_fp(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/aktivitas/get_fp/<?php echo $KD_PENGAJUAN;?>/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option='';
			var nama;
			var att;
			
			//$('#testing').html('');
			
			$('#fp').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['idFokusPrioritas'];
				nama = data[i]['FokusPrioritas'];
				att = data[i]['Attributes'];
				if (i == 0) option += '<input '+att+' value="'+id+'" name="fokus_prioritas" checked/>'+nama+'</br>';
				else option += '<input '+att+' value="'+id+'" name="fokus_prioritas"/>'+nama+'</br>';
			}
  				$('#fp').append(option);
		}
	});	
}
function get_rk(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo base_url()?>index.php/e-planning/aktivitas/get_rk/<?php echo $KD_PENGAJUAN;?>/'+v;
	//alert(v)
	
	$.ajax({
		//alert('test')
		url: url,
		data: '',
		type: 'GET',
		dataType: 'json',
		beforeSend: function()
		{
		},
		success: function(data)
		{
			var id;
			var option='';
			var nama;
			var att;
			
			//$('#testing').html('');
			
			$('#rk').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['idReformasiKesehatan'];
				nama = data[i]['ReformasiKesehatan'];
				att = data[i]['Attributes'];
				if (i== 0) option += '<input '+att+' value="'+id+'" name="reformasi_kesehatan" checked/>'+nama+'</br>';
				else option += '<input '+att+' value="'+id+'" name="reformasi_kesehatan"/>'+nama+'</br>';
			}
  				$('#rk').append(option);
		}
	});	
}
function validate_form()
	{
	if(document.forms["form_tambah_aktivitas"]["rincian1"].checked){
		var a=document.forms["form_tambah_aktivitas"]["rincian_kegiatan"].value;
	} else if(document.forms["form_tambah_aktivitas"]["rincian2"].checked){
		var a=document.forms["form_tambah_aktivitas"]["judul_usulan"].value;
	}
	var b=document.forms["form_tambah_aktivitas"]["volume"].value;
	var c=document.forms["form_tambah_aktivitas"]["harga_satuan"].value;
	var d=document.forms["form_tambah_aktivitas"]["jenis_pembiayaan"].value;
	var f=document.forms["form_tambah_aktivitas"]["jenis_usulan"].value;
	var e=document.forms["form_tambah_aktivitas"]["satuan"].value;
	if (a==null || a==""|| a=="0"|| a==0 || b==null || b=="" || c==null || c==""  || d==0  || f==0 || e==0)
	  {
	  alert("Harus memilih jenis usulan, satuan, dan jenis pembiayaan. Judul, rincian, dan harga satuan harus diisi.");
	  return false;
	  }
	 
}


</script>
