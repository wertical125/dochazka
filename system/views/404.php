<?php
session_start();
require("connection.php");
$id = $_SESSION["id"];
$sql = "SELECT * from uzivatel where u_id = {$id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$username = $row["u_jmeno"] . '.' . $row["u_prijmeni"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Docházka - 404</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php require("components/navbar.php"); ?>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> Stránka nenalezena..</p>
            <p class="lead">
                Stránka, kterou hledáte, neexistuje
            </p>
            <a href="/" class="btn btn-primary">Zpátky</a>
        </div>
    </div>
    <?php require("components/footer.php") ?>
</body>

</html>