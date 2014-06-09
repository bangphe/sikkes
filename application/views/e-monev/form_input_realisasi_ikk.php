<div>
    <?= anchor(site_url('e-monev/laporan_kinerja/'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Laporan Kinerja'); ?>
</div>
<br />
<?php if (isset($noRencana)): echo "<h1>$noRencana</h1>";?>
<?php else : echo form_open($post_action); ?>
<table width=auto>
    <tr>
        <td width="10%"><b>Kode</b></td>
        <td colspan="2">
            <?php echo $ikk[0]->KodeIkk; ?>
        </td>
    </tr>    
    <tr>
        <td width="10%"><b>Nama IKK </b></td>
        <td colspan="2">
            <?php echo $ikk[0]->Ikk; ?>
        </td>
    </tr>
    <tr>
        <td width="15%" height="10px" colspan="3"></td>
    </tr>
    <tr>
        <td width="10%">&nbsp;</td>
        <td width="20%"><b>Rencana</b></td>
        <td><b>Realisasi</b></td>        
    </tr>
    <?php foreach ($bulan as $id => $val): $str = "bulan_$id"; ?>
        <tr>
            <td align="right"><b><?php echo $val; ?></b>&nbsp;&nbsp;</td>
            <td>
                <input type="text" name="<?php echo "rencana_bulan_$id"; ?>" id="<?php echo "rencana_bulan_$id"; ?>" value="<?php echo $rencana[0]->$str;?>" disabled="disabled" />
            </td>
            <td>
                <?php if (isset($realisasi[0]) && $realisasi[0]->$str != NULL): ?>
                <input type="text" id="<?php echo "bulan_$id"; ?>" name="<?php echo "bulan_$id"; ?>" value="<?php echo $realisasi[0]->$str;?>" onChange="set_realisasi(<?php echo $id; ?>)"/>
                <?php else :?>
                <input type="text" id="<?php echo "bulan_$id"; ?>" name="<?php echo "bulan_$id"; ?>" value="<?php echo set_value("bulan_$id"); ?>" onChange="set_realisasi(<?php echo $id; ?>)" />
                <?php endif; echo form_error("bulan_$id"); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td>
            <div class="buttons">
                <button type="submit" class="regular" name="save">
                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                    Save
                </button>&nbsp;&nbsp;
                <button type="reset" class="negative" name="reset">
                    <img src="<?php echo base_url(); ?>images/main/reset.png" alt=""/>
                    Cancel
                </button>
            </div>
        </td>
    </tr>
</table>
<?php
echo form_close();
endif;
?>
<script>
	function set_realisasi(bulan){
		//var rencana = document.getElementsByName("bulan_"+bulan);
		var realisasi = parseInt($('#bulan_'+bulan).val());
		var rencana = $('#rencana_bulan_'+bulan).val();
		
		/*if(bulan != 1){
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
		}*/
		
		var bulan_sebelum = parseInt($('#bulan_'+(bulan-1)).val());
		
		if(realisasi<bulan_sebelum){
			alert("Rencana bulan ini tidak boleh lebih kecil dari bulan sebelumnya");
			for(var i=bulan; i<= 12;i++){
				$('#bulan_'+i).val(bulan_sebelum);
			}
		}else{
			for(var i=bulan; i<= 12;i++){
				$('#bulan_'+(i+1)).val(realisasi);
			}
		}
	}
</script>