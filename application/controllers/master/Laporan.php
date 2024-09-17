<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller {


    public function index()
    {
        $data['active_page'] = 'laporan'; // Menandai halaman aktif
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar', $data);
        $this->load->view('master/view_laporan');
        $this->load->view('templates/footer');
    }
}
