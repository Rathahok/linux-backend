<?php
include "connectDb.php";
$sql = "SELECT * FROM tbProduct";
$result = $conn->query($sql);
$products = [];
while ($row = $result->fetch_assoc()) {
    $row['img'] = "http://localhost/Linux_backend/UploadImg/" . $row['img'];
    $products[] = $row;
}

echo json_encode($products);
?>