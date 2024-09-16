<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pembelian_model');
        $this->load->model('pembelian_model');
        $this->load->model('pembelian_detail_model');
    }

    public function index()
    {
        $data['pembelian'] = $this->pembelian_model->get_data('tb_pembelian')->result();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_pembelian', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_pembelian = null)
    {
        $data['pembelian'] = $this->pembelian_model->get_data('tb_pembelian')->result();
        $data['supplier'] = $this->pembelian_model->get_data('tb_supplier')->result();
        $data['obat'] = $this->pembelian_model->get_data('tb_obat')->result();

        // Ambil data detail pembelian yang sudah disimpan
        if ($id_pembelian) {
            $data['detail_pembelian'] = $this->pembelian_model->get_data('tb_detail_pembelian', ['id_pembelian' => $id_pembelian])->result();
        } else {
            $data['detail_pembelian'] = [];
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_pembelian', $data);
        $this->load->view('templates/footer');
    }


    public function tambah()
    {
        $data = json_decode(file_get_contents('php://input'));
        $id = $this->pembelian_model->insert_data([
            'id_supplier' => $data->id_supplier,
            'tanggal' => $data->tanggal,
            'total' => $data->total
        ], 'tb_pembelian');
        
        foreach ($data->obat as $obat) {
            $idx = $this->pembelian_detail_model->insertData([
                "id_obat" => $obat->id_obat,
                "id_pembelian" => $id,
                "harga_beli" => $obat->harga_beli,
                "jumlah" => $obat->jumlah,
                "total" => $obat->harga_beli * $obat->jumlah,
            ], 'tb_detail_pembelian');
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(201)
            ->set_output(json_encode([
                'text' => 'Berhasil ditambahkan',
                'type' => $data,
            ]));
    }

    public function tambah_detail_pembelian()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $id_obat = $this->input->post('id_obat');
        $harga_beli = $this->input->post('harga_beli');
        $jumlah = $this->input->post('jumlah');

        // Validasi input
        if (!$id_pembelian || !$id_obat || !$harga_beli || !$jumlah) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        $data_detail = [
            'id_pembelian' => $id_pembelian,
            'id_obat' => $id_obat,
            'harga_beli' => $harga_beli,
            'jumlah' => $jumlah,
            'total' => $harga_beli * $jumlah
        ];

        $this->pembelian_model->insert_data($data_detail, 'tb_detail_pembelian');

        echo json_encode(['success' => true]);
    }


    public function update()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $data = [
            'pembelian' => $this->input->post('pembelian')
        ];

        $this->pembelian_model->update_data($data, ['id_pembelian' => $id_pembelian], 'tb_pembelian');
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">Data pembelian berhasil diupdate!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('master/pembelian');
    }

    public function delete($id_pembelian)
    {
        $this->pembelian_model->delete_data(['id_pembelian' => $id_pembelian], 'tb_pembelian');
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">Data pembelian berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('master/pembelian');
    }
}
