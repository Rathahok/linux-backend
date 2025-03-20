<?php
include 'connectDb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pIds = $_POST['pId'];
    $exportQtys = $_POST['exportQty'];

    if (count($pIds) === 0) {
        echo json_encode(["error" => "No products selected for export."]);
        exit;
    }

    $conn->begin_transaction();  

    try {
        $stmt = $conn->prepare("INSERT INTO tbExport (exTotalQty,exDate) VALUES ( ?,NOW())");
        $totalItems = count($pIds);
        $stmt->bind_param("i", $totalItems);
        $stmt->execute();
        $exId = $conn->insert_id;  

        $stmtDetail = $conn->prepare("INSERT INTO exportProductDetail (exId, pId, exportQty) VALUES (?, ?, ?)");
        $stmtUpdate = $conn->prepare("UPDATE tbProduct SET stockQty = stockQty - ?, TotalExport = TotalExport + ? WHERE pId = ?");

        for ($i = 0; $i < count($pIds); $i++) {
            $pId = intval($pIds[$i]);
            $exportQty = intval($exportQtys[$i]);

            $stmtDetail->bind_param("iii", $exId, $pId, $exportQty);
            $stmtDetail->execute();

            $stmtUpdate->bind_param("iii", $exportQty, $exportQty, $pId);
            $stmtUpdate->execute();
        }

        $conn->commit();
        echo json_encode(["message" => "Products exported successfully", "exportId" => $exId]);
    } catch (Exception $e) {
        $conn->rollback();  
        echo json_encode(["error" => "Transaction failed: " . $e->getMessage()]);
    }

    $stmt->close();
    $stmtDetail->close();
    $stmtUpdate->close();
    $conn->close();
}
?>