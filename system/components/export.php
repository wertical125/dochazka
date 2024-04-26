<?php
session_start();
$id = $_SESSION["id"];
if(isset($_POST["export"]))
{
    $query = "SELECT d_datum, d_prichod, d_odchod, d_pracovniDoba FROM dochazka where u_id = {$id}";
    exportdat($query);
}
if(isset($_POST["exportMonth"])){
    $query = "SELECT d_datum, d_prichod, d_odchod, d_pracovniDoba FROM dochazka where u_id = {$id} order by d_datum desc limit 30";
    exportdat($query);
}

function exportdat($query) {
    require("../connection.php");
    $result = $conn->query($query);
    $exportdat = filter_input(INPUT_POST,"exportdat", FILTER_SANITIZE_STRING);
    if($exportdat === "0"){
        header('Content-Type: text/csv; charset=UTF-8');
    }
    else if($exportdat === '1'){
        header('Content-Type: text/csv; charset=CP1250');
    }
    header('Content-Disposition: attachment; filename="exported_data.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ["\xEF\xBB\xBF"]);
    fputcsv($output, ['Datum', 'Prichod', 'Odchod', 'Pracovni doba']);
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
}
?>