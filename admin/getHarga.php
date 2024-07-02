<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shipment_management";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan data dari request
$alamat_gudang = $_POST['alamat_gudang'];
$tujuan_bongkar = $_POST['tujuan_bongkar'];
$muatan = $_POST['muatan'];

// Mengambil harga dari tabel tarif
$sql = "
    SELECT tarif_perton 
    FROM tarif 
    WHERE (asal = '$alamat_gudang' AND tujuan = '$tujuan_bongkar') 
       OR (asal = '$tujuan_bongkar' AND tujuan = '$alamat_gudang')
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $harga = $row['tarif_perton'];

    $hargaTotal = $harga * $muatan;

    // Mengembalikan respon dalam format JSON
    echo json_encode(array("status" => "success", "harga" => $hargaTotal));
} else {
    // Jika tidak ada data yang ditemukan
    echo json_encode(array("status" => "error", "message" => "Harga tidak ditemukan"));
}

// Menutup koneksi
$conn->close();
