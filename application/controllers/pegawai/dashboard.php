<?php

class Dashboard extends CI_Controller{
	
	public function index()
	{
		$data['title'] ="Dashboard Pegawai";		
		$id = $this->session->userdata('id_pegawai');
		$data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai 
			WHERE id_pegawai='$id'")->result();
		$this->load->view('templates_pegawai/header',$data);
		$this->load->view('templates_pegawai/sidebar');
		$this->load->view('pegawai/dashboard',$data);
		$this->load->view('templates_pegawai/footer');
	}
}

?>