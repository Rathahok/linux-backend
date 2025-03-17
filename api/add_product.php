<?php
include 'connectDb.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $pname = $_POST['Pname'];
    $unitPrice = $_POST['unitPrice'];
    $stockQty = $_POST['stockQty'];

    $targetDir = "../UploadImg/";
    $imageFile = basename($_FILES["img"]["name"]);
    $targetFile = $targetDir . $imageFile; // Corrected variable name
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO tbProduct (Pname, unitPrice, stockQty, img) 
                VALUES ('$pname', '$unitPrice', '$stockQty', '$imageFile')"; // Corrected variable in SQL
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Product added successfully"]);
        } else {
            echo json_encode(["error" => "Database error: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Image upload failed"]);
    }
}   
?>
