<?php
include 'connectDb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pId = $_POST['pId'];
    $exportQty = $_POST['exportQty'];


    $sql = "UPDATE tbProduct 
            SET stockQty = stockQty - $exportQty, 
                TotalExport = TotalExport + $exportQty 
            WHERE pId = $pId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Product exported successfully"]);
    } else {
        echo json_encode(["error" => "Database error: " . $conn->error]);
    }
}
?>