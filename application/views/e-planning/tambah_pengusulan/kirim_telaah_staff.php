<div id="kiri">
<div id="judul" class="title">
	Telaah Staff
</div>
<div id="content">
	<form id="form_kirim_telaah" class="appnitro" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/telaah/'.$kirimke.'/'.$kd_telaah; ?>" >
		<div>
			<font color="red"><?php echo  validation_errors(); ?></font>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="15%" style="padding-left:10px;vertical-align:top;"><p>Dari</p></td>
				<td><p>
					<?php if(isset($pengirim)){ $i=1;?>
					<div style="height:100px; overflow:auto;">
					<?php foreach($pengirim->result() as $row){ ?>
						<input style="width:20px;" id="dari" name="dari[]" type="radio" value="<?php echo  $row->id_peg; ?>" <?php if($i==1) echo 'checked'; ?>/>
						<?php echo  $row->nama_peg.' - '.$row->NAMA_JABATAN; ?></br>
					<?php $i++; } ?>
					</div>
					<?php } 
						else echo 'Daftar pegawai belum terdaftar dalam sistem.'; ?>
				</p></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="15%" style="padding-left:10px;vertical-align:top;"><p>Kepada</p></td>
				<td><p>
					<?php if(isset($penerima)){ $j=1;?>
					<div style="height:100px; overflow:auto;">
					<?php foreach($penerima->result() as $row){ ?>
						<input style="width:20px;" id="kepada"  name="kepada[]" type="radio" value="<?php echo  $row->id_peg; ?>" <?php if($j==1) echo 'checked'; ?>/>
						<?php echo  $row->nama_peg.' - '.$row->NAMA_JABATAN; ?></br>
					<?php $j++;} ?>
					</div>
					<?php }
						else echo 'Daftar pegawai belum terdaftar dalam sistem.'; ?>
				</p></td>
			</tr>
			<tr><td></td>
			<td>
				<div class="buttons">
				
					<button type="button" class="negative" name="batal" onClick="history.go(-1);"> <img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/> Batal </button>
					<button type="submit" class="regular" name="save" id="save">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Kirim
					</button>
				</div>
			</td>
			</tr>
		</table>
	</form>
</div>
</div>