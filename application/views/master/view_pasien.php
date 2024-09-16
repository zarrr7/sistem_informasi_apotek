<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Pasien</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/template') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/template') ?>/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
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
                                <h3><b>Data Pasien</b></h3>
                            </div>
                            <!-- Tombol Tambah diubah -->
                            <button class="btn bg-gradient-success ml-auto" data-toggle="modal" data-target="#formModal"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Id Pasien</th>
                                        <th>Pasien</th>
                                        <th>Alamat</th>
                                        <th>Gejala</th>
                                        <th>Obat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <?php foreach ($pasien as $psn): ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $psn->id_pasien ?></td>
                                            <td><?= $psn->pasien ?></td>
                                            <td><?= $psn->alamat ?></td>
                                            <td><?= $psn->gejala ?></td>
                                            <td><?= $psn->obat ?></td>
                                            <td class="text-center">
                                                <!-- Tombol Edit diubah -->
                                                <button class="btn btn-warning btn-sm" onclick="editpasien(
                                                '<?= $psn->id_pasien ?>',
                                                '<?= $psn->pasien ?>',
                                                '<?= $psn->alamat ?>',
                                                '<?= $psn->gejala ?>',
                                                '<?= $psn->obat ?>')"
                                                    data-toggle="modal" data-target="#formModal"><i class="fas fa-edit"></i></button>
                                                <a href="<?= base_url('master/pasien/delete/' . $psn->id_pasien) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Form pasien -->
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content card card-info">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="formModalLabel">Form Pasien</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="pasienForm" action="<?= base_url('master/pasien/tambah') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="id_pasien" class="col-sm-3 col-form-label">Id pasien</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="id_pasien" name="id_pasien">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pasien" class="col-sm-3 col-form-label">Pasien</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="pasien" name="pasien">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gejala" class="col-sm-3 col-form-label">Gejala</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="gejala" name="gejala">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="obat" class="col-sm-3 col-form-label">Obat</label>
                                <div class="col-sm-8">
                                    <select name="id_obat" class="form-control" required>
                                        <option value="" disabled selected>Pilih Data Obat!</option>
                                        <?php foreach ($obat as $obt) : ?>
                                            <option value="<?= $obt->id_obat ?>"><?= $obt->obat ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url('assets/template') ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/dist/js/demo.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
        });

        // Fungsi untuk edit data pasien
        function editpasien(id, pasien, alamat, gejala, obat) {
            $('#pasienForm').attr('action', '<?= base_url('master/pasien/update') ?>/' + id);
            $('#id_pasien').val(id).attr('readonly', true);
            $('#pasien').val(pasien);
            $('#alamat').val(alamat);
            $('#gejala').val(gejala);
            $('#id_obat').val(id_obat);
            $('#formModalLabel').text('Edit pasien');
        }
    </script>
</body>

</html>