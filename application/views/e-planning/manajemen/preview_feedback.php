<html>
<head>
</head>
<body>
<div width="600px" align="center">
	  <table width="600px" border="0" align="center">
        <tr>
          <td colspan="3"><p align="right">&nbsp;</p>
            <p align="right"><?php echo $tanggal; ?></p></td>
        </tr>
        <tr>
          <td>Nomor</td>
          <td colspan="2">: <?php echo $kode_surat.'/'.$nomor_surat.'/'.$tahun_surat; ?></td>
        </tr>
        <tr>
          <td>Hal</td>
          <td colspan="2">: Umpan balik usulan program / kegiatan <?php echo $judul; ?></td>
        </tr>
        <tr>
          <td colspan="3"><p>&nbsp;</p>
            <p><b>Yang terhormat,</b><br />
                <?php echo $nmsatker; ?><br />
                <?php echo $provinsi; ?></p>
            <h3>&nbsp;</h3>
            <p align="justify" >Menindaklanjuti surat Saudara nomor <?php echo $nomor_pengajuan; ?> tanggal <?php echo $tanggal_pengajuan; ?> tentang <?php echo $perihal; ?> dengan ini kami sampaikan umpan balik sebagai berikut:</p>
            <p align="justify"><?php echo $umpan_balik; ?></p>
            <p align="justify">Demikian kami sampaikan, atas perhatiannya kami ucapkan terima kasih. </p>
            <p align="justify">&nbsp;</p>
          <p align="justify"></p></td>
        </tr>
        <tr>
          <td width="109"><p>&nbsp;</p>          </td>
          <td width="221"><p align="center">&nbsp;</p></td>
          <td width="256"><p align="center">Kepala Biro Perencanaan dan Anggaran,</p>
            <p align="center">&nbsp;</p>
            <p align="center">&nbsp;</p>
            <p align="center">drg. Tini Suryanti Suhandi, M. Kes<br />
          195510151982012002</p></td>
        </tr>
        <tr>
          <td colspan="3"><?php if($kode_jenis_satker == 1 ||$kode_jenis_satker == 2){ ?>
            <p>Tembusan:</p>
            <p>1 -
              <?php foreach($this->mm->get_where('ref_unit_organisasi','KodeUnitOrganisasi',$kode_unit)->result() as $row) echo $row->NamaUnitOrganisasi;?>
              <br />
                <?php if($kode_jenis_satker ==1){?>
              2. ---Dinkes Provinsi/Kabupaten/Kota---</p>
            <p></p>
            <?php } ?>
            <?php } ?></td>
        </tr>
      </table>
</div>
</body>
</html>