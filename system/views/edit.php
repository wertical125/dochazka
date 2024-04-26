<?php
session_start();
require("connection.php");
$id = $_SESSION["id"];
$sql = "SELECT * from uzivatel where u_id = {$id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$username = $row["u_jmeno"] . '.' . $row["u_prijmeni"];
if (!isset($_SESSION["d_id"]) || $_SESSION["d_id"] === "") {
    header("Location: /");
}
if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] == "") {
    header("Location: /login");
};
$d_id = $_SESSION["d_id"];
$sql = "SELECT * from dochazka where d_id = {$d_id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$nevim = new DateTime($row["d_datum"]);
$date = $nevim->format("Y-d-m");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //funkce na pridani dochazky rucne 
    if (isset($_POST["editDoch"])) {
        $datumForm = $_POST['datum'];
        $datObject1 = new DateTime($datumForm);
        $datum = $datObject1->format('Y-d-m');
        $prichod = $_POST['prichod'];
        $odchod = $_POST['odchod'];
        $start_datetime = new DateTime($prichod);
        $end_datetime = new DateTime($odchod);
        $timeDifferent = $start_datetime->diff($end_datetime);
        $pracovniDoba =  "$timeDifferent->h\h  $timeDifferent->i\m";
        $poznamka = $_POST['poznamka'];
        $sql = "UPDATE dochazka SET d_datum = '{$datum}', d_prichod = '{$prichod}', d_odchod = '{$odchod}', d_pracovniDoba = '{$pracovniDoba}', d_poznamka = '{$poznamka}' where u_id = {$id} and d_id = {$d_id}";
        $conn->query($sql);
        $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_datum";
        $result = $conn->query($sql);
        $dochazka = array();
        foreach ($result as $row) {
            array_push($dochazka, $row);
        }
        $_SESSION["dochazka"] = $dochazka;
        header("Location: /");
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
    <?php require("components/navbar.php") ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <form method="POST">
                    <div class="row m-2">
                        <h3>Úprava docházky</h3>

                        <div class="col-md-3 mb-3">
                            <label for="datum" class="me-5">Datum: </label>
                            <input type="date" name="datum" pattern="\d{4}-\d{2}-\d{2}" id="" class="form-control shadow-sm" value="<?php echo $date ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="prichod" class="me-5">Příchod: </label>
                            <input type="time" name="prichod" id="" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="odchod" class="me-5">Odchod: </label>
                            <input type="time" name="odchod" id="" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="poznamka" class="me-5">Poznámka: </label>
                            <input placeholder="Poznámka" type="text" name="poznamka" id="" class="form-control shadow-sm">
                        </div>
                    </div>
                    <input type="submit" name="editDoch" class="btn btn-primary w-25 mx-4" value="Upravit docházku" />
                </form>
            </div>
        </div>
    </div>
    <?php require("components/footer.php") ?>
</body>

</html>