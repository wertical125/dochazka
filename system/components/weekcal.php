<?php 
require("connection.php");
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;
use benhall14\phpCalendar\Event as Event;



$calendar->setTimeFormat('06:00', '21:00', 120)->useWeekView();
$events = [];
$sql = 'SELECT * FROM event';
    $sql2 = 'SELECT * FROM uzivatel';
    $result = $conn->query($sql);
    $users = $conn->query($sql2);
    foreach ($result as $row) {
        $cojavim = new DateTime($row['e_datumZac']);
        $cojavim2 = new DateTime($row['e_datumKon']);
        $datumZac = $cojavim->format('Y-d-m');
        $datumKon = $cojavim2->format('Y-d-m');
        foreach ($users as $user) {
            if ($user['u_id'] == $row['u_id']) {
                $jmeno = $user['u_jmeno'] . ' ' . $user['u_prijmeni'];
            }
        }
        $popisK = $row['e_nazev'] . ' - ' . $row['e_popis'] . ' - ' . $jmeno;
        $calendar->addEvent($datumZac, $datumKon, $popisK, true);
    }

    echo $calendar->display(date('Y-m-d'))

?>
