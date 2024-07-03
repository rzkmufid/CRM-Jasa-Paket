<?php
include 'db.php';

if (isset($_GET['id'])) {
    $driver_id = $_GET['id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Attempt to delete the driver
        $sql = "DELETE FROM driver WHERE driver_id = $driver_id";
        $conn->query($sql);

        // Commit the transaction if no errors
        $conn->commit();

        // Redirect or show a success message
        // echo "Driver deleted successfully!";
        echo "<script>
                        alert('Driver deleted successfully!');
                        document.location.href='index.php?page=driver';
                    </script>";
    } catch (mysqli_sql_exception $exception) {
        // Rollback the transaction in case of error
        $conn->rollback();

        // Check if the error is due to a foreign key constraint
        if ($exception->getCode() == 1451) {
            echo "<script>
                        alert('Error: Tidak dapat menghapus driver ini karena terkait dengan table yang ada.');
                        document.location.href='index.php?page=driver';
                    </script>";
        } else {
            // For other errors, display a generic error message
            echo "Error: Could not delete driver.";
        }
    }

    $conn->close();
} else {
    echo "No driver_id provided.";
}
