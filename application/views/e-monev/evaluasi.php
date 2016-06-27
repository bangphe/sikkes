<style type="text/css">
table.myTable { width:100%; border-collapse:collapse;  }
table.myTable .tes { 
	background-color: #dfe4ea; color:#000; text-align:center;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 12px; font-weight:bold;}
table.myTable td { padding:8px; border:#999 1px solid; }

table.myTable tr:nth-child(even) { /*(even) or (2n+0)*/
	background-color: #f2f5f9;
}
table.myTable tr:nth-child(odd) { /*(odd) or (2n+1)*/
	background: #fff;
}
</style>

<div id="judul" class="title">
	<?php echo  $judul; ?>
</div>
<div id="content_master">
<table width="80%" height="25%" style="padding:10px">
    <form name="tambah_prioritas" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-monev/laporan_evaluasi/evaluasi'; ?>">
            <tr>
				<td width="10%" style="padding:5px">Tahun Anggaran</td>
				<td width="70%">
                <input type="text" width="15%" disabled="disabled" value="<?php echo  $this->session->userdata('thn_anggaran')?>" />
                </td>
			</tr>
            
            <table width="200" class="myTable">
              <tr class="tes">
                <td rowspan="2" class="tes" width="5%"><div style="padding:15px">Update Tanggal</div></td>
                <td rowspan="2" class="tes" width="25%"><div style="padding:15px">Program/Kegiatan/Output/Aktivitas</div></td>
                <td rowspan="2" class="tes" width="8%"><div style="padding:15px">Alokasi</div></td>
                <td colspan="3" class="tes" width="8%">Realisasi Akhir Tahun</td>
                <td rowspan="2" class="tes" width="6%"><div style="padding:15px">Sisa Pagu</div></td>
                <td rowspan="2" class="tes" width="2%"><div style="padding:15px">Evaluasi</div></td>
              </tr>
               <tr class="tes">
                <td class="tes" width="6%">Keuangan</td>
                <td class="tes" width="3%">%Keu</td>
                <td class="tes" width="3%">%Fisik</td>
              </tr>
              <?php foreach($sub->result() as $sub) {?>
              <?php foreach($this->lmm->get_where('depkesgabungan.t_program','kdprogram',$sub->kdprogram)->result() as $row){ ?>
              <?php foreach($this->lmm->get_jumlah_prog($sub->kdprogram)->result() as $jum) {?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row->kdprogram.'] - '.$row->nmprogram?></td>
                <td><?php echo  'Rp.'.number_format($jum->total);?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } ?>
              <?php foreach($this->lmm->get_where2('depkesgabungan.t_giat','kdprogram',$sub->kdprogram,'kdgiat',$sub->kdgiat)->result() as $row2){ ?>
              <?php foreach($this->lmm->get_jumlah_keg($row2->kdgiat,$row2->kdprogram)->result() as $jum2) {?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row2->kdgiat.'] - '.$row2->nmgiat?></td>
                <td><?php echo  'Rp.'.number_format($jum2->total);?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } ?>
			  <?php foreach($output->result() as $out) {?>
              <?php foreach($this->lmm->get_where2('depkesgabungan.t_output','kdgiat',$sub->kdgiat,'kdoutput',$out->kdoutput)->result() as $row3){ ?>
              <?php foreach($this->lmm->get_jumlah_output($row3->kdgiat,$row3->kdoutput)->result() as $jum3) {?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row3->kdoutput.'] - '.$row3->nmoutput?></td>
                <td><?php echo  'Rp.'.number_format($jum3->total);?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } } ?>
              <?php foreach($komponen->result() as $kmpnen) {?>
              <?php foreach($this->lmm->get_where3('depkesgabungan.d_kmpnen','kdgiat',$sub->kdgiat,'kdoutput',$out->kdoutput,'kdkmpnen',$kmpnen->kdkmpnen)->result() as $row4){ ?>
              <?php foreach($this->lmm->get_jumlah_kmpnen($row4->kdgiat,$row4->kdoutput,$row4->kdkmpnen)->result() as $jum4) {?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row4->kdkmpnen.'] - '.$row4->urkmpnen?></td>
                <td><?php echo  'Rp.'.number_format($jum4->total);?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr>
             
              <?php foreach($this->lmm->get_where3('depkesgabungan.d_skmpnen','kdgiat',$sub->kdgiat,'kdoutput',$out->kdoutput,'kdkmpnen',$kmpnen->kdkmpnen)->result() as $row5){ ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row5->kdskmpnen.'] - '.$row5->urskmpnen?></td>
                <td><?php echo  'Rp.'.number_format($jum4->total);?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } } ?>
              <?php } } } } } }?>
           <?php /*?>  <?php $no1=1; $no2=1;foreach($sub->result() as $row) {?>
              <?php if($no1 == 1) {?>
              <?php foreach($this->lmm->get_where('depkesgabungan.t_program','kdprogram',$row->kdprogram)->result() as $row2){ ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row2->kdprogram.'] - '.$row2->nmprogram?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } } ?>
             <?php if($no1 == 1) {?>
			 <?php foreach($this->lmm->get_where('depkesgabungan.t_giat','kdgiat',$row->kdgiat)->result() as $row2){ ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row2->kdgiat.'] - '.$row2->nmgiat?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } } ?>
			  <?php  foreach($this->lmm->get_where2('depkesgabungan.t_output','kdgiat',$row->kdgiat,'kdoutput',$row->kdoutput)->result() as $row3) { ?>
              
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row3->kdoutput.'] - '.$row3->nmoutput?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php $no1++; $no2++; } ?>
              <?php foreach($sub_komponen->result() as $subk) {?>
              <?php foreach($this->lmm->get_where3('depkesgabungan.d_kmpnen','kdoutput',$row->kdoutput,'kdgiat',$row->kdgiat,'kdkmpnen',$row->kdkmpnen)->result() as $row3) { ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row3->kdkmpnen.'] - '.$row3->urkmpnen?></td>
                <td></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } ?><?php */?>
              <?php /*?><?php foreach($this->lmm->get_where4('depkesgabungan.d_skmpnen','kdsoutput',$subk->kdsoutput,'kdoutput',$row->kdoutput,'kdgiat',$row->kdgiat,'kdkmpnen',$subk->kdkmpnen)->result() as $row3) { ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row3->kdskmpnen.'] - '.$row3->urskmpnen?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td><a href="<?php echo  base_url()?>index.php/e-monev/laporan_evaluasi/unggah/<?php echo  $subk->d_skmpnen_id ?>"><img style="margin:0 50px 0 50px" border="0" src="<?php echo  base_url()?>images/icon/upload.png"></a></a></td>
              </tr><?php } ?>
              <?php } } ?><?php */?>
              <?php /*?><?php foreach($sub_komponen->result() as $subk) {?>
              <?php foreach($this->lmm->get_where4('depkesgabungan.d_kmpnen','kdsoutput',$subk->kdsoutput,'kdoutput',$subk->kdoutput,'kdgiat',$subk->kdgiat,'kdkmpnen',$subk->kdkmpnen)->result() as $row3) { ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row3->kdkmpnen.'] - '.$row3->urkmpnen?></td>
                <td></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td></td>
              </tr><?php } ?>
              <?php foreach($this->lmm->get_where4('depkesgabungan.d_skmpnen','kdsoutput',$subk->kdsoutput,'kdoutput',$subk->kdoutput,'kdgiat',$subk->kdgiat,'kdkmpnen',$subk->kdkmpnen)->result() as $row3) { ?>
              <tr>
              	<td>-</td>
                <td><?php echo  '['.$row3->kdskmpnen.'] - '.$row3->urskmpnen?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td><a href="<?php echo  base_url()?>index.php/e-monev/laporan_evaluasi/unggah/<?php echo  $row->d_skmpnen_id ?>"><img style="margin:0 50px 0 50px" border="0" src="<?php echo  base_url()?>images/icon/upload.png"></a></a></td>
              </tr><?php } ?>
            <?php $no1++; }?><?php */?>
            </table>

			<tr>
				<td></td>
				<td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/e-monev/laporan_evaluasi"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
				</td>
			</tr>
        </form>
    </table>
</div>