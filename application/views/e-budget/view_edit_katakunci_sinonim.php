<script language="javascript">
    function isalp(strString)
    //  check for valid numeric strings
    {
        var strValidChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ[],.()%$@ ";
        var strChar;
        var blnResult = true;

        if (strString.length == 0) return false;

        //  test strString consists of valid characters listed above
        for (i = 0; i < strString.length && blnResult == true; i++)
        {
            strChar = strString.charAt(i);
            if (strValidChars.indexOf(strChar) == -1)
            {
                blnResult = false;
            }
        }
        return blnResult;
    }
   
    function validate() {
        if (document.addsinonim.katakunci.value == "") {
            alert(" Harap masukan Kata Kunci !");
            document.addsinonim.katakunci.focus();
            return false;
        }
//        if (!isalp(document.addsinonim.katakunci.value)) {
//            alert(" Kata Kunci hanya boleh terdiri dari karakter dan angka serta [],.()%$@");
//            document.addsinonim.katakunci.focus();
//            return false;
//        }
        return true;
    }
</script>
<div id="tengah">
    <div id="judul" class="title">
        Tambah Kata Kunci
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <form class="appnitro" name="addsinonim" enctype="multipart/form-data" method="post" action="<?php echo base_url() . 'index.php/e-budget/sinonim/edit_katakunci_action/'.$id.'/'.$pagesinonim; ?>" onsubmit="return validate();">
            <div>
                <table width="100%" height="100%">
                    <tr>
                        <td width="15%">Nama Sinonim</td>
                        <td width="85%">
                            <?php echo $nmsinonim;?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Kata Kunci</td>
                        <td width="85%">
                            <input type="text" name="katakunci" value="" />
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
                            <a href='<?php echo site_url()."/e-budget/sinonim/grid_katakunci/$id/$pagesinonim" ;?>'>
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
        </form>        
    </div>
</div>