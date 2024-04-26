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
if (isset($_SESSION["numData"])) {
    $num_of_data = $_SESSION["numData"];
}
$page = 1;
if (isset($_SESSION["page"])) {
    $page = $_SESSION["page"];
}
$startNum = ($page * $num_of_data) - $num_of_data;
//Ziskani uzivatele
$id = $_SESSION["id"];
$sql = "SELECT * from uzivatel where u_id = {$id}";
$data = $conn->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$username = $row["u_jmeno"] . '.' . $row["u_prijmeni"];
//Ziskani dochazky urciteho uzivatele
if (!isset($_SESSION["dochazka"])) {
    $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_datum";
    $result = $conn->query($sql);
    $dochazka = array();
    foreach ($result as $row) {
        array_push($dochazka, $row);
    }
} else {
    $dochazka = $_SESSION["dochazka"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //funkce na prichod
    if (isset($_POST["prichod"])) {
        if (!isset($_SESSION['prichod']) or $_SESSION['prichod'] == "") {
            require("connection.php");
            $id = $_SESSION["id"];
            $datum = date('Y-d-m');
            $prichod = date('H:i:s');
            $_SESSION['prichod'] = $prichod;
            $sql = "INSERT INTO dochazka(u_id, d_datum, d_prichod) VALUES ({$id}, '{$datum}', '{$prichod}')";
            $conn->query($sql);
            $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_datum";
            $result = $conn->query($sql);
            $data = array();
            foreach ($result as $row) {
                array_push($data, $row);
            }
            $_SESSION['dochazka'] = $data;
            header("Location: /");
        } else {
        }
    }
    //funkce na odchod
    if (isset($_POST["odchod"])) {
        require("connection.php");
        $id = $_SESSION["id"];
        $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_id desc LIMIT 1";
        $data = $conn->query($sql);
        $row = $data->fetch_array(MYSQLI_ASSOC);
        $d_id = $row['d_id'];
        $prichod = $_SESSION['prichod'];
        $odchod = date('H:i:s');
        $timeDifferent = DateTime::createFromFormat('H:i:s', $odchod)->diff(DateTime::createFromFormat('H:i:s', $prichod));
        $pracovniDoba =  "$timeDifferent->h\h $timeDifferent->i\m";
        $sql = "UPDATE dochazka SET d_odchod = '{$odchod}' where d_id = {$d_id}";
        $conn->query($sql);
        $sql = "UPDATE dochazka SET d_pracovniDoba = '{$pracovniDoba}' where d_id = {$d_id}";
        $conn->query($sql);
        $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_datum";
        $result = $conn->query($sql);
        $data = array();
        foreach ($result as $row) {
            array_push($data, $row);
        }
        $_SESSION['dochazka'] = $data;
        header("Location: /");
    }
    // funkce na filtr
    if (isset($_POST["filtr"])) {
        $datform1 = $_POST["dat1"];
        $datform2 = $_POST["dat2"];
        $datObject1 = new DateTime($datform1);
        $datObject2 = new DateTime($datform2);
        $dat1 = $datObject1->format('Y-d-m');
        $dat2 = $datObject2->format('Y-d-m');
        $sql = "SELECT * FROM dochazka WHERE d_datum between '{$dat1}' and '{$dat2}'";
        $result = $conn->query($sql);
        $data = array();
        foreach ($result as $row) {
            array_push($data, $row);
        }
        $_SESSION['dochazka'] = $data;
        header('Location: /');
    }
    //funkce na reset filtru
    if (isset($_POST['reset'])) {
        $sql = "SELECT * FROM dochazka where u_id = {$id} order by d_datum";
        $result = $conn->query($sql);
        $data = array();
        foreach ($result as $row) {
            array_push($data, $row);
        }
        $_SESSION['dochazka'] = $data;
        header('Location: /');
    }
    if (isset($_POST['select_option'])) {
        $num_Data = filter_input(INPUT_POST, "select_option", FILTER_SANITIZE_STRING);
        $_SESSION['numData'] = $num_Data;
        header('Location: /');
    }
    if (isset($_POST['prevBut'])) {
        $page -= 1;
        $_SESSION['page'] = $page;
        header('Location: /');
    }
    if (isset($_POST['nextBut'])) {
        $page += 1;
        $_SESSION['page'] = $page;
        header('Location: /');
    }
    if (isset($_POST['edit'])) {
        $id = $_POST["edit"];
        $_SESSION["d_id"] = htmlspecialchars($id);
        header("Location: /edit");
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
                <div class="row m-2">
                    <div class="col-sm-6 mb-3">
                        <form method="POST">
                            <input type="submit" name="prichod" class="btn btn-primary w-100" value="Příchod" />
                        </form>
                    </div>
                    <div class="col-sm-6 px-2 mb-3">
                        <form method="POST" action="">
                            <input type="submit" name="odchod" class="btn btn-primary w-100" value="Odchod" />
                        </form>
                    </div>
                </div>
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
                <form method="post" action="components/export.php">
                    <div class="row m-3">
                        <div class="col-md-3">
                            Výstupní formát:
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="exportdat" class="form-select form-select-sm">
                                <option value="0">UTF-8</option>
                                <option value="1" selected>CP1250</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="submit" name="export" class="btn btn-info w-100" value="Export" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="submit" name="exportMonth" class="btn btn-info w-100" value="Export last month" />
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Datum</th>
                            <th scope="col">Pracovní doba</th>
                            <th scope="col">Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 0 ?>
                        <?php for ($i = $startNum; $i < count($dochazka); $i++) : ?>
                            <?php if ($num <= $num_of_data - 1) : ?>
                                <tr>
                                    <td scope="row"><?php echo $dochazka[$i]['d_datum'] ?></td>
                                    <td><?php echo $dochazka[$i]['d_pracovniDoba'] ?></td>
                                    <td>
                                        <form method="POST">
                                            <button class="btn btn-primary" type="submit" name="edit" value="<?php echo $dochazka[$i]['d_id'] ?>"><i class='bx bxs-pencil'></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $num += 1; ?>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <div class="row m-2">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <form method="POST" action="">
                    <ul class="pagination">
                        <li class="page-item <?php if ($page === 1) : {
                                                        echo "disabled";
                                                    }
                                                endif ?>"><button name="prevBut" class="page-link" this.form.submit()>Předchozí</button></li>
                        <li class="page-item"><a href="" class="page-link active"><?php echo $page ?></a></li>
                        <li class="page-item <?php if ($num_of_data * $page > count($dochazka)) : {
                                                        echo "disabled";
                                                    }
                                                endif ?>"><button name="nextBut" class="page-link" onclick="this.form.submit()">Další</button></li>
                    </ul>
                </form>
            </div>
            <div class="col-md-7"></div>
            <div class="col-md-2">
                <form method="post">
                    <select name="select_option" id="select_option" class="form-select w-50" onchange="this.form.submit()">
                        <option value="10" <?php if ($num_of_data == 10) : echo "selected";
                                            endif ?>>10</option>
                        <option value="25" <?php if ($num_of_data == 25) : echo "selected";
                                            endif ?>>25</option>
                        <option value="50" <?php if ($num_of_data == 50) : echo "selected";
                                            endif ?>>50</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <?php require("components/footer.php") ?>
</body>

</html>