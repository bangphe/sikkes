<link rel="stylesheet" type="text/css" href="<?php echo  base_url()?>css/tooltip/tooltip-generic.css"/>
<!--<script type="text/javascript" src="<?php echo  base_url()?>js/jquery.tools.min.js"></script> 
-->
<script>
  // execute your scripts when the DOM is ready. this is a good habit
  $(function() {

        // select all desired input fields and attach tooltips to them
      $("#form_program input[title], textarea[title], select[title]").tooltip({

 		// place tooltip on the right edge
      position: "center right",
	  
      // a little tweaking of the position
      offset: [-2, 10],

      // use the built-in fadeIn/fadeOut effect
      effect: "fade",

      // custom opacity setting
      opacity: 0.7

      });
    });
</script>
<script type="text/javascript">
 function getValue(kdunit){
	 $.ajax({
		 url: '<?php echo  base_url()?>index.php/master_data/master_program/valid/',
		 data: 'kdunit='+kdunit,
		 type: 'GET',
		 beforeSend: function()
		 {},
		 success: function(data)
		 {
			 if(data=='FALSE')
			 {
				 document.getElementById('submit').disabled = true;
				 alert('Maaf, kode telah terdaftar dalam database.');
			 }
			 else
			 {
				 document.getElementById('submit').disabled = false;
			 }
		 }
	})
 }
	 
 function validasiKode(kode){
	 var x = document.getElementById('unit_organisasi');
	 getVal = x.value;
	 $.ajax({
		 url: '<?php echo  base_url()?>index.php/master_data/master_program/valid/'+kode,
		 data: 'kdunit='+getVal,
		 type: 'GET',
		 beforeSend: function()
		 {},
		 success: function(data)
		 {
			 if(data=='FALSE')
			 {
				 document.getElementById('submit').disabled = true;
				 alert('Maaf, kode '+getVal+'.'+kode+' telah terdaftar dalam database.');
			 }
			 else
			 {
				 document.getElementById('submit').disabled = false;
			 }
		 }
	 })
 }
</script>

<div id="tengah">
<div id="judul" class="title">
	Program
</div>
<div id="content_tengah">
	<form name="form_program" id="form_program" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/master_data/master_program/save_program'; ?>">
		<table width="80%" height="25%">
            <tr>
				<td width="10%">Unit Organisasi</td>
				<td width="70%"><?php $js = 'id="unit_organisasi" style="width:67%; padding:3px;"'; echo form_dropdown('unit_organisasi', $unit_organisasi, null, $js); ?></td>
			</tr>
            <div id="coba">
            <tr>
				<td width="10%">Kode Program</td>
				<td width="70%"><input type="text" id="kode_program" name="kode_program" style="padding:3px" onchange="validasiKode(this.value)" /></td>
			</tr>
            </div>
			<tr>
				<td width="10%">Program</td>
				<td width="70%"><textarea id="program" name="program" style="width:50%" rows="3"></textarea></td>
			</tr>
			<tr>
				<td width="10%">Output</td>
				<td width="70%"><textarea id="output" name="output" style="width:50%" rows="3"></textarea></td>
			</tr>
            <tr>
				<td width="10%">Status</td>
				<td width="70%"><?php $js = 'id="status" style="width:10%; padding:3px;"'; echo form_dropdown('status',$status,null,$js); ?></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="buttons">
						<button type="submit" class="regular" name="save" id="submit">
							<img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
							Save
						</button>
						<button type="reset" class="negative" name="reset">
							<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
							Reset
						</button>
					</div>
				</td>
			</tr>
            <tr>
                <td>
                    <div class="buttons">
                        <a href="<?php echo  base_url();?>index.php/master_data/master_program/grid_program"><img src="<?php echo  base_url(); ?>images/main/back.png" alt=""/>Back</a>
                    </div>
                </td>
            </tr>
		</table>
	</form>
</div>
</div>