<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller {
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
		$this->load->view('main/stok/stok', $data);

		$this->load->view('main/extend/footer');
	}

	public function add_stok()
	{
    
    $this->form_validation->set_rules('id_product', 'Nama Product', 'required');
    $this->form_validation->set_rules('stok', 'Stok', 'required');

    if ($this->form_validation->run() == FALSE) {
        $errors[] = validation_errors();
    } else {
        $id_product = $this->input->post('id_product');
        $stok = $this->input->post('stok');


        if (!is_numeric($stok)) {
            $errors[] = "Stokharus berupa angka. Silakan coba lagi.";
        } else {
                $data = array(
                    'id_product' => $id_product,
                    'stok' => $stok,
					'tanggal' => date('Y-m-d'),
                );
                $this->db->insert('tbl_stok', $data);
				$success = array("Data Stok behasil di masukkan !");
				$this->session->set_flashdata('error', display_success($success));
            }
        }

	redirect('stok');

	}

	public function hapus_stok($id_stok)
	{
		$del_id = $id_stok;
			$delete = $this->Product_model->delete_stok($del_id);
			if($delete){
				$success[] = "Data stok berhasil dihapus.";
				$this->session->set_flashdata('error', display_success($success));
                redirect('stok');
			} else {
				$errors[] = "Data stok gagal dihapus.";
				$this->session->set_flashdata('error', display_errors($errors));
                redirect('stok');
			}
	}
	
}
