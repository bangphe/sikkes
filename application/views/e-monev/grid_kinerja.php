<div id="tengah">
<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content_tengah">
	<?php
		if(isset($added_php)) echo $added_php."</br></br></br>";
		echo $js_grid;
	?>
    
    <? echo form_open("e-monev/laporan_kinerja/pilih_data"); ?>
    <table>
        <tr>
            <td width="12%"><b>Tahun Anggaran </b></td>
            <td><?php echo $this->session->userdata('thn_anggaran');?></td>
        </tr>
        <tr>
            <td width="12%"><b>Jenis Prioritas </b></td>
            <td><?php echo form_dropdown('prioritas', $prioritas, array($pilihan_prioritas))?></td>
        </tr>
        <tr>
            <td width="12%"><b>Update per tanggal </b></td>
            <td><?php echo $curr_date;?></td>
        </tr>
    </table>        
        <input type="submit" name="" value="OK" />
    <? echo form_close(); ?>
	<table id="user" style="display:none"></table>
</div>
<div id="petunjuk">            
		<?=$this->config->item('petunjuk');?>
		<?=$notification; $this->session->unset_userdata('notification');?>
		<? if (isset($failed_form)) { echo $failed_form; $this->session->unset_userdata('failed_form'); }?>
		<? if(isset($no_asal)) echo $no_asal;?>
	</div>
</div>
<?php if (isset($div)){echo $div;}?>
<?php if (isset($div2)){echo $div2;}?>
<?php if (isset($div3)){echo $div3;}?>