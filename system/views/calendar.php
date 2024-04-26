<?php
session_start();
require("connection.php");
$id = $_SESSION["id"];
if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] == "") {
    header("Location: /login");
};
$sql = "SELECT * from uzivatel where u_id = {$id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$username = $row["u_jmeno"] . '.' . $row["u_prijmeni"];

require 'vendor/autoload.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dochazka</title>
</head>

<body>
    <?php require("components/navbar.php") ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <button class="btn btn-secondary" onclick="switchCalendar('month')">Měsíc</button>
                <button class="btn btn-secondary" onclick="switchCalendar('week')">Týden</button>
                <button class="btn btn-secondary" onclick="switchCalendar('agenda')">Agenda</button>
            </div>
        </div>
        <div class="row m-3" id="monthCal">
            <div class="col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <?php require("components/calendar.php") ?>
            </div>
        </div>
        <div class="row m-3 zmiz" id="weekCal">
            <div class="col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <?php require("components/weekcal.php") ?>
            </div>
        </div>
        <div class="row m-3 zmiz" id="agenda">
            <div class="col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <?php require("components/agenda.php") ?>
            </div>
        </div>
    </div>
    <?php require("components/footer.php") ?>
</body>

</html>


<script>
    function switchCalendar(value) {
        var monthCal = document.getElementById("monthCal");
        var weekCal = document.getElementById("weekCal");
        var agenda = document.getElementById("agenda");
        if (value === "month"){
            monthCal.className = "row m-3"
            weekCal.className = "row m-3 zmiz"
            agenda.className = "row m-3 zmiz"
        } else if (value === "week") {
            monthCal.className = "row m-3 zmiz"
            weekCal.className = "row m-3 "
            agenda.className = "row m-3 zmiz"
        } else if (value === "agenda"){
            monthCal.className = "row m-3 zmiz"
            weekCal.className = "row m-3 zmiz"
            agenda.className = "row m-3"
        }
    }
</script>