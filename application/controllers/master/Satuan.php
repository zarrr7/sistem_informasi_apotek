<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('satuan_id')) {
            // redirect('auth/login');
        }
        $this->load->model('satuan_model');
    }

    public function index()
    {
        $data['active_page'] = 'satuan'; // Menandai halaman aktif
        $data['satuan'] = $this->satuan_model->get_data('tb_satuan')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_satuan', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_satuan = null)
    {
        $data['active_page'] = 'satuan'; // Menandai halaman aktif
        $data['satuan'] = $this->satuan_model->get_data('tb_satuan')->result();
        
        if ($id_satuan) {
            $data['satuan_edit'] = $this->satuan_model->get_data('tb_satuan', ['id_satuan' => $id_satuan])->row();
        } else {
            $data['satuan_edit'] = null;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_satuan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'id_satuan' => $this->input->post('id_satuan'),
            'satuan' => $this->input->post('satuan'),
        ];

        $this->satuan_model->insert_data($data, 'tb_satuan');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show col-sm-3" role="alert">
        Data satuan berhasil ditambahkan!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/satuan');
    }

    public function update()
{
    // Ambil id_satuan dari input form
    $id_satuan = $this->input->post('id_satuan');

    // Data yang akan diupdate
    $data = [
        'satuan' => $this->input->post('satuan'),
    ];

    // Pastikan $id_satuan diambil dari input dengan benar
    $this->satuan_model->update_data($data, ['id_satuan' => $id_satuan], 'tb_satuan');

    // Set flashdata sebagai feedback kepada pengguna
    $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show col-sm-3" role="alert">
    Data satuan berhasil diupdate!
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
     </button>
    </div>');
    redirect('master/satuan');
}

 
    public function delete($id_satuan)
    {
        $this->satuan_model->delete_data(['id_satuan' => $id_satuan], 'tb_satuan');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show col-sm-3" role="alert">
        Data satuan berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/satuan');
    }
} 
