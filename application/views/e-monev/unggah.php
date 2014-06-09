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
	<?php echo $judul; ?>
</div>
<div id="content_master">
<table width="80%" height="25%" style="padding:10px">
    <form name="tambah_prioritas" enctype="multipart/form-data" method="post" action="<?php echo base_url().'index.php/e-monev/laporan_monitoring/unggah/'.$d_skmpnen_id ?>">
    		<?php foreach($sub_komponen->result() as $row) {?>
            <tr>
				<td width="10%" style="padding:5px">Tahun Anggaran</td>
				<td width="70%">
                <input type="text" width="15%" disabled="disabled" value="<?php echo $row->thang?>" />
                </td>
			</tr>
            
            <table width="200" class="myTable">
              <tr class="tes">
                <td rowspan="2" class="tes" width="8%"><div style="padding:15px">Update Tanggal</div></td>
                <td rowspan="2" class="tes" width="20%"><div style="padding:15px">Program/Kegiatan/Output/Aktivitas</div></td>
                <td rowspan="2" class="tes" width="8%"><div style="padding:15px">Alokasi</div></td>
                <td colspan="3" class="tes" width="8%">Realisasi Akhir Tahun</td>
                <td rowspan="2" class="tes" width="6%"><div style="padding:15px">Sisa Pagu</div></td>
                <td rowspan="2" class="tes" width="6%"><div style="padding:15px">Evaluasi</div></td>
              </tr>
               <tr class="tes">
                <td class="tes" width="6%">Keuangan</td>
                <td class="tes" width="3%">%Keu</td>
                <td class="tes" width="3%">%Fisik</td>
              </tr>
              <?php foreach($this->lmm->get_where('depkesgabungan.t_program','kdprogram',$row->kdprogram)->result() as $row2){ ?>
              <tr>
              	<td>tes</td>
                <td><?php echo '['.$row2->kdprogram.'] - '.$row2->nmprogram?></td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
              </tr>
              <?php foreach($this->lmm->get_where('depkesgabungan.t_giat','kdgiat',$row->kdgiat)->result() as $row2){ ?>
              <tr>
              	<td>tes</td>
                <td><?php echo '['.$row2->kdgiat.'] - '.$row2->nmgiat?></td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
              </tr>
              <?php foreach($this->lmm->get_where2('depkesgabungan.t_output','kdgiat',$row->kdgiat,'kdoutput',$row->kdoutput)->result() as $row3) { ?>
              <tr>
              	<td>tes</td>
                <td><?php echo '['.$row3->kdoutput.'] - '.$row3->nmoutput?></td>
                <td></td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
              </tr>
              <?php foreach($this->lmm->get_where4('depkesgabungan.d_kmpnen','kdsoutput',$row->kdsoutput,'kdoutput',$row->kdoutput,'kdgiat',$row->kdgiat,'kdkmpnen',$row->kdkmpnen)->result() as $row3) { ?>
              <tr>
              	<td>tes</td>
                <td><?php echo '['.$row3->kdkmpnen.'] - '.$row3->urkmpnen?></td>
                <td></td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
              </tr>
              <?php foreach($this->lmm->get_where4('depkesgabungan.d_skmpnen','kdsoutput',$row->kdsoutput,'kdoutput',$row->kdoutput,'kdgiat',$row->kdgiat,'kdkmpnen',$row->kdkmpnen)->result() as $row3) { ?>
              <tr>
              	<td>tes</td>
                <td><?php echo '['.$row3->kdskmpnen.'] - '.$row3->urskmpnen?></td>
                <td></td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
                <td>tes</td>
              </tr>
              <?php } } } } } } ?>
              
            </table>

			<tr>
				<td></td>
				<td>
                    <div class="buttons">
                        <a href="<?php echo base_url();?>index.php/e-monev/laporan_monitoring"><img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
				</td>
			</tr>
        </form>
    </table>
</div>