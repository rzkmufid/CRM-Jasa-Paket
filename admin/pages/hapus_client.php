<?php
// Pastikan sesi dimulai jika diperlukan
// session_start();

// Periksa apakah ada id yang diterima melalui parameter GET
if (isset($_GET['id'])) {
    $idclient = $_GET['id'];

    // Hapus terlebih dahulu data dari tabel pengiriman yang merujuk ke client tersebut
    // $delete_pengiriman = mysqli_query($conn, "DELETE FROM pengiriman WHERE client_id=$idclient");

    if ($delete_pengiriman) {
        // Jika penghapusan dari tabel pengiriman berhasil, lanjutkan untuk menghapus data client
        $delete_client = mysqli_query($conn, "DELETE FROM client WHERE client_id=$idclient");

        if ($delete_client) {
            // Redirect kembali ke halaman client setelah penghapusan selesai
            echo "<script>  
                alert('Pengiriman Berhasil Dihapus!');
                document.location.href='index.php?page=client';
            </script>";
        } else {
            // Jika gagal menghapus client (seharusnya tidak terjadi jika tidak ada error database)
            echo "<script>alert('Gagal menghapus client.');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        // Jika gagal menghapus dari tabel pengiriman (terjadi jika ada foreign key constraint)
        echo "<script>alert('Tidak dapat menghapus client karena masih ada pengiriman terkait.');</script>";
        echo "<script>window.history.back();</script>";
    }
}
