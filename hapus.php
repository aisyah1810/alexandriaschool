<?php
session_start(); // Start the session
include 'koneksi.php'; // Include your database connection

if (isset($_GET['id'])) {
    $nisn = $_GET['id'];

    // SQL query to delete the student record
    $query = "DELETE FROM master_siswa WHERE NISN = '$nisn'";

    // Execute the delete query
    $delete_success = mysqli_query($koneksi, $query);

    if ($delete_success) {
        // If the delete query was successful
        echo '<script>
            alert("Data berhasil dihapus.");
            document.location.href = "data_siswa.php";
        </script>';
    } else {
        // If the delete query failed
        echo '<script>
            alert("Gagal menghapus data.");
            document.location.href = "data_siswa.php";
        </script>';
    }
} else {
    // If no ID is provided in the GET request
    header('Location: data_siswa.php'); // Redirect to the target page
    exit;
}
?>
