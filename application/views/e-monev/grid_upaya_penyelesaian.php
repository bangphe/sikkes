<script type="text/javascript">
    $(document).ready(function() {
        $("#form_tambah_penyelesaian").hide();
        $("#form_edit_penyelesaian").hide();
    });
    $("#load_penyelesaian").click(function () {
        $("#form_edit_penyelesaian").hide();
        $("#form_tambah_penyelesaian").toggle("slow");
    }); 
    
    function save_upaya(id_permasalahan){
        var detail_penyelesaian = $("#detail_penyelesaian").val();
        
        $("#data-table").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> saving...');
        $.ajax({
            url: '<?= base_url() ?>index.php/e-monev/laporan_monitoring/save_penyelesaian/'+id_permasalahan,
            global: false,
            type: 'POST',
            async: false,
            dataType: 'html',
            data:{
                detail_penyelesaian:detail_penyelesaian
            },
            success: function (response) {
                getUpaya(id_permasalahan);
            }
        });
        return false;
    }

    function reset_upaya(form)
    {
        if (form == 0) // input form
            $('#detail_penyelesaian').val("");
        else // edit form
            $('#edit_detail_penyelesaian').val("");
    }
    
    function edit(id){
        $("#form_tambah_penyelesaian").hide();
        
        var url = '<?= base_url() ?>index.php/e-monev/laporan_monitoring/get_penyelesaian/'+id;
        $.getJSON(url, function(data) {
            $("#form_edit_penyelesaian").show("slow", function(){
                $("#id_upaya_penyelesaian").val(data.id_upaya_penyelesaian);
                $("#id_permasalahan").val(data.id_permasalahan);
                $("#edit_detail_penyelesaian").val(data.detail_penyelesaian);
            });
        });
        return false;
    }
    
    function update_upaya(){
        var id_upaya_penyelesaian = $("#id_upaya_penyelesaian").val();
        var id_permasalahan = $("#id_permasalahan").val();
        var detail_penyelesaian = $("#edit_detail_penyelesaian").val();
        
        $("#data-table").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> saving...');
        $.ajax({
            url: '<?= base_url() ?>index.php/e-monev/laporan_monitoring/update_penyelesaian/'+id_upaya_penyelesaian,
            global: false,
            type: 'POST',
            async: false,
            dataType: 'html',
            data:{
                detail_penyelesaian:detail_penyelesaian
            },
            success: function (response) {
                getUpaya(id_permasalahan);
            }
        });
        return false;
    }
    
    function hapus(id_permasalahan, id_penyelesaian){
        $("#data-table").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
        $.ajax({
            url: '<?= base_url() ?>index.php/e-monev/laporan_monitoring/hapus_penyelesaian/',
            global: false,
            type: 'POST',
            async: false,
            dataType: 'html',
            data:{
                id_penyelesaian:id_penyelesaian
            },
            success: function (response) {
                getUpaya(id_permasalahan);
            }
        });
        return false;
    } 
    
    function getUpaya(id){
        $("#content_tengah").html('<img src="<?php echo base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
        get_html_data(base_url+"index.php/e-monev/laporan_monitoring/get_upaya_penyelesaian/"+id,'', 'profile_detail_loading', 'content_tengah');
    }
</script>

<h2 class="tablecloth">Tahun Anggaran : <?php echo $this->session->userdata('thn_anggaran'); ?></h2>
<h2 class="tablecloth">Bulan : <?php echo $bulan; ?></h2>
<h2 class="tablecloth">Nama Komponen/Sub Komponen : <?php echo $sub_komponen; ?></h2>

<table width=550>
    <tr>
        <td><b>Status</b></td>
        <td><?php echo $data_masalah->status == 0 ? 'Belum Resolved' : 'Sudah Resolved'; ?></td>

        <td><b>Pihak Terkait</b></td>
        <td><?php echo $data_masalah->pihak_terkait == 0 ? 'Internal' : 'Eksternal'; ?></td>
    </tr>
    <tr>
        <td><b>Permasalahan</b></td>
        <td><?php echo $data_masalah->isi_permasalahan; ?></td>
        <td><b>Keterangan Pihak Terkait</b></td>
        <td>
            <?php echo $data_masalah->ket_pihak_terkait; ?>
        </td>
    </tr>
</table>

<br/>
<div>
    <?= anchor(site_url('e-monev/laporan_monitoring/input_masalah/' . $data_masalah->d_skmpnen_id . '#'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Daftar Permasalahan', array('onclick' => 'update(' . $data_masalah->d_skmpnen_id . ',' . $data_masalah->bulan . ', true);;return false;')); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="#" id="load_penyelesaian"><img src="<?php echo base_url() . 'images/flexigrid/add.png'; ?>"/>Tambah Penyelesaian</a>
</div>

<div id="form_tambah_penyelesaian">
    <?php $this->load->view('e-monev/form_input_penyelesaian'); ?>
</div>
<div id="form_edit_penyelesaian">
    <?php $this->load->view('e-monev/form_edit_penyelesaian'); ?>
</div>
<br/>

<div id="data-table">
<table class="tablecloth" cellspacing="0" cellpadding="0" width="550">
    <tr>
        <th>No</th>        
        <th>Upaya Penyelesaian</th>
        <th>Edit Upaya</th>
        <th>Hapus Upaya</th>
    </tr>
    <?php
    $no = 1;
    foreach ($daftar_penyelesaian->result() as $row) {
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $row->detail_penyelesaian; ?></td>            
            <td><?php echo '<a href=\'#\'><img border=\'0\' onclick="edit(' . $row->id_upaya_penyelesaian . ');" src=\'' . base_url() . 'images/icon/iconedit.png\'></a></td>'; ?></td>
            <td><?php echo '<a href=\'#\'><img border=\'0\' onclick="hapus(' . $row->id_permasalahan . ',' . $row->id_upaya_penyelesaian . ');" src=\'' . base_url() . 'images/flexigrid/hapus.png\'></a></td>'; ?></td>
        </tr>
        <?php $no++;
    }
    ?>
</table>
</div>
