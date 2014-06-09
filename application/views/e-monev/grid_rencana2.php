<script src="<?php echo base_url(); ?>js/accounting.js"></script> <!-- format nominal angka di text input -->
<?php echo $added_script;?>
<div class="buttons">
	<button type="submit" class="regular" name="grafik" onClick="grafik2(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/icon/grafik.png" alt=""/>
		Grafik
	</button>
	<button type="submit" class="regular" name="rencana_keuangan" onClick="rencana_keuangan(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/icon/money.png" alt=""/>
		Rencana Keuangan
	</button>
	<button type="submit" class="regular" name="rencana_fisik" onClick="rencana_fisik(<?php echo $d_skmpnen_id;?>);">
		<img src="<?php echo base_url(); ?>images/icon/two_storied_house.png" alt=""/>
		Rencana Fisik
	</button>
</div>
<div class="buttons">
<br />
<p><b>Tahun Anggaran : </b><?php echo $this->session->userdata('thn_anggaran');?></p>
<p><b>Nama Komponen/Sub Komponen : </b><?php echo $sub_komponen;?></p>
<br />
</div>
