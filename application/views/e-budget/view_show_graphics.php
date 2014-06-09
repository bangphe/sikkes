<div id="tengah">
    <div id="judul"  class="title">
        Laporan Grafik
        <!--
        <label class="edit"><a href="#"><img src="<?php echo base_url(); ?>images/icons/Edit_icon.png" /></a></label>
        <label class="detail"><a href="#"><img src="<?php echo base_url(); ?>images/icons/detail.png" /></a></label>
        -->
    </div>
    <div id="content_tengah">
        <table border="0">
            <tbody>
                <tr>
                    <td class="title">Nama Unit : <?php echo $nmunit; ?>
                    </td>
                </tr>
                <tr>
                    <td class="title">Nama Satker : <?php echo $nmsatker; ?>
                    </td>
                </tr>
                <tr>
                    <td class="title">Jenis Laporan : <?php echo $nmtype; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b1">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b2">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b3">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b4">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b5">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b6">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b7">
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="b8">
                            
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <script language="JavaScript">
            var strXML = "";
            var chart1 = "";
            <?php
            $count = 0;
            foreach ($chart as $key => $value) {
                $count++;
            ?>
                strXML = "<?php echo $value; ?>";
                chart1 = new FusionCharts("http://202.70.136.72/charts/Pie3D.swf", "<?php echo $count ?>", "1100", "600");
                chart1.setDataXML(strXML);
                chart1.render("b<?php echo $count ?>");
            <?php
            }
            ?>
        </script>
    </div>
</div>
