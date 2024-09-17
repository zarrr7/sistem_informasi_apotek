<?php

$tahun = [];
for ($i = 2020; $i <= date("Y"); $i++) {
    $tahun[] = $i;
}
$bulan = [
    1 => "Januari",
    2 => "Februari",
    3 => "Maret",
    4 => "April",
    5 => "Mei",
    6 => "Juni",
    7 => "Juli",
    8 => "Agustus",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Desember",
];

?>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Laporan Transaksi Penjualan</h4>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group ml-2">
                        <label for="inputbulan" class="d-block font-weight-bold" style="font-size: 1.3rem;">Per
                            Bulan</label>
                        <div class="d-flex mt-2">
                            <div class="col-sm-4 p-0">
                                <select class="form-control custom-select" name="tahun">
                                    <option selected disabled>Pilih Tahun !</option>
                                    <?php foreach ($tahun as $t) : ?>
                                    <option value="<?= $t ?>"><?= $t ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-sm-4 p-0 ml-2">
                                <select class="form-control custom-select" name="bulan">
                                    <option selected disabled>Pilih Bulan !</option>

                                    <?php foreach ($bulan as $bn => $bv) : ?>
                                    <option value="<?= $bn ?>"><?= $bv ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="ml-2">
                                <button type="button" class="btn btn-primary ml-2 btn-filter penjualan bulanan"
                                    disabled><i class="fa fa-eye"></i>
                                    Lihat</button>
                                <!-- <button type="button" class="btn btn-success ml-1"><i class="fa fa-print"></i> Cetak</button> -->
                            </div>
                        </div>
                    </div>
                    <p>
                    <div class="form-group ml-2">
                        <label for="inputtahun" class="d-block font-weight-bold" style="font-size: 1.3rem;">Per
                            Tahun</label>
                        <div class="d-flex mt-2">
                            <div class="col-sm-4 p-0">
                                <select class="form-control custom-select" name="tahun">
                                    <option selected disabled>Pilih Tahun !</option>
                                    <?php foreach ($tahun as $t) : ?>
                                    <option value="<?= $t ?>"><?= $t ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="ml-2">
                                <button type="button" class="btn btn-primary ml-2 btn-filter penjualan tahunan"
                                    disabled><i class="fa fa-eye"></i>
                                    Lihat</button>
                                <!-- <button type="button" class="btn btn-success ml-1"><i class="fa fa-print"></i> Cetak</button> -->
                            </div>
                        </div>
                    </div>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6 right">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Laporan Transaksi Pembelian</h4>
                    </div>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group ml-2">
                        <label for="inputbulan" class="d-block font-weight-bold" style="font-size: 1.3rem;">Per
                            Bulan</label>
                        <div class="d-flex mt-2">
                            <div class="col-sm-4 p-0">
                                <select class="form-control custom-select" name="tahun">
                                    <option selected disabled>Pilih Tahun !</option>
                                    <?php foreach ($tahun as $t) : ?>
                                    <option value="<?= $t ?>"><?= $t ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-sm-4 p-0 ml-2">
                                <select class="form-control custom-select" name="bulan">
                                    <option selected disabled>Pilih Bulan !</option>

                                    <?php foreach ($bulan as $bn => $bv) : ?>
                                    <option value="<?= $bn ?>"><?= $bv ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="ml-2">
                                <button type="button" class="btn btn-primary ml-2 btn-filter pembelian bulanan"
                                    disabled><i class="fa fa-eye"></i>
                                    Lihat</button>
                                <!-- <button type="button" class="btn btn-success ml-1"><i class="fa fa-print"></i> Cetak</button> -->
                            </div>
                        </div>
                    </div>

                    <p>
                    <div class="form-group ml-2">
                        <label for="inputtahun" class="d-block font-weight-bold" style="font-size: 1.3rem;">Per
                            Tahun</label>
                        <div class="d-flex mt-2">
                            <div class="col-sm-4 p-0">
                                <select class="form-control custom-select" name="tahun">
                                    <option selected disabled>Pilih Tahun !</option>
                                    <?php foreach ($tahun as $t) : ?>
                                    <option value="<?= $t ?>"><?= $t ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="ml-2">
                                <button type="button" class="btn btn-primary ml-2 btn-filter pembelian tahunan"
                                    disabled><i class="fa fa-eye"></i>
                                    Lihat</button>
                                <!-- <button type="button" class="btn btn-success ml-1"><i class="fa fa-print"></i> Cetak</button> -->
                            </div>
                        </div>
                    </div>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row g-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <h3><b>Data Laporan</b></h3>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-laporan" class="table table-bordered table-hover dt-responsive"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Jumlah Item</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="http://localhost/skripsi/assets/js/moment.js"></script>
<script src="http://localhost/skripsi/assets/js/puller.js"></script>
<script>
const cloud = new Puller();

function formatRupiah(angka, prefix) {
    var number_string = angka
        .toString()
        .replace(/[^,\d]/g, "")
        .toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}
</script>

<script>
let tableLaporan = $("#table-laporan");

$("body").on("click", ".btn-filter", function(e) {
    const type = $(this).hasClass("pembelian") ? "pembelian" : "penjualan";
    const periode = $(this).hasClass("bulanan") ? "bulanan" : "tahunan";

    const filter = {
        tahun: $(this).closest(".form-group").find("[name=tahun]").val(),
    };

    if (periode == "bulanan") {
        filter.bulan = parseInt($(this).closest(".form-group").find("[name=bulan]").val());
    }

    if (Object.values(filter).includes(null)) {
        alert("Pilih periode terlebih dahulu !");
        return;
    }

    const data = cloud.get(type).data.filter(x => {
        if (periode == "bulanan") {
            return (moment(x.tanggal).month() == (filter.bulan - 1)) && (moment(x.tanggal).year() ==
                filter.tahun);
        } else {
            return moment(x.tanggal).year() ==
                filter.tahun;
        }
    })

    let num = 1;
    tableLaporan.find("tbody").empty();
    data.forEach(d => {
        const items = cloud.get(`${type}-detail`).data.filter(y => y[`id_${type}`] == d[
            `id_${type}`
        ]);
        tableLaporan.find("tbody").append(`
                            <tr>
                                <td>${num++}</td>
                                <td>${d.tanggal}</td>
                                <td>${items.length}</td>
                                <td>${formatRupiah(d.total, "Rp. ")}</td>
                            </tr>
        `);
    });
});

$(document).ready(function() {
    cloud.add("http://localhost/skripsi/master/penjualan/find", {
        name: "penjualan",
    }).then(penjualan => {

        cloud.add("http://localhost/skripsi/master/penjualan/detail", {
            name: "penjualan-detail",
        }).then(penjualanDetail => {
            cloud.add("http://localhost/skripsi/master/pembelian/find", {
                name: "pembelian",
            }).then(pembelian => {
                cloud.add("http://localhost/skripsi/master/pembelian/detail", {
                    name: "pembelian-detail",
                }).then(obat => {
                    cloud.add("http://localhost/skripsi/master/supplier/find", {
                        name: "supplier",
                    }).then(supplier => {
                        cloud.add(
                            "http://localhost/skripsi/master/obat/find", {
                                name: "obat",
                            }).then(obat => {
                            $(".btn.btn-primary.ml-2").prop(
                                "disabled",
                                false);
                        });
                    });
                });
            });
        });
    });
});
</script>