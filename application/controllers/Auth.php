<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
    }

    public function check_login($username, $password)
    {
        $user = $this->db->get_where('tb_user', ['username' => $username])->row();

        // Verifikasi password dengan password_verify
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }


    public function login()
    {
        // Periksa apakah pengguna sudah login
        // if ($this->session->userdata('user_id')) {
        //     $role = $this->session->userdata('role');
        //     if ($role == 'owner') {
        //         redirect('owner/dashboard');
        //     } elseif ($role == 'kasir') {
        //         redirect('dashboard');
        //     } else {
        //         redirect('auth/login');
        //     }
        // }

        // Periksa apakah ini adalah permintaan POST

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->auth_model->check_login($username, $password);

            if ($user) {
                $this->session->set_userdata('user_id', $user->id_user);
                $this->session->set_userdata('username', $user->username);
                $this->session->set_userdata('role', $user->role);

                if ($user->role == 'owner') {
                    redirect('owner/dashboard');
                } elseif ($user->role == 'kasir') {
                    redirect('dashboard');
                } else {
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau Password salah');
                redirect('auth/login');
            }
        }

        // Tampilkan halaman login jika permintaan bukan POST
        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
