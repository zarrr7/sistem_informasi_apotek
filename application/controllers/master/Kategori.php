<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('kategori_id')) {
            // redirect('auth/login');
        }
        $this->load->model('kategori_model');
    }

    public function index()
    {
        $data['kategori'] = $this->kategori_model->get_data('tb_kategori')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_kategori', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_kategori = null)
    {
        $data['kategori'] = $this->kategori_model->get_data('tb_kategori')->result();
        
        if ($id_kategori) {
            $data['kategori_edit'] = $this->kategori_model->get_data('tb_kategori', ['id_kategori' => $id_kategori])->row();
        } else {
            $data['kategori_edit'] = null;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_kategori', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'id_kategori' => $this->input->post('id_kategori'),
            'kategori' => $this->input->post('kategori'),
        ];

        $this->kategori_model->insert_data($data, 'tb_kategori');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show col-sm-3" role="alert">
        Data kategori berhasil ditambahkan!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/kategori');
    }

    public function update()
{
    // Ambil id_kategori dari input form
    $id_kategori = $this->input->post('id_kategori');

    // Data yang akan diupdate
    $data = [
        'kategori' => $this->input->post('kategori'),
    ];

    // Pastikan $id_kategori diambil dari input dengan benar
    $this->kategori_model->update_data($data, ['id_kategori' => $id_kategori], 'tb_kategori');

    // Set flashdata sebagai feedback kepada pengguna
    $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show col-sm-3" role="alert">
    Data kategori berhasil diupdate!
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
     </button>
    </div>');
    redirect('master/kategori');
}


    public function delete($id_kategori)
    {
        $this->kategori_model->delete_data(['id_kategori' => $id_kategori], 'tb_kategori');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show col-sm-3" role="alert">
        Data kategori berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/kategori');
    }
    
}