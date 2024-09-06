<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function get_all_products() {
        $this->db->select('*');
        $this->db->from('tbl_product');
        //$this->db->join('tbl_jenis_product', 'tbl_jenis_product.id_jenis_product = tbl_product.id_jenis_product', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_stok() {
        $this->db->select('*');
        $this->db->from('tbl_stok');
        $this->db->join('tbl_pegawai', 'tbl_stok.id_pegawai = tbl_pegawai.id_pegawai');
        $this->db->group_by('tbl_stok.tanggal');
        $this->db->order_by('tbl_stok.tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_stok_by_cabang($id, $tanggal) {
        $this->db->select('*');
        $this->db->from('tbl_stok');
        $this->db->join('tbl_product', 'tbl_product.id_product = tbl_stok.id_product');
        $this->db->join('tbl_pegawai', 'tbl_stok.id_pegawai = tbl_pegawai.id_pegawai');
        $this->db->where('tbl_stok.id_pegawai', $id);
        $this->db->where('tbl_stok.tanggal', $tanggal);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_cabang() {
        $this->db->select('*');
        $this->db->where('is_admin', '0');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function get_product($id) {
        $this->db->select('*');
        $this->db->from('tbl_product');
        $this->db->join('tbl_jenis_product', 'tbl_jenis_product.id_jenis_product = tbl_product.id_jenis_product', 'left');
        $this->db->where('id_product', $id);
        $query = $this->db->get();
        return $query->row();
    }

	function update_product($id_product, $data) {
        $this->db->where('id_product', $id_product);
        $this->db->update('tbl_product', $data);
        return $this->db->affected_rows();
    }

	public function delete_product($del_id) {
        $this->db->select('foto');
        $this->db->where('id_product', $del_id);
        $query = $this->db->get('tbl_product');
        $result = $query->row_array();
        if ($query->num_rows() > 0 && file_exists("./assets/images/products/".$result['foto'])) {
            unlink("./assets/images/products/".$result['foto']);
        }
        $this->db->where('id_product', $del_id);
        $this->db->delete('tbl_product');
        return true;
    }

    public function delete_stok($del_id) {
        $this->db->where('id_stok', $del_id);
        $this->db->delete('tbl_stok');
        return true;
    }

    public function check_duplicate_stok($tanggal, $id_product) {
        $this->db->where('tanggal', $tanggal);
        $this->db->where('id_product', $id_product);
        $query = $this->db->get('tbl_stok');

        if ($query->num_rows() > 0) {
            return true; // Data duplikat ditemukan
        } else {
            return false; // Tidak ada data duplikat
        }
    }

    public function check_duplicate_laporan($tanggal, $id_product) {
        $this->db->where('tanggal_terjual', $tanggal);
        $this->db->where('id_product', $id_product);
        $query = $this->db->get('tbl_penjualan');

        if ($query->num_rows() > 0) {
            return true; // Data duplikat ditemukan
        } else {
            return false; // Tidak ada data duplikat
        }
    }

	public function get_by_jenis($id) {
		$this->db->select('id_product');
        $this->db->from('tbl_product');
        $this->db->where('id_jenis_product', $id);
        $query = $this->db->get();
        return $query->num_rows();
	}

	public function get_jenis($id)
	{
        $this->db->select('*');
        $this->db->from('tbl_jenis_product');
        $this->db->where('id_jenis_product', $id);
        $query = $this->db->get();
        return $query->row();
	}

	public function get_all_jenis() {
        $this->db->select('*');
        $this->db->from('tbl_jenis_product');
        $query = $this->db->get();
        return $query->result();
    }

	public function get_jenis_name($name) {
		$this->db->select('nama_jenis_product');
        $this->db->from('tbl_jenis_product');
        $this->db->where('nama_jenis_product', $name);
        $query = $this->db->get();
        return $query->num_rows();
	}

	public function get_jenis_name_update($name, $id) {
		$this->db->select('nama_jenis_product');
        $this->db->from('tbl_jenis_product');
        $this->db->where('nama_jenis_product', $name, "and id_jenis_product != $id");
        $query = $this->db->get();
        return $query->num_rows();
	}
}
