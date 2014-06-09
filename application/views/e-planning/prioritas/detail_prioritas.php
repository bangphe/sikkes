<style type="text/css">
table.myTable { width:100%; border-collapse:collapse;  }
table.myTable .tes { 
	background-color: #dfe4ea; color:#000; text-align:center;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 12px; font-weight:bold;}
table.myTable td { padding:8px; border:#999 1px solid; }

table.myTable tr:nth-child(even) { /*(even) or (2n+0)*/
	background: #fff;
}
table.myTable tr:nth-child(odd) { /*(odd) or (2n+1)*/
	background-color: #f2f5f9;
}
</style>

<div id="judul" class="title">
	<?php echo $judul; ?>
</div>
<div id="content_master">
<table width="80%" height="25%" style="padding:10px">
    <form name="tambah_prioritas" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-planning/prioritas/detail/'.$th ?>">
    		<tr>
				<td width="10%" style="padding:10px">Periode</td>
				<td width="70%">
                <?php $js = 'id="prioritas" style="width:15%; padding:4px;" disabled="disabled"'; echo form_dropdown('prioritas', $opt_periode, $periode, $js); ?>
                </td>
			</tr>
            <tr>
				<td width="10%" style="padding:10px">Tahun</td>
				<td width="70%">
                <?php $js = 'id="tahun" style="width:15%; padding:4px;" disabled="disabled"'; echo form_dropdown('tahun', $opt_tahun, $tahun, $js); ?>
                </td>
			</tr>
            
            <table width="200" class="myTable">
              <tr class="tes">
                <td class="tes" width="2%">Kode</td>
                <td class="tes" width="10%">Program/Kegiatan</td>
                <td class="tes" width="15%">Indikator Kinerja</td>
                <td class="tes" width="8%">Prioritas</td>
              </tr>
              
              <?php $i=1; $k=1;foreach($ref_prog->result() as $row) {?>
			  <tr>
                <td><input type="hidden" id="kdprog<?php echo $k?>" name="kdprog[]" value="<?php echo $row->KodeProgram;?>" /><?php echo $row->KodeProgram; ?></td>
                <td><?php echo $row->NamaProgram; ?></td>
                <td></td>
                <td>
                <select id="jenis_prioritas<?php echo $k?>" name="jenis_prioritas_program[]" disabled="disabled" style="padding:3px; width:80%; margin:0 20px 0 20px">
                 <?php
				  	foreach($prioritas->result() as $row3)
                    {
						$progr = $this->masmo->get_where2('prioritas_program','KodeProgram',$row->KodeProgram,'idThnAnggaran',$th);
						if($progr->num_rows())
						{
							foreach($progr->result() as $pr)
							{
								 if($pr->KodeJenisPrioritas == $row3->KodeJenisPrioritas)
								 {
									echo '<option value="'.$row3->KodeJenisPrioritas.'" selected="selected">'.$row3->JenisPrioritas.'</option>';
								 }
							}
						}
					}
                 ?>
                </select>
                </td>
              </tr>
              <?php foreach($this->masmo->get_where('ref_iku','KodeProgram',$row->KodeProgram)->result() as $row2){?>
              <tr>
                <td><input type="hidden" id="kdiku<?php echo $i?>" name="kdiku[]" value="<?php echo $row2->KodeIku;?>" /><?php echo $row2->KodeIku; ?></td>
                <td></td>
                <td><?php echo $row2->Iku; ?></td>
                <td>
                <select id="jenis_prioritas<?php echo $i?>" name="jenis_prioritas_iku[]" disabled="disabled" style="padding:3px; width:80%; margin:0 20px 0 20px" >
                  <?php
				 	foreach($prioritas->result() as $row3)
                    {
						$iku = $this->masmo->get_where2('prioritas_iku','KodeIku',$row2->KodeIku,'idThnAnggaran',$th);
						if($iku->num_rows())
						{
							foreach($iku->result() as $dataiku)
							{
								 if($dataiku->KodeJenisPrioritas == $row3->KodeJenisPrioritas)
								 {
									echo '<option value="'.$row3->KodeJenisPrioritas.'" selected="selected">'.$row3->JenisPrioritas.'</option>';
								 }
							}
						}
					}
                  ?>
                </select>
                </td>
              </tr><?php $i++; $k++;} ?>
              
              <?php $j=1; $l=1;foreach($this->masmo->get_where('ref_kegiatan','KodeProgram',$row->KodeProgram)->result() as $ikk1) {?>
			  <tr>
                <td><input type="hidden" id="kdkeg<?php echo $l?>" name="kdkeg[]" value="<?php echo $ikk1->KodeKegiatan;?>" /><?php echo $ikk1->KodeKegiatan; ?></td>
                <td><?php echo $ikk1->NamaKegiatan; ?></td>
                <td></td>
                <td>
                <select id="jenis_prioritas<?php echo $l?>" name="jenis_prioritas_kegiatan[]" disabled="disabled" style="padding:3px; width:80%; margin:0 20px 0 20px">
                  <?php
				  foreach($prioritas->result() as $row3)
                    {
						$keg = $this->masmo->get_where2('prioritas_kegiatan','KodeKegiatan',$ikk1->KodeKegiatan,'idThnAnggaran',$th);
						if($keg->num_rows())
						{
							foreach($keg->result() as $datakeg)
							{
								 if($datakeg->KodeJenisPrioritas == $row3->KodeJenisPrioritas)
								 {
									echo '<option value="'.$row3->KodeJenisPrioritas.'" selected="selected">'.$row3->JenisPrioritas.'</option>';
								 }
							}
						}
					}
                  ?>
                </select>
                </td>
              </tr>
              <?php foreach($this->masmo->get_where('ref_ikk','KodeKegiatan',$ikk1->KodeKegiatan)->result() as $ikk2){?>
              <tr>
                <td><input type="hidden" id="kdikk<?php echo $j?>" name="kdikk[]" value="<?php echo $ikk2->KodeIkk;?>" /><?php echo $ikk2->KodeIkk; ?></td>
                <td></td>
                <td><?php echo $ikk2->Ikk; ?></td>
                <td>
                <select id="jenis_prioritas<?php echo $j?>" name="jenis_prioritas_ikk[]" disabled="disabled" style="padding:3px; width:80%; margin:0 20px 0 20px" >
                  <?php
				  	foreach($prioritas->result() as $row3)
                    {
						$ikk = $this->masmo->get_where2('prioritas_ikk','KodeIkk',$ikk2->KodeIkk,'idThnAnggaran',$th);
						if($ikk->num_rows())
						{
							foreach($ikk->result() as $dataikk)
							{
								 if($dataikk->KodeJenisPrioritas == $row3->KodeJenisPrioritas)
								 {
									echo '<option value="'.$row3->KodeJenisPrioritas.'" selected="selected">'.$row3->JenisPrioritas.'</option>';
								 }
							}
						}
					}
                  ?>
                </select></td>
              </tr><?php $j++; $l++;} } } ?>
            </table>

			<tr>
				<td></td>
				<td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/e-planning/prioritas/grid"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
				</td>
			</tr>
        </form>
    </table>
</div>