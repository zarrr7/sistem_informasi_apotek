<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('penjualan_id')) {
            // redirect('auth/login');
        }
        $this->load->model('penjualan_model');
    }
    public function index()
    {
        $data['penjualan'] = $this->penjualan_model->get_data('tb_penjualan')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_penjualan' , $data);
        $this->load->view('templates/footer');
    }

    public function form($id_penjualan = null)
    {
        $data['penjualan'] = $this->penjualan_model->get_data('tb_penjualan')->result();
        $data['obat'] = $this->penjualan_model->get_data('tb_obat')->result();
        
        if ($id_penjualan) {
            $data['penjualan_edit'] = $this->penjualan_model->get_data('tb_penjualan', ['id_penjualan' => $id_penjualan])->row();
        } else {
            $data['penjualan_edit'] = null;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_penjualan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'id_penjualan' => $this->input->post('id_penjualan'),
            'penjualan' => $this->input->post('penjualan'),

        ];

        $this->penjualan_model->insert_data($data, 'tb_penjualan');
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Data penjualan berhasil ditambahkan!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/penjualan');
    }

    public function update()
    {
        $id_penjualan = $this->input->post('id_penjualan');
        $data = [
            'penjualan' => $this->input->post('penjualan'),
        ];

        $this->penjualan_model->update_data($data, ['id_penjualan' => $id_penjualan], 'tb_penjualan');
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Data penjualan berhasil diupdate!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/penjualan');
    }

    public function delete($id_penjualan)
    {
        $this->penjualan_model->delete_data(['id_penjualan' => $id_penjualan], 'tb_penjualan');
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Data penjualan berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/penjualan');
    }
}