<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	public function __construct()
	{	
		parent::__construct();
		
		$this->load->library('form_validation'); 
		if ($this->session->userdata('logged_in') == false) {
			redirect('auth');
		}
		$this->load->view('lib/f_library');
		$this->load->view('lib/f_notification');
		$this->load->model('Pegawai');

		$idgue = $this->session->userdata('id_pegawai');
		$dataku['dataku'] = $this->Pegawai->dataku($idgue);
		
		date_default_timezone_set('Asia/Makassar');

		$this->load->view('main/extend/header', $dataku);
		$this->load->model('Product_model');
        $this->load->helper('security');
	}

	public function index()
	{
		
		$data['data_stok'] = $this->Product_model->get_all_stok();
		// var_dump($data['chart_labels']);
		$this->load->view('main/stok/laporan', $data);

		$this->load->view('main/extend/footer');
	}

    public function add_laporan()
	{
    
    $this->form_validation->set_rules('id_product', 'Nama Product', 'required');
    $this->form_validation->set_rules('stok', 'Stok', 'required');

    if ($this->form_validation->run() == FALSE) {
        $errors[] = validation_errors();
    } else {
        $id_product = $this->input->post('id_product');
        $stok = $this->input->post('stok');
		$tanggal = date('Y-m-d');

        if (!is_numeric($stok)) {
            $errors[] = "Stokharus berupa angka. Silakan coba lagi.";
        } else {
			if ($this->Product_model->check_duplicate_laporan($tanggal, $id_product)) {
				$this->session->set_flashdata('error', 'Laporan Barang di tanggal hari ini sudah ada !');
				redirect('laporan');
			} else {
                $data = array(
                    'id_product' => $id_product,
                    'stok_terjual' => $stok,
					'tanggal_terjual' => date('Y-m-d'),
                );
                $this->db->insert('tbl_penjualan', $data);
				$success = array("Data Laporan behasil di masukkan !");
				$this->session->set_flashdata('error', display_success($success));
            }
		}
        }

	redirect('laporan');

	}
	
}
