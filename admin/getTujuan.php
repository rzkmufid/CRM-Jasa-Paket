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

// Mengambil alamat gudang dari parameter GET
if (isset($_GET['alamat_gudang'])) {
    $alamat_gudang = $_GET['alamat_gudang'];

    // Query untuk mengambil tujuan bongkar berdasarkan semua tarif yang sesuai
    $query = "
        SELECT DISTINCT t.tujuan
        FROM tarif t
        JOIN gudang g ON t.asal = g.alamat_gudang
        WHERE g.alamat_gudang = '$alamat_gudang'
        UNION
        SELECT DISTINCT t2.asal AS tujuan
        FROM tarif t2
        JOIN gudang g2 ON t2.tujuan = g2.alamat_gudang
        WHERE g2.alamat_gudang = '$alamat_gudang'
    ";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $tujuan_bongkar = array();
        while ($row = $result->fetch_assoc()) {
            $tujuan_bongkar[] = $row;
        }
        echo json_encode($tujuan_bongkar);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}

// Menutup koneksi database
$conn->close();
