<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('obat_id')) {
            // redirect('auth/login');
        }
        $this->load->model('obat_model');
        $this->load->model('kategori_model'); // Load model kategori
        $this->load->model('satuan_model');   // Load model satuan
    }
    public function index($id_obat = null)
    {
        $data['obat'] = $this->obat_model->get_data('tb_obat')->result();
        $data['obat'] = $this->obat_model->get_all_obat();

        $data['kategori'] = $this->kategori_model->get_all_kategori(); // Mengambil data kategori dari Kategori_model
        $data['satuan'] = $this->satuan_model->get_all_satuan(); // Mengambil data satuan dari Satuan_model

        if ($id_obat) {
            $data['obat_edit'] = $this->obat_model->get_data('tb_obat', ['id_obat' => $id_obat])->row();
        } else {
            $data['obat_edit'] = null;
        }


        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_obat', $data);
        $this->load->view('templates/footer');
    }

    // public function form

    public function tambah()
{
    if ($this->input->post('form_action') == 'edit') {
        // Jika form digunakan untuk edit, arahkan ke metode update
        return $this->update();
    }

    $data = [
        'obat' => $this->input->post('obat'),
        'id_kategori' => $this->input->post('kategori'),
        'id_satuan' => $this->input->post('satuan'),
    ];

    $this->obat_model->insert_data($data, 'tb_obat');
    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show col-sm-3" role="alert">
        Data obat berhasil ditambahkan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>');

    redirect('master/obat');
}

public function update()
{
    $id_obat = $this->input->post('id_obat');
    
    $data = [
        'obat' => $this->input->post('obat'),
        'id_kategori' => $this->input->post('kategori'),
        'id_satuan' => $this->input->post('satuan'),
    ];

    $this->obat_model->update_data($data, ['id_obat' => $id_obat], 'tb_obat');

    $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-dismissible fade show col-sm-3" role="alert">
        Data obat berhasil diupdate!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>');
    redirect('master/obat');
}


    public function delete($id_obat)
    {
        $this->obat_model->delete_data(['id_obat' => $id_obat], 'tb_obat');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show col-sm-3" role="alert">
        Data obat berhasil dihapus!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
        </div>');
        redirect('master/obat');
    }

    public function updateHargaJual()
    {
        $id_obat = $this->input->post('id_obat');

        if (!$id_obat) {

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Id tidak ditemukan!',
                ]));
        }
        try {
            $data = [
                'harga_jual' => $this->input->post('harga_jual'),
            ];

            $this->obat_model->update_data($data, ['id_obat' => $id_obat], 'tb_obat');

            $obat = $this->obat_model->get_data('tb_obat', ['id_obat' => $id_obat])->row();

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'obat' => $obat,
                    'status' => 'success',
                    'message' => 'Harga jual berhasil diupdate!',
                ]));
        } catch (\Throwable $th) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $th->getMessage(),
                ]));
        }
    }

    public function find()
    {
        $id_obat = $this->input->post_get('id_obat');

        if (!$id_obat) {

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Data berhasil diambil',
                    'data' => $this->obat_model->get_all_obat(),
                ]));
        }
        $obat = $this->obat_model->get_data('tb_obat', ['id_obat' => $id_obat])->row();
        if ($obat) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'data' => $obat,
                    'status' => 'success',
                    'message' => 'Data berhasil ditemukan',
                ]));
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(404)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]));
    }
}
