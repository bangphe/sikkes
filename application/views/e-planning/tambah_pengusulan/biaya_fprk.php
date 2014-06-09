<div id="tengah">
<div id="judul" class="title">
	Detail Fokus Prioritas dan Reformasi Kesehatan
	<!--label class="edit"><a href="<?php //echo base_url(); ?>index.php/e-planning/manajemen/detail_pengajuan/<?php //echo $kd_pengajuan ?>/2"><img src="<?php //echo base_url(); ?>images/icons/Edit_icon.png" /></a></label-->
</div>
<div id="content_tengah">
<form id="detail_pengajuan" name="biaya_fprk" method="POST"  action="<?php echo base_url().'index.php/e-planning/manajemen/update_biaya_fprk/'.$kd_pengajuan; ?>">
	
	<table width="100%" height="auto">
		<tr>
			<td style="vertical-align:top;">Fokus Prioritas</td>
			<td><table border="0">
				<?php foreach ($fp_selected as $row) { ?>
				<tr>
				<td width="85%"><?php echo $this->mm->get_where('fokus_prioritas','idFokusPrioritas',$row->idFokusPrioritas)->row()->FokusPrioritas; ?> </td>
					<td align="right"><input style="text-align:right" type="text" name="<?php echo 'biaya_fp_'.$row->idFokusPrioritas;?>" onchange="totalFp()" onfocusout="totalFp()" <?php echo 'value="'.$row->Biaya.'"';?>  onfocusin="if(this.value=='0') this.value=''" onblur="if(this.value=='') this.value='0'"/> </td>
				</tr>
				<?php } ?>
				
				<tr><td align="center">Total Biaya</td>
				<td align="right"><input style="text-align:right" name="total_fp"  type="text" readonly="true" value="<?php echo $this->pm->sum('data_fokus_prioritas','Biaya','KD_PENGAJUAN',$kd_pengajuan); ?>"/></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="vertical-align:top;">Reformasi Kesehatan</td>
			<td>
				<table border="0">
				<?php foreach ($rk_selected as $row) { ?>
				<tr><td width="85%"><?php echo $this->mm->get_where('reformasi_kesehatan','idReformasiKesehatan',$row->idReformasiKesehatan)->row()->ReformasiKesehatan;?> </td>
				<td align="right"><input style="text-align:right" type="text" name="<?php echo 'biaya_rk_'.$row->idReformasiKesehatan;?>"  onchange="totalRk()" onfocusout="totalRk()" <?php echo 'value="'.$row->Biaya.'"';?> onfocusin="if(this.value=='0') this.value=''" onblur="if(this.value=='') this.value='0'"/> </td>
				</tr>
				<?php } ?>
				
				<tr><td align="center">Total Biaya</td>
				<td align="right"><input style="text-align:right" name="total_rk" type="text"  readonly="true"  value="<?php echo $this->pm->sum('data_reformasi_kesehatan','Biaya','KD_PENGAJUAN',$kd_pengajuan); ?>"/></td>
				</tr>
				</table>
				<div id="label" class="negative"></div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				
	<div class="buttons">
	  <a href="<?php echo site_url(); ?>/e-planning/manajemen/grid_pengajuan" class="negative">
						<img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
						Batal
					 </a>
      <button type="submit" class="regular" name="save" id="save"> <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/> Simpan </button>
	  </div>
			</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	
	function totalRk(){
		var biaya=0;
		<?php $reformasi_kesehatan = $this->mm->get_where('data_reformasi_kesehatan','KD_PENGAJUAN',$kd_pengajuan)->result();
		if(isset($reformasi_kesehatan)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					foreach($reformasi_kesehatan as $row) {
						if($no>0) echo "+";
						echo "eval(document.biaya_fprk.biaya_rk_".$row->idReformasiKesehatan.".value)";
						$no++;
					}
					echo ";";
				?>
		<?php } ?>
		document.biaya_fprk.total_rk.value = biaya;
		if(document.biaya_fprk.total_rk.value != document.biaya_fprk.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Prioritas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
	
	function totalFp(){
		var biaya=0;
		<?php $fokus_prioritas= $this->mm->get_where('data_fokus_prioritas','KD_PENGAJUAN',$kd_pengajuan)->result();
		if(isset($fokus_prioritas)){ ?>
				<?php
					$no=0;
					echo "biaya=";
					foreach($fokus_prioritas as $row) {
						if($no>0) echo "+";
						echo "eval(document.biaya_fprk.biaya_fp_".$row->idFokusPrioritas.".value)";
						$no++;
					}
					echo ";";
				?>
		<?php } ?>
		document.biaya_fprk.total_fp.value = biaya;
		if(document.biaya_fprk.total_rk.value != document.biaya_fprk.total_fp.value){
			document.getElementById("save").disabled = true;
			document.getElementById('label').innerHTML ="Total biaya Fokus Priortas dan Total biaya Reformasi Kesehatan harus sama";
		}else{
			document.getElementById("save").disabled = false;
			document.getElementById('label').innerHTML ="";
		}
	}
</script>
</div>
</div>
