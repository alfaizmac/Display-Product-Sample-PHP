<?php
include "../db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM product WHERE product_ID = ?";
    $params = array($id);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        echo "<script>
        window.location.href = '../index.php';
    </script>";
    } else {
        echo "<script>
        alert('Failed to delete list.');
        window.location.href = '../index.php';
    </script>";
    }
}
?>