<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="shortcut icon" href="images/upgates-sign-white.svg" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="css/calendar.min.css">
  <link rel="stylesheet" href="style.css">  
</head>

<body>

</body>

</html>


<?php
$routes = ['/'];

route("/", function () {
  require('views/dashboard.php');
});
route('/login', function () {
  require('views/login.php');
});
route('/forgotten-password', function () {
  require('views/forpass.php');
});
route('/404', function () {
  require('views/404.php');
});
route('/out', function () {
  require('components/logout.php');
});
route('/export', function () {
  require('components/export.php');
});
route('/dochazka', function () {
  require('views/dochazka.php');
});
route('/edit', function () {
  require('views/edit.php');
});
route('/udalost', function () {
  header('Location: /udalost/moje');
});
route('/udalost/create', function () {
  require('views/novaUdalost.php');
});
route('/udalost/moje', function () {
  require('views/mojeUdalosti.php');
} );
route('/calendar', function () {
  require('views/calendar.php');
});

function route(string $path, callable $callback)
{
  global $routes;
  $routes[$path] = $callback;
}

run();

function run()
{
  global $routes;
  $uri = $_SERVER['REQUEST_URI'];
  $found = false;
  foreach ($routes as $path => $callback) {
    if ($path !== $uri) continue;

    $found = true;
    $callback();
  }

  if (!$found) {
    $notFoundCallback = $routes['/404'];
    $notFoundCallback();
  }
}
?>