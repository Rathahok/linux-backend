<?php
include 'connectDb.php';

header("Content-Type: application/json");

$sqlExport = "SELECT * FROM tbExport";
$resultExport = $conn->query($sqlExport);

$exportData = [];

if ($resultExport->num_rows > 0) {
    while ($rowExport = $resultExport->fetch_assoc()) {
        $exId = $rowExport["exId"];

        // Fetch export product details for this export ID
        $sqlDetail = "SELECT ed.pId, ed.exportQty, p.Pname 
                      FROM exportProductDetail ed
                      JOIN tbProduct p ON ed.pId = p.pId
                      WHERE ed.exId = ?";
        
        $stmtDetail = $conn->prepare($sqlDetail);
        $stmtDetail->bind_param("i", $exId);
        $stmtDetail->execute();
        $resultDetail = $stmtDetail->get_result();

        $exportDetails = [];
        while ($rowDetail = $resultDetail->fetch_assoc()) {
            $exportDetails[] = $rowDetail;
        }

        $exportData[] = [
            "exId" => $exId,
            "exportDate" => $rowExport["exDate"],
            "totalItems" => $rowExport["exTotalQty"],
            "exportDetails" => $exportDetails
        ];

        $stmtDetail->close();
    }
}

$conn->close();
echo json_encode($exportData);
?>
