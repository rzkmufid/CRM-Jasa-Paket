<?php
// session_start();
// if (!isset($_SESSION["login"]) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
//     header("location:../login");
//     exit;
// }

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM client WHERE client_id=$id");
    header("Location: client.php");
}
