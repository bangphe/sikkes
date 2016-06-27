<?php
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<p align="center"><b>Tahun Anggaran : </b><?php echo  $this->session->userdata('thn_anggaran');?></p>
<br />
<p align="center"><b>Nama Komponen/Sub Komponen : </b><?php echo  $sub_komponen;?></p>
<br />
<hr />
<?php
echo $graph;
?>
<div id="chartdiv" align="center"> 
</div>
