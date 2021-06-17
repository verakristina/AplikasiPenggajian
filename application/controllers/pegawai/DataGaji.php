<?php

class DataGaji extends CI_Controller{
	
	public function index()
	{
		$data['title'] ="Data Gaji";		
		$nik = $this->session->userdata('nik');
		$data['potongan'] = $this->penggajianModel->get_data('potongan_gaji')->result();
		$data['gaji'] = $this->db->query(" SELECT data_pegawai.nama_pegawai,data_pegawai.nik,data_jabatan.gaji_pokok,data_jabatan.tj_transport,data_jabatan.uang_makan,data_kehadiran.alpha,data_kehadiran.bulan,data_kehadiran.id_kehadiran
			FROM data_pegawai
			INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
			INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
			WHERE data_kehadiran.nik='$nik'
			ORDER BY data_kehadiran.bulan DESC")->result();
		$this->load->view('templates_pegawai/header',$data);
		$this->load->view('templates_pegawai/sidebar');
		$this->load->view('pegawai/dataGaji',$data);
		$this->load->view('templates_pegawai/footer');
	}

	public function cetakSlip($id)
	{
		$data['title'] ="Cetak Slip Gaji";
		$data['potongan'] = $this->penggajianModel->get_data('potongan_gaji')->result();
		$nama = $this->input->post('nama_pegawai');

		$data['print_slip'] = $this->db->query("SELECT data_pegawai.nik,data_pegawai.nama_pegawai,data_jabatan.nama_jabatan,data_jabatan.gaji_pokok,data_jabatan.tj_transport,data_jabatan.uang_makan,data_kehadiran.alpha
		FROM data_pegawai
		INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
		INNER JOIN data_jabatan ON data_jabatan.nama_jabatan= data_pegawai.jabatan
		WHERE data_kehadiran.id_kehadiran='$id'")->result();
		$this->load->view('templates_pegawai/header',$data);
		$this->load->view('pegawai/cetakSlipGaji',$data);	
	}
}

?>