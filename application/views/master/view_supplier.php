<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Supplier</title>
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
                                <h3><b>Data Supplier</b></h3>
                            </div>
                            <!-- Tombol Tambah diubah -->
                            <button class="btn bg-gradient-success ml-auto" data-toggle="modal" data-target="#formModal"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Id Supplier</th>
                                        <th>Supplier</th>
                                        <th>Alamat</th>
                                        <th>No Telp</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <?php foreach ($supplier as $spl): ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $spl->id_supplier ?></td>
                                            <td><?= $spl->supplier ?></td>
                                            <td><?= $spl->alamat ?></td>
                                            <td><?= $spl->no_telp ?></td>
                                            <td class="text-center">
                                                <!-- Tombol Edit diubah -->
                                                <button class="btn btn-warning btn-sm" onclick="editsupplier('<?= $spl->id_supplier ?>', '<?= $spl->supplier ?>', '<?= $spl->alamat ?>', '<?= $spl->no_telp ?>')" data-toggle="modal" data-target="#formModal"><i class="fas fa-edit"></i></button>
                                                <a href="<?= base_url('master/supplier/delete/' . $spl->id_supplier) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
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

        <!-- Modal untuk Form supplier -->
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content card card-info">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="formModalLabel">Form Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="supplierForm" action="<?= base_url('master/supplier/tambah') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="id_supplier" class="col-sm-3 col-form-label">Id Supplier</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="id_supplier" name="id_supplier">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="supplier" class="col-sm-3 col-form-label">Supplier</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="supplier" name="supplier">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="no_telp" class="col-sm-3 col-form-label">No Telp</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_telp" name="no_telp">
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

        // Fungsi untuk edit data supplier
        function editsupplier(id, supplier, alamat, no_telp) {
            $('#supplierForm').attr('action', '<?= base_url('master/supplier/update') ?>/' + id);
            $('#id_supplier').val(id).attr('readonly', true);
            $('#supplier').val(supplier);
            $('#alamat').val(alamat);
            $('#no_telp').val(no_telp);
            $('#formModalLabel').text('Edit supplier');
        }
    </script>
</body>

</html>