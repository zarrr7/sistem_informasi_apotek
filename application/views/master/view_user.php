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
                            <h3><b>Data User</b></h3>
                        </div>
                        <!-- Tombol Tambah diubah -->
                        <button class="btn bg-gradient-success ml-auto" data-toggle="modal" data-target="#formModal"><i
                                class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover dt-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Id Username</th>
                                    <th>username</th>
                                    <th>Role</th>
                                    <th>Password</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php foreach ($user as $usr): ?>
                            <tbody>
                                <tr>
                                    <td><?= $usr->id_user ?></td>
                                    <td><?= $usr->username ?></td>
                                    <td><?= $usr->role ?></td>
                                    <td><?= $usr->password ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Edit diubah -->
                                        <button class="btn btn-warning btn-sm" onclick="edituser(
                                                '<?= $usr->id_user ?>',
                                                '<?= $usr->username ?>',
                                                '<?= $usr->role ?>',
                                                '<?= $usr->password ?>')" data-toggle="modal"
                                            data-target="#formModal"><i class="fas fa-edit"></i></button>
                                        <a href="<?= base_url('master/user/delete/' . $usr->id_user) ?>"
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

    <!-- Modal untuk Form username -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content card card-info">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="formModalLabel">Form User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="usernameForm" action="<?= base_url('master/user/tambah') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="id_user" class="col-sm-3 col-form-label">Id User</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="id_user" name="id_user">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="role" name="role" style=" width: 100%;">
                                    <option value="" disabled selected>Pilih Role!</option>
                                    <option>Owner</option>
                                    <option>Admin</option>
                                    <option>Kasir</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" required>
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

// Fungsi untuk edit data username
function edituser(id, username, role, password) {
    $('#usernameForm').attr('action', '<?= base_url('master/user/update') ?>/' + id);
    $('#id_user').val(id).attr('readonly', true);
    $('#username').val(username);
    $('#role').val(role);
    $('#password').val(password);
    $('#formModalLabel').text('Edit user');
}
</script>