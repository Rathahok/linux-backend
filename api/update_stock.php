<?php
include 'connectDb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pId = $_POST['pId'];
    $addedStockQty = $_POST['stockQty']; 

    $sql = "UPDATE tbProduct SET stockQty = stockQty + $addedStockQty WHERE pId = $pId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Stock updated successfully"]);
    } else {
        echo json_encode(["error" => "Database error: " . $conn->error]);
    }
}
?>