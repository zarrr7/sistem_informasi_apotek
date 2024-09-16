<div class="modal fade" id="modalObat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card card-info">
            <form method="POST" id="form-add">
                <input type="hidden" name="tr" id="tr-value" value="">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="modalLabel">Tambah Data Obat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
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
                    <div class="form-group row">
                        <label for="inputText" class="col-sm-3 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga" class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="harga_beli" name="harga_beli" min="0.001" step="0.001" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
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

    document.getElementById('harga_beli').addEventListener('input', function(e) {
        this.value = formatRupiah(this.value);
    });
</script>