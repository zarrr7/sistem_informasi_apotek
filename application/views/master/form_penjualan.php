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
</head>

<body>
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h5><b>Data Penjualan</b></h5>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputId" class="col-sm-2 col-form-label">Id Penjualan</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="datepicker" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="obat" class="col-sm-2 col-form-label">Obat</label>
                    <div class="col-sm-4">
                        <select name="id_obat" class="form-control" required>
                            <option value="" disabled selected>Pilih Data Obat!</option>
                            <?php foreach ($obat as $obt) : ?>
                                <option value="<?= $obt->id_obat ?>"><?= $obt->obat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputJumlah" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="inputJumlah">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="harga">
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

                        document.getElementById('harga').addEventListener('keyup', function(e) {
                            this.value = formatRupiah(this.value, 'Rp. ');
                        });
                    </script>
                </div>
                <div class="form-group row-1">
                    <button type="submit" class="btn btn-info">Tambah</button>
                    <button type="submit" class="btn btn-secondary">Cancel</button>
                </div>
                <table id="example2" class="table table-bordered table-hover dt-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Id Penjualan</th>
                            <th>Tanggal</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
                <p>
                <div class="form-group row justify-content-end align-items-center">
                    <label for="total_harga" class="col-form-label mr-1">Total Harga</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
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

                        document.getElementById('total').addEventListener('keyup', function(e) {
                            this.value = formatRupiah(this.value, 'Rp. ');
                        });
                    </script>
                    <div class="mr-3">
                        <button type="button" class="btn btn-success" id="calculateTotal">Jumlah</button>
                        <button type="submit" class="btn btn-info ml-1">Simpan</button>
                    </div>
                </div>
                </p>
            </div>
        </form>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


</body>

</html>