function getObat() {
	const data = [];
	$("#purchaseItems tr").each(function () {
		const p = {
			id_obat: $(this).data("id"),
			jumlah: parseInt($(this).find("td:eq(1) input").val().replace(/\./g, "")),
			harga_jual: parseInt($(this).find("td:eq(2) input").val().replace(/\./g, "")),
		};
		p.total = p.jumlah * p.harga_jual;
		data.push(p);
	});
	return data;
}

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

$("body").on("click", "#btn-add", function (e) {
	e.preventDefault();
	if (
		$("[name=id_obat]").val() == null ||
		$("[name=id_obat]").val() == undefined ||
		$("[name=id_obat]").val() == "" ||
		$("[name=inputJumlah]").val() == "" ||
		$("[name=inputHargaJual]").val() == 0
	) {
		alert("Pilih obat yang valid dan masukkan jumlahnya!");
		return;
	}
	const data = cloud
		.get("obat")
		.data.find((x) => x.id_obat == $("[name=id_obat]").val());
	const jumlah = parseInt($("[name=inputJumlah]").val());
	const total = jumlah * parseInt(data.harga_jual);

	if (jumlah > data.stok) {
		alert("Stok obat tidak cukup!");
		return;
	}

	const rownum = $("#purchaseItems tr").length + 1;
	// Tambahkan data ke tabel
	var newRow = `<tr data-id="${data.id_obat}" data-rownum="${rownum}">
                        <td>${data.obat}</td>
                        <td><input type="text" class="form-control reset-total format-rupiah" value="${formatRupiah(
													jumlah
												)}" data-id="${data.id_obat}" /></td>
                        <td><input type="text" class="form-control reset-total format-rupiah" value="${formatRupiah(
													data.harga_jual
												)}"/></td>
                        <td>${formatRupiah(
													total
												)}</td>  <!-- Tampilkan dalam format ribuan -->
                        <td>
                            <button class="btn btn-danger btn-sm remove-item"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
	$("#purchaseItems").append(newRow);
	$("#calculateTotal").trigger("click");

	$("[name=id_obat]").val("");
	$("[name=inputJumlah]").val("");
});

$("body").on("keyup", ".reset-total", function (e) {
	e.preventDefault();
	const id_obat = $(this).closest("tr").data("id");
	const data = cloud.get("obat").data.find((x) => x.id_obat == id_obat);
	const jumlah = parseInt(
		$(this).closest("tr").find("td:eq(1) input").val().replace(/\./g, "")
	);
	const harga = parseInt(
		$(this).closest("tr").find("td:eq(2) input").val().replace(/\./g, "")
	);

	if (jumlah > data.stok) {
		alert("Stok obat tidak cukup!");
		$(this).closest("tr").find("td:eq(1) input").val(data.stok);
		return;
	}

	const total = jumlah * harga;
	console.log(jumlah, harga, total);

	$(this).closest("tr").find("td:eq(3)").text(formatRupiah(total));
	$("#calculateTotal").trigger("click");
});

$("body").on("keyup", ".format-rupiah", function (e) {
	this.value = formatRupiah(this.value);
});

$("body").on("submit", "#purchaseForm", function (e) {
	e.preventDefault();
	const data = {};
	$(this)
		.serializeArray()
		.map(function (x) {
			data[x.name] = x.value;
		});
	if (getObat().length == 0) {
		alert("Tidak ada item yang dijual!");
		return;
	}

	data.obat = getObat();
	let total = 0;
	getObat().forEach((obat) => {
		total += obat.jumlah * obat.harga_jual;
	});
	data.total = total;

	const urlForm =
		data.id_penjualan.length == 0
			? "http://localhost/skripsi/master/penjualan/tambah"
			: "http://localhost/skripsi/master/penjualan/update";

	$.ajax({
		type: "POST",
		url: urlForm,
		data: JSON.stringify(data),
		dataType: "json",
		contentType: "application/json",
		cache: false,
		processData: false,
		success: function (res) {
			window.location.href = "http://localhost/skripsi/master/penjualan";
		},
	});
});

// Submit form modal untuk menambahkan obat ke tabel

// Menghapus item dari tabel
$("body").on("click", ".remove-item", function (e) {
	$(this).closest("tr").remove();
	$("#calculateTotal").trigger("click");
});

$("#calculateTotal").click(function () {
	let totalHarga = 0;
	// Loop melalui setiap baris di tabel dan ambil nilai 'Total'
	$("#purchaseItems tr").each(function () {
		// Ambil nilai total dari kolom 'Total' (kolom ke-4)
		let totalItem = $(this).find("td:eq(3)").text();
		// Hapus format ribuan (jika ada) dan konversi ke integer
		totalItem = parseInt(totalItem.replace(/\./g, ""));
		// Tambahkan nilai total item ke totalHarga
		totalHarga += totalItem;
	});
	// Format totalHarga dengan format ribuan dan set ke input Total Harga
	$("#total_harga").val(totalHarga.toLocaleString("id-ID"));
});

$(document).ready(function () {
	cloud
		.add(origin + "/skripsi/master/obat/find", {
			name: "obat",
			wrap: "data",
		})
		.then((data) => {
			$("#btn-add").prop("disabled", false);
			console.log(data["data"]);
		});
});
