<div id="tengah">
    <div id="judul"  class="title">
        <?php echo $judul;?>
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <form class="appnitro" name="mapping" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'index.php/e-budget/feedback/grid_komponen/-1/-1/1'; ?>">
            <script language="JavaScript">
                function unitChanged() {
                    var unit = document.mapping.unit;
                    var satker = document.mapping.satker;

                    var selected = unit.options[unit.selectedIndex].value;

                    for (var i=(satker.options.length-1); i>=0; i--) {
                        satker.options[i] = null;
                    }
        
                    if (selected == "0") {
                        var opt = new Option("SEMUA SATKER", "0", true);
                        satker.options.add(opt);
                    }
                    else {
                        var opt = new Option("SEMUA SATKER", "0", true);
                        satker.options.add(opt);
                        if (selected != "") {
                            var i = 0;
                            for (var key in kdunit[selected]) {
                                var value = kdunit[selected][key];
                                i++;
                                var opt = new Option(value, key, false);
                                satker.options.add(opt);
                            }
                        }
                    }

                    return true;
                }
            </script>   
            <div>
                <table width="100%" height="100%">
                    <tr>
                        <td width="15%">Pilih Unit Utama</td>
                        <td width="85%">
                            <?php echo form_dropdown('unit', $search, array(), 'id="unit" onchange="unitChanged();"'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Satker</td>
                        <td width="85%">
                            <select name="satker" id="satker">

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%">  
                            <div class="buttons">
                                <button type="submit" class="regular" name="submit">
                                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                                    Pilih
                                </button>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </form>       
            <script language="JavaScript">
                unitChanged();
            </script>     
    </div>
</div>
