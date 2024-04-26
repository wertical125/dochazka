<?php
//pripojeni databaze
require("connection.php");
session_start();
//kontrola jestli je uzivatel prihlasen
if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] == "") {
    header("Location: /login");
};
$num_of_data = 10;
//kontrola poctu zobrazenych dat
if (isset($_SESSION["numDataEvent"])) {
    $num_of_data = $_SESSION["numDataEvent"];
}
//Ziskani uzivatele
$id = $_SESSION["id"];
$sql = "SELECT * from uzivatel where u_id = {$id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$username = $row["u_jmeno"] . '.' . $row["u_prijmeni"];
//Ziskani dochazky urciteho uzivatele
if (!isset($_SESSION["event"])) {
    $sql = "SELECT * FROM event where u_id = {$id} order by e_datumZac";
    $event = $conn->query($sql);
} else {
    $event = $_SESSION["event"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // funkce na filtr
    if (isset($_POST["filtr"])) {
        $datform1 = $_POST["dat1"];
        $datform2 = $_POST["dat2"];
        $datObject1 = new DateTime($datform1);
        $datObject2 = new DateTime($datform2);
        $dat1 = $datObject1->format('Y-d-m');
        $dat2 = $datObject2->format('Y-d-m');
        $sql = "SELECT * FROM event WHERE e_datumZac between '{$dat1}' and '{$dat2}' order by e_datumZac asc";
        $result = $conn->query($sql);
        $data = array();
        foreach ($result as $row) {
            array_push($data, $row);
        }
        $_SESSION['event'] = $data;
        header('Location: /udalost/moje');
    }
    //funkce na reset filtru
    if (isset($_POST['reset'])) {
        $sql = "SELECT * FROM event where u_id = {$id} order by e_datumZac asc";
        $result = $conn->query($sql);
        $data = array();
        foreach ($result as $row) {
            array_push($data, $row);
        }
        $_SESSION['event'] = $data;
        header('Location: /udalost/moje');
    }
    if (isset($_POST['select_option'])) {
        $num_Data = filter_input(INPUT_POST,"select_option", FILTER_SANITIZE_STRING);
        $_SESSION['numDataEvent'] = $num_Data;
        header('Location: /udalost/moje');
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
                        <div class="col-sm-6 ">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dat1" class="me-5">Od: </label>
                                    <input type="date" name="dat1" id="dat1" class="rounded-3 shadow-sm">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dat2" class="me-5">Do: </label>
                                    <input type="date" name="dat2" id="dat2" class="rounded-3 shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="submit" name="filtr" class="btn btn-success w-100" value="Filtrovat" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="submit" name="reset" class="btn btn-warning w-100" value="Reset" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Od</th>
                            <th scope="col">Do</th>
                            <th scope="col">Název</th>
                            <th scope="col">Popis</th>
                            <th scope="col">Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 0; ?>
                        <?php foreach ($event as $row) : ?>
                            <?php if ($num <= $num_of_data) : ?>
                                <tr>
                                    <td><?php echo $row['e_datumZac'] ?></td>
                                    <td><?php echo $row['e_datumKon'] ?></td>
                                    <td><?php echo $row['e_nazev'] ?></td>
                                    <td><?php echo $row['e_popis'] ?></td>
                                    <td>Akce</td>
                                </tr>
                                <?php $num+=1; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <div class="row m-2">
            <div class="col-md-2"></div>
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <form method="post">
                    <select name="select_option" id="select_option" class="form-select w-50" onchange="this.form.submit()">
                        <option value="10" <?php if ($num_of_data == 10): echo "selected"; endif ?> >10</option>
                        <option value="25" <?php if ($num_of_data == 25): echo "selected"; endif ?> >25</option>
                        <option value="50" <?php if ($num_of_data == 50): echo "selected"; endif ?> >50</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <?php require("components/footer.php") ?>
</body>

</html>