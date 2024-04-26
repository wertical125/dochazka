<?php
session_start();
require("connection.php");
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $email = $_POST["email"];
    $sql = "INSERT INTO zadost(z_email) values ('{$email}')";
    $conn->query($sql);
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
                                    <a class="nav-link active" href="#">Zapomenuté heslo</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <h2 class="mx-2">Zapomenuté heslo</h2>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <form method="POST">
                            <div class="form-group mb-3">
                                <label style="text-align: left;" for="frm-logInForm-username">
                                    Email:
                                    <input size="20" type="text" class="form-control" placeholder="Napiš email" required="" name="email" data-nette-rules="[{&quot;op&quot;:&quot;:filled&quot;,&quot;msg&quot;:&quot;Prosím vypňte email.&quot;}]">
                                </label>
                            </div>
                            <input class="btn btn-primary " type="submit" name="submit" value="Odeslat žádost">
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