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
                                <h3><b>Data Satuan</b></h3>
                            </div>
                            <!-- Tombol Tambah diubah -->
                            <button class="btn bg-gradient-success ml-auto" data-toggle="modal"
                                data-target="#formModal"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover dt-responsive"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Id Satuan</th>
                                        <th>Satuan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <?php foreach ($satuan as $stn): ?>
                                <tbody>
                                    <tr>
                                        <td><?= $stn->id_satuan ?></td>
                                        <td><?= $stn->satuan ?></td>
                                        <td class="text-center">
                                            <!-- Tombol Edit diubah -->
                                            <button class="btn btn-warning btn-sm"
                                                onclick="editsatuan('<?= $stn->id_satuan ?>', '<?= $stn->satuan ?>')"
                                                data-toggle="modal" data-target="#formModal"><i
                                                    class="fas fa-edit"></i></button>
                                            <a href="<?= base_url('master/satuan/delete/' . $stn->id_satuan) ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i
                                                    class="fas fa-trash"></i></a>
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

        <!-- Form satuan -->

        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content card card-info">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="formModalLabel">Form Satuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="satuanForm" action="<?= base_url('master/satuan/tambah') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="id_satuan" class="col-sm-3 col-form-label">Id Satuan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="id_satuan" name="id_satuan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="satuan" name="satuan">
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

    <script>
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3000);
});

// Fungsi untuk edit data satuan
function editsatuan(id, nama) {
    $('#satuanForm').attr('action', '<?= base_url('master/satuan/update') ?>/' + id);
    $('#id_satuan').val(id).attr('readonly', true);
    $('#satuan').val(nama);
    $('#formModalLabel').text('Edit satuan');
}
    </script>