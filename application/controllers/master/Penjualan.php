<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('penjualan_model');
        $this->load->model('penjualan_model');
        $this->load->model('penjualan_detail_model');
        $this->load->model('obat_model');
    }
    public function index()
    {
        $data['active_page'] = 'penjualan'; // Menandai halaman aktif
        $data['penjualan'] = $this->penjualan_model->get_data('tb_penjualan')->result();
        $data['detail'] = $this->penjualan_detail_model;
        $data['obat'] = $this->obat_model;

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/view_penjualan', $data);
        $this->load->view('templates/footer');
    }

    public function form($id_penjualan = null)
    {
        $data['active_page'] = 'penjualan'; // Menandai halaman aktif
        $data['penjualan'] = $this->penjualan_model->get_data('tb_penjualan')->result();
        $data['obat'] = $this->penjualan_model->get_data('tb_obat')->result();
        $data['obat_model'] = $this->penjualan_model;
        $data['detail_penjualan'] = $this->penjualan_detail_model;

        if ($id_penjualan) {
            $data['penjualan_edit'] = $this->penjualan_model->get_data('tb_penjualan', ['id_penjualan' => $id_penjualan])->row();
        } else {
            $data['penjualan_edit'] = null;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('master/form_penjualan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data = json_decode(file_get_contents('php://input'));
        $id = $this->penjualan_model->insert_data([
            'tanggal' => $data->tanggal,
            'total' => $data->total
        ], 'tb_penjualan');

        foreach ($data->obat as $obat) {
            $o = $this->penjualan_detail_model->getData("tb_obat", ["id_obat" => $obat->id_obat])->row();
            $stok = $o->stok ? $o->stok : 0;

            $idx = $this->penjualan_detail_model->insertData([
                "id_obat" => $obat->id_obat,
                "id_penjualan" => $id,
                "jumlah" => $obat->jumlah,
                "harga_jual" => $obat->harga_jual,
                "total" => $obat->jumlah * $obat->harga_jual,
            ], 'tb_detail_penjualan');

            $this->penjualan_detail_model->updateData(["harga_jual" => $obat->harga_jual, "stok" => $stok - $obat->jumlah], ["id_obat" => $obat->id_obat], "tb_obat");
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
        $this->penjualan_model->update_data([
            'tanggal' => $data->tanggal,
            'total' => $data->total
        ], ['id_penjualan' => $data->id_penjualan], 'tb_penjualan');

        $onDatabase = $this->penjualan_detail_model->getData("tb_detail_penjualan", ["id_penjualan" => $data->id_penjualan])->result();
        foreach ($onDatabase as $detail) {
            $id_obat = $detail->id_obat;
            $newObat = [];
            $newDetail = array_reduce($data->obat, static function ($carry, $item) use ($id_obat) {
                return $carry === false && $item->id_obat == $id_obat ? $item : $carry;
            }, false);

            $o = $this->penjualan_detail_model->getData("tb_obat", ["id_obat" => $detail->id_obat])->row();
            $stok = $o->stok ? $o->stok : 0;
            if ($newDetail == false) {
                $this->penjualan_detail_model->deleteData(["id_detail_penjualan" => $detail->id_detail_penjualan], "tb_detail_penjualan");
                $this->penjualan_detail_model->updateData(["stok" => $stok + $detail->jumlah], ["id_obat" => $detail->id_obat], "tb_obat");
            } else {
                $attribution = $newDetail->jumlah - $detail->jumlah;
                $this->penjualan_detail_model->updateData(["harga_jual" => $newDetail->harga_jual, "stok" => $stok - $attribution], ["id_obat" => $newDetail->id_obat], "tb_obat");
                $this->penjualan_detail_model->updateData(["harga_jual" => $newDetail->harga_jual, "jumlah" => $newDetail->jumlah], ["id_detail_penjualan" => $detail->id_detail_penjualan], "tb_detail_penjualan");
            }
        }
        foreach ($data->obat as $new) {
            $id_obat = $new->id_obat;
            $newDetail = array_reduce($onDatabase, static function ($carry, $item) use ($id_obat) {
                return $carry === false && $item->id_obat == $id_obat ? $item : $carry;
            }, false);

            if ($newDetail == false) {
                $o = $this->penjualan_detail_model->getData("tb_obat", ["id_obat" => $new->id_obat])->row();
                $stok = $o->stok ? $o->stok : 0;

                $idx = $this->penjualan_detail_model->insertData([
                    "id_obat" => $new->id_obat,
                    "id_penjualan" => $data->id_penjualan,
                    "harga_jual" => $new->harga_jual,
                    "jumlah" => $new->jumlah,
                    "total" => $new->harga_jual * $new->jumlah,
                ], 'tb_detail_penjualan');

                $this->penjualan_detail_model->updateData(["harga_jual" => $new->harga_jual, "stok" => $stok - $new->jumlah], ["id_obat" => $new->id_obat], "tb_obat");
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

    public function delete($id_penjualan)
    {
        $this->penjualan_model->delete_data(['id_penjualan' => $id_penjualan], 'tb_penjualan');

        foreach ($this->penjualan_detail_model->getData("tb_detail_penjualan", ["id_penjualan" => $id_penjualan])->result() as $detail) {

            $o = $this->penjualan_detail_model->getData("tb_obat", ["id_obat" => $detail->id_obat])->row();
            $stok = $o->stok ? $o->stok : 0;

            $this->penjualan_detail_model->updateData(["stok" => $stok + $detail->jumlah], ["id_obat" => $detail->id_obat], "tb_obat");
        }

        $this->penjualan_detail_model->deleteData(["id_penjualan" => $id_penjualan], "tb_detail_penjualan");

        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">Data penjualan berhasil dihapus!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('master/penjualan');
    }

    public function find()
    {
        $id_penjualan = $this->input->post_get('id_penjualan');

        if (!$id_penjualan) {

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Data berhasil diambil',
                    'data' => $this->penjualan_model->get_all_penjualan(),
                ]));
        }
        $penjualan = $this->penjualan_model->get_data('tb_penjualan', ['id_penjualan' => $id_penjualan])->row();
        if ($penjualan) {
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
                'data' => $this->penjualan_detail_model->getAll(),
            ]));
    }
}
