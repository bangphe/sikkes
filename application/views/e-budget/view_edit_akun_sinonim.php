<div id="tengah">
    <div id="judul" class="title">
        Tambah Akun
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <form class="appnitro" name="addsinonim" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'index.php/e-budget/sinonim/edit_akun_action/'.$id.'/'.$pagesinonim; ?>">
            <script>
                function createChecks(){
                    var belanja = document.addsinonim.belanja;

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
            <div>
                <table width="100%" height="100%">
                    <tr>
                        <td width="15%">Nama Sinonim</td>
                        <td width="85%">
                            <?php echo $nmsinonim;?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Pilih Jenis Belanja</td>
                        <td width="85%">
                            <select id="belanja" name="belanja" onchange="createChecks();">
                                <option value="51">BELANJA PEGAWAI</option>
                                <option value="52">BELANJA BARANG</option>
                                <option value="53">BELANJA MODAL</option>
                                <option value="57">BELANJA BANTUAN SOSIAL</option>
                            </select>
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
                        <td width="15%"></td>
                        <td width="85%">  
                            <div class="buttons">
                                <button type="submit" class="regular" name="submit">
                                    <img src="<?php echo base_url(); ?>images/main/save.png" alt=""/>
                                    Tambah
                                </button>
                            </div>
                            <a href='<?php echo site_url()."/e-budget/sinonim/grid_akun/$id/$pagesinonim" ;?>'>
                                <div class="buttons">
                                    <button type="button" class="regular" name="submit">
                                        <img src="<?php echo base_url(); ?>images/main/back.png" alt=""/>
                                        Kembali
                                    </button>
                                </div>
                            </a>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $error; ?></td>
                        <td width="85%">
                            
                        </td>
                    </tr>
                </table>
            </div>
<script language="javascript">
        createChecks();
</script>    
        </form>        
    </div>
</div>