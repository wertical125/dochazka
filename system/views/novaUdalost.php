<?php
require("connection.php");
session_start();
$id = $_SESSION['id'];
if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] == "") {
    header("Location: /login");
};
$sql = "SELECT * from uzivatel where u_id = {$id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$username = $row["u_jmeno"] . '.' . $row["u_prijmeni"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //funkce na pridani dochazky rucne 
    if (isset($_POST["newEv"])) {
        $nazev = $_POST["nazev"];
        $popis = $_POST["popis"];
        $datumFrom = $_POST['datumStart'];
        $datObject1 = new DateTime($datumFrom);
        $datum1 = $datObject1->format('Y-d-m');
        $datumEnd = $_POST['datumEnd'];
        $datObject2 = new DateTime($datumEnd);
        $datum2 = $datObject2->format('Y-d-m');
        $casOd = $_POST['timeStart'];
        $casDo = $_POST['timeEnd'];
        $sql = "INSERT INTO event(u_id, e_nazev, e_popis, e_datumZac, e_casZac, e_datumKon, e_casKon) Values ({$id}, '{$nazev}', '{$popis}', '{$datum1}', '{$casOd}','{$datum2}', '{$casDo}')";
        $conn->query($sql);
        $sql = "SELECT * FROM event where u_id = {$id} order by e_datumZac";
        $result = $conn->query($sql);
        $data = array();
        foreach ($result as $row) {
            array_push($data, $row);
        }
        $_SESSION['event'] = $data;
        header("Location: /udalost/create");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dochazka</title>
</head>

<body>
    <?php require('components/navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <form method="POST">
                    <h3 class="mx-3">Vytvoření nové události</h3>
                    <div class="row m-2">
                        <div class="col-md-6 mb-3">
                            <label for="nazev" class="me-5">Název: </label>
                            <input placeholder="Název události" type="text" name="nazev" id="" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="popis" class="me-5">Popis: </label>
                            <input placeholder="Napiš o co se jedná..." type="text" name="popis" id="" class="form-control shadow-sm">
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-md-3 mb-3">
                            <label for="datumStart" class="me-5">Datum od: </label>
                            <input type="date" name="datumStart" id="" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="timeStart" class="me-5">Čas od: </label>
                            <input type="time" name="timeStart" id="" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="datumEnd" class="me-5">Datum do: </label>
                            <input type="date" name="datumEnd" id="" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="timeEnd" class="me-5">Čas do: </label>
                            <input type="time" name="timeEnd" id="" class="form-control shadow-sm">
                        </div>
                    </div>
                    <input type="submit" name="newEv" class="btn btn-primary w-15 mx-4" value="Přidat událost" />
                </form>
            </div>
        </div>
    </div>
    <?php require('components/footer.php'); ?>
</body>

</html>