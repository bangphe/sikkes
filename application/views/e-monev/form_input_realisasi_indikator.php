<div>
	<?php echo  anchor(site_url('e-monev/laporan_kinerja/input_indikator/'.$kodeikk.'/'.$thn.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Indikator',array('onclick' => 'daftar_indikator('.$kodeikk.','.$thn.');;return false;')); ?>
</div>
<br />
<?php if (isset($noRencana)): echo "<h1>$noRencana</h1>";?>
<?php else : echo form_open($post_action); ?>
<table width=auto>
        <tr>
    	    <td><b>Rencana Per Bulan</b></td>
        </tr>
        <?php foreach ($bulan as $id => $val): $str="bulan_$id"; ?>
		<tr>
			<td align="right" width="5%"><b><?php echo  $val; ?></b>&nbsp;&nbsp;</td>
            <td>
                <input type="text" name="<?php echo  "bulan_$id"; ?>" value="<?php echo  $rencana[0]->$str;?>" disabled="disabled" />
            </td>
            <td>
                <?php if (isset($realisasi[0]) && $realisasi[0]->$str != NULL): ?>
                <input type="text" id="<?php echo  "bulan_$id"; ?>" name="<?php echo  "bulan_$id"; ?>" value="<?php echo  $realisasi[0]->$str;?>" onChange="set_realisasi(<?php echo  $id; ?>)"/>
                <?php else :?>
                <input type="text" id="<?php echo  "bulan_$id"; ?>" name="<?php echo  "bulan_$id"; ?>" value="<?php echo  set_value("bulan_$id"); ?>" onChange="set_realisasi(<?php echo  $id; ?>)" />
                <?php endif; echo form_error("bulan_$id"); ?>
            </td>
		</tr>
        <?php endforeach; ?>
		<tr align="center">
			<td></td>
			<td>
				<div class="buttons">
					<button type="submit" class="regular" name="save" id="submit">
						<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
						Save
					</button>
					<button type="reset" class="negative" name="reset" onClick="daftar_indikator(<?php echo  $kodeikk.','.$thn?>);">
						<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
						Cancel
					</button>
				</div>
			</td>
		</tr>
	</table>
<?php echo  form_close(); endif; ?>
<script>
	function set_realisasi(bulan){
		//var rencana = document.getElementsByName("bulan_"+bulan);
		var realisasi = parseInt($('#bulan_'+bulan).val());
		
		if(bulan != 1){
			var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
			if(realisasi<bulan_sebelum){
				alert("Realisasi bulan ini tidak boleh lebih kecil dari bulan sebelumnya");
				for(var i=bulan; i<= 12;i++){
					$('#bulan_'+i).val(bulan_sebelum);
				}
			}else{
				for(var i=bulan; i<= 12;i++){
					$('#bulan_'+(i+1)).val(realisasi);
				}
			}
		}else{
			for(var i=bulan; i<= 12;i++){
				$('#bulan_'+(i+1)).val(realisasi);
			}
		}
	}
</script>