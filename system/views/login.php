<?php
session_start();
require("connection.php");
$sql = "SELECT * from uzivatel";
$data = $conn->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    foreach ($data as $row) {
        if ($username === $row["u_email"] and $password === $row["u_heslo"]) {
            $_SESSION["id"] = $row["u_id"];
            $_SESSION["isLogged"] = "True";
            if($username === "admin"){
                $_SESSION["isAdmin"] = "True";
            }
            else{
                $_SESSION["isAdmin"] = "False";
            }
            header("Location: /");
        }
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
    <div class="container ">
        <div class="row ">
            <div class="col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <nav class="navbar navbar-expand-sm bg-primary navbar-dark rounded-2 m-2">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="/">
                            <img src="images/upgates-sign-white.svg" alt="" width="25px">
                            Dochazka
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavbar">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" href="/forgotten-password">Zapomenuté heslo</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <h2 class="mx-2">Přihlášení</h2>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <form method="POST" action="/login">
                            <div class="form-group mb-3">
                                <label style="text-align: left;" for="frm-logInForm-username">
                                    Uživatelské jméno:
                                    <input size="20" type="text" class="form-control" placeholder="Napiš username" required="" name="username" id="username" data-nette-rules="[{&quot;op&quot;:&quot;:filled&quot;,&quot;msg&quot;:&quot;Prosím vypňte uzivatelske jmeno.&quot;}]">
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <label style="text-align: left;" for="frm-logInForm-password">
                                    Heslo:
                                    <input type="password" class="form-control" placeholder="Napiš password" required="" name="password" id="password" data-nette-rules="[{&quot;op&quot;:&quot;:filled&quot;,&quot;msg&quot;:&quot;Prosím vypňte své heslo.&quot;}]">
                                </label>
                            </div>
                            <input class="btn btn-primary " type="submit" name="submit" value="Přihlásit se">
                        </form>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <?php require("components/footer.php"); ?>
    </div>
</body>

</html>