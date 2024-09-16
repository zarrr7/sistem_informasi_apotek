<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('supplier_id')) {
            // redirect('auth/login');
        }
        $this->load->model('supplier_model');
    }

    public function index()
    {
        $data['supplier'] = $this->supplier_model->get_data('tb_supplier')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_supplier', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_supplier = null)
    {
        if ($id_supplier) {
            // Mengambil data berdasarkan id_supplier yang diklik
            $data['supplier_edit'] = $this->supplier_model->get_data('tb_supplier', ['id_supplier' => $id_supplier])->row();
        } else {
            $data['supplier_edit'] = null;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_supplier', $data);
        $this->load->view('templates/footer');
    }


    public function tambah()
    {
        $data = [
            'id_supplier' => $this->input->post('id_supplier'),
            'supplier' => $this->input->post('supplier'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
        ];

        $this->supplier_model->insert_data($data, 'tb_supplier');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show col-sm-3" role="alert">
        Data supplier berhasil ditambahkan!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/supplier');
    }

    public function update()
    {
        // Ambil id_supplier dari input form
        $id_supplier = $this->input->post('id_supplier');

        // Data yang akan diupdate
        $data = [
            'supplier' => $this->input->post('supplier'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp')
        ];

        // Pastikan $id_supplier diambil dari input dengan benar
        $this->supplier_model->update_data($data, ['id_supplier' => $id_supplier], 'tb_supplier');

        // Set flashdata sebagai feedback kepada pengguna
        $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show col-sm-3" role="alert">
    Data supplier berhasil diupdate!
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
     </button>
    </div>');
        redirect('master/supplier');
    }


    public function delete($id_supplier)
    {
        $this->supplier_model->delete_data(['id_supplier' => $id_supplier], 'tb_supplier');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show col-sm-3" role="alert">
        Data supplier berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/supplier');
    }
}
