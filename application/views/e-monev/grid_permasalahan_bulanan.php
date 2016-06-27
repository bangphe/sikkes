<script type="text/javascript">
    $(document).ready(function() {
        $("#form_tambah_masalah").hide();
        $("#form_edit_masalah").hide();
    });
    $("#load_masalah").click(function () {
        $("#form_edit_masalah").hide();
        $("#form_tambah_masalah").toggle("slow");
    }); 
    
    function save_data(id3, bulan){
        var permasalahan = $("#permasalahan").val();
        var pihak_terkait = $("#pihak_terkait").val();
        var ket_pihak_terkait = $("#ket_pihak_terkait").val();
        var status = $("#status").val();
        
        $("#data-table").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> saving...');
        $.ajax({
            url: '<?php echo  base_url() ?>index.php/e-monev/laporan_monitoring/save_masalah/'+id3+'/'+bulan,
            global: false,
            type: 'POST',
            async: false,
            dataType: 'html',
            data:{
                permasalahan:permasalahan,
                pihak_terkait:pihak_terkait,
                ket_pihak_terkait:ket_pihak_terkait,
                status:status
            },
            success: function (response) {
                update(id3, bulan, false);
            }
        });
        return false;
    }

    function reset(form)
    {
        if (form == 0){ //input form
            $('#permasalahan').val("");
            $('#pihak_terkait').val("0");
            $('#ket_pihak_terkait').val("");
            $('#status').val(0);
        }else{ // edit form
            $('#edit_permasalahan').val("");
            $('#edit_pihak_terkait').val("0");
            $('#edit_ket_pihak_terkait').val("");
            $('#edit_status').val(0);
        }
    }
    
    function edit(id){
        $("#form_tambah_masalah").hide();
        
        var url = '<?php echo  base_url() ?>index.php/e-monev/laporan_monitoring/get_masalah/'+id;
        $.getJSON(url, function(data) {
            $("#form_edit_masalah").show("slow", function(){
                $("#id_skmpnen").val(data.d_skmpnen_id);
                $("#bulan").val(data.bulan);
                $("#id_permasalahan").val(data.permasalahan_id);
                $("#edit_status option[value='"+data.status+"']").attr("selected", "selected");
                $("#edit_permasalahan").val(data.isi_permasalahan);
                $("#edit_pihak_terkait option[value='"+data.pihak_terkait+"']").attr("selected", "selected");
                $("#edit_ket_pihak_terkait").val(data.ket_pihak_terkait);
            });
        });
        return false;
    }
    
    function edit_data(){
        var id_skmpnen = $("#id_skmpnen").val();
        var bulan = $("#bulan").val();
        var id_permasalahan = $("#id_permasalahan").val();
        var permasalahan = $("#edit_permasalahan").val();
        var pihak_terkait = $("#edit_pihak_terkait option:selected").val();
        var ket_pihak_terkait = $("#edit_ket_pihak_terkait").val();
        var status = $("#edit_status option:selected").val();
        
        $("#data-table").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> saving...');
        $.ajax({
            url: '<?php echo  base_url() ?>index.php/e-monev/laporan_monitoring/update_masalah/',
            global: false,
            type: 'POST',
            async: false,
            dataType: 'html',
            data:{
                id_permasalahan:id_permasalahan,
                permasalahan:permasalahan,
                pihak_terkait:pihak_terkait,
                ket_pihak_terkait:ket_pihak_terkait,
                status:status
            },
            success: function (response) {
                update(id_skmpnen, bulan, false);
            }
        });
        return false;
    }
    
    function getUpaya(id){
        $("#content_tengah").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
        get_html_data(base_url+"index.php/e-monev/laporan_monitoring/get_upaya_penyelesaian/"+id,'', 'profile_detail_loading', 'content_tengah');
    }
	
	
    function getFeedback(id){
        $("#content_tengah").html('<img src="<?php echo  base_url() . 'images/flexigrid/load.gif'; ?>"> loading...');
        get_html_data(base_url+"index.php/e-monev/laporan_monitoring/input_feedback/"+id,'', 'profile_detail_loading', 'content_tengah');
    }
</script>

<h2 class="tablecloth">Tahun Anggaran : <?php echo  $this->session->userdata('thn_anggaran'); ?></h2>
<h2 class="tablecloth">Bulan : <?php echo  $bulan; ?></h2>
<h2 class="tablecloth">Nama Komponen/Sub Komponen : <?php echo  $sub_komponen; ?></h2>

<div>
    <?php echo  anchor(site_url('e-monev/laporan_monitoring/input_masalah/' . $d_skmpnen_id . '#'), img(array('src' => 'images/flexigrid/prev.gif', 'border' => '0', 'alt' => '')) . 'Kembali Ke Daftar Permasalahan', array('onclick' => 'kembali(' . $d_skmpnen_id . ');;return false;')); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="#" id="load_masalah"><img src="<?php echo  base_url() . 'images/flexigrid/add.png'; ?>"/>Tambah Permasalahan</a>
</div>

<div id="form_tambah_masalah">
    <?php $this->load->view('e-monev/form_input_masalah'); ?>
</div>
<div id="form_edit_masalah">
    <?php $this->load->view('e-monev/form_edit_masalah'); ?>
</div>
<br/>

<div id="data-table">
<table class="tablecloth" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <th>No</th>
        <th>Permasalahan</th>
        <th>Pihak Terkait</th>
        <th>Keterangan Pihak Terkait</th>
        <th>Status</th>
        <th>Edit Permasalahan</th>
        <th>Feedback</th>
        <th>Upaya Penyelesaian</th>
    </tr>
    <?php
    $no = 1;
    foreach ($daftar_permasalahan as $row) {
		
		if($row->status == 0){
			$feedback = '<a href=\'#\'><img border=\'0\' onclick="getFeedback(' . $row->permasalahan_id . ');" src="' . base_url() . 'images/icon/iconedit.png">';
		}else{
			$feedback = '<a href=\'#\' style="cursor:default;"><img border=\'0\' src="' . base_url() . 'images/icon/iconedit-disabled.png">';
		}
        ?>
        <tr>
            <td><?php echo  $no; ?></td>
            <td><?php echo  $row->isi_permasalahan; ?></td>
            <td><?php echo  $row->pihak_terkait == 0 ? 'Internal' : 'Eksternal'; ?></td>
            <td><?php echo  $row->ket_pihak_terkait ?></td>
            <td><?php echo  $row->status == 0 ? 'Belum Resolved' : 'Sudah Resolved'; ?></td>                
            <td><?php echo  '<a href=\'#\'><img border=\'0\' onclick="edit(' . $row->permasalahan_id . ',' . $row->bulan . ');" src=\'' . base_url() . 'images/icon/iconedit.png\'></a></td>'; ?></td>
            <td><?php echo  $feedback; ?></td>
            <td><?php echo  '<a href=\'#\' onclick="getUpaya(' . $row->permasalahan_id . ');">Ada ' . $row->jml_penyelesaian . ' upaya penyelesaian</a></td>'; ?></td>
        </tr>
        <?php $no++;
    } ?>
</table>
</div>