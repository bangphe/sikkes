<script language="javascript">
    function isalp(strString)
    //  check for valid numeric strings
    {
        var strValidChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
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
        if (document.addsinonim.sinonim.value == "") {
            alert(" Harap masukan Sinonim !");
            document.addsinonim.sinonim.focus();
            return false;
        }
        if (!isalp(document.addsinonim.sinonim.value)) {
            alert(" Sinonim hanya boleh terdiri dari karakter dan angka !");
            document.addsinonim.sinonim.focus();
            return false;
        }
        return true;
    }
</script>
<div id="tengah">
    <div id="judul" class="title">
        Tambah Sinonim Negatif
        <!--
        <label class="edit"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo  base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <form class="appnitro" name="addsinonim" enctype="multipart/form-data" method="post" action="<?php echo  base_url() . 'index.php/e-budget/sinonim/add_sinonim_negatif_action'; ?>" onsubmit="return validate();">
            <div>
                <table width="100%" height="100%">
                    <tr>
                        <td width="15%">Nama Sinonim</td>
                        <td width="85%">
                            <input type="text" name="sinonim" id="sinonim"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%">  
                            <div class="buttons">
                                <button type="submit" class="regular" name="submit">
                                    <img src="<?php echo  base_url(); ?>images/main/save.png" alt=""/>
                                    Tambah
                                </button>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo  $error; ?></td>
                        <td width="85%">

                        </td>
                    </tr>
                </table>
            </div>
        </form>        
    </div>
</div>

