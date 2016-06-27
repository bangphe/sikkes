<div>
	<?php echo  anchor(site_url('e-monev/laporan_kinerja/input_indikator/'.$kodeikk.'/'.$thn.'#'),img(array('src'=>'images/flexigrid/prev.gif','border'=>'0','alt'=>'')).'Kembali Ke Daftar Indikator',array('onclick' => 'daftar_indikator('.$kodeikk.','.$thn.');;return false;')); ?>
</div>
<br />
<?php echo  form_open($post_action);?>
<table width=auto>
        <tr>
    	    <td><b>Rencana Per Bulan</b></td>
        </tr>
        <?php foreach ($bulans as $id => $val): ?>
		<tr>
			<td align="right" width="10%"><b><?php echo  $val; ?></b>&nbsp;&nbsp;</td>
            <td>
            	<?php $str = "bulan_$id"; if (isset($rencana[0]) && $rencana[0]->$str != NULL): ?>
                <input type="text" id="<?php echo  "bulan_$id"; ?>" name="<?php echo  "bulan_$id"; ?>" value="<?php echo  $rencana[0]->$str;?>" onChange="set_rencana(<?php echo  $id; ?>)"/>
                <?php else :?>
                <input type="text" id="<?php echo  "bulan_$id"; ?>"name="<?php echo  "bulan_$id"; ?>" value="<?php echo  set_value("bulan_$id"); ?>" onChange="set_rencana(<?php echo  $id; ?>)" />
                <?php endif; echo form_error("bulan_$id"); ?>
				<?php /*?><div>
                    <?php $str="bulan_$id_bln"; $id=$id_bln-1; $bulan_sebelum="bulan_$id"; if (isset($rencana[0]) && $rencana[0]->$str != NULL):?>
                    <input type="text" name="<?php echo  "bulan_$id_bln"; ?>" id="<?php echo  "bulan_$id_bln"; ?>" value="<?php echo  $rencana[0]->$str; ?>" onchange="set_rencana(<?php echo  $id_bln; ?>)" />
                    <input type="hidden" name="bulan_hidden" id="bulan_hidden" value=<?php echo  $bulan; ?> />
					<?php if($id_bln > 1) { ?><input type="hidden" name="rencana_hidden" id="rencana_hidden" value=<?php echo  $rencana[0]->$bulan_sebelum; ?> />				
                    <?php } else { ?>
                    <input type="hidden" name="rencana_hidden" id="rencana_hidden" value=<?php echo  '0'; ?> /><?php } ?>
                    <?php else : ?>
                    <input type="text" name="<?php echo  "bulan_$id_bln"; ?>" id="<?php echo  "bulan_$id_bln"; ?>" onchange="set_rencana(<?php echo  $id_bln; ?>)" />
                    <input type="hidden" name="bulan_hidden" id="bulan_hidden" value=<?php echo  $bulan; ?> />
                    <input type="hidden" name="rencana_hidden" id="rencana_hidden" value=<?php echo  '0'; ?> />
                    <?php endif; ?>
				</div>
				<!--
				<div>
					Characters :  <p id="counter"></p>
				</div>
				--><?php */?>
			</td>
		</tr>
        <?php endforeach; ?>
		<tr>
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
<?php echo  form_close(); ?>
<script>
	function set_rencana(bulan){
		//var rencana = document.getElementsByName("bulan_"+bulan);
		var rencana = parseInt($('#bulan_'+bulan).val());
		
		if(rencana == 0){
			var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
			alert("Inputan harus lebih dari 0");
			for(var i=bulan; i<= 12;i++){
				$('#bulan_'+i).val(bulan_sebelum);
			}
		}
		else{
			if(bulan != 1){
				var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
				if(rencana<bulan_sebelum){
					alert("Rencana bulan ini tidak boleh lebih kecil dari bulan sebelumnya");
					for(var i=bulan; i<= 12;i++){
						$('#bulan_'+i).val(bulan_sebelum);
					}
				}else{
					for(var i=bulan; i<= 12;i++){
						$('#bulan_'+(i+1)).val(rencana);
					}
				}
			}else{
				for(var i=bulan; i<= 12;i++){
					$('#bulan_'+(i+1)).val(rencana);
				}
			}
		}
	}
</script>