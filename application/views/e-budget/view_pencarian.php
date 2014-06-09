<div id="tengah">
    <div id="judul" class="title">
        <?php if ($type=="0") { ?>
        Pencarian
        <?php
        } else {
        ?>
        Rekap Rincian
        <?php
        }
        ?>
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <script language="JavaScript">
            function unitChanged() {
                var unit = document.pencarian.unit;
                var satker = document.pencarian.satker;
                var program = document.pencarian.program;

                var selected = unit.options[unit.selectedIndex].value;

                for (var i=(satker.options.length-1); i>=0; i--) {
                    satker.options[i] = null;
                }
                for (var i=(program.options.length-1); i>=0; i--) {
                    program.options[i] = null;
                }
        
                if (selected == "0") {
                    var opt = new Option("SEMUA SATKER", "0", true);
                    satker.options.add(opt);
                    var opt = new Option("SEMUA PROGRAM", "0", true);
                    program.options.add(opt);                    
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
                    opt = new Option("SEMUA PROGRAM", "0", true);
                    program.options.add(opt);
                    if (selected != "") {
                        var i = 0;
                        for (var key in kdunit_p[selected]) {
                            var value = kdunit_p[selected][key];
                            i++;
                            var opt = new Option(value, key, false);
                            program.options.add(opt);
                        }
                    }
                }
                programChanged();
                return true;
            }

            function programChanged() {
                var program = document.pencarian.program;
                var kegiatan = document.pencarian.kegiatan;

                var selected = program.options[program.selectedIndex].value;

                for (var i=(kegiatan.options.length-1); i>=0; i--) {
                    kegiatan.options[i] = null;
                }

                if (selected == "0") {
                    var opt = new Option("SEMUA KEGIATAN", "0", true);
                    kegiatan.options.add(opt);
                }
                else {
                    var opt = new Option("SEMUA KEGIATAN", "0", true);
                    kegiatan.options.add(opt);
                    if (selected != "") {
                        var i=0;
                        for (var key in kdprogram[selected]) {
                            var value = kdprogram[selected][key];
                            i++;
                           
                            var opt = new Option(value, key, false);
                            kegiatan.options.add(opt);
                        }
                    }
                }
                kegiatanChanged();
                return true;
            }

            function kegiatanChanged() {
                var kegiatan = document.pencarian.kegiatan;
                var ikk = document.pencarian.ikk;

                var selected = kegiatan.options[kegiatan.selectedIndex].value;

                for (var i=(ikk.options.length-1); i>=0; i--) {
                    ikk.options[i] = null;
                }

                if (selected == "0") {
                    var opt = new Option("SEMUA IKK", "0", true);
                    ikk.options.add(opt);
                }
                else {
                    var opt = new Option("SEMUA IKK", "0", true);
                    ikk.options.add(opt);
                    var i=0;
                    if (selected != "") {
                        for (var key in kdgiat[selected]) {
                            var value = kdgiat[selected][key];
                            i++;
                            
                            var opt = new Option(value, key, false);
                            ikk.options.add(opt);
                        }
                    }
                }

                return true;
            }


            function createChecks(){
                var belanja = document.pencarian.belanja;
        
                var _div = document.getElementById("container_akun");
                var el;
                //first remove all existing checkboxes
                while(_div.hasChildNodes(  )){
                    for(var i = 0; i < _div.childNodes.length; i++){
                        _div.removeChild(_div.firstChild);
                    }
            
                }
        
                for (var key in kdakun) {
                    var value = kdakun[key];
            
                    var keybelanja = key.substring(0, 2);
            
                    if (keybelanja == belanja.options[belanja.selectedIndex].value) {
                        el = document.createElement("input");
                        el.setAttribute("type","checkbox");
                        el.setAttribute("name","akun[]");
                        el.setAttribute("value",key);
                        _div.appendChild(el);
                        _div.appendChild(document.createTextNode(value));
                        _div.appendChild(document.createElement("br"));
                    }
                }
            }
        </script>    
        <form class="appnitro" name="pencarian" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'index.php/e-budget/pencarian/result_pencarian/'.$type; ?>">
            <div>
                <table width="100%" height="100%">
                    <tr>
                        <td width="15%">Pilih Unit Utama</td>
                        <td width="85%">
                            <select id="unit" name="unit" onchange="unitChanged();">
                                <?php
                                foreach ($units as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Satker</td>
                        <td width="85%">
                            <select id="satker" name="satker" >
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Jenis Belanja</td>
                        <td width="85%">
                            <select id="belanja" name="belanja" onchange="createChecks();">
                                <option value="51" >BELANJA PEGAWAI</option>
                                <option value="52" >BELANJA BARANG</option>
                                <option value="53" >BELANJA MODAL</option>
                                <option value="57" >BELANJA BANTUAN SOSIAL</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Program</td>
                        <td width="85%">
                            <select id="program" name="program" onchange="programChanged();">
                                <?php
                                foreach ($programs as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Kegiatan</td>
                        <td width="85%">
                            <select id="kegiatan" name="kegiatan" onchange="kegiatanChanged();">

                            </select>
                        </td>
                    </tr>
                    <tr>
                    <script language="JavaScript">
                        function toggleLocation(source) {
                            checkboxes = document.getElementsByName('lokasi[]');
                            for (var i=0;i<checkboxes.length;i++) {
                                checkboxes[i].checked = source.checked;
                            }
                        }
                    </script>

                    <td width="15%">Pilih Lokasi</td>
                    <td width="85%">
                        <input type="checkbox" name="alllokasi" value="0" onClick="toggleLocation(this)"/>SEMUA LOKASI<br />
                        <div class="container" style="border:2px solid #ccc; width:1000px; height: 200px; overflow-y: scroll;">
                            <?php
                            foreach ($lokasis as $key => $value) {
                                ?>
                                <input type="checkbox" name="lokasi[]" value="<?php echo $key; ?>" /><?php echo $value; ?><br />
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <script language="JavaScript">
                        function toggleAkun(source) {
                            checkboxes = document.getElementsByName('akun[]');
                            for (var i=0;i<checkboxes.length;i++) {
                                checkboxes[i].checked = source.checked;
                            }
                        }
                    </script>
                    <td width="15%">Pilih Akun</td>
                    <td width="85%">
                        <input type="checkbox" name="allakun" value="0" onClick="toggleAkun(this)"/>SEMUA AKUN<br />
                        <div class="container_akun" id="container_akun" style="border:2px solid #ccc; width:1000px; height: 200px; overflow-y: scroll;">
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <script language="JavaScript">
                        function toggleBeban(source) {
                            checkboxes = document.getElementsByName('beban[]');
                            for (var i=0;i<checkboxes.length;i++) {
                                checkboxes[i].checked = source.checked;
                            }
                        }
                    </script>
                    <td width="15%">Pilih Sumber Pembiayaan</td>
                    <td width="85%">
                        <input type="checkbox" name="allbeban" value="0" onClick="toggleBeban(this)"/>SEMUA SUMBER PEMBIAYAAN<br />
                        <div class="container" style="border:2px solid #ccc; width:1000px; height: 190px; overflow-y: scroll;">
                            <?php
                            foreach ($bebans as $key => $value) {
                                ?>
                                <input type="checkbox" name="beban[]" value="<?php echo $key; ?>" /><?php echo $value; ?><br />
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                    </tr>
                    <tr>
                    <script language="JavaScript">
                        function toggleKewenangan(source) {
                            checkboxes = document.getElementsByName('jenissat[]');
                            for (var i=0;i<checkboxes.length;i++) {
                                checkboxes[i].checked = source.checked;
                            }
                        }
                    </script>
                    <td width="15%">Pilih Kewenangan</td>
                    <td width="85%">
                        <input type="checkbox" name="allkewenangan" value="0" onClick="toggleKewenangan(this)"/>SEMUA KEWENANGAN<br />
                        <div class="container" style="border:2px solid #ccc; width:1000px; height: 130px; overflow-y: scroll;">
                            <?php
                            foreach ($jenissats as $key => $value) {
                                ?>
                                <input type="checkbox" name="jenissat[]" value="<?php echo $key; ?>" /><?php echo $value; ?><br />
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Ikk</td>
                        <td width="85%">
                            <select id="ikk" name="ikk">

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Reformasi Kesehatan</td>
                        <td width="85%">
                            <select id="reformasi_kesehatan" name="reformasi_kesehatan">
                                <option value="0" >SEMUA REFORMASI KESEHATAN</option>
                                <?php
                                foreach ($reformasi_kesehatans as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Fokus Prioritas</td>
                        <td width="85%">
                            <select id="fokus_prioritas" name="fokus_prioritas">
                                <option value="0" >SEMUA FOKUS PRIORITAS</option>
                                <?php
                                foreach ($fokus_prioritass as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%">  
                            <div class="buttons">
                                <button type="submit" class="regular" name="submit">
                                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                                    Cari
                                </button>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <script language="javascript">
                unitChanged();
                programChanged();
                kegiatanChanged();
                createChecks();
            </script>    
        </form>        
    </div>
</div>

