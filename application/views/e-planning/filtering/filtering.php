<script>
function input(val,i)
{
	var prop = document.getElementById('provinsi'+i).value;
	/*var prioritas = val;
	var periode = document.getElementById('periode').value;
	var tahun = document.getElementById('tahun').value;*/
	
	$.ajax({
		url:'<?php echo  base_url()?>index.php/e-planning/filtering/tes',
		type: 'POST',
		//data: 'kode='+kode+'&prio='+prioritas+'&periode='+periode+'&tahun='+tahun,
		data: 'prop='+prop,
		beforeSend: function()
		{},
		success: function(data)
		{
			alert(data);
		}
	})
}
function validateForm(frm)
{
	var destCount = frm.elements['provinsi[]'].length;
	var destSel   = false;
	for(i = 0; i < destCount; i++){
		if(frm.elements['provinsi[]'][i].checked){
			destSel = true;
			break;
		}
	}
	if(!destSel){
		alert('Silahkan pilih pilihan Provinsi terlebih dahulu.');
	}
	return destSel;
}
</script>

<div id="tengah">
<div id="judul" class="title">
	Filtering
</div>
<div id="content_tengah">
	<form class="appnitro" name="form_filtering" id="form_filtering" enctype="multipart/form-data" method="post" action="<?php echo  base_url().'index.php/e-planning/filtering/cek'; ?>" >
    <table width="200">
          <tr>
            <th width="15%">Provinsi</th>
            <td>
                <div class="container" style="height:108px; overflow:auto; border:1px solid #ccc;">
                        <?php /*?><?php $i=1; foreach ($prov as $row) { ?>
                            <input style="width:20px;" id="provinsi<?php echo  $i?>" name="provinsi" type="checkbox" value="<?php echo  $row->KodeProvinsi; ?>" onchange="input(this.value,<?php echo  $i?>)" />
                            <?php echo  $row->NamaProvinsi; ?></br>
                        <?php $i++; } ?><?php */?>
                        <?php if(isset($prov)) { foreach ($prov as $row) { ?>
                            <input style="width:20px;" id="provinsi" name="provinsi[]" type="checkbox" value="<?php echo  $row->KodeProvinsi; ?>"/>
                            <?php echo  $row->NamaProvinsi; ?></br>
                        <?php } } ?>
                </div>
            </td>
          </tr>
          <!--<tr>
            <th>Prioritas</th>
            <td>
            <select name="prioritas" id="prioritas" style="padding:3px; width:13%">
                <option value="1">Prioritas</option>
                <option value="2" selected="TRUE">Non Prioritas</option>
            </select>
            </td>
          </tr>
          <tr id="jenis">
              <th>Jenis Prioritas</th>
              <td>
              <div class="container" style="height:60px; padding:3px; border:1px solid #ccc;">
                  <input type="checkbox" id="jenis_prioritas" name="jenis_prioritas[]" value="1" />Nasional <br/>
                  <input type="checkbox" id="jenis_prioritas" name="jenis_prioritas[]" value="3" />Kementrian <br/>
                  <input type="checkbox" id="jenis_prioritas" name="jenis_prioritas[]" value="2" />Bidang
              </div>
              </td>
          </tr>-->
          <tr class="tree">
          	<th>Program</th>
            <td>
                <div style="height:300px; overflow:auto; border:1px solid #ccc;">
                    <ul>
                        <?php foreach($program->result() as $row){?>
                        <li><input style="width:50px" type="checkbox" name="program[]" value="<?php echo  $row->KodeProgram; ?>" ><span><?php echo  $row->NamaProgram; ?></span>
                            <ul>
                                <li><strong>IKU</strong></li>
                                <?php foreach($this->fm->get_where('ref_iku','KodeProgram',$row->KodeProgram)->result() as $row){?>
                                    <li><input style="width:50px" type="checkbox" name="iku[]" value="<?php echo  $row->KodeIku; ?>" ><span><?php echo  $row->Iku; ?></span>
                                <?php } ?>
                                <li><strong>Kegiatan</strong></li>
                                <?php foreach($this->fm->get_where('ref_kegiatan','KodeProgram',$row->KodeProgram)->result() as $row){?>
                                <li><input style="width:50px" type="checkbox" name="kegiatan[]" value="<?php echo  $row->KodeKegiatan; ?>" ><span><?php echo  $row->NamaKegiatan; ?></span>
                                    <ul>
                                        <?php foreach($this->fm->get_where('ref_ikk','KodeKegiatan',$row->KodeKegiatan)->result() as $row){?>
                                            <li><input style="width:50px" type="checkbox" name="ikk[]" value="<?php echo  $row->KodeIkk; ?>" ><span><?php echo  $row->Ikk; ?></span>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </ul>
                </div>
            </td>
        </tr>
          <tr>
            <th>Fokus Prioritas</th>
            <td>
            <div class="container" style="height:86px; overflow:auto; border:1px solid #ccc;">
			<?php foreach ($fokus_prioritas as $row) { ?>
                <input style="width:20px;" id="fokus_prioritas" name="fokus_prioritas[]" type="checkbox" value="<?php echo  $row->idFokusPrioritas; ?>" />
                <?php echo  $row->FokusPrioritas; ?></br>
            <?php } ?>
            </div>
            </td>
          </tr>
          <tr>
            <th>Reformasi Kesehatan</th>
            <td>
            <div class="container" style="height:86px; overflow:auto; border:1px solid #ccc;">
			<?php foreach ($reformasi_kesehatan as $row) { ?>
                <input style="width:20px;" id="reformasi_kesehatan" name="reformasi_kesehatan[]" type="checkbox" value="<?php echo  $row->idReformasiKesehatan; ?>" />
                <?php echo  $row->ReformasiKesehatan; ?></br>
            <?php } ?>
            </div>
            </td>
          </tr>
          <tr>
			<td></td>
            <td><div class="buttons">
                    <button type="submit" id="submit" class="positive" name="submit">
                        <img src="<?php echo  base_url(); ?>images/main/search.png" alt=""/>
                        Cari
                    </button>
                    <button type="reset" class="negative" name="reset">
                        <img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
                        Reset
                    </button>
                </div></td>
        	</tr>
	</table>

	<?php /*?><table width="100%" height="100%" cellspacing="0" cellpadding="0" >
		<tr>
			<td width="=50%">
			<strong>Provinsi</strong></br></br>
			<div style="height:600px; overflow:auto;">
				<?php foreach ($prov as $row) { ?>
					<input style="width:20px;" id="provinsi" name="provinsi[]" type="checkbox" value="<?php echo  $row->KodeProvinsi; ?>" />
					<?php echo  $row->NamaProvinsi; ?></br>
				<?php } ?>
			</div>
			</td>
			<td width="50%">
				<table width="100%" border="0" cellspacing="5" cellpadding="5" height="100%">
					<tr>
						<td>
							<!--
							<input type="hidden" id="kode_prioritas" name="kode_prioritas" value="" />
							<textarea id="prioritas" name="prioritas" readonly="TRUE" onfocusin="window.open('<?php //echo base_url(); ?>index.php/e-planning/Filtering/program',null,'height=600,width=550,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes,left=0,top=0,screenX=0,screenY=0');"></textarea>
							<label id="error"><?php //echo form_error('prioritas'); ?></label>
							-->
							Prioritas </br>
							<select name="prioritas" id="prioritas">
								<option value="1">Prioritas</option>
								<option value="2" selected="TRUE">Non Prioritas</option>
							</select>
						</td>
					</tr>
					<tr id="tree">
						<td>
							<div style="height:300px; overflow:auto;">
								<ul>
									<?php foreach($program->result() as $row){?>
									<li><input style="width:50px" type="checkbox" name="program[]" value="<?php echo  $row->KodeProgram; ?>" ><span><?php echo  $row->NamaProgram; ?></span>
										<ul>
											<li><strong>IKU</strong></li>
											<?php foreach($this->fm->get_where('ref_iku','KodeProgram',$row->KodeProgram)->result() as $row){?>
												<li><input style="width:50px" type="checkbox" name="iku[]" value="<?php echo  $row->KodeIku; ?>" ><span><?php echo  $row->Iku; ?></span>
											<?php } ?>
											<li><strong>Kegiatan</strong></li>
											<?php foreach($this->fm->get_where('ref_kegiatan','KodeProgram',$row->KodeProgram)->result() as $row){?>
											<li><input style="width:50px" type="checkbox" name="kegiatan[]" value="<?php echo  $row->KodeKegiatan; ?>" ><span><?php echo  $row->NamaKegiatan; ?></span>
												<ul>
													<?php foreach($this->fm->get_where('ref_ikk','KodeKegiatan',$row->KodeKegiatan)->result() as $row){?>
														<li><input style="width:50px" type="checkbox" name="ikk[]" value="<?php echo  $row->KodeIkk; ?>" ><span><?php echo  $row->Ikk; ?></span>
													<?php } ?>
												</ul>
											<?php } ?>
										</ul>
									<?php } ?>
								</ul>
							</div>
						</td>
					</tr>
					<tr id="jenis">
						<td>
							Jenis Prioritas </br>
							<input style="width:30px" type="checkbox" id="prioritas" name="jenis_prioritas[]" value="1" />Nasional <br/>
							<input style="width:30px" type="checkbox" id="prioritas" name="jenis_prioritas[]" value="3" />Kementrian <br/>
							<input style="width:30px" type="checkbox" id="prioritas" name="jenis_prioritas[]" value="2" />Bidang
						</td>
					</tr>
					<tr>
						<td>
							Fokus Prioritas</br>
							<div style="height:100px; overflow:auto;">
							<?php foreach ($fokus_prioritas as $row) { ?>
								<input style="width:20px;" id="fokus_prioritas" name="fokus_prioritas[]" type="checkbox" value="<?php echo  $row->idFokusPrioritas; ?>" />
								<?php echo  $row->FokusPrioritas; ?></br>
							<?php } ?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							Reformasi Kesehatan</br>
							<div style="height:100px; overflow:auto;">
							<?php foreach ($reformasi_kesehatan as $row) { ?>
								<input style="width:20px;" id="reformasi_kesehatan" name="reformasi_kesehatan[]" type="checkbox" value="<?php echo  $row->idReformasiKesehatan; ?>" />
								<?php echo  $row->ReformasiKesehatan; ?></br>
							<?php } ?>
							</div>
						</td>
					</tr>
					<!--
					<tr>
						<td>Program</td>
						<td>
							<input id="label2" />
							<input type="hidden" id="program" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td><textarea id="label_prog" readonly="TRUE"></textarea></td>
					</tr>
					<tr>
						<td>IKU</td>
						<td>
							<input id="label3" />
							<input type="hidden" id="kode_iku" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td><textarea id="label_iku" readonly="TRUE"></textarea></td>
					</tr>
					<tr>
						<td>Kegiatan</td>
						<td>
							<input id="label4" />
							<input type="hidden" id="kegiatan" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td><textarea id="label_keg" readonly="TRUE"></textarea></td>
					</tr>
					<tr>
						<td>IKK</td>
						<td>
							<input id="label5" />
							<input type="hidden" id="kode_ikk" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td><textarea id="label_ikk" readonly="TRUE"></textarea></td>
					</tr>
					-->
					<tr>
						<td>
							<div class="buttons">
								<button type="submit" class="positive" name="Cari">
									<img src="<?php echo  base_url(); ?>images/main/search.png" alt=""/>
									Cari
								</button>
								<button type="reset" class="negative" name="reset">
									<img src="<?php echo  base_url(); ?>images/main/reset.png" alt=""/>
									Reset
								</button>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><?php */?>
	</form>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#jenis').hide();
		
		var prog = [ <?php echo  $prog; ?> ];
		var keg = [ <?php echo  $keg; ?> ];
		var ikk = [ <?php echo  $ikk; ?> ];
		var iku = [ <?php echo  $iku; ?> ];
		var provTags = [ <?php echo  $prov; ?> ];
		function split( val ) {
			return val.split( /;\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#label" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						provTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( label_prov.value );
					var terms2 = split( provinsi.value );
					// remove the current input
					terms.pop();
					terms2.pop();
					// add the selected item
					terms.push( ui.item.label );
					terms2.push( ui.item.id );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					terms2.push( "" );
					label_prov.value = terms.join( ";" );
					provinsi.value = terms2.join( ";" );
					label.value='';
					return false;
				}
			});
			
			$( "#label2" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						prog, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( label_prog.value );
					var terms2 = split( program.value );
					// remove the current input
					terms.pop();
					terms2.pop();
					// add the selected item
					terms.push( ui.item.label );
					terms2.push( ui.item.id );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					terms2.push( "" );
					label_prog.value = terms.join( ";" );
					program.value = terms2.join( ";" );
					label2.value='';
					return false;
				}
			});
			
			$( "#label3" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						prog, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( label_iku.value );
					var terms2 = split( kode_iku.value );
					// remove the current input
					terms.pop();
					terms2.pop();
					// add the selected item
					terms.push( ui.item.label );
					terms2.push( ui.item.id );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					terms2.push( "" );
					label_iku.value = terms.join( ";" );
					kode_iku.value = terms2.join( ";" );
					label3.value='';
					return false;
				}
			});
			
			$( "#label4" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						keg, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( label_keg.value );
					var terms2 = split( kegiatan.value );
					// remove the current input
					terms.pop();
					terms2.pop();
					// add the selected item
					terms.push( ui.item.label );
					terms2.push( ui.item.id );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					terms2.push( "" );
					label_keg.value = terms.join( ";" );
					kegiatan.value = terms2.join( ";" );
					label4.value='';
					return false;
				}
			});
			
			$( "#label5" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						ikk, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( label_ikk.value );
					var terms2 = split( kode_ikk.value );
					// remove the current input
					terms.pop();
					terms2.pop();
					// add the selected item
					terms.push( ui.item.label );
					terms2.push( ui.item.id );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					terms2.push( "" );
					label_ikk.value = terms.join( ";" );
					kode_ikk.value = terms2.join( ";" );
					label5.value='';
					return false;
				}
			});
	});
	
	$('#prioritas').change( function() {
		var $select = $( this ), selected = $select.val();
		if(selected == "1"){
			$('#jenis').show('slow');
			$('#tree').hide('slow');
		}
		else{
			$('#jenis').hide('slow');
			$('#tree').show('slow');
		}
	});
</script>