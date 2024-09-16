<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembelian</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="card card-info">
        <div class="card-header">
            <h5><b>Data Pembelian</b></h5>
        </div>
        <form id="purchaseForm">
            <div class="card-body">
                <div class="form-group row">
                    <label for="id_pembelian" class="col-sm-2 col-form-label">Id Pembelian</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="id_pembelian" name="id_pembelian">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
                    <div class="col-sm-4">
                        <select name="id_supplier" class="form-control" required>
                            <option value="" disabled selected>Pilih Data Supplier!</option>
                            <?php foreach ($supplier as $spl) : ?>
                                <option value="<?= $spl->id_supplier ?>"><?= $spl->supplier ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-info" id="btn-add" data-toggle="modal"
                            data-target="#modalObat"><i class="fa fa-plus"></i> <b>Tambah Obat</b></button>
                    </div>
                </div>
                <table id="purchaseTable" class="table table-bordered table-hover dt-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseItems">
                        <?php if (!empty($detail_pembelian)) : ?>
                            <?php foreach ($detail_pembelian as $detail) : ?>
                                <tr>
                                    <td><?= $detail->obat ?></td>
                                    <td><?= $detail->jumlah ?></td>
                                    <td><?= $detail->harga_beli ?></td>
                                    <td><?= number_format($detail->total, 0, ',', '.') ?></td>
                                    <td><button class="btn btn-danger btn-sm remove-item">Hapus</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
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
    <?php $this->load->view('master/crud_pembelian'); ?>
    <script>
        $(document).ready(function() {
            // Submit form modal untuk menambahkan obat ke tabel
            $("#form-add").submit(function(e) {
                e.preventDefault();
                var tr_row = $('#tr-value').val();
                var id_obat = $('select[name="id_obat"]').val();
                const data = cloud.get("obat").data.find(x => x.id_obat == id_obat);
                var obat = $(this).find('option[value="' + id_obat + '"]').text();
                var jumlah = parseInt($('input[name="jumlah"]').val().toString().replace(/\./g, ''));
                var harga_beli = parseInt($('input[name="harga_beli"]').val().toString().replace(/\./g,
                    ''));
                // Cek apakah user telah memilih obat yang valid
                if (!id_obat) {
                    alert("Pilih obat yang valid!");
                    return;
                }
                // Hitung total
                var total = jumlah * harga_beli;
                const rownum = $("#purchaseItems tr").length + 1;
                if (tr_row) {
                    const row = $("#purchaseItems tr[data-rownum='" + tr_row + "']");
                    row.find("td:eq(0)").text(obat);
                    row.find("td:eq(1)").text(jumlah);
                    row.find("td:eq(2)").text(harga_beli);
                    row.find("td:eq(3)").text(total.toLocaleString());
                } else {
                    // Tambahkan data ke tabel
                    var newRow = `<tr data-id="${id_obat}" data-rownum="${rownum}">
                                    <td>${obat}</td>
                                    <td>${jumlah}</td>
                                    <td>${harga_beli}</td>
                                    <td>${total.toLocaleString()}</td>  <!-- Tampilkan dalam format ribuan -->
                                    <td><button class="btn btn-warning btn-sm update-item" data-toggle="modal" data-target="#modalObat"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm remove-item"><i class="fas fa-trash"></i></button></td>
                                    </tr>`;
                    $("#purchaseItems").append(newRow);
                }
                $("#modalObat").modal('hide');
                $("#form-add")[0].reset();
                $("#calculateTotal").trigger("click");
            });
            // Menghapus item dari tabel
            $("body").on("click", ".remove-item", function() {
                $(this).closest("tr").remove();
            });
        });
        $(document).ready(function() {
            // Ketika tombol 'Jumlah' diklik
            $("#calculateTotal").click(function() {
                let totalHarga = 0;
                // Loop melalui setiap baris di tabel dan ambil nilai 'Total'
                $("#purchaseItems tr").each(function() {
                    // Ambil nilai total dari kolom 'Total' (kolom ke-4)
                    let totalItem = $(this).find('td:eq(3)').text();
                    // Hapus format ribuan (jika ada) dan konversi ke integer
                    totalItem = parseInt(totalItem.replace(/\./g, ''));
                    // Tambahkan nilai total item ke totalHarga
                    totalHarga += totalItem;
                });
                // Format totalHarga dengan format ribuan dan set ke input Total Harga
                $("#total_harga").val(totalHarga.toLocaleString('id-ID'));
            });
        });
    </script>
    <!-- Modal -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <?php $this->load->view('master/crud_pembelian'); ?>
    <script src="http://localhost/skripsi/assets/js/puller.js"></script>
    <script>
        const cloud = new Puller();
    </script>
    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script>
        function getObat() {
            const data = [];
            $("#purchaseItems tr").each(function() {
                const p = {
                    id_obat: $(this).data("id"),
                    jumlah: parseInt($(this).find("td:eq(1)").text().replace(/\./g, '')),
                    harga_beli: parseInt($(this).find("td:eq(2)").text().replace(/\./g, '')),
                };
                p.total = p.jumlah * p.harga_beli;
                data.push(p);
            });
            return data;
        }

        $("body").on("click",
            ".update-item",
            function(e) {
                e.preventDefault();
                const id = $(this).closest("tr").data("id");
                const rownum = $(this).closest("tr").data("rownum");
                const jumlah = $(this).closest("tr").find("td:eq(1)").text();
                const harga_beli = $(this).closest("tr").find("td:eq(2)").text();
                $("#form-add option[value='" + id + "']").prop("selected", true);
                $("#jumlah").val(jumlah);
                $("#harga_beli").val(harga_beli);
                $("#tr-value").val(rownum);
                $("#form-add select[name=id_obat]").prop("disabled", true);
                $("#form-add button[type=submit]").text("Ubah");
            });

        $("body").on("click",
            "#btn-add",
            function(e) {
                e.preventDefault();
                $("#form-add")[0].reset();
                $("#form-add #tr-value").val("");
                $("#form-add button[type=submit]").text("Tambah");
                $("#form-add select[name=id_obat]").prop("disabled", false);
            });

        $("body").on("submit", "#purchaseForm", function(e) {
            e.preventDefault();
            const data = {};
            $(this).serializeArray().map(function(x) {
                data[x.name] = x.value
            });
            if (getObat().length == 0) {
                alert("Tidak ada item yang dibeli!");
                return;
            }

            data.obat = getObat();
            let total = 0;
            getObat().forEach(obat => {
                total += obat.jumlah * obat.harga_beli
            });
            data.total = total;

            // send json request data
            $.ajax({
                type: "POST",
                url: "http://localhost/skripsi/master/pembelian/tambah",
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json",
                cache: false,
                processData: false,
                success: function(res) {
                    window.location.href = "http://localhost/skripsi/master/pembelian";
                }
            });
        });
        $(document).ready(function() {
            cloud.add(origin + "/skripsi/master/obat/find", {
                name: "obat",
                wrap: "data"
            }).then(data => {
                console.log(data["data"]);
            });
        });

        $("body").on("submit", "#form-add", function() {

        });
    </script>
</body>