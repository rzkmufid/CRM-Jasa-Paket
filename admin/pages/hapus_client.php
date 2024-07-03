<?php
// Pastikan sesi dimulai jika diperlukan
// session_start();

// Periksa apakah ada id yang diterima melalui parameter GET
if (isset($_GET['id'])) {
    $idclient = $_GET['id'];

    // Hapus terlebih dahulu data dari tabel pengiriman yang merujuk ke client tersebut
    // $delete_pengiriman = mysqli_query($conn, "DELETE FROM pengiriman WHERE client_id=$idclient");

    try {
        $stmt = $conn->prepare("DELETE FROM client WHERE client_id  = ?");
        $stmt->bind_param("i", $idclient);
        $stmt->execute();
        $stmt->close();

        echo "<script>  
                alert('Client Berhasil Dihapus!');
                document.location.href='index.php?page=client';
            </script>";
    } catch (mysqli_sql_exception $e) {
        // Tangani kesalahan foreign key constraint
        if ($e->getCode() == 1451) {
            echo "<script>
                        alert('Error: Tidak dapat menghapus Client karena terkait dengan data pengiriman. Harap hapus atau perbarui data terkait terlebih dahulu.');
                        document.location.href='index.php?page=client';
                    </script>";
            // echo "";
        } else {
            // Tangani kesalahan lain
            echo "Error: " . $e->getMessage();
        }
    }
}
