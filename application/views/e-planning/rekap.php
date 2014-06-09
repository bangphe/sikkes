<script type="text/javascript">
var fungsi ='rekap_fokus_prioritas';
$(document).ready(function(e){
	document.getElementById('form_rekap').action = fungsi;
});
function setFungsi(no)
{
	switch(no)
	{
		case '0':
			fungsi = 'rekap_fokus_prioritas';
			break;
		case '1':
			fungsi = 'rekap_reformasi_kesehatan';
			break;
		case '2':
			fungsi = 'rekap_jenis_pembiayaan';
			break;
		case '3':
			fungsi = 'rekap_sumber_dana';
			break;
		case '4':
			fungsi = 'rekap_apbn';
			break;
		case '5':
			fungsi = 'rekap_dak';
			break;
		case '6':
			fungsi = 'rekap_lengkap';
			break;
		case '7':
			fungsi = 'rekap_daerah';
			break;
	}
	document.getElementById('form_rekap').action = fungsi;
}
</script>
<div id="judul" class="title">
	Rekap
</div>
<div id="content">
	<form name="form_rekap" id="form_rekap" method="POST" action="">
		<table width="80%" height="25%">
			<tr>
				<td width="10%">Tahun Anggaran</td>
				<td width="70%"><?php $js = 'id="thn_anggaran" style="width:7%; padding:3px;"'; echo form_dropdown('thn_anggaran',$thn_anggaran,$this->session->userdata('thn_anggaran'), $js); ?></td>
			</tr>
            <tr>
				<td width="10%">Pilihan Rekap</td>
				<td width="70%"><select name="rekap" id="rekap" style="padding:3px" onchange="setFungsi(this.value)">
				  <option value="0">Fokus Prioritas</option>
				  <option value="1">Reformasi Kesehatan</option>
				  <option value="2">Jenis Pembiayaan</option>
				  <option value="3">Sumber Dana</option>
				  <option value="4">APBN</option>
				  <option value="5">DAK</option>
				  <option value="6">Lengkap</option>
				  <option value="7">Proposal Daerah</option>
				</select></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="positive" name="cetak">
							<img src="<?php echo base_url(); ?>images/main/excel.png" alt=""/>
							Cetak
						</button>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>