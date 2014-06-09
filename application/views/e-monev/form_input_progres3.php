<table width=auto>
		<div>
		<?= anchor(site_url('e-monev/laporan_monitoring/input_progres_keuangan/'.$d_skmpnen_id.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Progres Keuangan',array('onclick' => 'daftar_progres_keuangan('.$d_skmpnen_id.');;return false;')); ?>
		</div>
		<br />
		<tr>
			<td><b>Bulan</b></td>
			<td>
				<?php echo $bulan;?>
			</td>
		</tr>
		<tr>
			<td><b>Nomor SPM</b></td>
			<td>
				<div>
					<?php 
							$data1 = array(
										'name'        => 'nomor_spm',
										'id'          => 'nomor_spm',
										'value'       => $nomor_spm
									);
							echo form_input($data1);
						?>		
				</div>				
			</td>
		</tr>
		<tr>
			<td><b>Nominal</b></td>
			<td>
				<div>
					<?php 
							$data2 = array(
										'name'        => 'nominal',
										'id'          => 'nominal',
										'value'       => $nominal
									);
							echo form_input($data2);
						?>		
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" onClick="save_data(<?php echo $spm_id.','.$d_skmpnen_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="daftar_progres_keuangan(<?php echo $d_skmpnen_id;?>);">
						<img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>
