<?php 

class PotonganGaji extends CI_Controller{
	public function __construct(){
		parent::__construct();

		if ($this->session->userdata('hak_akses') !='1') {
			$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong> Anda Harus Login!</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>');
			redirect('welcome');
		}
	}
	public function index()
	{
		$data['title'] = "Setting Potongan Gaji Pegawai";
		$data['pot_gaji'] = $this->penggajianModel->get_data('potongan_gaji')->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/potonganGaji',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahData()
	{
		$data['title'] = "Tambah Potongan Gaji Pegawai";
		$data['pot_gaji'] = $this->penggajianModel->get_data('potongan_gaji')->result();
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambahPotonganGaji',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambahDataAksi()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->tambahData();
		}else{
			$potongan 		= $this->input->post('potongan');
			$jml_potongan 	= $this->input->post('jml_potongan');

			$data 	= array(
				'potongan' => $potongan,
				'jml_potongan' => $jml_potongan
			);

			$this->penggajianModel->insert_data($data,'potongan_gaji');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Jabatan Berhasil Ditambahkan !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			redirect('admin/potonganGaji');
		}
	}

	//edit 

	public function updateData($id)
	{
		$where = array('id' => $id);
		$data['pot_gaji'] = $this->db->query("SELECT * FROM potongan_gaji WHERE id='$id'")->result();
		$data['title'] = "Update Potongan Gaji";
		$this->load->view('templates_admin/header',$data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/updatePotonganGaji',$data);
		$this->load->view('templates_admin/footer');
	}

	public function updateDataAksi()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->updateData();
		}else{
			$id            	 = $this->input->post('id');
			$potongan 		 = $this->input->post('potongan');
			$jml_potongan    = $this->input->post('jml_potongan');

			$data = array(
				'potongan'		 => $potongan,
				'jml_potongan'   => $jml_potongan,
			);

			$where = array(
				'id' => $id
			);

			$this->penggajianModel->update_data('potongan_gaji',$data,$where);
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Potongan Gaji Berhasil Diedit !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			redirect('admin/potonganGaji');
		}
	}

	//delete

	public function deleteData($id)
	{
		$where = array('id' => $id);
		$this->penggajianModel->delete_data($where, 'potongan_gaji');
		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Data Potongan Gaji Berhasil Dihapus !</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>');
		redirect('admin/potonganGaji');
	}



	public function _rules()
	{
		$this->form_validation->set_rules('potongan','Potongan','required');
		$this->form_validation->set_rules('jml_potongan','Jumlah Potongan','required');
	}
}
?>