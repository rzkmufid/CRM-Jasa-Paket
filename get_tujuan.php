<?php
// Database connection
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "shipment_management"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil kota asal dari parameter GET
if (isset($_GET['asal'])) {
    $asal = $_GET['asal'];

    // Query untuk mendapatkan kota tujuan yang relevan berdasarkan kota asal
    $query = "SELECT DISTINCT tujuan FROM ( SELECT asal, tujuan FROM tarif
                                    UNION
                                    SELECT tujuan AS asal, asal AS tujuan FROM tarif
                                ) AS t1 WHERE asal = '$asal'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $tujuan = [];
        while ($row = $result->fetch_assoc()) {
            $tujuan[] = $row['tujuan'];
        }
        echo json_encode($tujuan);
    } else {
        echo json_encode([]);
    }
}

// Tutup koneksi database
$conn->close();
