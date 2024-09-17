<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <!-- Include jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h5><b>Data Penjualan</b></h5>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="purchaseForm">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputId" class="col-sm-2 col-form-label">Id Penjualan</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="id_penjualan" name="id_penjualan"
                            value="<?= $penjualan_edit ? $penjualan_edit->id_penjualan : "" ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="<?= $penjualan_edit ?  $penjualan_edit->tanggal : "" ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="obat" class="col-sm-2 col-form-label">Obat</label>
                    <div class="col-sm-4">
                        <select name="id_obat" class="form-control">
                            <option value="" disabled selected>
                                Pilih Data Obat!</option>
                            <?php foreach ($obat as $obt) : ?>
                                <option value="<?= $obt->id_obat ?>"><?= $obt->obat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputJumlah" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="inputJumlah" name="inputJumlah" min="1" step="1">
                    </div>
                </div>
                <div class="form-group row-1">
                    <button type="button" class="btn btn-info" id="btn-add" disabled>Tambah</button>
                </div>
                <table id="purchaseTable" class="table table-bordered table-hover dt-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th style="width: 10rem;">Jumlah</th>
                            <th style="width: 15rem;">Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <?php $total = 0; ?>
                    <tbody id="purchaseItems">
                        <?php if (!empty($penjualan_edit)) : ?>
                            <?php foreach ($detail_penjualan->getData("tb_detail_penjualan", ["id_penjualan" => $penjualan_edit->id_penjualan])->result() as $detail) : ?>
                                <?php $num = 1; ?>
                                <?php $total += $detail->jumlah * $detail->harga_jual; ?>
                                <tr data-iddetail="<?= $detail->id_detail_penjualan ?>" data-id="<?= $detail->id_obat ?>"
                                    data-rownum="<?= $num++ ?>">
                                    <td><?= $obat_model->get_data("tb_obat", ["id_obat" => $detail->id_obat])->row()->obat ?>
                                    </td>
                                    <td><input type="text" class="form-control reset-total format-rupiah"
                                            value="<?= $detail->jumlah ?>" data-id="<?= $detail->id_penjualan ?>" /></td>
                                    <td><input type="text" class="form-control reset-total format-rupiah"
                                            value="<?= number_format($detail->harga_jual, 0, ',', '.') ?>" /></td>
                                    <td><?= number_format($detail->total, 0, ',', '.') ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-item"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p>
                <div class="form-group row justify-content-end align-items-center">
                    <label for="total_harga" class="col-form-label mr-1">Total Harga</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="total_harga" name="total" value="<?= number_format($total, 0, ',', '.') ?>" readonly>
                    </div>
                    <script>
                        function formatRupiah(angka, prefix) {
                            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                split = number_string.split(','),
                                sisa = split[0].length % 3,
                                rupiah = split[0].substr(0, sisa),
                                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }

                            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                        }
                        $(document).ready(function() {
                            // Format input total harga
                            $('#total_harga').on('input', function() {
                                this.value = formatRupiah(this.value, 'Rp. ');
                            });

                            // Menghitung total harga saat tombol 'Jumlah' diklik
                            $("#calculateTotal").click(function() {
                                let totalHarga = 0;
                                $("#purchaseItems tr").each(function() {
                                    let totalItem = $(this).find('td:eq(3)').text().replace(/\./g,
                                        '');
                                    totalHarga += parseInt(totalItem);
                                });
                                $("#total_harga").val(formatRupiah(totalHarga.toString(), 'Rp. '));
                            });
                        });
                    </script>
                    <div class="mr-3">
                        <button type="button" class="btn btn-success d-none" id="calculateTotal">Jumlah</button>
                        <button type="submit" class="btn btn-info ml-1">Simpan</button>
                    </div>
                </div>
                </p>
            </div>
        </form>
    </div>
    <!-- Modal untuk Tambah Obat -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="http://localhost/skripsi/assets/js/puller.js"></script>
    <script>
        const cloud = new Puller();
    </script>
    <script src="http://localhost/skripsi/assets/js/page/penjualan.js"></script>


</body>

</html>