<? if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div style="margin:5px; background-color:#ffffff">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid thin #000000; height:80%; ">
	  <tr>
	  	 <td rowspan="3" align="left" valign="top">
		<?php $this->load->model('role_model'); ?>
					<fieldset style="border-color:#000000; height:197px; overflow:auto;" >
						<legend class="legend" >| Selamat Datang |</legend>
				
						<div class="info" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;font-weight:bold;">
							<div  style="color:#1BA6C5;">Berikut ini informasi umum sistem aplikasi :</div>
						</div>
						
						<div style="font-family:Arial, Helvetica, sans-serif;font-size:12px;overflow:auto; height:66%;background-color:#C1DCE2;padding:8px;-moz-border-radius:5px;">
							<table width="0" border="0" cellspacing="0" cellpadding="0" >
							  <tr>
								<td colspan="2"><div style="color:#666">Sistem Informasi E-Planning, E-Budgeting dan E-Monev, merupakan sistem aplikasi yang mendukung fungsi-fungsi umum antara lain :</div></td>
							  </tr>
							  <tr>
							    <td align="center" valign="top">&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
								<td width="17" align="center" valign="top"><div style="color:#666">-</div></td>
								<td width="791" align="justify"><div style="color:#666">Sistem mampu mencatat dan memproses pengajuan pengusulan, data pengusulan yang disetujui, data pengusulan yang ditolak. </div></td>
							  </tr>
							  <tr>
								<td align="center" valign="top"><div style="color:#666">-</div></td>
								<td><div style="color:#666">Sistem mampu menampilkan anggaran yang akan digunakan beserta penyerapannya.</div></td>
							  </tr>
							  <tr>
							    <td align="center" valign="top"><div style="color:#666">-</div></td>
							    <td><div style="color:#666">Sistem mampu memonitor dan mengevaluasi kegiatan yang telah dilaksanakan.</div></td>
						      </tr>
							</table>
						</div>
					</fieldset>		
					
					
				<fieldset style="border-color:#000000; height:197px;overflow:auto;">
						<legend>| Informasi |</legend>
						
						<div class="info" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;font-weight:bold;">
							<div style="color:#1BA6C5;">Berikut ini informasi tentang  :</div>
						</div>
						
						<div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; overflow:auto; height:46%;background-color:#C1DCE2;padding:8px;-moz-border-radius:5px;">
						<table width="0" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="360" style="color:#666;">Jumlah Data Usulan</td>
							<td width="40" style="color:#666;">:</td>
							<td width="231" style="color:#666;"><?php
                            if($this->session->userdata('kd_role') == Role_model::VERIFIKATOR)
							{
							$query_usulan = $this->manajemen_model->get_count_by_user();
							$num_rows = $query_usulan->num_rows(); echo $num_rows;
							}
							else if($this->session->userdata('kd_role') == Role_model::PENELAAH)
							{
								$query_usulan = $this->manajemen_model->get_count_by_dekon();
								$num_rows = $query_usulan->num_rows(); echo $num_rows;
							}
							else if($this->session->userdata('kd_role') == Role_model::PENGUSUL)
							{
							$query_usulan = $this->manajemen_model->get_count_by_user();
							$num_rows = $query_usulan->num_rows(); echo $num_rows;
							}
							?></td>
						    <td width="653" rowspan="5" valign="top" style="color:#666;">
								
							</td>
						  </tr>
						  
						  <tr>
						    <td style="color:#666;">Jumlah Data Usulan Yang Diterima</td>
						    <td style="color:#666;">:</td>
						    <td style="color:#666;"><?php $query_usulan_terima = $this->manajemen_model->get_count_by_acc();
		$num_rows = $query_usulan_terima->num_rows(); echo $num_rows;?></td>
				          </tr>
                          
                          <tr>
						    <td style="color:#666;">Jumlah Data Usulan Yang Ditolak</td>
						    <td style="color:#666;">:</td>
						    <td style="color:#666;"><?php $query_usulan_tolak = $this->manajemen_model->get_count_by_ref();
		$num_rows = $query_usulan_tolak->num_rows(); echo $num_rows;?></td>
				          </tr>
                          
                          <tr>
						    <td style="color:#666;">Jumlah Data Usulan Yang Dipertimbangkan</td>
						    <td style="color:#666;">:</td>
						    <td style="color:#666;"><?php $query_usulan_timbang = $this->manajemen_model->get_count_by_con();
		$num_rows = $query_usulan_timbang->num_rows(); echo $num_rows;?></td>
				          </tr>
						
                          <tr>
						    <td style="color:#666;">Jumlah Data Persetujuan</td>
						    <td style="color:#666;">:</td>
						    <td style="color:#666;"><?php $query_persetujuan = $this->manajemen_model->get_count_by_app();
		$num_rows = $query_persetujuan->num_rows(); echo $num_rows;?></td>
				          </tr>
                          
						  <tr>
							<td colspan="4"></td>
						  </tr>
						</table>
						</div>
					</fieldset>	
		<p>Anda bisa mendapatkan bantuan tentang aplikasi ini dengan menghubungi <a href="mailto:erenggar.helpdesk@gmail.com">erenggar.helpdesk@gmail.com</a> atau menghubungi kontak chat kami.</p>
							
		</td>
			
			<td>
			<?php if($this->session->userdata('kd_role') == Role_model::ADMIN){ ?>
				<table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td><?php $this->db->select('*');
							$this->db->from('ref_tupoksi');
							$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
							$return = $this->db->get();
							
							if($return->num_rows() < 1)	{
						  echo '<div class="qitem"><a href="#" onclick="alert(\'Tupoksi belum ada. Silakan mengisi tupoksi terlebih dahulu di menu Rencana Kerja Satker\')"><img src="'.base_url().'images/shortcut/1_1.gif" alt="Test 1" title="" width="126" height="126"/></a><span class="caption"><h4>x</h4><p>.</p></span></div>';
						  } else {
							echo '<div class="qitem"><a href="'.site_url().'/e-planning/pendaftaran/tambah_usulan"><img src="'.base_url().'images/shortcut/1_1.gif" alt="Test 1" title="" width="126" height="126"/></a><span class="caption"><h4>x</h4><p>.</p></span></div>';
						  }
						  ?></td>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/e-planning/manajemen/grid_pengajuan"><img src="<?=base_url();?>images/shortcut/2_2.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>							</div>						</td>
					
						<td>
							<div class="qitem">
                            	<a href="<?=site_url();?>/e-planning/manajemen/grid_pengajuan_disetujui"><img src="<?=base_url();?>images/shortcut/3_3.gif" alt="Test 1" title="" width="126" height="126"/></a><span class="caption">
							  <h4>x</h4><p>.</p></span>						  </div>						</td>
				  	</tr>
				  	<tr>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/e-planning/manajemen/grid_pengajuan_ditolak"><img src="<?=base_url();?>images/shortcut/4_4.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>							</div>						
						</td>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/e-planning/utility/grid_file"><img src="<?=base_url();?>images/shortcut/8.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>							</div>						
						</td>
					
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/beranda"><img src="<?=base_url();?>images/shortcut/5.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>							</div>						
						</td>					
				  	</tr>
				  
				  	<tr>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/beranda"><img src="<?=base_url();?>images/shortcut/6.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>							</div>						
						</td>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/master_data/master_user/grid_user"><img src="<?=base_url();?>images/shortcut/7.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Manajemen User</h4><p>Pengguna Aplikasi Melakukan Pengaturan Akun Aplikasi.</p></span>							</div>						
						</td>
						<td>
							<div class="qitem">
								<a href="<?php echo base_url(); ?>file/user_guide/<?php echo $file; ?>"><img src="<?=base_url();?>images/shortcut/9.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Bantuan Penggunaan</h4><p>Pengguna Aplikasi Meminta Dokumen Bantuan Penggunaan Aplikasi.</p></span>							</div>						
						</td>
				  	</tr>
				</table>
			<?php } ?>
			<?php if($this->session->userdata('kd_role') == Role_model::PENGUSUL){ ?>
				<table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td><?php $this->db->select('*');
							$this->db->from('ref_tupoksi');
							$this->db->where('kdsatker', $this->session->userdata('kdsatker'));
							$return = $this->db->get();
							
							if($return->num_rows() < 1)	{
						  echo '<div class="qitem"><a href="#" onclick="alert(\'Tupoksi belum ada. Silakan mengisi tupoksi terlebih dahulu di menu Rencana Kerja Satker\')"><img src="'.base_url().'images/shortcut/1_1.gif" alt="Test 1" title="" width="126" height="126"/></a><span class="caption"><h4>x</h4><p>.</p></span></div>';
						  } else {
							echo '<div class="qitem"><a href="'.site_url().'/e-planning/pendaftaran/tambah_usulan"><img src="'.base_url().'images/shortcut/1_1.gif" alt="Test 1" title="" width="126" height="126"/></a><span class="caption"><h4>x</h4><p>.</p></span></div>';
						  }
						  ?>
						  </td>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/e-planning/manajemen/grid_pengajuan"><img src="<?=base_url();?>images/shortcut/2_2.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>							</div>						</td>
					
						<td>
							<div class="qitem">
                            	<a href="<?=site_url();?>/e-planning/manajemen/grid_pengajuan_telah_ditelaah"><img src="<?=base_url();?>images/shortcut/3_3.gif" alt="Test 1" title="" width="126" height="126"/></a><span class="caption">
							  <h4>x</h4><p>.</p></span>						  </div>						</td>
				  	</tr>	
					<tr>
					<td>
							<div class="qitem">
								<a href="<?php echo base_url(); ?>file/user_guide/<?php echo $file; ?>"><img src="<?=base_url();?>images/shortcut/9.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Bantuan Penggunaan</h4><p>Pengguna Aplikasi Meminta Dokumen Bantuan Penggunaan Aplikasi.</p></span>							</div>						
						</td>
				  	</tr>
				</table>
			<?php } ?>
			<?php if($this->session->userdata('kd_role') == Role_model::VERIFIKATOR){ ?>
				<table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/e-planning/manajemen/grid_pengajuan"><img src="<?=base_url();?>images/shortcut/2_2.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>	</div></td>
					
						
					<td>
							<div class="qitem">
								<a href="<?php echo base_url(); ?>file/user_guide/<?php echo $file; ?>"><img src="<?=base_url();?>images/shortcut/9.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Bantuan Penggunaan</h4><p>Pengguna Aplikasi Meminta Dokumen Bantuan Penggunaan Aplikasi.</p></span>							</div>						
						</td>
				  	</tr>
				</table>
			<?php } ?>
			<?php if($this->session->userdata('kd_role') == Role_model::PEMBUAT_ANGGARAN){ ?>
				<table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						
						<td>
							<div class="qitem">
								<a href="<?php echo base_url(); ?>file/user_guide/<?php echo $file; ?>"><img src="<?=base_url();?>images/shortcut/9.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Bantuan Penggunaan</h4><p>Pengguna Aplikasi Meminta Dokumen Bantuan Penggunaan Aplikasi.</p></span>							</div>						
						</td>
				  	</tr>
				</table>
			<?php } ?>
			<?php if($this->session->userdata('kd_role') == Role_model::PEMBUAT_LAPORAN){ ?>
				<table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						
						<td>
							<div class="qitem">
								<a href="<?php echo base_url(); ?>file/user_guide/<?php echo $file; ?>"><img src="<?=base_url();?>images/shortcut/9.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Bantuan Penggunaan</h4><p>Pengguna Aplikasi Meminta Dokumen Bantuan Penggunaan Aplikasi.</p></span>							</div>						
						</td>
				  	</tr>
				</table>
			<?php } ?>
			<?php if($this->session->userdata('kd_role') == Role_model::PENELAAH || $this->session->userdata('kd_role') == Role_model::PENYETUJU){ ?>
				<table width="0" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td>
							<div class="qitem">
								<a href="<?=site_url();?>/e-planning/manajemen/grid_persetujuan"><img src="<?=base_url();?>images/shortcut/2_2.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>x</h4><p>.</p></span>	</div></td>
					
						
					<td>
							<div class="qitem">
								<a href="<?php echo base_url(); ?>file/user_guide/<?php echo $file; ?>"><img src="<?=base_url();?>images/shortcut/9.gif" alt="Test 1" title="" width="126" height="126"/></a>
								<span class="caption"><h4>Bantuan Penggunaan</h4><p>Pengguna Aplikasi Meminta Dokumen Bantuan Penggunaan Aplikasi.</p></span>							</div>						
						</td>
				  	</tr>
				</table>
			<?php } ?>
		</td>
  	  </tr>
	</table>
</div>
<div style="display: none;" id="displayBox">
	<div class="qitem_2">
		<a href="<?=site_url();?>/laporan_penangkaran_produksi_per_varietas"><img src="<?=base_url();?>images/shortcut/4.1.gif" alt="Test 1" title="" width="250" height="250"/></a>		
	</div>
	<div class="qitem_2">
		<a href="<?=site_url();?>/laporan_penangkaran_produksi_per_groupKB"><img src="<?=base_url();?>images/shortcut/4.2.gif" alt="Test 1" title="" width="250" height="250"/></a>
	</div>
</div>
<script language="JavaScript">
	function show_report(){
		$(document).ready(function() { 
				$.blockUI({ 
					message: $('#displayBox'),
					css: { 
						top:  ($(window).height() - 400) /2 + 'px', 
						left: ($(window).width() - 500) /2 + 'px', 
						width: '530px', 
						height: '260px'
					} 
				}); 
				$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
				//setTimeout($.unblockUI, 5000); 
		}); 
	}
</script>

