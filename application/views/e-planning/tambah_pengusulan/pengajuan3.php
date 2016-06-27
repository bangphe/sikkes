<div id="tengah">
<div id="judul" class="title">
	Kinerja dan Anggaran
	<!--
	<label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>

<script type="text/javascript">

function getSub(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getSub/'+v;
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
			var option;
			var nama;
			
			//$('#testing').html('');
			
			$('#subfungsi_').html('<option value="0">--- Pilih Sub Fungsi ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeSub'];
				nama = data[i]['NamaSub'];
				option += '<option value="'+id+'">'+nama+'</option>';
			}
  				$('#subfungsi_').append(option);
		}
	});	
}
function getOutcome(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getOutcome/'+v;
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
			var option='';
			var nama;
			
			//$('#testing').html('');
			
			$('#outcome').html('');
			
			for(var i=0; i< data.length;i++)
			{
				nama = data[i]['OutComeProgram'];
				option += nama+'</br>';
			}
  				$('#outcome').append(option);
		}
	});	
}

function getOutput(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getOutput/'+v;
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
			
			//$('#testing').html('');
			
			$('#output').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeOutput'];
				nama = data[i]['Output'];
				option += nama+'</br>';
			}
  				$('#output').html(option);
		}
	});	
}
function getIkk(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getIkk/'+v;
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
			var target;
			
			//$('#testing').html('');
			
			$('#ikk').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIkk'];
				nama = data[i]['Ikk'];
				target = data[i]['TargetNasional'];
				option +=  '<tr><td><input type="checkbox" name="ikk_[]" value="'+id+'"/></></td><td>'+nama+'</td><td width="17%"><iwidth="17%"><input readonly="true" type="text" name="nasional_ikk'+i+'" value="'+target+'" style="text-align:center"/></td><td width="17%"><input type="text" style="text-align:center" name="target_ikk'+id+'" /></td></tr>';
			}
  				$('#ikk').append(option);
		}
	});	
}
function getIku(v)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getIku/'+v;
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
			var target;
			
			//$('#testing').html('');
			
			$('#iku').html('');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeIku'];
				nama = data[i]['Iku'];
				target = data[i]['TargetNasional'];
				option += '<tr><td><input type="checkbox" name="iku_[]" value="'+id+'"/></></td><td>'+nama+'</td><td width="17%"><iwidth="17%"><input readonly="true" type="text" name="nasional_iku'+i+'" value="'+target+'" style="text-align:center"/></td><td width="17%"><input type="text" style="text-align:center" name="target_iku'+id+'" /></td></tr>';
			}
  				$('#iku').append(option);
		}
	});	
}

function getKeg(x,y,z)
{
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getKeg/'+x+'/'+y+'/'+z;
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
			var option;
			var nama;
			
			//$('#testing').html('');
			
			$('#kegiatan_').html('<option value="0">--- Pilih Kegiatan ---</option>');
			
			for(var i=0; i< data.length;i++)
			{
				id = data[i]['KodeKeg'];
				nama = data[i]['NamaKeg'];
				option += '<option value="'+id+'">'+nama+'</option>';
				
			}
  				$('#kegiatan_').append(option);
		}
	});	
}
function getAktivitas(x){
	//var kdProv = document.getElementById('provinsi').value;
	var url = '<?php echo  base_url()?>index.php/e-planning/pendaftaran/getAktivitas/'+x;
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
			var option;
			var no;
			var jenisusulan;
			var judulusulan;
			var perincian;
			var volume;
			var satuan;
			var hargasatuan;
			var jumlah;
			var jenispembiayaan;
			var fokusprioritas='';
			var reformasikesehatan='';
			
			//$('#testing').html('');
			
			$('#aktivitas_').html('');
			option += '<tr><td>No</td><td>Jenis Usulan</td><td>Judul Usulan</td><td>Perincian</td><td>Volume</td><td>Harga Satuan</td><td>Jumlah</td><td>Jenis Pembiayaan</td><td>Fokus Prioritas</td><td>Reformasi Kesehatan</td></tr>';
			for(var i=0; i< data.length;i++)
			{
				no = i+1;
				jenisusulan = data[i]['jenisusulan'];
				judulusulan = data[i]['judulusulan'];
				perincian = data[i]['perincian'];
				volume = data[i]['volume']+' ';
				satuan = data[i]['satuan'];
				hargasatuan = data[i]['hargasatuan'];
				jumlah = data[i]['jumlah'];
				jenispembiayaan = data[i]['jenispembiayaan'];
				for(var j=0; j=data[i]['fokusprioritas'].length; j++){
					fokusprioritas += data[i]['fokusprioritas'][j]+'</br>';
				}
				for(var j=0; j=data[i]['reformasikesehatan'].length; j++){
					reformasikesehatan += data[i]['reformasikesehatan'][j]+'</br>';
				}
				option += '<tr><td>'+no+'</td><td>'+jenisusulan+'</td><td>'+judulusulan+'</td><td>'+perincian+'</td><td>'+volume+satuan+'</td><td>'+hargasatuan+'</td><td>'+jumlah+'</td><td>'+jenispembiayaan+'</td><td>'+fokusprioritas+'</td><td>'+reformasikesehatan+'</td></tr>';
				
			}
  				$('#aktivitas_').append(option);
		}
	});	
}
function validateForm()
	{
	var a=document.forms["form_pengusulan"]["fungsi"].value;
	var b=document.forms["form_pengusulan"]["subfungsi_"].value;
	var c=document.forms["form_pengusulan"]["program"].value;
	var d=document.forms["form_pengusulan"]["kegiatan_"].value;
	if (a==0 || b==0 || c==0 || d==0 )
	  {
	  alert("Fungsi, subfungsi, program, dan kegiatan harus diisi.");
	  return false;
	  }
	
	<?php if(isset($fokus_prioritas)){
			if(isset($reformasi_kesehatan)){
			for($i=0; $i<count($fokus_prioritas);$i++){ 
				foreach($this->pm->get_where('fokus_prioritas',$fokus_prioritas[$i]['idFokusPrioritas'], 'idFokusPrioritas')->result() as $row) {?>
			var fp<?php echo  $i;?> = document.forms["form_pengusulan"]["biaya_fp_<?php echo  $row->idFokusPrioritas;?>"].value;
			<?php } ?>
			<?php  foreach($this->pm->get_where('reformasi_kesehatan',$reformasi_kesehatan[$i]['idReformasiKesehatan'], 'idReformasiKesehatan')->result() as $row) {?>
			var rk<?php echo  $i;?> = document.forms["form_pengusulan"]["biaya_fp_<?php echo  $row->idReformasiKesehatan;?>"].value;
			<?php } ?>
			if (fp<?php echo  $i;?> == "0" || fp<?php echo  $i;?> == 0 ||rk<?php echo  $i;?> == "0" ||rk<?php echo  $i;?> == 0){
				alert("Biaya fokus prioritas dan reformasi kesehatan harus diisi.");
				return false;
			}
			<?php } ?>
	if (document.form_pengusulan.total_rk.value != document.form_pengusulan.total_fp.value)
		{
		alert("Total biaya fokus prioritas dan reformasi kesehatan harus sama.");
		return false;
		}
	<?php }} ?>
	var iku, ikk;
	for (i=0; i<document.test.iku_.length; i++){
		iku[i] = document.forms["form_pengusulan"]["target_iku"+i].value;
		if (document.test.iku_[i].checked==true){
			if (iku[i] == "0" || iku[i] == 0){
				alert("Jumlah IKU yang terpilih harus diisi.")
				return false;
				}
		}
	}
	for (i=0; i<document.test.ikk_.length; i++){
		ikk[i] = document.forms["form_pengusulan"]["target_ikk"+i].value;
		if (document.test.ikk_[i].checked==true){
			if (ikk[i] == "0" || ikk[i] == 0){
				alert("Jumlah IKK yang terpilih harus diisi.")
				return false;
				}
		}
	}
	}
</script>
<div id="content_tengah">
	<form class="appnitro" name="form_pengusulan" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/pendaftaran/pengajuan'; ?>" onsubmit="return validateForm()" >
	<ul id="tt" class="easyui-tree"
			url="<?php echo  base_url(); ?>index.php/e-planning/pendaftaran/json"
			checkbox="true">
	</ul>
	<input type="hidden" name="kd_pengajuan" id="kd_pengajuan" value="<?php echo  $kd_pengajuan; ?>" /></td>
	
	<h3>Ringkasan Fungsi</h3>
	<table width="100%" height="3%">
      <div>
        <tr>
          <td width="15%" height="23" style="padding-left:10px;">Fungsi</td>
          <td width="85%"><select id="fungsi" name="fungsi" onchange="getKeg(this.value, subfungsi_.value, program.value); getSub(this.value);">
            				<option value="0">--- Pilih Fungsi ---</option>
                            <?php
							  foreach($fungsi->result() as $row)
							  {
								  echo '<option value="'.$row->KodeFungsi.'">'.$row->NamaFungsi.'</option>';
							  }
							  ?>
              </select>
			</td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
      
		<tr >
			<td width="15%"  style="padding-left:10px;">Sub Fungsi</td>
			<td width="85%"><select id="subfungsi_" name="subfungsi_"  onchange="getKeg(fungsi.value, this.value, program.value); ">
            <option value="0">--- Pilih Sub Fungsi ---</option></select></td>
		</tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
        <tr>
          <td width="15%" style="padding-left:10px;">Program</td>
          <td><label>
           <select id="program" name="program" onchange="getKeg(fungsi.value, subfungsi_.value, this.value); getOutcome(this.value); getIku(this.value);">
            				<option value="0">--- Pilih Program ---</option>
                            <?php
							  foreach($program->result() as $row)
							  {
								  echo '<option value="'.$row->KodeProgram.'">'.$row->NamaProgram.'</option>';
							  }
							  ?>
              </select>
          </label></td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
	  <div>
        <tr>
          <td width="15%" height="32" style="padding-left:10px;vertical-align:top;">Outcome</td>
          <td name="outcome" id="outcome" >
            --- Pilih Program Terlebih Dahulu ---
          </td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="23%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">IKU</td>
          <td style="padding-left:10px;">&nbsp;</td>
          <td width="17%"><div align="center">Nasional</div></td>
          <td width="17%"><div align="center">Jumlah</div></td>
        </tr>
        <tr>
          <td height="21" style="padding-left:10px;">&nbsp;</td>
          <td colspan="3" style="padding-left:10px;">
		  	<table>
				<tr id="iku" name="iku"><td>
					--- Pilih Program Terlebih Dahulu ---</td>
				</tr>
			</table>
		  	</td>
          </tr>
      </div>
	  </table>
        
	<p>&nbsp;</p>
	<table width="100%" height="8%">
	  <div>
       
		<tr>
          <td width="15%" height="21" style="padding-left:10px;">Kegiatan</td>
          <td><label>
            <select id="kegiatan_" name="kegiatan_" onchange="getOutput(this.value); getIkk(this.value)">
            <option selected="true" value="0">--- Pilih Kegiatan ---</option></select></select>
          </label></td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="4%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">Output</td>
          <td name="output" id="output" >
		  --- Pilih Kegiatan Terlebih Dahulu ---
		  </td>
        </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<table width="100%" height="23%">
	  <div>
        <tr>
          <td width="15%" height="21" style="padding-left:10px;vertical-align:top;">IKK</td>
          <td style="padding-left:10px;">&nbsp;</td>
          <td width="17%"><div align="center">Nasional</div></td>
          <td width="17%"><div align="center">Jumlah</div></td>
        </tr>
        <tr>
          <td height="21" style="padding-left:10px;">&nbsp;</td>
          <td colspan="3" style="padding-left:10px;">
		  	<table>
				<tr id="ikk" name="ikk"><td>
					--- Pilih Kegiatan Terlebih Dahulu ---</td>
				</tr>
			</table>
		  	</td>
          </tr>
      </div>
	  </table>
	<p>&nbsp;</p>
	<h3>Anggaran</h3>
	<p>
	  <input type="button" name="tambahaktivitas" id="tambahaktivitas" value="Tambah Aktivitas"  onclick="popAktivitas(<?php echo  $kd_pengajuan; ?>)"/>
	  
	  <!--<a href="<?php // echo base_url().'index.php/e-planning/aktivitas/tambah_aktivitas'; ?>">Tambah Aktivitas</a> -->
	</p>
	<table width="100%" height="3%">
	<tr id="aktivitas_" name="aktivitas_"><td>
	
	
	<fieldset>
		<legend><strong>Aktivitas</strong></legend>	
			<table id = "rounded-corner" border="1" bordercolor="#8C8D8E" width="50%">
			<thead>
			<tr>
			  <td width="10%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Judul Usulan</div></td>
			  <td width="8%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Jenis Usulan</div></td>
			  <td width="10%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Perincian</div></td>
			  <td width="8%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Volume</div></td>
			  <td width="10%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Satuan</div></td>
			  <td width="8%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Harga Satuan</div></td>
			  <td width="10%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Jumlah</div></td>
			  
			  <td width="10%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Ubah</div></td>
			  <td width="10%" bgcolor="#b9c9fe" class="rounded-company" scope="col"><div align="center">Hapus</div></td>
			</tr>
			<?php
				$kode_aktivitas='';
					foreach($this->pm->get_where_double_join('aktivitas_temp','ref_jenis_usulan','aktivitas.KodeJenisUsulan=ref_jenis_usulan.KodeJenisUsulan','ref_satuan','aktivitas.KodeSatuan=ref_satuan.KodeSatuan','KD_PENGAJUAN',$kd_pengajuan)->result() as $row){ 
					$kode_aktivitas = $row->KodeAktivitas; ?>
					<tr>
					<td><?php echo  $row->JudulUsulan; ?></td>
					<td><?php echo  $row->JenisUsulan; ?></td>
					<td><?php echo  $row->Perincian; ?></td>
					<td><?php echo  $row->Volume; ?></td>
					<td><?php echo  $row->Satuan; ?></td>
					<td><?php echo  $row->HargaSatuan; ?></td>
					<td><?php echo  $row->Jumlah; ?></td>
					<td><a href='edit_aktivitass<?php echo  '/'.$kode_aktivitas; ?>'>Ubah</a></td>  
					<td><a href='deleteAktivitas<?php echo  '/'.$kode_aktivitas; ?>'>Hapus</a></td>
					</tr>
				<?php } ?>
		  </thead>
		  </table>
		</fieldset>
	
	
	
	
	</td></tr>
	</table>
	<table width="100%" height="3%">
		<tr>
			<td width="14%" style="padding-left:10px;vertical-align:top;">Fokus Prioritas</td>
			<td colspan="2">
			<table width="100%">
			<?php if(isset($fokus_prioritas)){
				for($i=0; $i<count($fokus_prioritas);$i++){ 
				foreach($this->pm->get_where('fokus_prioritas',$fokus_prioritas[$i]['idFokusPrioritas'], 'idFokusPrioritas')->result() as $row) {?>
              <tr>
                <td width="83%"><?php echo  $row->FokusPrioritas; ?></td>
                <td width="17%"><input type="text" id="<?php echo  'biaya_fp_'.$row->idFokusPrioritas; ?>" name="<?php echo  'biaya_fp_'.$row->idFokusPrioritas; ?>" onchange="totalFp();"  onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';" style="text-align:right" value="0"/></td>
              </tr>
			  <?php } } } else echo '<tr><td>Tidak ada fokus prioritas yang dipilih</td></tr>'; ?>
            </table></td>
	    </tr>
		<tr>
		  <td style="padding-left:10px;">&nbsp;</td>
		  <td width="71%"><div align="right">Total biaya </div></td>
		  <td width="15%"><input type="text" id="total_fp" name="total_fp" readonly="true" value="0" style="text-align:right"/></td>
	    </tr>
	</table>
	<p>&nbsp;</p>
	<table width="100%" height="3%">
      <tr>
        <td width="14%" style="padding-left:10px;vertical-align:top;">Reformasi Kesehatan </td>
        <td colspan="2"><?php //echo $reformasi_kesehatan; ?>
		<table width="100%">
			<?php if(isset($reformasi_kesehatan)){
				for($i=0; $i<count($reformasi_kesehatan);$i++){ 
				foreach($this->pm->get_where('reformasi_kesehatan',$reformasi_kesehatan[$i]['idReformasiKesehatan'], 'idReformasiKesehatan')->result() as $row) {?>
              <tr>
                <td width="83%"><?php echo  $row->ReformasiKesehatan; ?></td>
                <td width="17%"><input type="text" id="<?php echo  'biaya_rk_'.$row->idReformasiKesehatan; ?>" name="<?php echo  'biaya_rk_'.$row->idReformasiKesehatan; ?>" onchange="totalRk();"   onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';" value="0"style="text-align:right" /></td>
              </tr>
			  <?php } } } else echo '<tr><td>Tidak ada reformasi kesehatan yang dipilih</td></tr>';  ?>
            </table>
			</td>
      </tr>
      <tr>
        <td style="padding-left:10px;">&nbsp;</td>
        <td width="71%"><div align="right">Total biaya </div></td>
        <td width="15%"><input type="text" name="total_rk" id="total_rk" value="0" style="text-align:right" readonly="true"/></td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<div class="buttons">
	<button type="button" class="negative" name="sebelumnya" onClick="history.go(-1);"> <img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/> Sebelumnya </button>
      <button type="submit" class="regular" name="save" id="save"> <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/> Simpan </button>
	  
	  </div>
	<p>&nbsp;</p>
	</form>
</div>
</div>
<!--<input id="submit-button" type="submit" name="lanjut" value="program" onclick="window.open('<?php echo  base_url(); ?>index.php/e-planning/Filtering/program',null,'height=500,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"/> -->

<script type="text/javascript">

function popAktivitas(x)
 {
window.open("<?php echo  base_url().'index.php/e-planning/pendaftaran/tambah_aktivitas/'; ?>"+x,'popAktivitas','toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=yes,copyhistory=no,scrollbars=yes,width=800,height=800');
 }
 
	<?php /* if(isset($reformasi_kesehatan)){foreach($reformasi_kesehatan as $row) { ?>
		$('<?php echo  "#biaya_rk_".$row->idReformasiKesehatan; ?>').hide();
	<?php }} ?>
	<?php if(isset($fokus_prioritas)){ foreach ($fokus_prioritas as $row) { ?>
		$('<?php echo  "#biaya_fp_".$row->idFokusPrioritas; ?>').hide();
	<?php }} */?>
	
	function get_data(kdsatker){
		document.form_pengusulan.kdsatker.value = '';
		document.form_pengusulan.provinsi.value = '';
		$.ajax({
			url: "<?php echo  base_url(); ?>index.php/e-planning/pendaftaran/get_alamatSatker",
			global: false,
			type: "POST",
			async: false,
			dataType: "html",
			data: "kdsatker="+ satker.value, //the name of the $_POST variable and its value
			success: function (response) {
				str = response.split(";");
				document.form_pengusulan.kdsatker.value = satker.value;
				document.form_pengusulan.provinsi.value = str[0];
			}          
		});
	  	return false;
	}
	
	
	function totalRk(){
		var biaya=0;
		<?php //if(isset($reformasi_kesehatan)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					for($i=0; $i<count($reformasi_kesehatan);$i++){ 
					if($i>0) echo "+";
					foreach($this->pm->get_where('reformasi_kesehatan',$reformasi_kesehatan[$i]['idReformasiKesehatan'], 'idReformasiKesehatan')->result() as $row) {
						echo "eval(document.form_pengusulan.biaya_rk_".$row->idReformasiKesehatan.".value)";
					}}
					echo ";";
				?>
		<?php //} ?>
		document.form_pengusulan.total_rk.value = biaya;
		if(document.form_pengusulan.total_rk.value != document.form_pengusulan.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Prioritas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	function totalFp(){
		var biaya=0;
		<?php //if(isset($fokus_prioritas)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					for($i=0; $i<count($fokus_prioritas);$i++){ 
					if($i>0) echo "+";
					foreach($this->pm->get_where('fokus_prioritas',$fokus_prioritas[$i]['idFokusPrioritas'], 'idFokusPrioritas')->result() as $row) {
						echo "eval(document.form_pengusulan.biaya_fp_".$row->idFokusPrioritas.".value)";
					}}
					echo ";";
				?>
		<?php //} ?>
		document.form_pengusulan.total_fp.value = biaya;
		if(document.form_pengusulan.total_rk.value != document.form_pengusulan.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Prioritas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	<?php /* if(isset($reformasi_kesehatan)){foreach($reformasi_kesehatan as $row) { ?>
		$('<?php echo  "#reformasi_kesehatan".$row->idReformasiKesehatan; ?>').click(function() {
		  if(this.checked){
			$('<?php echo  "#biaya_rk_".$row->idReformasiKesehatan; ?>').show();
		  }else{
			$('<?php echo  "#biaya_rk_".$row->idReformasiKesehatan; ?>').hide();
			<?php echo  "document.form_pengusulan.biaya_rk_".$row->idReformasiKesehatan.".value='0';"; ?>
			totalRk();
		  }
		});
	<?php }} ?>
	<?php if(isset($fokus_prioritas)){foreach($fokus_prioritas as $row) { ?>
		$('<?php echo  "#fokus_prioritas".$row->idFokusPrioritas; ?>').click(function() {
		  if(this.checked){
			$('<?php echo  "#biaya_fp_".$row->idFokusPrioritas; ?>').show();
		  }else{
			$('<?php echo  "#biaya_fp_".$row->idFokusPrioritas; ?>').hide();
			<?php echo  "document.form_pengusulan.biaya_fp_".$row->idFokusPrioritas.".value='0';"; ?>
			totalFp();
		  }
		});
	<?php }} */?>
	
</script>
