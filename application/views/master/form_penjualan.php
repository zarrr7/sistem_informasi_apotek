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
        <form id="purchaseForm">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputId" class="col-sm-2 col-form-label">Id Penjualan</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="id_penjualan" name="id_penjualan"
                            value="<?= $penjualan ? $penjualan->id_penjualan : "" ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="<?= $penjualan ?  $penjualan->tanggal : "" ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="obat" class="col-sm-2 col-form-label">Obat</label>
                    <div class="col-sm-4">
                        <select name="id_obat" class="form-control" required>
                            <option value="" disabled <?php if (empty($penjualan)) : ?>selected<?php endif ?>>
                                Pilih Data Obat!</option>
                            <?php foreach ($obat as $obt) : ?>
                            <?php if (!empty($penjualan)) : ?>
                            <?php $selected = $obt->id_obat == $penjualan->id_obat ? "selected" : ""; ?>
                            <?php else : ?>
                            <?php $selected = ""; ?>
                            <?php endif; ?>
                            <option value="<?= $obt->id_obat ?>" <?= $selected ?>><?= $obt->obat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputJumlah" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="inputJumlah" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="harga_jual" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" min="0.001" step="0.001" required>
                    </div>
                </div>
                <div class="form-group row-1">
                    <button type="submit" class="btn btn-info">Tambah</button>
                    <button type="submit" class="btn btn-secondary">Cancel</button>
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
                    <?php $total = 0; ?>
                    <tbody id="purchaseItems">
                        <?php if (!empty($penjualan)) : ?>
                        <?php foreach ($detail_penjualan->getData("tb_detail_penjualan", ["id_penjualan" => $penjualan->id_penjualan])->result() as $detail) : ?>
                        <?php $num = 1; ?>
                        <?php $total += $detail->jumlah * $detail->harga_jual; ?>
                        <tr data-iddetail="<?= $detail->id_detail_penjualan ?>" data-id="<?= $detail->id_obat ?>" data-rownum="<?= $num++ ?>">
                            <td><?= $obat_model->get_data("tb_obat", ["id_obat" => $detail->id_obat])->row()->obat ?>
                            </td>
                            <td><?= $detail->jumlah ?></td>
                            <td><?= number_format($detail->harga_jual, 0, ',', '.') ?></td>
                            <td><?= number_format($detail->total, 0, ',', '.') ?></td>
                            <td><button class="btn btn-warning btn-sm update-item" data-toggle="modal"
                                    data-target="#modalObat"><i class="fas fa-edit"></i></button>
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
            var harga_jual = parseInt($('input[name="harga_jual"]').val().toString().replace(/\./g,
                ''));
            // Cek apakah user telah memilih obat yang valid
            if (!id_obat) {
                alert("Pilih obat yang valid!");
                return;
            }
            // Hitung total
            var total = jumlah * harga_jual;
            const rownum = $("#purchaseItems tr").length + 1;
            if (tr_row) {
                const row = $("#purchaseItems tr[data-rownum='" + tr_row + "']");
                row.find("td:eq(0)").text(obat);
                row.find("td:eq(1)").text(jumlah);
                row.find("td:eq(2)").text(harga_jual);
                row.find("td:eq(3)").text(total.toLocaleString());
            } else {
                // Tambahkan data ke tabel
                var newRow = `<tr data-id="${id_obat}" data-rownum="${rownum}">
                                    <td>${obat}</td>
                                    <td>${jumlah}</td>
                                    <td>${harga_jual}</td>
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
        $("body").on("click", ".remove-item", function(e) {
            const id = $(this).closest("tr").data("iddetail");
            $.ajax({
                type: "GET",
                url: "http://localhost/skripsi/master/penjualan/deletedetail/" + id,
                success: function (res) {
                    
                }
            });
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


</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                harga_jual: parseInt($(this).find("td:eq(2)").text().replace(/\./g, '')),
            };
            p.total = p.jumlah * p.harga_jual;
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
            const harga_jual = $(this).closest("tr").find("td:eq(2)").text();
            $("#form-add option[value='" + id + "']").prop("selected", true);
            $("#jumlah").val(jumlah);
            $("#harga_jual").val(harga_jual);
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
            alert("Tidak ada item yang dijual!");
            return;
        }

        data.obat = getObat();
        let total = 0;
        getObat().forEach(obat => {
            total += obat.jumlah * obat.harga_jual
        });
        data.total = total;

        const urlForm = data.id_penjualan.length == 0  ? "http://localhost/skripsi/master/penjualan/tambah":"http://localhost/skripsi/master/penjualan/update";

        $.ajax({
            type: "POST",
            url: urlForm,
            data: JSON.stringify(data),
            dataType: "json",
            contentType: "application/json",
            cache: false,
            processData: false,
            success: function(res) {
                window.location.href = "http://localhost/skripsi/master/penjualan";
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

</html>