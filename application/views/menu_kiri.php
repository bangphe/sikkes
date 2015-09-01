<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div> <!--This is the first division of left-->
  <div id="firstpane" class="menu_list"> <!--Code for menu starts here-->
		<p class="menu_head"><?= anchor(site_url('beranda'),'Halaman Utama','Menampilkan halaman utama'); ?></p>
		<p class="menu_head"><??> Rencana Kerja Kementerian</p>
		<?php $this->load->model('role_model'); ?>
		<div class="menu_body" align="left">
		  <? //anchor(site_url().'/e-planning/prioritas/pilihan_prioritas/3',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Prioritas Kelembagaan',''); ?>
	       <? //anchor(site_url().'/e-planning/prioritas/pilihan_prioritas/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Prioritas Nasional',''); ?>
		   <? //anchor(site_url().'/e-planning/prioritas/pilihan_prioritas/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Prioritas Bidang',''); ?>
		   <?= anchor(site_url().'/e-planning/prioritas/grid',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Prioritas',''); ?>
		   <?= anchor(site_url().'/e-planning/rencana_kinerja_kementrian/grid_visi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Visi',''); ?>
		   <?= anchor(site_url().'/e-planning/rencana_kinerja_kementrian/grid_misi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Misi',''); ?>
	       <?= anchor(site_url().'/e-planning/rencana_kinerja_kementrian/grid_sasaran',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Sasaran Strategis',''); ?>
		   <?= anchor(site_url().'/e-planning/fokus_prioritas/grid_fokus_prioritas',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Fokus Prioritas',''); ?>
		   <?= anchor(site_url().'/master_data/master_reformasi_kesehatan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Reformasi Kesehatan',''); ?>
		</div>
		
		<p class="menu_head"><??> Rencana Kerja Satker</p>
		<div class="menu_body" align="left">
		   <?= anchor(site_url().'/e-planning/referensi2/grid_visi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Visi',''); ?>
		   <?= anchor(site_url().'/e-planning/referensi2/grid_misi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Misi',''); ?>
		   <?= anchor(site_url().'/e-planning/referensi2/grid_sasaran',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Sasaran Satker',''); ?>
		<?php /*   <?= anchor(site_url().'/e-planning/prioritas/prioritas_satker/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Prioritas',''); ?> */ ?>
		   <?= anchor(site_url().'/e-planning/master/grid_tupoksi/'.$this->session->userdata('kdsatker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Tupoksi',''); ?>
		</div>
<?php if($this->session->userdata('kd_role') == Role_model::ADMIN){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		<?php $this->db->select('*');
							$this->db->from($this->db->database.'.ref_tupoksi');
							$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
							$return = $this->db->get();
							
							if($return->num_rows() < 1)	{
						  echo '<a href="#" onclick="alert(\'Tupoksi belum ada. Silakan mengisi tupoksi terlebih dahulu di menu Rencana Kerja Satker\')"><img src="'.base_url().'images/icon/doc.png" alt="Test 1" /> Ajukan Proposal</a>';
						  } else {
							echo '<a href="'.site_url().'/e-planning/pendaftaran/tambah_usulan"><img src="'.base_url().'images/icon/doc.png" alt="Test 1" /> Ajukan Proposal</a>';
						  }
						  ?>
          <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
			<?= anchor(site_url().'/e-planning/manajemen/grid_persetujuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Persetujuan',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?>
			<?= anchor(site_url().'/e-planning/manajemen/grid_pertimbangan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Dipertimbangkan',''); ?>
			<?= anchor(site_url().'/e-planning/filtering',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pencarian',''); ?>
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
			<?= anchor(site_url().'/e-planning/utility/load_rekap',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Rekap',''); ?>
			<?= anchor(site_url('login/chart2'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Grafik','Menampilkan Grafik Persetujuan Satker'); ?>
		</div>
		<p class="menu_head"><??> E-Budgeting</p>
		<div class="menu_body" align="left">
            <?= anchor(site_url().'/e-budget/import',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Import RKA-KL','');?>
            <?//= anchor(site_url().'/e-budget/mapping/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
            <?= anchor(site_url().'/e-budget/mapping_output',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
			<?= anchor(site_url().'/e-budget/feedback/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Feedback','');?>
			<?= anchor(site_url().'/e-budget/sinonim/index/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Sinonim Positif','');?>
			<?= anchor(site_url().'/e-budget/sinonim/index/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Sinonim Negatif','');?>
			<?= anchor(site_url().'/e-budget/akungroup/grid_akungroup/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Akun Group','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian Canggih','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian Canggih','');?>
            <!--<?= anchor(site_url().'/e-budget/pencarian/form_pencarian/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian','');?>-->
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Unit/Satker','');?>
            <?= anchor(site_url().'/e-budget/graphics/form_graphics',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Grafik','');?>
			<?= anchor(site_url().'/e-budget/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		</div>
		<p class="menu_head"><??> E-Monev</p>
		<div class="menu_body" align="left">
          <?= anchor(site_url('e-monev/dashboard'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Kementerian',''); ?>
          <?= anchor(site_url('e-monev/dashboard_satker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Satker',''); ?>
		  <?= anchor(site_url('e-monev/dashboard_unit'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Unit Utama',''); ?>
		  <?= anchor(site_url('e-monev/laporan_monitoring'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Monitoring',''); ?>
          <!--<?= anchor(site_url('e-monev/laporan_evaluasi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Evaluasi',''); ?>-->
          <?= anchor(site_url('e-monev/laporan_kinerja'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Kinerja Kementrian',''); ?>
		</div>
		<p class="menu_head"><??>Referensi</p>
		<div class="menu_body" align="left" style="overflow:auto; max-height:210px">
		   <?php /*?><?= anchor(site_url().'/master_data/master_departemen',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Departemen',''); ?><?php */?>
	       <?= anchor(site_url().'/master_data/master_fungsi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Fungsi',''); ?>
		   <?= anchor(site_url().'/master_data/master_subfungsi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Sub Fungsi',''); ?>
	       <?= anchor(site_url().'/master_data/master_propinsi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Provinsi',''); ?>
		   <?= anchor(site_url().'/master_data/master_tahun_anggaran',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Tahun Anggaran',''); ?>
		   <?= anchor(site_url().'/master_data/master_program',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Program',''); ?>
		   <?= anchor(site_url().'/e-planning/referensi2/grid_periode',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Periode',''); ?>
		   <?= anchor(site_url().'/master_data/master_kegiatan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kegiatan',''); ?>
		   <?= anchor(site_url().'/master_data/master_ikk',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' IKK',''); ?>
		   <?= anchor(site_url().'/master_data/master_menu_kegiatan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Menu Kegiatan',''); ?>
		   <?= anchor(site_url().'/master_data/master_iku',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' IKU',''); ?>
		   <?= anchor(site_url().'/master_data/master_satker',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Satker',''); ?>
		   <?= anchor(site_url().'/master_data/master_kabupaten',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kabupaten',''); ?>
           <?= anchor(site_url().'/master_data/master_satuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Satuan',''); ?>     
           <?= anchor(site_url().'/master_data/master_jenis_pembiayaan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Pembiayaan',''); ?>    
           <?= anchor(site_url().'/master_data/master_kanwil',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kanwil',''); ?>    
           <?= anchor(site_url().'/master_data/master_unit',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Unit',''); ?>    
           <?= anchor(site_url().'/master_data/master_pegawai',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pegawai',''); ?> 
           <?= anchor(site_url().'/master_data/master_jenis_kewenangan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Kewenangan',''); ?>
           <?= anchor(site_url().'/master_data/master_jenis_usulan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Usulan',''); ?>
           <?//= anchor(site_url().'/e-monev/master_bank',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Bank',''); ?>
		   <?= anchor(site_url('e-monev/laporan_monitoring/referensi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Ketentuan Pengisian Progres',''); ?>
           <?= anchor(site_url('master_data/master_kppn'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' KPPN',''); ?>
           <?= anchor(site_url('master_data/master_jenis_satker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Satker',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::PENGUSUL){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		<?php $this->db->select('*');
							$this->db->from('ref_tupoksi');
							$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
							$return = $this->db->get();
							
							if($return->num_rows() < 1)	{
						  echo '<a href="#" onclick="alert(\'Tupoksi belum ada. Silakan mengisi tupoksi terlebih dahulu di menu Rencana Kerja Satker\')"><img src="'.base_url().'images/icon/doc.png" alt="Test 1" /> Ajukan Proposal</a>';
						  } else {
							echo  '<a href="'.site_url().'/e-planning/pendaftaran/tambah_usulan"><img src="'.base_url().'images/icon/doc.png" alt="Test 1" /> Ajukan Proposal</a>';
						  }
						  ?>
          <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::PENELAAH){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		  <?//= anchor(site_url().'/e-planning/pendaftaran/pengajuan_step1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Ajukan Proposal',''); ?>
          <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_persetujuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Persetujuan',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?>
			<?= anchor(site_url().'/e-planning/manajemen/grid_pertimbangan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Dipertimbangkan',''); ?>
			<?= anchor(site_url().'/e-planning/filtering',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pencarian',''); ?>
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::DIREKTORAT) { ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?>
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		</div>
<?php }?>
<?php if($this->session->userdata('kd_role') == Role_model::VERIFIKATOR){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		  <?//= anchor(site_url().'/e-planning/pendaftaran/pengajuan_step1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Ajukan Proposal',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?>
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		</div>
		<p class="menu_head"><??> E-Budgeting</p>
		<div class="menu_body" align="left">
            <?= anchor(site_url().'/e-budget/import',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Import RKA-KL','');?>
            <?//= anchor(site_url().'/e-budget/mapping/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
            <?= anchor(site_url().'/e-budget/mapping_output',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
			<?= anchor(site_url().'/e-budget/feedback/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Feedback','');?>
			<?= anchor(site_url().'/e-budget/sinonim/grid_sinonim/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Sinonim','');?>
			<?= anchor(site_url().'/e-budget/akungroup/grid_akungroup/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Akun Group','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian Canggih','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian Canggih','');?>
            <!--<?= anchor(site_url().'/e-budget/pencarian/form_pencarian/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian','');?>-->
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Unit/Satker','');?>
            <?= anchor(site_url().'/e-budget/graphics/form_graphics',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Grafik','');?>
			<?= anchor(site_url().'/e-budget/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		
		</div>
		<p class="menu_head"><??> E-Monev</p>
		<div class="menu_body" align="left">
          <?//= anchor(site_url('e-monev/dashboard'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?> 
          <?= anchor(site_url('e-monev/dashboard_satker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Satker',''); ?>
<?php if($this->session->userdata('kodejenissatker') == 2){ ?>
		  <?//= anchor(site_url('e-monev/dashboard_propinsi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Propinsi',''); ?>
<?php } ?>
<?php if($this->session->userdata('kodejenissatker') == 3){ ?>
		  <?= anchor(site_url('e-monev/dashboard_unit'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Unit Utama',''); ?>
<?php } ?>
		  <?= anchor(site_url('e-monev/laporan_monitoring'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Monitoring',''); ?>
          <!--<?= anchor(site_url('e-monev/laporan_evaluasi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Evaluasi',''); ?>-->
          <?= anchor(site_url('e-monev/laporan_kinerja'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Kinerja Kementrian',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::PENYETUJU){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		  <?//= anchor(site_url().'/e-planning/pendaftaran/pengajuan_step1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Ajukan Proposal',''); ?>
          <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_persetujuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Persetujuan',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?>
			<?= anchor(site_url().'/e-planning/manajemen/grid_pertimbangan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Dipertimbangkan',''); ?>
			<?= anchor(site_url().'/e-planning/filtering',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pencarian',''); ?>
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::ADMIN_PLANNING){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
		<?php $this->db->select('*');
							$this->db->from('ref_tupoksi');
							$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
							$return = $this->db->get();
							
							if($return->num_rows() < 1)	{
						  echo '<a href="#" onclick="alert(\'Tupoksi belum ada. Silakan mengisi tupoksi terlebih dahulu di menu Rencana Kerja Satker\')"><img src="'.base_url().'images/icon/doc.png" alt="Test 1" /> Ajukan Proposal</a>';
						  } else {
							echo '<a href="'.site_url().'/e-planning/pendaftaran/tambah_usulan"><img src="'.base_url().'images/icon/doc.png" alt="Test 1" /> Ajukan Proposal</a>';
						  }
						  ?>
          <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal',''); ?>
			<?= anchor(site_url().'/e-planning/manajemen/grid_persetujuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Persetujuan',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_disetujui',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Disetujui',''); ?>
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_ditolak',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Ditolak',''); ?> 
		  <?= anchor(site_url().'/e-planning/manajemen/grid_pengajuan_telah_ditelaah',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Telah Ditelaah',''); ?>
			<?= anchor(site_url().'/e-planning/manajemen/grid_pertimbangan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Proposal Dipertimbangkan',''); ?>
			<?= anchor(site_url().'/e-planning/filtering',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pencarian',''); ?>
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
			<?= anchor(site_url().'/e-planning/utility/load_rekap',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Rekap',''); ?>
			<?= anchor(site_url('login/chart2'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Grafik','Menampilkan Grafik Persetujuan Satker'); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::PEMBUAT_ANGGARAN){ ?>
		<p class="menu_head"><??> E-Budgeting</p>
		<div class="menu_body" align="left">
            <?= anchor(site_url().'/e-budget/import',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Import RKA-KL','');?>
            <?//= anchor(site_url().'/e-budget/mapping/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
            <?= anchor(site_url().'/e-budget/mapping_output',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
			<?= anchor(site_url().'/e-budget/feedback/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Feedback','');?>
			<?= anchor(site_url().'/e-budget/sinonim/grid_sinonim/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Sinonim','');?>
			<?= anchor(site_url().'/e-budget/akungroup/grid_akungroup/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Akun Group','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian Canggih','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian Canggih','');?>
            <!--<?= anchor(site_url().'/e-budget/pencarian/form_pencarian/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian','');?>-->
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Unit/Satker','');?>
            <?= anchor(site_url().'/e-budget/graphics/form_graphics',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Grafik','');?>
		
		</div>
		<?php } ?>
		<!--
		<p class="menu_head"><??> E-Budgeting</p>
		<div class="menu_body" align="left">
		  <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Daftar Anggaran',''); ?>
		</div>
		-->
<?php if($this->session->userdata('kd_role') == Role_model::ADMIN_BUDGETING){ ?>
		<p class="menu_head"><??> E-Budgeting</p>
		<div class="menu_body" align="left">
            <?= anchor(site_url().'/e-budget/import',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Import RKA-KL','');?>
            <?//= anchor(site_url().'/e-budget/mapping/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
            <?= anchor(site_url().'/e-budget/mapping_output',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Mapping Output','');?>
			<?= anchor(site_url().'/e-budget/feedback/form_mapping',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Feedback','');?>
			<?= anchor(site_url().'/e-budget/sinonim/grid_sinonim/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Sinonim','');?>
			<?= anchor(site_url().'/e-budget/akungroup/grid_akungroup/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Akun Group','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian Canggih','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian Canggih','');?>
            <!--<?= anchor(site_url().'/e-budget/pencarian/form_pencarian/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian','');?>-->
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Unit/Satker','');?>
            <?= anchor(site_url().'/e-budget/graphics/form_graphics',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Grafik','');?>
			<?= anchor(site_url().'/e-budget/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		
		</div>
		<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN){ ?>
		<p class="menu_head"><??> E-Monev</p>
		<div class="menu_body" align="left">
          <?= anchor(site_url('e-monev/dashboard_satker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Satker',''); ?>
		  <?= anchor(site_url('e-monev/laporan_monitoring'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Monitoring',''); ?>
          <?= anchor(site_url('e-monev/laporan_kinerja'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Kinerja Kementrian',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::ADMIN_MONEV){ ?>
		<p class="menu_head"><??> E-Monev</p>
		<div class="menu_body" align="left">
          <?//= anchor(site_url('e-monev/dashboard'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?> 
          <?= anchor(site_url('e-monev/dashboard'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Kementerian',''); ?>
          <?= anchor(site_url('e-monev/dashboard_satker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Satker',''); ?>
		  <?= anchor(site_url('e-monev/dashboard_unit'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Unit Utama',''); ?>
		  <?= anchor(site_url('e-monev/laporan_monitoring'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Monitoring',''); ?>
          <!--<?= anchor(site_url('e-monev/laporan_evaluasi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Evaluasi',''); ?>-->
          <?= anchor(site_url('e-monev/laporan_kinerja'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Kinerja Kementrian',''); ?>
		</div>
<?php } ?>
<?php if($this->session->userdata('kd_role') == Role_model::ADMIN_REF){ ?>
	<p class="menu_head"><??>Referensi</p>
	<div class="menu_body" align="left" style="overflow:auto; max-height:210px">
	   <?php /*?><?= anchor(site_url().'/master_data/master_departemen',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Departemen',''); ?><?php */?>
       <?= anchor(site_url().'/master_data/master_fungsi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Fungsi',''); ?>
	   <?= anchor(site_url().'/master_data/master_subfungsi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Sub Fungsi',''); ?>
       <?= anchor(site_url().'/master_data/master_propinsi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Provinsi',''); ?>
	   <?= anchor(site_url().'/master_data/master_tahun_anggaran',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Tahun Anggaran',''); ?>
	   <?= anchor(site_url().'/master_data/master_program',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Program',''); ?>
	   <?= anchor(site_url().'/e-planning/referensi2/grid_periode',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Periode',''); ?>
	   <?= anchor(site_url().'/master_data/master_kegiatan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kegiatan',''); ?>
	   <?= anchor(site_url().'/master_data/master_ikk',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' IKK',''); ?>
	   <?= anchor(site_url().'/master_data/master_menu_kegiatan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Menu Kegiatan',''); ?>
	   <?= anchor(site_url().'/master_data/master_iku',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' IKU',''); ?>
	   <?= anchor(site_url().'/master_data/master_satker',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Satker',''); ?>
	   <?= anchor(site_url().'/master_data/master_kabupaten',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kabupaten',''); ?>
       <?= anchor(site_url().'/master_data/master_satuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Satuan',''); ?>     
       <?= anchor(site_url().'/master_data/master_jenis_pembiayaan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Pembiayaan',''); ?>    
       <?= anchor(site_url().'/master_data/master_kanwil',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kanwil',''); ?>    
		<?= anchor(site_url().'/master_data/master_unit',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Unit',''); ?>    
		<?= anchor(site_url().'/master_data/master_pegawai',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pegawai',''); ?> 
		<?= anchor(site_url().'/master_data/master_jenis_kewenangan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Kewenangan',''); ?>
		<?= anchor(site_url().'/master_data/master_jenis_usulan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Usulan',''); ?>
		<?//= anchor(site_url().'/e-monev/master_bank',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Bank',''); ?>
		<?= anchor(site_url('e-monev/laporan_monitoring/referensi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Ketentuan Pengisian Progres',''); ?>
		<?= anchor(site_url('master_data/master_kppn'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' KPPN',''); ?>
		<?= anchor(site_url('master_data/master_jenis_satker'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Jenis Satker',''); ?>
		</div>
		<?php } ?>
	
<?php if($this->session->userdata('kd_role') == Role_model::EKSEKUTIF){ ?>
		<p class="menu_head"><??> E-Planning</p>
		<div class="menu_body" align="left">
			<?= anchor(site_url().'/e-planning/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
			<?= anchor(site_url('login/chart2'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Grafik','Menampilkan Grafik Persetujuan Satker'); ?>
		</div>
		<p class="menu_head"><??> E-Budgeting</p>
		<div class="menu_body" align="left">
			<?= anchor(site_url().'/e-budget/sinonim/grid_sinonim/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Sinonim','');?>
			<?= anchor(site_url().'/e-budget/akungroup/grid_akungroup/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Akun Group','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian Canggih','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/2',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian Canggih','');?>
            <!--<?= anchor(site_url().'/e-budget/pencarian/form_pencarian/0',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Pencarian','');?>
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Pencarian','');?>-->
            <?= anchor(site_url().'/e-budget/pencarian/form_pencarian_canggih/1',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Unit/Satker','');?>
            <?= anchor(site_url().'/e-budget/graphics/form_graphics',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).'Rekap Grafik','');?>
			<?= anchor(site_url().'/e-budget/dashboard',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
		</div>
		<p class="menu_head"><??> E-Monev</p>
		<div class="menu_body" align="left">
			<?= anchor(site_url().'/e-monev/dashboard_monev',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard',''); ?>
          <?= anchor(site_url('e-monev/dashboard'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Dashboard Kementerian',''); ?>
          <!--<?= anchor(site_url('e-monev/laporan_evaluasi'),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Laporan Evaluasi',''); ?>-->
		</div>
<?php } ?>

	<!--
		<p class="menu_head"><??> Tabel Referensi</p>
		<div class="menu_body" align="left">
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Departemen',''); ?>
	       <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Fungsi',''); ?>
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' IKK',''); ?>
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' IKU',''); ?>
	       <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kabupaten',''); ?>
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kanwil',''); ?>
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Kegiatan',''); ?>
	       <?= anchor(site_url().'/e-planning/referensi2/grid_misi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Misi',''); ?>
		   <?= anchor(site_url().'/e-planning/referensi2/grid_periode',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Periode',''); ?>
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Propinsi',''); ?>
	       <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Program',''); ?>
		   <?= anchor(site_url().'/e-planning/referensi2/grid_sasaran',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Sasaran Satker',''); ?>
	       <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Satker',''); ?>
		   <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' SubFungsi',''); ?>
		   <?= anchor(site_url().'/e-planning/referensi2/grid_tujuan',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Tujuan',''); ?>
	       <?= anchor(site_url().'/e-planning/referensi2/grid_visi',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Visi',''); ?>
		</div>
		-->
		<!--
		<p class="menu_head"><??> Basis Data</p>
		<div class="menu_body" align="left">
		  <?= anchor(site_url().'/e-planning/utility/loadView_yankes',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Unggah Yankes',''); ?>
          <?= anchor(site_url().'/e-planning/utility/loadView_yandas',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Unggah Yandas',''); ?>
		  <?= anchor(site_url().'/e-planning/utility/loadView_dak_binfar',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Unggah DAK Binfar',''); ?>
		  <?= anchor(site_url().'/e-planning/utility/grid_file',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Menyalin Data',''); ?>
		</div>
		-->
		<!--
		<p class="menu_head"><??> Manajemen Aplikasi</p>
		<div class="menu_body" align="left">
		  <?= anchor(site_url(''),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Pendaftaran',''); ?>
          <?= anchor(site_url(''),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Manajemen',''); ?>
		  <?= anchor(site_url(''),img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Filter',''); ?>
		</div>
		-->
	<p class="menu_head"><??> User Menu</p>
		<div class="menu_body" align="left">
		  <?php if($this->session->userdata('kd_role') == Role_model::ADMIN || $this->session->userdata('kd_role') == Role_model::ADMIN_REF){ ?>
		  <!--
		  <?= anchor(base_url().'',img(array('src'=>'images/icon/doc.png','border'=>'0','alt'=>'')).' Bantuan Penggunaan',''); ?>
		  -->
		  <?= anchor(site_url().'/e-planning/master/grid_satker',img(array('src'=>'images/icon/lock.png','border'=>'0','alt'=>'')).' Kemampuan Satker',''); ?>
		  <?= anchor(site_url().'/master_data/master_user',img(array('src'=>'images/icon/lock.png','border'=>'0','alt'=>'')).' Manajemen User',''); ?>
		  <?php } ?>
          <?= anchor(site_url().'/master_data/master_user/detail_user',img(array('src'=>'images/icon/lock.png','border'=>'0','alt'=>'')).' Ubah Profil',''); ?>
          <?= anchor(site_url().'/login/logout',img(array('src'=>'images/icon/lock.png','border'=>'0','alt'=>'')).' Logout',''); ?>
		</div>
		
  </div>  <!--Code for menu ends here-->
</div>
