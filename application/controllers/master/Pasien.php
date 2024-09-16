<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('pasien_id')) {
            // redirect('auth/login');
        }
        $this->load->model('pasien_model');
        $this->load->model('obat_model'); // Pastikan model ini ada dan digunakan untuk mengambil data obat
    }

    public function index()
    {
        $data['pasien'] = $this->pasien_model->get_data('tb_pasien')->result();
        $data['pasien'] = $this->pasien_model->get_all_pasien();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_pasien', $data);
        $this->load->view('templates/footer');
    }


    public function form($id_pasien = null) {
        $data['pasien'] = $this->pasien_model->get_data('tb_pasien')->result();
        $data['obat'] = $this->pasien_model->get_data('tb_obat')->result();
        
        if ($id_pasien) {
            $data['pasien_edit'] = $this->pasien_model->get_data('tb_pasien', ['id_pasien' => $id_pasien])->row();
        } else {
            $data['pasien_edit'] = null;
        }

        $data['obat'] = $this->pasien_model->get_data('tb_obat')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_pasien', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        // Ambil data obat dari tabel tb_obat
        $data['obat'] = $this->db->get('tb_obat')->result();

        // Load view dan kirim data obat
        $this->load->view('nama_view', $data);
        $data = [
            'id_pasien' => $this->input->post('id_pasien'),
            'pasien' => $this->input->post('pasien'),
            'alamat' => $this->input->post('alamat'),
            'gejala' => $this->input->post('gejala'),
            'id_obat' => $this->input->post('id_obat'),
        ];

        $this->pasien_model->insert_data($data, 'tb_pasien');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show col-sm-3" role="alert">
        Data pasien berhasil ditambahkan!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/pasien');
    }

    public function update()
    {
        $id_pasien = $this->input->post('id_pasien');

        $data = [
            'pasien' => $this->input->post('pasien'),
            'alamat' => $this->input->post('alamat'),
            'gejala' => $this->input->post('gejala'),
            'id_obat' => $this->input->post('id_obat'),
        ];

        $this->pasien_model->update_data($data, ['id_pasien' => $id_pasien], 'tb_pasien');

        $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show col-sm-3" role="alert">
        Data pasien berhasil diupdate!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/pasien');
    }

    public function delete($id_pasien)
    {
        $this->pasien_model->delete_data(['id_pasien' => $id_pasien], 'tb_pasien');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show col-sm-3" role="alert">
        Data pasien berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/pasien');
    }
}
