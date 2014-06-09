<?php /*?><div id="tengah">
<div id="judul" class="title">
	Hasil Filtering
    <table width="200" border="1">
  <tr>
    <td>Provinsi</td>
    <?php if(isset($hasil)) {
			if($hasil->num_rows() > 0) {
				foreach($hasil->result() as $row) {?>
    <td><?php echo $row->KodeProvinsi.'-'.$row->NamaProvinsi?></td>
    <?php } } }?>
  </tr>
</table>

</div>
<div id="content_tengah">
	<h1>Rincian Pengusul</h1>
	
</div>
</div>
<?php */?>

<div id="master">
<div id="judul" class="title">Hasil Filtering</div>
<div id="content_master">
	<form name="form_kabupaten" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/filtering/detail_dept/'; ?>">


	<table width="83%" height="25%">
			<tr>
				<th width="16%">Provinsi</th>
                <th width="2%">:</th>
				<th width="82%">
                <?php for($i=0;$i<count($propinsi);$i++){?>
				<?php echo $propinsi[$i]['namaprop'];?></br>
				<?php } ?>
                <?php /*?><!--<?php foreach ($propinsi->result() as $row) { ?>
				<?php if($this->pm->cekProp($row->KodeProvinsi)) echo $row->NamaProvinsi; else echo '-';?></br>
				<?php } ?>--><?php */?>
                </th>
			</tr>
            <tr>
				<th width="16%">Program</th>
                <th width="2%">:</th>
				<th width="82%">
				<?php for($i=0;$i<count($program);$i++){?>
				<?php echo $program[$i]['namaprog'];?></br>
				<?php } ?>
                </th>
			</tr>
            <tr>
				<th width="16%">IKU</th>
                <th width="2%">:</th>
				<th width="82%">
				<?php for($i=0;$i<count($iku);$i++){?>
				<?php echo $iku[$i]['namaiku'];?></br>
				<?php } ?>
                </th>
			</tr>
            <tr>
				<th width="16%">Kegiatan</th>
                <th width="2%">:</th>
				<th width="82%">
				<?php for($i=0;$i<count($kegiatan);$i++){?>
				<?php echo $kegiatan[$i]['namakeg'];?></br>
				<?php } ?>
                </th>
			</tr>
            <tr>
				<th width="16%">IKK</th>
                <th width="2%">:</th>
				<th width="82%">
				<?php for($i=0;$i<count($ikk);$i++){?>
				<?php echo $ikk[$i]['namaikk'];?></br>
				<?php } ?>
                </th>
			</tr>
            <?php /*?><tr>
				<th width="16%">Prioritas</th>
                <th width="2%">:</th>
				<th width="82%">
				<?php for($i=0;$i<count($jenis_prioritas);$i++){?>
				<?php echo $jenis_prioritas[$i]['namajenis'];?></br>
				<?php } ?>
                </th>
			</tr><?php */?>
            <tr>
				<th width="16%">Fokus Prioritas</th>
                <th width="2%">:</th>
				<th width="82%">
                <?php for($i=0;$i<count($fokus_prioritas);$i++){?>
				<?php echo $fokus_prioritas[$i]['namafok'];?></br>
				<?php } ?>
				<?php /*?><?php foreach($fokus_prioritas->result() as $row2) { ?>
				<?php if($this->pm->cekFokus($row2->idFokusPrioritas)) echo $row2->FokusPrioritas; else echo '-';?></br>
				<?php }?><?php */?>
                </th>
			</tr>
            <tr>
				<th width="16%">Reformasi Kesehatan</th>
                <th width="2%">:</th>
				<th width="82%">
                <?php for($i=0;$i<count($reformasi_kesehatan);$i++){?>
				<?php echo $reformasi_kesehatan[$i]['namarefkes'];?></br>
				<?php } ?>
                <?php /*?><?php foreach($reformasi_kesehatan->result() as $row3) { ?>
				<?php if($this->pm->cekReform($row3->idReformasiKesehatan)) echo $row3->ReformasiKesehatan; else echo '-';?></br>
				<?php }?><?php */?>
                </th>
			</tr>
	</table>
	</form>
</div>
</div>

<?php if(isset($panel)) echo $panel; ?>
<?php if (isset($div)){echo $div;}?>
<?php if (isset($div2)){echo $div2;}?>
<?php if (isset($div3)){echo $div3;}?>
<div id="kiri">
<div id="judul" class="title">
	Rincian
	<!--
	<label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
	<label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
	-->
</div>
<div id="content">
	<?php
		echo $js_grid;
	?>
	<table id="user" style="display:none"></table>
</div>
</div>
<table>
<tr>
  <td>
      <div class="buttons">
          <a href="<?php echo base_url();?>index.php/e-planning/filtering"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
      </div>
  </td>
</tr>
</table>