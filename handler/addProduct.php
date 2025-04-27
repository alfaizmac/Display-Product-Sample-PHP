<?php
// Make sure the path to db_connect.php is correct
require_once '../db_connect.php';

if (isset($_POST['submit'])) {
    // Validate inputs
    if (empty($_POST['product_name']) || empty($_POST['description'])) {
        die(json_encode(['status' => 'error', 'message' => 'Product name and description are required']));
    }

    $productName = $_POST['product_name'];
    $description = $_POST['description'];
    $imagePath = 'img/default.png'; // Default image path

    // Handle image upload
    if (isset($_FILES['Profile_Image_Path']) && $_FILES['Profile_Image_Path']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';

        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate unique filename
        $extension = pathinfo($_FILES['Profile_Image_Path']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $targetFile = $uploadDir . $filename;

        // Check if file is an image
        $check = getimagesize($_FILES['Profile_Image_Path']['tmp_name']);
        if ($check === false) {
            die(json_encode(['status' => 'error', 'message' => 'File is not an image']));
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['Profile_Image_Path']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            die(json_encode(['status' => 'error', 'message' => 'Failed to upload image']));
        }
    }

    // Prepare SQL with error handling
    $sql = "INSERT INTO product (product_img, product_name, product_description) VALUES (?, ?, ?)";
    $params = array($imagePath, $productName, $description);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if (!$stmt) {
        die(json_encode(['status' => 'error', 'message' => 'Database prepare failed', 'errors' => sqlsrv_errors()]));
    }

    if (sqlsrv_execute($stmt)) {
        echo "<script>
        window.location.href = '../index.php';
    </script>";
    } else {
        die(json_encode(['status' => 'error', 'message' => 'Database insert failed', 'errors' => sqlsrv_errors()]));
    }

    // Clean up
    sqlsrv_free_stmt($stmt);
}
?>