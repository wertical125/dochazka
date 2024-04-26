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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //funkce na pridani dochazky rucne 
    if (isset($_POST["dochMan"])) {
        $datumForm = $_POST['datum'];
        $datObject1 = new DateTime($datumForm);
        $datum = $datObject1->format('Y-d-m');
        $prichod = $_POST['prichod'];
        $odchod = $_POST['odchod'];
        $start_datetime = new DateTime($prichod);
        $end_datetime = new DateTime($odchod);
        $timeDifferent = $start_datetime->diff($end_datetime);
        $pracovniDoba =  "$timeDifferent->h\h  $timeDifferent->i\m";
        $u_id = $_POST['kdo'];
        $poznamka = $_POST['poznamka'];
        $sql = "INSERT INTO dochazka(u_id, d_datum, d_prichod, d_odchod, d_poznamka, d_pracovniDoba) VALUES ({$u_id}, '{$datum}', '{$prichod}', '{$odchod}', '{$poznamka}', '{$pracovniDoba}')";
        $conn->query($sql);
        $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_datum";
        $result = $conn->query($sql);
        $dochazka = array();
        foreach ($result as $row) {
            array_push($dochazka, $row);
        }
        $_SESSION["dochazka"] = $dochazka;
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
                        <h3>Manuální zadání docházky</h3>

                        <div class="col-md-3 mb-3">
                            <label for="datum" class="me-5">Datum: </label>
                            <input type="date" name="datum" id="" class="form-control shadow-sm">
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
                            <label for="kdo" class="me-5">Kdo: </label>
                            <select name="kdo" class="form-control form-select ">
                                <option value="<?php echo $id ?>"><?php echo $username ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-md-9 mb-3">
                            <label for="poznamka" class="me-5">Poznámka: </label>
                            <input placeholder="Poznámka" type="text" name="poznamka" id="" class="form-control shadow-sm">
                        </div>
                    </div>
                    <input type="submit" name="dochMan" class="btn btn-primary w-25 mx-4" value="Přidat docházku" />
                </form>
            </div>
        </div>
    </div>
    <?php require("components/footer.php") ?>
</body>

</html>