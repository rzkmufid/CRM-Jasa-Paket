<?php
// session_start();
// if (!isset($_SESSION["login"]) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
//     header("location:../login");
//     exit;
// }

include 'db.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Mengaktifkan laporan kesalahan MySQLi

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Bungkus query dalam try-catch
    try {
        $stmt = $conn->prepare("DELETE FROM gudang WHERE warehouse_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        echo "<script>  
                alert('Gudang Berhasil Dihapus!');
                document.location.href='index.php?page=gudang';
            </script>";
    } catch (mysqli_sql_exception $e) {
        // Tangani kesalahan foreign key constraint
        if ($e->getCode() == 1451) {
            echo "<script>
                        alert('Error: Tidak dapat menghapus gudang karena terkait dengan data pengiriman. Harap hapus atau perbarui data terkait terlebih dahulu.');
                        document.location.href='index.php?page=gudang';
                    </script>";
            // echo "";
        } else {
            // Tangani kesalahan lain
            echo "Error: " . $e->getMessage();
        }
    }
}
