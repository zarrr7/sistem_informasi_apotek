<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('user_model');
    }

    public function index()
    {
        $data['active_page'] = 'user'; // Menandai halaman aktif
        $data['user'] = $this->user_model->get_data('tb_user')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_user', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_user = null)
    {
        $data['active_page'] = 'user'; // Menandai halaman aktif
        $data['user'] = $this->user_model->get_data('tb_user')->result();

        if ($id_user) {
            $data['user_edit'] = $this->user_model->get_data('tb_user', ['id_user' => $id_user])->row();
        } else {
            $data['user_edit'] = null;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_user', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = [
            'id_user' => $this->input->post('id_user'),
            'username' => $this->input->post('username'),
            'role' => $this->input->post('role'),
            'password' => $this->input->post('password'),
        ];

        $this->user_model->insert_data($data, 'tb_user');
        // pesan sukses ditampilkan
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show col-sm-3" role="alert">
    Data User berhasil ditambahkan!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>');
        redirect('master/user');
    }


    public function update()
    {
        $id_user = $this->input->post('id_user');
        $user = $this->user_model->get_data('tb_user', ['id_user' => $id_user])->row();

        // Enkripsi ulang password hanya jika ada perubahan
        $password = $this->input->post('password');

        $data = [
            'username' => $this->input->post('username'),
            'role' => $this->input->post('role'),
            'password' => $password
        ];

        $this->user_model->update_data($data, ['id_user' => $id_user], 'tb_user');
        // pesan sukses ditampilkan
        $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show col-sm-3" role="alert">
    Data User berhasil diupdate!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>');
        redirect('master/user');
    }


    public function delete($id_user)
    {
        $this->user_model->delete_data(['id_user' => $id_user], 'tb_user');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show col-sm-3" role="alert">
        Data User berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/user');
    }
}
