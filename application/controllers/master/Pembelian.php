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
        $this->load->model('supplier_model');
    }

    public function index()
    {
        $data['active_page'] = 'pembelian'; // Menandai halaman aktif
        $data['pembelian'] = $this->pembelian_model->get_data('tb_pembelian')->result();
        $data['detail'] = $this->pembelian_detail_model;
        $data['supplier'] = $this->supplier_model;
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_pembelian', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_pembelian = null)
    {
        $data['active_page'] = 'pembelian'; // Menandai halaman aktif
        $data['pembelian_model'] = $this->pembelian_model->get_data('tb_pembelian')->result();
        $data['supplier'] = $this->pembelian_model->get_data('tb_supplier')->result();
        $data['obat'] = $this->pembelian_model->get_data('tb_obat')->result();
        $data['obat_model'] = $this->pembelian_model;
        $data['detail_pembelian'] = $this->pembelian_detail_model;

        // Ambil data detail pembelian yang sudah disimpan
        if ($id_pembelian) {
            $data['pembelian'] = $this->pembelian_model->get_data('tb_pembelian', ['id_pembelian' => $id_pembelian])->row();
        } else {
            $data['pembelian'] = null;
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
            $o = $this->pembelian_detail_model->getData("tb_obat", ["id_obat" => $obat->id_obat])->row();
            $stok = $o->stok ? $o->stok : 0;

            $idx = $this->pembelian_detail_model->insertData([
                "id_obat" => $obat->id_obat,
                "id_pembelian" => $id,
                "harga_beli" => $obat->harga_beli,
                "jumlah" => $obat->jumlah,
                "total" => $obat->harga_beli * $obat->jumlah,
            ], 'tb_detail_pembelian');

            $this->pembelian_detail_model->updateData(["harga_beli" => $obat->harga_beli, "stok" => $stok + $obat->jumlah], ["id_obat" => $obat->id_obat], "tb_obat");
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(201)
            ->set_output(json_encode([
                'text' => 'Berhasil ditambahkan',
                'type' => $data,
            ]));
    }

    public function update()
    {
        $data = json_decode(file_get_contents('php://input'));
        $this->pembelian_model->update_data([
            'id_supplier' => $data->id_supplier,
            'tanggal' => $data->tanggal,
            'total' => $data->total,
        ], ['id_pembelian' => $data->id_pembelian], 'tb_pembelian');

        $onDatabase = $this->pembelian_detail_model->getData("tb_detail_pembelian", ["id_pembelian" => $data->id_pembelian])->result();
        foreach ($onDatabase as $detail) {
            $id_obat = $detail->id_obat;
            $newDetail = array_reduce($data->obat, static function ($carry, $item) use ($id_obat) {
                return $carry === false && $item->id_obat == $id_obat ? $item : $carry;
            }, false);

            $o = $this->pembelian_detail_model->getData("tb_obat", ["id_obat" => $detail->id_obat])->row();
            $stok = $o->stok ? $o->stok : 0;
            if ($newDetail == false) {
                $this->pembelian_detail_model->deleteData(["id_detail_pembelian" => $detail->id_detail_pembelian], "tb_detail_pembelian");
                $this->pembelian_detail_model->updateData(["stok" => $stok - $detail->jumlah], ["id_obat" => $detail->id_obat], "tb_obat");
            } else {
                $attribution = $newDetail->jumlah - $detail->jumlah;
                $this->pembelian_detail_model->updateData(["harga_beli" => $newDetail->harga_beli, "stok" => $stok - $attribution], ["id_obat" => $newDetail->id_obat], "tb_obat");
                $this->pembelian_detail_model->updateData(["harga_beli" => $newDetail->harga_beli, "jumlah" => $newDetail->jumlah], ["id_detail_pembelian" => $detail->id_detail_pembelian], "tb_detail_pembelian");
            }
        }
        foreach ($data->obat as $new) {
            $id_obat = $new->id_obat;
            $newDetail = array_reduce($onDatabase, static function ($carry, $item) use ($id_obat) {
                return $carry === false && $item->id_obat == $id_obat ? $item : $carry;
            }, false);

            if ($newDetail == false) {
                $o = $this->pembelian_detail_model->getData("tb_obat", ["id_obat" => $new->id_obat])->row();
                $stok = $o->stok ? $o->stok : 0;

                $idx = $this->pembelian_detail_model->insertData([
                    "id_obat" => $new->id_obat,
                    "id_pembelian" => $data->id_pembelian,
                    "harga_beli" => $new->harga_beli,
                    "jumlah" => $new->jumlah,
                    "total" => $new->harga_beli * $new->jumlah,
                ], 'tb_detail_pembelian');

                $this->pembelian_detail_model->updateData(["harga_beli" => $new->harga_beli, "stok" => $stok + $new->jumlah], ["id_obat" => $new->id_obat], "tb_obat");
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'text' => 'Berhasil ditambahkan',
                'type' => $data,
            ]));
    }

    public function delete($id_pembelian)
    {
        $this->pembelian_model->delete_data(['id_pembelian' => $id_pembelian], 'tb_pembelian');

        foreach ($this->pembelian_detail_model->getData("tb_detail_pembelian", ["id_pembelian" => $id_pembelian])->result() as $detail) {

            $o = $this->pembelian_detail_model->getData("tb_obat", ["id_obat" => $detail->id_obat])->row();
            $stok = $o->stok ? $o->stok : 0;

            $this->pembelian_detail_model->updateData(["stok" => $stok - $detail->jumlah], ["id_obat" => $detail->id_obat], "tb_obat");
        }

        $this->pembelian_detail_model->deleteData(["id_pembelian" => $id_pembelian], "tb_detail_pembelian");

        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">Data pembelian berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('master/pembelian');
    }

    public function find()
    {
        $id_pembelian = $this->input->post_get('id_pembelian');

        if (!$id_pembelian) {

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Data berhasil diambil',
                    'data' => $this->pembelian_model->get_all_pembelian(),
                ]));
        }
        $pembelian = $this->pembelian_model->get_data('tb_pembelian', ['id_pembelian' => $id_pembelian])->row();
        if ($pembelian) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'data' => $pembelian,
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

    public function detail()
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Data berhasil diambil',
                'data' => $this->pembelian_detail_model->getAll(),
            ]));
    }
}
