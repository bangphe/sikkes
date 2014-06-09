<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_monitoring_bc extends CI_Controller 
{
	function __construct(){
		parent::__construct();
		$this->cek_session();
		$this->load->helper('fusioncharts');
		$this->load->model('e-monev/laporan_monitoring_model','lmm');
		$this->load->model('e-monev/bank_model','bm');
	}
	
	function cek_session()
	{	
		$kode_role = $this->session->userdata('kd_role');
		if($kode_role == '')
		{
			redirect('login/login_ulang');
		}
	}
	
	/*
	function grafik()
	{
		$dummy_cat_data = array(
							'Jan',
							'Feb',
							'Mar', 
							'Apr',
							'May',
							'Jun',
							'Jul',
							'Aug',
							'Sep',
							'Oct',
							'Nov',
							'Dec'
						);
		$dummy_cat_data['value'] = array(
									'1127654',
									'1226234',
									'1299456',
									'1311565',
									'1324454',
									'1357654',
									'1296234',
									'1359456',
									'1391565',
									'1414454',
									'1671565',
									'1134454' 
									);
		$dummy_val_data = array(
							'1127654',
							'1226234',
							'1299456',
							'1311565',
							'1324454',
							'1357654',
							'1296234',
							'1359456',
							'1391565',
							'1414454',
							'1671565',
							'1134454' 
							);
							
		$dummy_val_data2 = array(
							'927654',
							'1126234',
							'999456',
							'1111565',
							'1124454',
							'1257654',
							'1196234',
							'1259456',
							'1191565',
							'1214454',
							'1371565',
							'1434454'
							);
		
		$graph_swfFile      = base_url().'charts/MSLine.swf' ;
		$graph_caption      = 'Grafik Rencana Pelaksanaan Paket' ;
		$graph_numberPrefix = '' ;
		$graph_title        = '' ;
		$graph_width        = 250;
		$y_axis_max_value   = 100;
		$y_axis_min_value   = 800000;
		$num_div_lines		= 10;
		$graph_height       = 200;
		
		$strXML = "<graph numDivLines='".$num_div_lines."' caption='".$graph_caption."' numberPrefix='".$graph_numberPrefix."' formatNumberScale='0' decimalPrecision='0' yAxisName='Presentase' yAxisMinValue='".$y_axis_min_value."'>";
	
		$strXML .= "<categories>";
		foreach ($dummy_cat_data as $cat_data) {
			$strXML .= "<category name='".$cat_data."'/>";
		}
		$strXML .= "</categories>";
		$strXML .= "<dataset seriesName=\'Current Year\' color=\'A66EDD\'>";
		foreach ($dummy_val_data as $val_data) {
			$strXML .= "<set value='".$val_data."'/>";
		}
		$strXML .= "</dataset>";
		$strXML .= "<dataset seriesName=\'Previous Year\' color=\'F6BD0F\'>";
		foreach ($dummy_val_data2 as $val_data2) {
			$strXML .= "<set value='".$val_data2."'/>";
		}
		$strXML .= "</dataset>";
		$strXML .= "</graph>";
	
		$graph  = renderChartHTML($graph_swfFile,"", $strXML, "div2" , $graph_width, $graph_height, false);
		
		$data['graph'] = $graph;
		$data['content'] = $this->load->view('e-monev/graph',$data);
	}
	*/
	
	function grafik($d_skmpnen_id)
	{
		$strXML = '';
		$strXML .= '<graph yAxisName=\'Presentase\' caption=\'Grafik Rencana Pelaksanaan Paket\' subcaption=\'Tahun '.$this->session->userdata('thn_anggaran').'\' hovercapbg=\'FFECAA\' hovercapborder=\'F47E00\' formatNumberScale=\'0\' decimalPrecision=\'0\' showvalues=\'0\' numdivlines=\'5\' numVdivlines=\'0\' yaxisminvalue=\'1000\' yaxismaxvalue=\'100\'  rotateNames=\'1\' NumberSuffix=\'%25\'>
					<categories >
						<category name=\'Jan\' />
						<category name=\'Feb\' />
						<category name=\'Mar\' />
						<category name=\'Apr\' />
						<category name=\'Mei\' />
						<category name=\'Jun\' />
						<category name=\'Jul\' />
						<category name=\'Agt\' />
						<category name=\'Sep\' />
						<category name=\'Okt\' />
						<category name=\'Nop\' />
						<category name=\'Des\' />
					</categories>';
		$strXML .= '<dataset seriesName=\'Fisik\' color=\'1D8BD1\' anchorBorderColor=\'1D8BD1\' anchorBgColor=\'1D8BD1\'>';
		foreach($this->lmm->get_rencana($d_skmpnen_id) as $row)
		{
			$strXML .= '<set value="'.$row->fisik.'" />';
		}
		$strXML .= '</dataset>';
		$strXML .= '<dataset seriesName=\'Keuangan\' color=\'F1683C\' anchorBorderColor=\'F1683C\' anchorBgColor=\'F1683C\'>';
		foreach($this->lmm->get_rencana($d_skmpnen_id) as $row)
		{
			$strXML .= '<set value="'.$row->keuangan.'" />';
		}
		$strXML .= '</dataset>';
		$strXML .= '</graph>';
		$myFile = dirname(dirname(dirname(dirname(__FILE__)))).'\charts\testFile.xml';
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $strXML);
		fclose($fh);
		$graph = '<script type="text/javascript">
					   var chart = new FusionCharts("'.base_url().'charts/FCF_MSLine.swf", "ChartId", "600", "350");
					   chart.setDataURL("'.base_url().'charts/testFile.xml");		   
					   chart.render("chartdiv");
					</script>';
		$data['graph'] = $graph;
		if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
		{
			$data['kembali'] = 1;
		}
		else
		{
			$data['kembali'] = 0;
		}
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$this->load->view('e-monev/graph',$data);
	} 
	
	function grafik2($d_skmpnen_id)
	{
		$strXML = '';
		$strXML .= '<graph yAxisName=\'Presentase\' caption=\'Grafik Progres Fisik\' subcaption=\'Tahun '.$this->session->userdata('thn_anggaran').'\' hovercapbg=\'FFECAA\' hovercapborder=\'F47E00\' formatNumberScale=\'0\' decimalPrecision=\'0\' showvalues=\'0\' numdivlines=\'5\' numVdivlines=\'0\' yaxisminvalue=\'1000\' yaxismaxvalue=\'100\'  rotateNames=\'1\' NumberSuffix=\'%25\'>
					<categories >
						<category name=\'Jan\' />
						<category name=\'Feb\' />
						<category name=\'Mar\' />
						<category name=\'Apr\' />
						<category name=\'Mei\' />
						<category name=\'Jun\' />
						<category name=\'Jul\' />
						<category name=\'Agt\' />
						<category name=\'Sep\' />
						<category name=\'Okt\' />
						<category name=\'Nop\' />
						<category name=\'Des\' />
					</categories>';
		$strXML .= '<dataset seriesName=\'Rencana\' color=\'1D8BD1\' anchorBorderColor=\'1D8BD1\' anchorBgColor=\'1D8BD1\'>';
		foreach($this->lmm->get_rencana($d_skmpnen_id) as $row)
		{
			$strXML .= '<set value="'.$row->fisik.'" />';
		}
		$strXML .= '</dataset>';
		$strXML .= '<dataset seriesName=\'Realisasi\' color=\'F1683C\' anchorBorderColor=\'F1683C\' anchorBgColor=\'F1683C\'>';
		foreach($this->lmm->get_progres($d_skmpnen_id) as $row)
		{
			$strXML .= '<set value="'.$row->fisik.'" />';
		}
		$strXML .= '</dataset>';
		$strXML .= '</graph>';
		$myFile = dirname(dirname(dirname(dirname(__FILE__)))).'\charts\testFile.xml';
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $strXML);
		fclose($fh);
		$graph = '<script type="text/javascript">
					   var chart = new FusionCharts("'.base_url().'charts/FCF_MSLine.swf", "ChartId", "600", "350");
					   chart.setDataURL("'.base_url().'charts/testFile.xml");		   
					   chart.render("chartdiv");
					</script>';
		$data['graph'] = $graph;
		if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
		{
			$data['kembali'] = 1;
		}
		else
		{
			$data['kembali'] = 0;
		}
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$this->load->view('e-monev/graph2',$data);
	} 
	
	function index()
	{
		$this->grid();
	}
	
	function grid()
	{
		$kode_role = $this->session->userdata('kd_role');
		$colModel['no'] = array('No',20,TRUE,'center',0);
		if($kode_role == 8) $colModel['nmsatker'] = array('Nama Satker',200,TRUE,'center',1);
		$colModel['SUB_KOMPONEN'] = array('Komponen / Sub Komponen',350,TRUE,'center',1);
		$colModel['REALISASI_FISIK'] = array('Realisasi Fisik',80,TRUE,'center',1);
		$colModel['REALISASI_KEUANGAN'] = array('Realisasi Keuangan',100,TRUE,'center',1);
		$colModel['PERMASALAHAN'] = array('Permasalahan',80,FALSE,'center',0);
		$colModel['LAPORAN'] = array('Laporan',50,FALSE,'center',0);
		$colModel['GRAFIK'] = array('Grafik',50,FALSE,'center',0);
		$colModel['UNGGAH_DOK'] = array('Unggah Dokumen',90,FALSE,'center',0);
			
		//setting konfigurasi pada bottom tool bar flexigrid
		$gridParams = array(
							'width' => 'auto',
							'height' => 500,
							'rp' => 15,
							'rpOptions' => '[15,30,50,100]',
							'pagestat' => 'Menampilkan : {from} ke {to} dari {total} data.',
							'blockOpacity' => 0,
							'title' => '',
							'showTableToggleBtn' => false
							);
							
		//menambah tombol pada flexigrid top toolbar
		$buttons[] = array('Tambah','add','spt_js');
		$buttons[] = array('Hapus','delete','spt_js');
		$buttons[] = array('separator');
		$buttons[] = array('Pilih Semua','add','spt_js');
		$buttons[] = array('separator');
		$buttons[] = array('Hapus Pilihan','delete','spt_js');
		$buttons[] = array('separator');	
		
		// mengambil data dari file controler ajax pada method grid_user	
		$url = site_url()."/e-monev/laporan_monitoring_bc/grid_data_monitoring";
		$grid_js = build_grid_js('user',$url,$colModel,'ID','asc',$gridParams,$buttons,true);
		$data['js_grid'] = $grid_js;
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Pilih Semua')
			{
				$('.bDiv tbody tr',grid).addClass('trSelected');
			}
			if (com=='Tambah'){
				location.href= '".base_url()."index.php/laporan_monitoring_bc/add';    
			}
			if (com=='Hapus Pilihan')
			{
				$('.bDiv tbody tr',grid).removeClass('trSelected');
			}
			if (com=='Hapus')
				{
				   if($('.trSelected',grid).length>0){
					   if(confirm('Anda yakin ingin menghapus ' + $('.trSelected',grid).length + ' buah data?')){
							var items = $('.trSelected',grid);
							var itemlist ='';
							for(i=0;i<items.length;i++){
								itemlist+= items[i].id.substr(3)+',';
							}
							$.ajax({
							   type: 'POST',
							   url: '".site_url('/laporan_monitoring_bc/delete')."',
							   data: 'items='+itemlist,
							   success: function(data){
								$('#user').flexReload();
								alert(data);
							   }
							});
						}
					} else {
						return false;
					} 
				}        
		} </script>";
		$data['notification'] = "";
		if($this->session->userdata('notification')!=''){
			$data['notification'] = "
				<script>
					$(document).ready(function() {
						$.growlUI('Pesan :', '".$this->session->userdata('notification')."');
					});
				</script>
			";
		}//end if
			
		//$data['added_js'] variabel untuk membungkus javascript yang dipakai pada tombol yang ada di toolbar atas
		$data['judul'] = 'Laporan Monitoring';
		$data['content'] = $this->load->view('grid',$data,true);
		$this->load->view('main',$data);
	}
	
	function grid_data_monitoring() 
	{
		$kd_role = $this->session->userdata('kd_role');
		$valid_fields = array('d_skmpnen_id','urskmpnen');
		$this->flexigrid->validate_post('d_skmpnen_id','asc',$valid_fields);
		$records = $this->lmm->get_sub_komponen();	
		$this->output->set_header($this->config->item('json_header'));
		$no = 0;
		foreach ($records['records']->result() as $row){
				$no = $no+1;
				if($kd_role == 8)
				{
					$record_items[] = array(
										$row->d_skmpnen_id,
										$no,
										$row->nmsatker,
										$row->urskmpnen,
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/rf/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/doc.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/rk/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/doc.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/input_masalah/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/lihat.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/input_laporan/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/input.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/grafik/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/grafik.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/unggah/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/upload.png\'></a>'
									);
				}
				else
				{
					$record_items[] = array(
										$row->d_skmpnen_id,
										$no,
										$row->urskmpnen,
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/rf/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/doc.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/rk/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/doc.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/input_masalah/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/lihat.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/laporan/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/input.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/grafik/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/grafik.png\'></a>',
										'<a href='.base_url().'index.php/e-monev/laporan_monitoring_bc/unggah/'.$row->d_skmpnen_id.'><img border=\'0\' src=\''.base_url().'images/icon/upload.png\'></a>'
									);
				}		
		}
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function tes()
	{
		$myFile = dirname(dirname(dirname(dirname(__FILE__))));
		/*
		$fh = fopen($myFile, 'w') or die("can't open file");
		$stringData = "Bobby Bopper\n";
		fwrite($fh, $stringData);
		$stringData = "Tracy Tanner\n";
		fwrite($fh, $stringData);
		fclose($fh);
		*/
		echo $myFile;
	}
	
	function bulan()
	{
		$bulan = array(
					'1' => 'Januari',
					'2' => 'Februari',
					'3' => 'Maret',
					'4' => 'April',
					'5' => 'Mei',
					'6' => 'Juni',
					'7' => 'Juli',
					'8' => 'Agustus',
					'9' => 'September',
					'10' => 'Oktober',
					'11' => 'November',
					'12' => 'Desember'
					);
		return $bulan;
	}
	
	function input_masalah($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_permasalahan',$data,true);
		$this->load->view('main',$data);
	}
	
	function input_progres_fisik($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_progres',$data,true);
		$this->load->view('main',$data);
	}
	
	function input_rencana($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_rencana',$data,true);
		$this->load->view('main',$data);
	}
	
	function unggah($d_skmpnen_id)
	{
		$option_thn;
		foreach($this->lmm->get('ref_tahun_anggaran')->result() as $row){
			$option_thn[$row->idThnAnggaran] = $row->thn_anggaran;	
		}
		
		$data['judul'] = 'Laporan Evaluasi';
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id);
		$data['option_tahun'] = $option_thn;
		//$data['tahun'] = $this->lmm->get_where('ref_tahun_anggaran','idThnAnggaran',$this->session->userdata('idThnAnggaran'));
		$data['content'] = $this->load->view('E-monev/unggah',$data,true);
		$this->load->view('main',$data);
	}
	
	function data_kelompok_pengerjaan()
	{
		$data = array('OP','Rutin','Rehabilitasi','Pembangunan','Peningkatan','Fisik Penunjang');
		return $data;
	}
	
	function data_kategori_pengadaan()
	{
		$data = array('Barang','Pemborongan','Jasa Lainnya');
		return $data;
	}
	
	function data_cara_pengadaan()
	{
		$data = array('Pelelangan Umum (Pra-Kualifikasi)');
		return $data;
	}
	
	function data_paket_pengerjaan()
	{
		$data = array('Kontraktual','Swakelola');;
		return $data;
	}
	
	function data_posisi_kontrak()
	{
		$data = array('Persiapan','Lelang','Pelaksanaan');
		return $data;
	}
	
	function input_laporan($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_laporan',$data,true);
		$this->load->view('main',$data);
	}
	
	function input_laporan2($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_laporan2',$data,true);
		$this->load->view('main',$data);
	}
	
	function input_laporan4($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_laporan4',$data,true);
		$this->load->view('main',$data);
	}
	
	function input_laporan3($d_skmpnen_id)
	{
		if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->num_rows > 0)
		{
			if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row()->paket_lanjutan == 0)
			{
				$data['added_script'] = 'function reset()
										{
											$("#nomor_kontrak").val(\'\');
											$("#tanggal_ttd").val(\'\');
											$("#tanggal_pelaksanaan").val(\'\');
											$("#tanggal_spmk").val(\'\');
											$("#tanggal_selesai").val(\'\');
											$("#rekanan_utama").val(\'\');
											$("#alamat").val(\'\');
											$("#npwp").val(\'\');
											$("#realisasi_keuangan").val(\'\');
											$("#realisasi_fisik").val(\'\');
											$("#nilai_kontrak").val(\'\');
											$("#phln").val(\'\');
										}';
				$data['added_script2'] = 'function save_data_detail_kontrak(){
												var nomor_kontrak = $("#nomor_kontrak").val();
												var tanggal_ttd = $("#tanggal_ttd").val();
												var tanggal_pelaksanaan = $("#tanggal_pelaksanaan").val();
												var tanggal_spmk = $("#tanggal_spmk").val();
												var tanggal_selesai = $("#tanggal_selesai").val();
												var rekanan_utama = $("#rekanan_utama").val();
												var alamat = $("#alamat").val();
												var npwp = $("#npwp").val();
												var realisasi_keuangan = $("#realisasi_keuangan").val();
												var realisasi_fisik = $("#realisasi_fisik").val();
												var nilai_kontrak = $("#nilai_kontrak").val();
												var phln = $("#phln").val();
												var nama_bank = $("#nama_bank").val();
												if (nomor_kontrak==\'\' || tanggal_ttd==\'\' || tanggal_pelaksanaan==\'\' || tanggal_spmk==\'\' || tanggal_selesai==\'\' || rekanan_utama==\'\' || alamat==\'\' || npwp==\'\' || realisasi_keuangan==\'\' || realisasi_fisik==\'\' || nilai_kontrak==\'\' || phln==\'\')
												{
												  alert("Semua kolom harus diisi !!");
												  return false;
												}
												else
												{
													$.ajax({
														url: \'http://localhost/sikkes/index.php/e-monev/laporan_monitoring_bc/save_data_kontrak/\'+d_skmpnen_id,
														global: false,
														type: \'POST\',
														async: false,
														dataType: \'html\',
														data:{
															nomor_kontrak:nomor_kontrak,
															tanggal_ttd:tanggal_ttd,
															tanggal_pelaksanaan:tanggal_pelaksanaan,
															tanggal_spmk:tanggal_spmk,
															tanggal_selesai:tanggal_selesai,
															rekanan_utama:rekanan_utama,
															alamat:alamat,
															npwp:npwp,
															realisasi_keuangan:realisasi_keuangan,
															realisasi_fisik:realisasi_fisik,
															nilai_kontrak:nilai_kontrak,
															phln:phln,
															nama_bank:nama_bank
														},
														success: function (response) {
															form_kontrak();
														}
													});
													return false;
												}
											}';
											
				$data['added_script3'] = 'function update_data_detail_kontrak(){
												var nomor_kontrak = $("#nomor_kontrak").val();
												var tanggal_ttd = $("#tanggal_ttd").val();
												var tanggal_pelaksanaan = $("#tanggal_pelaksanaan").val();
												var tanggal_spmk = $("#tanggal_spmk").val();
												var tanggal_selesai = $("#tanggal_selesai").val();
												var rekanan_utama = $("#rekanan_utama").val();
												var alamat = $("#alamat").val();
												var npwp = $("#npwp").val();
												var realisasi_keuangan = $("#realisasi_keuangan").val();
												var realisasi_fisik = $("#realisasi_fisik").val();
												var nilai_kontrak = $("#nilai_kontrak").val();
												var phln = $("#phln").val();
												var nama_bank = $("#nama_bank").val();
												if (nomor_kontrak==\'\' || tanggal_ttd==\'\' || tanggal_pelaksanaan==\'\' || tanggal_spmk==\'\' || tanggal_selesai==\'\' || rekanan_utama==\'\' || alamat==\'\' || npwp==\'\' || realisasi_keuangan==\'\' || realisasi_fisik==\'\' || nilai_kontrak==\'\' || phln==\'\')
												{
												  alert("Semua kolom harus diisi !!");
												  return false;
												}
												else
												{
													$.ajax({
														url: \'http://localhost/sikkes/index.php/e-monev/laporan_monitoring_bc/update_kontrak/\'+d_skmpnen_id,
														global: false,
														type: \'POST\',
														async: false,
														dataType: \'html\',
														data:{
															nomor_kontrak:nomor_kontrak,
															tanggal_ttd:tanggal_ttd,
															tanggal_pelaksanaan:tanggal_pelaksanaan,
															tanggal_spmk:tanggal_spmk,
															tanggal_selesai:tanggal_selesai,
															rekanan_utama:rekanan_utama,
															alamat:alamat,
															npwp:npwp,
															realisasi_keuangan:realisasi_keuangan,
															realisasi_fisik:realisasi_fisik,
															nilai_kontrak:nilai_kontrak,
															phln:phln,
															nama_bank:nama_bank
														},
														success: function (response) {
															form_kontrak();
														}
													});
													return false;
												}
											}';
			}
			else
			{
				$data['added_script'] = 'function reset()
										{
											$("#nomor_kontrak").val(\'\');
											$("#tanggal_ttd").val(\'\');
											$("#tanggal_pelaksanaan").val(\'\');
											$("#tanggal_spmk").val(\'\');
											$("#tanggal_selesai").val(\'\');
											$("#rekanan_utama").val(\'\');
											$("#alamat").val(\'\');
											$("#npwp").val(\'\');
											$("#nilai_kontrak").val(\'\');
											$("#phln").val(\'\');
										}';
				$data['added_script2'] = 'function save_data_detail_kontrak(){
												var nomor_kontrak = $("#nomor_kontrak").val();
												var tanggal_ttd = $("#tanggal_ttd").val();
												var tanggal_pelaksanaan = $("#tanggal_pelaksanaan").val();
												var tanggal_spmk = $("#tanggal_spmk").val();
												var tanggal_selesai = $("#tanggal_selesai").val();
												var rekanan_utama = $("#rekanan_utama").val();
												var alamat = $("#alamat").val();
												var npwp = $("#npwp").val();
												var nilai_kontrak = $("#nilai_kontrak").val();
												var phln = $("#phln").val();
												var nama_bank = $("#nama_bank").val();
												if (nomor_kontrak==\'\' || tanggal_ttd==\'\' || tanggal_pelaksanaan==\'\' || tanggal_spmk==\'\' || tanggal_selesai==\'\' || rekanan_utama==\'\' || alamat==\'\' || npwp==\'\' || nilai_kontrak==\'\' || phln==\'\')
												{
												  alert("Semua kolom harus diisi !!");
												  return false;
												}
												else
												{
													$.ajax({
														url: \'http://localhost/sikkes/index.php/e-monev/laporan_monitoring_bc/save_data_kontrak/\'+d_skmpnen_id,
														global: false,
														type: \'POST\',
														async: false,
														dataType: \'html\',
														data:{
															nomor_kontrak:nomor_kontrak,
															tanggal_ttd:tanggal_ttd,
															tanggal_pelaksanaan:tanggal_pelaksanaan,
															tanggal_spmk:tanggal_spmk,
															tanggal_selesai:tanggal_selesai,
															rekanan_utama:rekanan_utama,
															alamat:alamat,
															npwp:npwp,
															nilai_kontrak:nilai_kontrak,
															phln:phln,
															nama_bank:nama_bank
														},
														success: function (response) {
															$("#uraian_kegiatan").val(\'\');
															$("#tanggal").val(\'\');
															form_prakontrak3();
														}
													});
													return false;
												}
											}';
				$data['added_script3'] = 'function update_data_detail_kontrak(){
												var nomor_kontrak = $("#nomor_kontrak").val();
												var tanggal_ttd = $("#tanggal_ttd").val();
												var tanggal_pelaksanaan = $("#tanggal_pelaksanaan").val();
												var tanggal_spmk = $("#tanggal_spmk").val();
												var tanggal_selesai = $("#tanggal_selesai").val();
												var rekanan_utama = $("#rekanan_utama").val();
												var alamat = $("#alamat").val();
												var npwp = $("#npwp").val();
												var nilai_kontrak = $("#nilai_kontrak").val();
												var phln = $("#phln").val();
												var nama_bank = $("#nama_bank").val();
												if (nomor_kontrak==\'\' || tanggal_ttd==\'\' || tanggal_pelaksanaan==\'\' || tanggal_spmk==\'\' || tanggal_selesai==\'\' || rekanan_utama==\'\' || alamat==\'\' || npwp==\'\' || nilai_kontrak==\'\' || phln==\'\')
												{
												  alert("Semua kolom harus diisi !!");
												  return false;
												}
												else
												{
													$.ajax({
														url: \'http://localhost/sikkes/index.php/e-monev/laporan_monitoring_bc/update_kontrak/\'+d_skmpnen_id,
														global: false,
														type: \'POST\',
														async: false,
														dataType: \'html\',
														data:{
															nomor_kontrak:nomor_kontrak,
															tanggal_ttd:tanggal_ttd,
															tanggal_pelaksanaan:tanggal_pelaksanaan,
															tanggal_spmk:tanggal_spmk,
															tanggal_selesai:tanggal_selesai,
															rekanan_utama:rekanan_utama,
															alamat:alamat,
															npwp:npwp,
															nilai_kontrak:nilai_kontrak,
															phln:phln,
															nama_bank:nama_bank
														},
														success: function (response) {
															$("#uraian_kegiatan").val(\'\');
															$("#tanggal").val(\'\');
															form_prakontrak3();
														}
													});
													return false;
												}
											}';
			}
		}
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['content'] = $this->load->view('E-monev/main_laporan3',$data,true);
		$this->load->view('main',$data);
	}
	
	function data_dummy_array()
	{
		$data = array('yoga','tes','tes2','tes3');
		return $data;
	}
	
	function data_kontraktual()
	{
		$data = array('Barang','Jasa');
		return $data;
	}
	
	function data_swakelola()
	{
		$data = array('Fisik','Non Fisik');
		return $data;
	}
	
	function get_data(){   
		if ($_POST['data1']!='') {
			$data =''; 		
			$parent = $_POST['data1'];
			$result = $this->bulan();
			//$result	= $this->pendaftaran_model->get_negara_byRegion($parent);			
			foreach ($result as $key=>$value){
				$data.= '<option value="'.$key.'" class="dynamic_data2">'.$value.'</option>';
			}
			echo $data;
		}
		else
			echo '<option value="0" class="dynamic_data2">-- Pilih Data 2 --</option>';
	}
	
	function get_jenis_paket()
	{   
		if ($_POST['data_post']!='') {
			$data =''; 		
			$parent = $_POST['data_post'];
			if($parent == 0)
			{
				$result = $this->data_kontraktual();
			}
			else if($parent == 1)
			{
				$result = $this->data_swakelola();
			}		
			foreach ($result as $key=>$value){
				$data.= '<option value="'.$key.'" class="dynamic_data_jenis_paket">'.$value.'</option>';
			}
			echo $data;
		}
		else
			echo '<option value="0" class="dynamic_data_jenis_paket">-- Pilih Jenis Paket --</option>';
	}
	
	function get_kabupaten()
	{   
		if ($_POST['data_post']!='') {
			$data =''; 		
			$parent = $_POST['data_post'];
			$result = $this->lmm->get_kabupaten_by_kode_provinsi($parent);
			foreach ($result as $row){
				$data.= '<option value="'.$row->KodeKabupaten.'" class="dynamic_data_kabupaten">'.$row->NamaKabupaten.'</option>';
			}
			echo $data;
		}
		else
			echo '<option value="0" class="dynamic_data_kabupaten">-- Pilih Kabupaten --</option>';
	}
	
	function form_prakontrak($d_skmpnen_id)
	{
		if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
		{
			$data_kategori_pengadaan = $this->data_kategori_pengadaan();
			$data_cara_pengadaan = $this->data_cara_pengadaan();
			if($this->lmm->get_prakontrak_by_d_skmpnen_id($d_skmpnen_id)->num_rows > 0)
			{
				$data_prakontrak = $this->lmm->get_prakontrak_by_d_skmpnen_id($d_skmpnen_id)->row();
				$data['kategori_pengadaan'] = $data_kategori_pengadaan[$data_prakontrak->kategori_pengadaan];
				$data['cara_pengadaan'] = $data_cara_pengadaan[$data_prakontrak->cara_pengadaan];
				$data['nilai_hps_oe'] = $data_prakontrak->nilai_hps_oe;
				$this->load->view('e-monev/form_detail_prakontrak2',$data);
			}
			else
			{
				$data['d_skmpnen_id'] = $d_skmpnen_id;
				$data['kategori_pengadaan'] = $data_kategori_pengadaan;
				$data['cara_pengadaan'] = $data_cara_pengadaan;
				$this->load->view('e-monev/form_detail_prakontrak',$data);
			}
		}
		else
		{
			echo 'Hanya untuk paket pekerjaan yang berjenis kontraktual';
		}
	}
	
	function form_prakontrak2($d_skmpnen_id)
	{
		if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
		{
			$data['detail_prakontrak_id'] = $d_skmpnen_id;
			$this->load->view('e-monev/jadual_pelaksanaan',$data);
		}
		else
		{
			echo 'Hanya untuk paket pekerjaan yang berjenis kontraktual';
		}
	}
	
	function form_prakontrak3($d_skmpnen_id)
	{
		if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
		{
			$data_jadual_pelaksanaan = $this->lmm->get_jadual_pelaksanaan_by_d_skmpnen_id($d_skmpnen_id);
			$data['data_jadual_pelaksanaan'] = $data_jadual_pelaksanaan;
			$this->load->view('e-monev/jadual_pelaksanaan2',$data);
		}
		else
		{
			echo 'Hanya untuk paket pekerjaan yang berjenis kontraktual';
		}
	}
	
	function form_kontrak($d_skmpnen_id)
	{
		if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
		{
			if($this->lmm->get_kontrak_by_d_skmpnen_id($d_skmpnen_id)->num_rows > 0)
			{
				
				$data_kontrak = $this->lmm->get_kontrak_by_d_skmpnen_id($d_skmpnen_id)->row();
				$tanggal_ttd = explode("-",$data_kontrak->tanggal_ttd);
				$tanggal_spmk = explode("-",$data_kontrak->tanggal_spmk);
				$tanggal_selesai = explode("-",$data_kontrak->tanggal_selesai);
				$waktu_pelaksanaan = explode("-",$data_kontrak->waktu_pelaksanaan);
				$data['realisasi_keuangan'] = $data_kontrak->realisasi_keuangan;
				$data['realisasi_fisik'] = $data_kontrak->realisasi_fisik;
				$data['nilai_kontrak'] = $data_kontrak->nilai_kontrak;
				$data['phln'] = $data_kontrak->phln;
				if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row()->paket_lanjutan == 0)
				{
					$data['input_nilai_kontrak'] = $this->load->view('e-monev/detail_nilai_kontrak2',$data,true);
				}
				else
				{
					$data['input_nilai_kontrak'] = $this->load->view('e-monev/detail_nilai_kontrak',null,true);
				}
				
				$data['nomor_kontrak'] = $data_kontrak->nomor_kontrak;
				$data['tanggal_ttd'] = $tanggal_ttd[2].'/'.$tanggal_ttd[1].'/'.$tanggal_ttd[0];
				$data['waktu_pelaksanaan'] = $waktu_pelaksanaan[2].'/'.$waktu_pelaksanaan[1].'/'.$waktu_pelaksanaan[0];
				$data['tanggal_spmk'] = $tanggal_spmk[2].'/'.$tanggal_spmk[1].'/'.$tanggal_spmk[0];
				$data['tanggal_selesai'] = $tanggal_selesai[2].'/'.$tanggal_selesai[1].'/'.$tanggal_selesai[0];
				$data['rekanan_utama'] = $data_kontrak->rekanan_utama;
				$data['alamat'] = $data_kontrak->alamat;
				$data['nama_bank'] = $this->bm->get_bank($data_kontrak->bank_id)->row()->nama_bank;
				$data['npwp'] = $data_kontrak->npwp;
				$this->load->view('e-monev/form_detail_kontrak2',$data);
			}
			else
			{
				$bank = array();
				foreach($this->bm->get_all_bank()->result() as $row)
				{
					$bank[$row->bank_id] = $row->nama_bank;
				}
				$data['nama_bank'] = $bank;
				if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row()->paket_lanjutan == 0)
				{
					$data['input_nilai_kontrak'] = $this->load->view('e-monev/nilai_kontrak2',null,true);
				}
				else
				{
					$data['input_nilai_kontrak'] = $this->load->view('e-monev/nilai_kontrak',null,true);
				}
				$this->load->view('e-monev/form_detail_kontrak',$data);
			}
		}
		else
		{
			echo 'Hanya untuk paket pekerjaan yang berjenis kontraktual';
		}
	}
	
	function form_paket($d_skmpnen_id)
	{
		$paket_pengerjaan = $this->data_paket_pengerjaan();
		$data_kontraktual = $this->data_kontraktual();
		$data_swakelola = $this->data_swakelola();
		$kelompok_pengerjaan = $this->data_kelompok_pengerjaan();
		$posisi_kontrak = $this->data_posisi_kontrak();
		$data_provinsi = array();
		$data_kppn = array();
		$data_paket = $this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row();
		foreach($this->lmm->get_kppn() as $row2)
		{
			$data_kppn[$row2->KDKPPN] = $row2->NMKPPN;
		}
		foreach($this->lmm->get_provinsi() as $row)
		{
			$data_provinsi[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['data_kelompok_pengerjaan'] = $this->data_kelompok_pengerjaan();
		$data['data_posisi_kontrak'] = $this->data_posisi_kontrak();
		$data['kppn'] = $data_kppn;
		$data['data_provinsi'] = $data_provinsi;
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
		if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->num_rows > 0)
		{
			$data['paket_pengerjaan'] = $paket_pengerjaan[$data_paket->paket_pengerjaan];
			if($data_paket->paket_pengerjaan == 0)
			{
				$data['jenis_paket'] = $data_kontraktual[$data_paket->jenis_paket];
			}
			else
			{
				$data['jenis_paket'] = $data_swakelola[$data_paket->jenis_paket];
			}
			$data['kelompok_pengerjaan'] = $kelompok_pengerjaan[$data_paket->kelompok_pengerjaan];
			$data['posisi_kontrak'] = $posisi_kontrak[$data_paket->posisi_kontrak];
			$data['provinsi'] = $this->lmm->get_nama_provinsi_by_kode_provinsi($data_paket->KodeProvinsi)->row()->NamaProvinsi;
			$data['kabupaten'] = $this->lmm->get_nama_kabupaten_by_kode_kabupaten($data_paket->KodeKabupaten,$data_paket->KodeProvinsi)->row()->NamaKabupaten;
			$data['kppn_detail'] = $this->lmm->get_nama_kppn_by_kode_kppn($data_paket->KDKPPN)->row()->NMKPPN;
			$data['paket_lanjutan'] = $data_paket->paket_lanjutan;
			$this->load->view('e-monev/info_paket',$data);
		}
		else
		{
			$this->load->view('e-monev/form_paket',$data);
		}
	}
	
	function edit_paket($d_skmpnen_id)
	{
		$data_provinsi = array();
		$data_kppn = array();
		foreach($this->lmm->get_kppn() as $row2)
		{
			$data_kppn[$row2->KDKPPN] = $row2->NMKPPN;
		}
		foreach($this->lmm->get_provinsi() as $row)
		{
			$data_provinsi[$row->KodeProvinsi] = $row->NamaProvinsi;
		}
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
		$data['data_kelompok_pengerjaan'] = $this->data_kelompok_pengerjaan();
		$data['data_posisi_kontrak'] = $this->data_posisi_kontrak();
		$data['kppn'] = $data_kppn;
		$data['data_provinsi'] = $data_provinsi;
		$data_paket = $this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row();
		$data['paket_pengerjaan_dipilih'] = $data_paket->paket_pengerjaan;
		$data['jenis_paket_dipilih'] = $data_paket->jenis_paket;
		$data['kelompok_pengerjaan_dipilih'] = $data_paket->kelompok_pengerjaan;
		$data['posisi_kontrak_dipilih'] = $data_paket->posisi_kontrak;
		$data['provinsi_dipilih'] = $data_paket->KodeProvinsi;
		$data['kabupaten_dipilih'] = $data_paket->KodeKabupaten;
		$data['kppn_detail_dipilih'] = $data_paket->KDKPPN;
		$data['paket_lanjutan_dipilih'] = $data_paket->paket_lanjutan;
		$this->load->view('e-monev/form_edit_paket',$data);
	}
	
	function edit_detail_prakontrak($d_skmpnen_id)
	{
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data_kategori_pengadaan = $this->data_kategori_pengadaan();
		$data_cara_pengadaan = $this->data_cara_pengadaan();
		
		$data_prakontrak = $this->lmm->get_prakontrak_by_d_skmpnen_id($d_skmpnen_id)->row();
		$data['kategori_pengadaan'] = $data_kategori_pengadaan;
		$data['cara_pengadaan'] = $data_cara_pengadaan;
		$data['kategori_pengadaan_dipilih'] = $data_prakontrak->kategori_pengadaan;
		$data['cara_pengadaan_dipilih'] = $data_prakontrak->cara_pengadaan;
		$data['nilai_hps_oe'] = $data_prakontrak->nilai_hps_oe;
		$this->load->view('e-monev/form_edit_detail_prakontrak',$data);
	}
	
	function edit_detail_kontrak($d_skmpnen_id)
	{
		$nama_bank = array();
		foreach($this->bm->get_all_bank()->result() as $row)
		{
			$nama_bank[$row->bank_id] = $row->nama_bank;
		}
		$data_kontrak = $this->lmm->get_kontrak_by_d_skmpnen_id($d_skmpnen_id)->row();
		$tanggal_ttd = explode("-",$data_kontrak->tanggal_ttd);
		$tanggal_spmk = explode("-",$data_kontrak->tanggal_spmk);
		$tanggal_selesai = explode("-",$data_kontrak->tanggal_selesai);
		$waktu_pelaksanaan = explode("-",$data_kontrak->waktu_pelaksanaan);
		$data['realisasi_keuangan'] = $data_kontrak->realisasi_keuangan;
		$data['realisasi_fisik'] = $data_kontrak->realisasi_fisik;
		$data['nilai_kontrak'] = $data_kontrak->nilai_kontrak;
		$data['phln'] = $data_kontrak->phln;
		if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row()->paket_lanjutan == 0)
		{
			$data['input_nilai_kontrak'] = $this->load->view('e-monev/nilai_kontrak3',$data,true);
		}
		else
		{
			$data['input_nilai_kontrak'] = $this->load->view('e-monev/nilai_kontrak4',null,true);
		}
		
		$data['nomor_kontrak'] = $data_kontrak->nomor_kontrak;
		$data['tanggal_ttd'] = $tanggal_ttd[2].'-'.$tanggal_ttd[1].'-'.$tanggal_ttd[0];
		$data['tanggal_pelaksanaan'] = $waktu_pelaksanaan[2].'-'.$waktu_pelaksanaan[1].'-'.$waktu_pelaksanaan[0];
		$data['tanggal_spmk'] = $tanggal_spmk[2].'-'.$tanggal_spmk[1].'-'.$tanggal_spmk[0];
		$data['tanggal_selesai'] = $tanggal_selesai[2].'-'.$tanggal_selesai[1].'-'.$tanggal_selesai[0];
		$data['rekanan_utama'] = $data_kontrak->rekanan_utama;
		$data['alamat'] = $data_kontrak->alamat;
		$data['nama_bank'] = $nama_bank;
		$data['bank_dipilih'] = $data_kontrak->bank_id;
		$data['npwp'] = $data_kontrak->npwp;
		$this->load->view('e-monev/form_detail_kontrak3',$data);
	}
	
	function daftar_masalah($d_skmpnen_id)
	{
		if($this->lmm->cek_permasalahan_by_d_skmpnen_id($d_skmpnen_id) == FALSE)
		{
			foreach($this->bulan() as $key=>$value)
			{
				$data = array(
					'd_skmpnen_id' => $d_skmpnen_id,
					'thang' => 2013,
					'bulan' => $key,
					'isi_permasalahan' => '-',
					'upaya_penyelesaian' => '-'
					);
				$this->lmm->add($data);
			}
		}
		$data['bulan'] = $this->bulan();
		$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
		$data['daftar_permasalahan'] = $this->lmm->get_permasalahan($d_skmpnen_id);
		$this->load->view('e-monev/grid_permasalahan',$data);
	}
	
	function daftar_rencana($d_skmpnen_id)
	{
		if($this->lmm->cek_paket2($d_skmpnen_id)->num_rows() > 0)
		{
			if($this->lmm->cek_rencana_by_d_skmpnen_id($d_skmpnen_id) == FALSE)
			{
				foreach($this->bulan() as $key=>$value)
				{
					$data = array(
						'd_skmpnen_id' => $d_skmpnen_id,
						'tahun' => $this->session->userdata('thn_anggaran'),
						'bulan' => $key,
						'fisik' => '0',
						'keuangan' => '0'
						);
					$this->lmm->add_rencana($data);
				}
			}
				
			if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
			{
				$data['bulan'] = $this->bulan();
				$data['d_skmpnen_id'] = $d_skmpnen_id;
				$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
				$data['daftar_rencana'] = $this->lmm->get_rencana($d_skmpnen_id);
				$this->load->view('e-monev/grid_rencana',$data);
			}
			else
			{
				$data['bulan'] = $this->bulan();
				$data['d_skmpnen_id'] = $d_skmpnen_id;
				$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
				$data['added_script'] = '<script type="text/javascript">
										$(document).ready(function(){
										  get_html_data(base_url+"index.php/e-monev/laporan_monitoring_bc/rencana_keuangan/'.$d_skmpnen_id.'",\'\', \'profile_detail_loading\', \'tabel_rencana\');
										});
										</script>';
				$this->load->view('e-monev/grid_rencana2',$data);
			}
		}
		else
		{
			echo 'Data paket belum diisi. Silakan isi terlebih dahulu';
		}
	}
	
	function daftar_progres($d_skmpnen_id)
	{
		if($this->lmm->cek_paket2($d_skmpnen_id)->num_rows() > 0)
		{
			if($this->lmm->cek_progres_by_d_skmpnen_id($d_skmpnen_id) == FALSE)
			{
				foreach($this->bulan() as $key=>$value)
				{
					$data = array(
						'd_skmpnen_id' => $d_skmpnen_id,
						'tahun' => $this->session->userdata('thn_anggaran'),
						'bulan' => $key,
						'fisik' => '0',
						'keuangan' => '0'
						);
					$this->lmm->add_progres($data);
				}
			}
				
			if($this->lmm->cek_paket_pengerjaan($d_skmpnen_id)->num_rows() > 0)
			{
				$data['bulan'] = $this->bulan();
				$data['d_skmpnen_id'] = $d_skmpnen_id;
				$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
				$data['daftar_progres'] = $this->lmm->get_progres($d_skmpnen_id);
				$this->load->view('e-monev/grid_progres',$data);
			}
			else
			{
				$nilai_persiapan = 0;
				$nilai_pelaksanaan = 0;
				$nilai_pembuatan_laporan = 0;
				$nilai_dokumen_laporan = 0;
				foreach($this->lmm->get_progres_by_id($d_skmpnen_id)->result() as $row)
				{
					$nilai_persiapan = $nilai_persiapan + $row->persiapan;
					$nilai_pelaksanaan = $nilai_pelaksanaan + $row->pelaksanaan;
					$nilai_pembuatan_laporan = $nilai_pembuatan_laporan + $row->pembuatan_laporan;
					$nilai_dokumen_laporan = $nilai_dokumen_laporan + $row->dokumen_laporan;
				}
				$data['nilai_persiapan'] = $nilai_persiapan;
				$data['nilai_pelaksanaan'] = $nilai_pelaksanaan;
				$data['nilai_pembuatan_laporan'] = $nilai_pembuatan_laporan;
				$data['nilai_dokumen_laporan'] = $nilai_dokumen_laporan;
				$data['bulan'] = $this->bulan();
				$data['d_skmpnen_id'] = $d_skmpnen_id;
				$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
				$data['daftar_progres'] = $this->lmm->get_progres($d_skmpnen_id);
				$this->load->view('e-monev/grid_progres_swakelola',$data);
			}
		}
		else
		{
			echo 'Data paket belum diisi. Silakan isi terlebih dahulu';
		}
	}
	
	function rencana_keuangan($d_skmpnen_id)
	{
		$data['bulan'] = $this->bulan();
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
		$data['daftar_rencana'] = $this->lmm->get_rencana($d_skmpnen_id);
		$this->load->view('e-monev/grid_rencana3',$data);
	}
	
	function rencana_fisik($d_skmpnen_id)
	{	
		$nilai_persiapan = 0;
		$nilai_pelaksanaan = 0;
		$nilai_pembuatan_laporan = 0;
		$nilai_dokumen_laporan = 0;
		foreach($this->lmm->get_rencana_by_id($d_skmpnen_id)->result() as $row)
		{
			$nilai_persiapan = $nilai_persiapan + $row->persiapan;
			$nilai_pelaksanaan = $nilai_pelaksanaan + $row->pelaksanaan;
			$nilai_pembuatan_laporan = $nilai_pembuatan_laporan + $row->pembuatan_laporan;
			$nilai_dokumen_laporan = $nilai_dokumen_laporan + $row->dokumen_laporan;
		}
		$data['nilai_persiapan'] = $nilai_persiapan;
		$data['nilai_pelaksanaan'] = $nilai_pelaksanaan;
		$data['nilai_pembuatan_laporan'] = $nilai_pembuatan_laporan;
		$data['nilai_dokumen_laporan'] = $nilai_dokumen_laporan;
		$data['bulan'] = $this->bulan();
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['sub_komponen'] = $this->lmm->get_sub_komponen_by_id($d_skmpnen_id)->row()->urskmpnen;
		$data['daftar_rencana'] = $this->lmm->get_rencana($d_skmpnen_id);
		$this->load->view('e-monev/grid_rencana4',$data);
	}
	
	function coba_ajax()
	{
		$data['data1'] = $this->data_dummy_array();
		$data['content'] = $this->load->view('e-monev/coba_ajax',$data,true);
		$this->load->view('main',$data);
	}
	
	function save_masalah($id)
	{
		$permasalahan = $this->input->post('permasalahan');
		$upaya_penyelesaian = $this->input->post('upaya');
		$data = array(
				'isi_permasalahan'=> $permasalahan,
				'upaya_penyelesaian'=> $upaya_penyelesaian
					);
		$this->lmm->update($id,$data);
	}
	
	function save_rencana($id)
	{
		$fisik = $this->input->post('fisik');
		$keuangan = $this->input->post('keuangan');
		$data = array(
				'fisik'=> $fisik,
				'keuangan'=> $keuangan
					);
		$this->lmm->update_rencana($id,$data);
	}
	
	function save_rencana2($id)
	{
		$keuangan = $this->input->post('keuangan');
		$data = array(
				'keuangan'=> $keuangan
					);
		$this->lmm->update_rencana($id,$data);
	}
	
	function save_rencana3($id)
	{
		$nilai_persiapan = 0;
		$nilai_pelaksanaan = 0;
		$nilai_pembuatan_laporan = 0;
		$nilai_dokumen_laporan = 0;
		$persiapan = $this->input->post('persiapan');
		$pelaksanaan = $this->input->post('pelaksanaan');
		$pembuatan_laporan = $this->input->post('pembuatan_laporan');
		$dokumen_laporan = $this->input->post('dokumen_laporan');
		$fisik = $persiapan + $pelaksanaan + $pembuatan_laporan + $dokumen_laporan;
		$data = array(
						'persiapan'=> $persiapan,
						'pelaksanaan'=> $pelaksanaan,
						'pembuatan_laporan'=> $pembuatan_laporan,
						'dokumen_laporan'=> $dokumen_laporan,
						'fisik'=> $fisik
					);
		$this->lmm->update_rencana($id,$data);
	}
	
	// fungsi untuk download file yg ter-upload
	function download($progres_id)
	{
		// gett the file from DB
		$this->load->helper('download');
		$record = $this->lmm->get_progres_by_id($progres_id);
		if($record->num_rows() > 0 )
		{
			$nama_paket = $record->row()->dok_bukti_fisik;
			if (is_file('./file/'.$nama_paket)){
				$data = file_get_contents('./file/'.$nama_paket);			
				force_download($nama_paket, $data); 
			}
		}
		else
		{
			echo 'tidak ada file yang ditemukan';
		}
	}// end of download
	
	function save_progres($id)
	{
		$config['upload_path'] = './file/';
		$config['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg';
		$config['max_size']  = '10240';

		$this->load->library('upload', $config);
		
		// create directory if doesn't exist
		if(!is_dir($config['upload_path']))	mkdir($config['upload_path'], 0777);
		
		$file='';
		if(!empty($_FILES['file']['name'])){			
			$upload = $this->upload->do_upload('file');
			$data = $this->upload->data('file');
			if($data['file_size'] > 0) $file = $data['file_name'];
		}
		$data_file = array(
							'tanggal' 	=> date('Y-m-d'),
							'fisik' 	=> $this->input->post('fisik'),
							'dok_bukti_fisik' 	=> $file
		);
		$this->lmm->update_progres($id, $data_file);
		redirect('e-monev/laporan_monitoring_bc/input_progres_fisik/'.$this->input->post('d_skmpnen_id'));
	}
	
//ini
	function save_progres2($id)
	{
		$nilai_persiapan = 0;
		$nilai_pelaksanaan = 0;
		$nilai_pembuatan_laporan = 0;
		$nilai_dokumen_laporan = 0;
		$persiapan = $this->input->post('persiapan');
		$pelaksanaan = $this->input->post('pelaksanaan');
		$pembuatan_laporan = $this->input->post('pembuatan_laporan');
		$dokumen_laporan = $this->input->post('dokumen_laporan');
		$fisik = $persiapan + $pelaksanaan + $pembuatan_laporan + $dokumen_laporan;
		$data = array(
						'persiapan'=> $persiapan,
						'pelaksanaan'=> $pelaksanaan,
						'pembuatan_laporan'=> $pembuatan_laporan,
						'dokumen_laporan'=> $dokumen_laporan,
						'fisik'=> $fisik
					);
		$this->lmm->update_progres($id, $data);
	}

//	ini	
	function cek_dropdown($value)
	{
		if($value == 0)
		{
			//$this->form_validation->set_message('cek_dropdown', 'Kolom %s harus dipilih!!');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function update_paket($d_skmpnen_id)
	{
		$data = array(
					'paket_pengerjaan' => $this->input->post('paket_pengerjaan'),
					'jenis_paket' => $this->input->post('jenis_paket'),
					'kelompok_pengerjaan' => $this->input->post('kelompok_pengerjaan'),
					'posisi_kontrak' => $this->input->post('posisi_kontrak'),
					'KodeProvinsi' => $this->input->post('provinsi'),
					'KodeKabupaten' => $this->input->post('kabupaten'),
					'KDKPPN' => $this->input->post('kppn'),
					'paket_lanjutan' => $this->input->post('paket_lanjutan')
					);
		$this->lmm->update_paket($d_skmpnen_id, $data);
		$this->lmm->update_rencana($d_skmpnen_id, array('fisik'=>0));
	}
	
	function update_kontrak($d_skmpnen_id)
	{
		if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row()->paket_lanjutan == 0)
		{
			$tanggal_ttd = explode("-",$this->input->post('tanggal_ttd'));
			$waktu_pelaksanaan = explode("-",$this->input->post('tanggal_pelaksanaan'));
			$tanggal_spmk = explode("-",$this->input->post('tanggal_spmk'));
			$tanggal_selesai = explode("-",$this->input->post('tanggal_selesai'));
			$data = array(
					'nomor_kontrak' => $this->input->post('nomor_kontrak'),
					'tanggal_ttd' => $tanggal_ttd[2].'-'.$tanggal_ttd[1].'-'.$tanggal_ttd[0],
					'waktu_pelaksanaan' => $waktu_pelaksanaan[2].'-'.$waktu_pelaksanaan[1].'-'.$waktu_pelaksanaan[0],
					'tanggal_spmk' => $tanggal_spmk[2].'-'.$tanggal_spmk[1].'-'.$tanggal_spmk[0],
					'tanggal_selesai' => $tanggal_selesai[2].'-'.$tanggal_selesai[1].'-'.$tanggal_selesai[0],
					'rekanan_utama' => $this->input->post('rekanan_utama'),
					'alamat' => $this->input->post('alamat'),
					'npwp' => $this->input->post('npwp'),
					'realisasi_keuangan' => $this->input->post('realisasi_keuangan'),
					'realisasi_fisik' => $this->input->post('realisasi_fisik'),
					'nilai_kontrak' => $this->input->post('nilai_kontrak'),
					'phln' => $this->input->post('phln'),
					'bank_id' => $this->input->post('nama_bank'),
					'd_skmpnen_id' => $d_skmpnen_id
					);
			$this->lmm->update_data_kontrak($d_skmpnen_id,$data);
		}
		else
		{
			$data = array(
					'nomor_kontrak' => $this->input->post('nomor_kontrak'),
					'tanggal_ttd' => $this->input->post('tanggal_ttd'),
					'tanggal_pelaksanaan' => $this->input->post('tanggal_pelaksanaan'),
					'tanggal_spmk' => $this->input->post('tanggal_spmk'),
					'tanggal_selesai' => $this->input->post('tanggal_selesai'),
					'rekanan_utama' => $this->input->post('rekanan_utama'),
					'alamat' => $this->input->post('alamat'),
					'npwp' => $this->input->post('npwp'),
					'nilai_kontrak' => $this->input->post('nilai_kontrak'),
					'phln' => $this->input->post('phln'),
					'bank_id' => $this->input->post('nama_bank')
					);
			$this->lmm->update_data_kontrak($d_skmpnen_id,$data);
		}
	}
	
	function update_data_detail_prakontrak($d_skmpnen_id)
	{
		$data = array(
					'kategori_pengadaan' => $this->input->post('kategori_pengadaan'),
					'cara_pengadaan' => $this->input->post('cara_pengadaan'),
					'nilai_hps_oe' => $this->input->post('nilai_hps_oe')
					);
		$this->lmm->update_data_detail_prakontrak($d_skmpnen_id, $data);
	}
	
	function save_data_jadual_pelaksanaan($id)
	{
		$tanggal_post = explode("-",$this->input->post('tanggal'));
		$tanggal_db = $tanggal_post[2].'-'.$tanggal_post[1].'-'.$tanggal_post[0];
		$data = array(
					'd_skmpnen_id' => $id,
					'uraian_kegiatan' => $this->input->post('uraian_kegiatan'),
					'tanggal' => $tanggal_db
					);
		$this->lmm->add_jadual_pelaksanaan($data);
	}
	
	function save_paket($id)
	{
		$data = array(
					'd_skmpnen_id' => $id,
					'paket_pengerjaan' => $this->input->post('paket_pengerjaan'),
					'jenis_paket' => $this->input->post('jenis_paket'),
					'kelompok_pengerjaan' => $this->input->post('kelompok_pengerjaan'),
					'posisi_kontrak' => $this->input->post('posisi_kontrak'),
					'KodeProvinsi' => $this->input->post('provinsi'),
					'KodeKabupaten' => $this->input->post('kabupaten'),
					'KDKPPN' => $this->input->post('kppn'),
					'paket_lanjutan' => $this->input->post('paket_lanjutan')
					);
		$this->lmm->add_paket($data);
	}
	
	function save_data_detail_prakontrak($d_skmpnen_id)
	{
		$data = array(
					'd_skmpnen_id' => $d_skmpnen_id,
					'kategori_pengadaan' => $this->input->post('kategori_pengadaan'),
					'cara_pengadaan' => $this->input->post('cara_pengadaan'),
					'nilai_hps_oe' => $this->input->post('nilai_hps_oe')
					);
		$this->lmm->add_detailprakontrak($data);
	}
	
	function save_data_kontrak($d_skmpnen_id)
	{
		if($this->lmm->get_paket_by_d_skmpnen_id($d_skmpnen_id)->row()->paket_lanjutan == 0)
		{
			$tanggal_ttd = explode("-",$this->input->post('tanggal_ttd'));
			$waktu_pelaksanaan = explode("-",$this->input->post('tanggal_pelaksanaan'));
			$tanggal_spmk = explode("-",$this->input->post('tanggal_spmk'));
			$tanggal_selesai = explode("-",$this->input->post('tanggal_selesai'));
			$data = array(
					'nomor_kontrak' => $this->input->post('nomor_kontrak'),
					'tanggal_ttd' => $tanggal_ttd[2].'-'.$tanggal_ttd[1].'-'.$tanggal_ttd[0],
					'waktu_pelaksanaan' => $waktu_pelaksanaan[2].'-'.$waktu_pelaksanaan[1].'-'.$waktu_pelaksanaan[0],
					'tanggal_spmk' => $tanggal_spmk[2].'-'.$tanggal_spmk[1].'-'.$tanggal_spmk[0],
					'tanggal_selesai' => $tanggal_selesai[2].'-'.$tanggal_selesai[1].'-'.$tanggal_selesai[0],
					'rekanan_utama' => $this->input->post('rekanan_utama'),
					'alamat' => $this->input->post('alamat'),
					'npwp' => $this->input->post('npwp'),
					'realisasi_keuangan' => $this->input->post('realisasi_keuangan'),
					'realisasi_fisik' => $this->input->post('realisasi_fisik'),
					'nilai_kontrak' => $this->input->post('nilai_kontrak'),
					'phln' => $this->input->post('phln'),
					'bank_id' => $this->input->post('nama_bank'),
					'd_skmpnen_id' => $d_skmpnen_id
					);
			$this->lmm->add_data_kontrak($data);
		}
		else
		{
			$data = array(
					'nomor_kontrak' => $this->input->post('nomor_kontrak'),
					'tanggal_ttd' => $this->input->post('tanggal_ttd'),
					'tanggal_pelaksanaan' => $this->input->post('tanggal_pelaksanaan'),
					'tanggal_spmk' => $this->input->post('tanggal_spmk'),
					'tanggal_selesai' => $this->input->post('tanggal_selesai'),
					'rekanan_utama' => $this->input->post('rekanan_utama'),
					'alamat' => $this->input->post('alamat'),
					'npwp' => $this->input->post('npwp'),
					'nilai_kontrak' => $this->input->post('nilai_kontrak'),
					'phln' => $this->input->post('phln'),
					'bank_id' => $this->input->post('nama_bank')
					);
			$this->lmm->add_data_kontrak($data);
		}
	}
	
	function form_input_masalah($id,$bulan)
	{
		$result = $this->lmm->get_permasalahan_by_id($id)->row();
		$array_bulan = $this->bulan();
		$data['isi_permasalahan'] = $result->isi_permasalahan;
		$data['upaya_penyelesaian'] = $result->upaya_penyelesaian; 
		$data['permasalahan_id'] = $id;
		$data['bulan'] = $array_bulan[$bulan];
		$this->load->view('e-monev/form_input_masalah',$data);
	}
	
	function upload_file($field_name)
	{	
		$config['upload_path'] = './file';
		$config['allowed_types'] ='doc|docx|pdf|txt|jpg|jpeg';
		
		$this->load->library('upload', $config);		
		$files = $this->upload->do_upload($field_name);	
				
		$out = '';		
		if (  ! $files ){
			$out .= array('error' => $this->upload->display_errors());
			return "";
		}	
		else{
			$data = $this->upload->data($field_name);
			$file_name = $data['file_name'];
			$path[0] = 'file/'.$file_name;
			$path[1] = $file_name;
			return $path;
		}
	}
	
	function form_input_progres($d_skmpnen_id,$id, $bulan)
	{
		$result = $this->lmm->get_progres_by_id($id)->row();
		$array_bulan = $this->bulan();
		$data['fisik'] = $result->fisik; 
		$data['progres_id'] = $id;
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['bulan'] = $array_bulan[$bulan];
		$this->load->view('e-monev/form_input_progres',$data);
	}
	
	function form_input_rencana($d_skmpnen_id,$id,$bulan)
	{
		$result = $this->lmm->get_rencana_by_id($id)->row();
		$array_bulan = $this->bulan();
		$data['fisik'] = $result->fisik;
		$data['keuangan'] = $result->keuangan; 
		$data['rencana_id'] = $id;
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['bulan'] = $array_bulan[$bulan];
		$this->load->view('e-monev/form_input_rencana',$data);
	}
	
	function form_input_rencana2($d_skmpnen_id,$id,$bulan)
	{
		$result = $this->lmm->get_rencana_by_id($id)->row();
		$array_bulan = $this->bulan();
		$data['keuangan'] = $result->keuangan; 
		$data['rencana_id'] = $id;
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['bulan'] = $array_bulan[$bulan];
		$this->load->view('e-monev/form_input_rencana2',$data);
	}
	
	function form_input_rencana3($d_skmpnen_id,$id,$bulan)
	{
		$result = $this->lmm->get_rencana_by_id($id)->row();
		$array_bulan = $this->bulan();
		$data['fisik'] = $result->fisik;
		$data['persiapan'] = $result->persiapan; 
		$data['pelaksanaan'] = $result->pelaksanaan; 
		$data['pembuatan_laporan'] = $result->pembuatan_laporan; 
		$data['dokumen_laporan'] = $result->dokumen_laporan; 
		$data['rencana_id'] = $id;
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['bulan'] = $array_bulan[$bulan];
		$this->load->view('e-monev/form_input_rencana3',$data);
	}
	
//ini
	function form_input_progres2($d_skmpnen_id,$id,$bulan)
	{
		$result = $this->lmm->get_progres_by_id($id)->row();
		$array_bulan = $this->bulan();
		$data['fisik'] = $result->fisik;
		$data['persiapan'] = $result->persiapan; 
		$data['pelaksanaan'] = $result->pelaksanaan; 
		$data['pembuatan_laporan'] = $result->pembuatan_laporan; 
		$data['dokumen_laporan'] = $result->dokumen_laporan; 
		$data['progres_id'] = $id;
		$data['d_skmpnen_id'] = $d_skmpnen_id;
		$data['bulan'] = $array_bulan[$bulan];
		$this->load->view('e-monev/form_input_progres2',$data);
	}
	
//ini
	function delete_jadual_pelaksanaan($jadual_pelaksanaan_id)
	{
		$this->lmm->delete('monev.jadual_pelaksanaan','jadual_pelaksanaan_id',$jadual_pelaksanaan_id);
	}
	

}//end class

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
