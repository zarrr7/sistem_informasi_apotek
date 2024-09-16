<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Obat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="<?= base_url('assets/template') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?= base_url('assets/template') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/template') ?>/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <section class="content">
        <?php if ($this->session->flashdata('pesan')): ?>
            <?= $this->session->flashdata('pesan'); ?>
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">
                                <h3><b>Data Obat</b></h3>
                            </div>
                            <a href="#" class="btn bg-gradient-success ml-auto" data-toggle="modal" data-target="#formModal">
                                <i class="fa fa-plus"></i> Tambah
                            </a>

                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dt-responsive"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <!-- <th>Id Obat</th> -->
                                        <th>Obat</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($obat as $obt): ?>
                                        <tr>
                                            <!-- <td><?= $obt->id_obat ?></td> -->
                                            <td><?= $obt->obat ?></td>
                                            <td><?= $obt->kategori; ?></td>
                                            <td><?= $obt->satuan; ?></td>
                                            <td><?= number_format($obt->harga_beli ?? 0) ?></td>
                                            <td>
                                                <input type="text" class="form-control harga-jual format-rupiah"
                                                    value="<?= number_format($obt->harga_jual, 0, ',', '.') ?>"
                                                    data-id="<?= $obt->id_obat ?>" />
                                            </td>

                                            <td><?= $obt->stok ?? 0 ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm"
                                                    onclick="editobat('<?= $obt->id_obat ?>','<?= $obt->obat ?>','<?= $obt->kategori; ?>','<?= $obt->satuan; ?>','<?= $obt->harga_beli ?>','<?= $obt->harga_jual ?>','<?= $obt->stok ?>')"
                                                    data-toggle="modal" data-target="#formModal"><i
                                                        class="fas fa-edit"></i></button>
                                                <a href="<?= base_url('master/obat/delete/' . $obt->id_obat) ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i
                                                        class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content card card-info">
                    <form method="POST" action="<?= base_url('master/obat/tambah') ?>" id="form-add">
                        <input type="hidden" name="form_action" value="add"> <!-- Ini untuk default tambah -->
                        <input type="hidden" id="id_obat" name="id_obat"> <!-- Ini untuk menyimpan id_obat saat edit -->
                        <div class="modal-header bg-info">
                            <h4 class="modal-title" id="modalLabel">Tambah Data Obat</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <!-- <div class="form-group row">
                                <label for="id_obat" class="col-sm-3 col-form-label">Id obat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="id_obat" name="id_obat">
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label for="obat" class="col-sm-3 col-form-label">Obat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="obat" name="obat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_kategori" class="col-sm-3 col-form-label">Kategori</label>
                                <div class="col-sm-8">
                                    <select name="kategori" class="form-control" required>
                                        <option value="" disabled selected>Pilih Data kategori!</option>
                                        <?php foreach ($kategori as $ktg) : ?>
                                            <option value="<?= $ktg->id_kategori ?>"><?= $ktg->kategori ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_satuan" class="col-sm-3 col-form-label">Satuan</label>
                                <div class="col-sm-8">
                                    <select name="satuan" class="form-control" required>
                                        <option value="" disabled selected>Pilih Data satuan!</option>
                                        <?php foreach ($satuan as $stn) : ?>
                                            <option value="<?= $stn->id_satuan ?>"><?= $stn->satuan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $("body").on("submit", "#form-add", function(e) {
                e.preventDefault();
                const obat = $('select[name="id_obat"]').val();
                const kategori = $('select[name="id_kategori"]').val();
                const satuan = $('select[name="id_satuan"]').val();
                const jumlah = $('input[name="jumlah"]').val();
                const harga_beli = $('input[name="harga_beli"]').val();
                const data = cloud.get("obat").data.find(x => x.id_obat == obat);
                console.log(data);
            });

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

            document.getElementById('harga_beli').addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
        </script>

    </section>

    <script src="<?= base_url('assets/template') ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <script src="<?= base_url('assets/template') ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/dist/js/demo.js"></script>

    <script>
        $("body").on("change", ".harga-jual", function(e) {
            const val = $(this).val();
            const id = $(this).data("id");
            $(this).prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "<?= base_url('master/obat/updateHargaJual') ?>",
                data: {
                    id_obat: id,
                    harga_jual: val
                },
                success: (res) => {
                    $(this).prop("disabled", false);
                }
            });
        });
        $(document).ready(function() {

            // Fungsi untuk memformat angka ke format rupiah
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // Menambahkan titik sebagai pemisah ribuan
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                // Menambahkan koma untuk nilai desimal
                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

                // Mengembalikan nilai dengan prefix (contoh: Rp. )
                return prefix + rupiah;
            }
        });

        $("body").on("change", ".harga-jual", function(e) {
            const val = $(this).val();
            const id = $(this).data("id");
            $(this).prop("disabled", true);

            $.ajax({
                type: "POST",
                url: "<?= base_url('master/obat/updateHargaJual') ?>",
                data: {
                    id_obat: id,
                    harga_jual: val
                },
                success: (res) => {
                    $(this).prop("disabled", false);
                    if (res.status === 'success') {
                        alert(res.message); // Menampilkan pesan
                        setTimeout(() => {
                            location.reload(); // Reload halaman setelah 3 detik
                        }, 0000);
                    } else {
                        alert(res.message);
                    }
                },
                error: () => {
                    alert("Terjadi kesalahan saat mengupdate harga.");
                    $(this).prop("disabled", false);
                }
            });
        });

        function editobat(id, obat, kategori, satuan, stok) {
            $('#form-add').attr('action', '<?= base_url('master/obat/update') ?>/' + id);
            $('#id_obat').val(id).attr('readonly', true);
            $('#obat').val(obat);
            $('select[name="kategori"]').val(kategori); // Set kategori yang dipilih
            $('select[name="satuan"]').val(satuan); // Set satuan yang dipilih
            $('#formModalLabel').text('Edit Obat');
        }
    </script>

    <script>
        // Fungsi untuk menghilangkan pesan setelah 3 detik
        setTimeout(function() {
            $(".alert-dismissible").fadeOut("slow", function() {
                $(this).remove(); // Menghapus elemen setelah efek fade out
            });
        }, 3000); // Durasi 3000 ms (3 detik)
    </script>

</body>

</html>