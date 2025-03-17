<?php
include 'connectDb.php';

//this code for best exported product
$bestExportQuery = "SELECT Pname, TotalExport FROM tbProduct ORDER BY TotalExport DESC LIMIT 1";
$bestExportResult = $conn->query($bestExportQuery);
$bestExport = $bestExportResult->fetch_assoc();

//stock alert 
$stockAlertQuery = "SELECT Pname, stockQty FROM tbProduct WHERE stockQty < 10";
$stockAlertResult = $conn->query($stockAlertQuery);
$stockAlerts = [];
while ($row = $stockAlertResult->fetch_assoc()) {
    $stockAlerts[] = $row;
}

echo json_encode(["bestExported" => $bestExport, "stockAlerts" => $stockAlerts]);

?>