<?php
include 'db.php';

// Create Client
if (isset($_POST['create'])) {
    $nama_client = $_POST['nama_client'];
    $alamat_client = $_POST['alamat_client'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $sql = "INSERT INTO client (nama_client, alamat_client, telepon, email) VALUES ('$nama_client', '$alamat_client', '$telepon', '$email')";
    $conn->query($sql);
}

// Read Clients
$result = $conn->query("SELECT * FROM client");

// Update and Delete operations here

$conn->close();
?>
