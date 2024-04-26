<?php 
require("connection.php");
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;
use benhall14\phpCalendar\Event as Event;


    # create the calendar object
    $calendar = new Calendar;
    
    # change the weekly start date to "Monday"
    $calendar->useMondayStartingDate();
    
    # (optional) - if you want to use full day names instead of initials (ie, Sunday instead of S), apply the following:
    $calendar->useFullDayNames();

    $calendar->setDays([
        'sunday' => [
        	'initials' => 'N',
        	'full' => 'Neděle'
        ],
        'monday' => [
        	'initials' => 'P',
        	'full' => 'Pondělí',
        ],
        'tuesday' => [
        	'initials' => 'Ú',
        	'full' => 'Úterý',
        ],
        'wednesday' => [
        	'initials' => 'S',
        	'full' => 'Středa',
        ],
        'thursday' => [
        	'initials' => 'Č',
        	'full' => 'Čtvrtek',
        ],
        'friday' => [
        	'initials' => 'P',
        	'full' => 'Pátek',
        ],
        'saturday' => [
        	'initials' => 'S',
        	'full' => 'Sobota',
        ],
    ]);

    $calendar->setMonths([
        'january' => 'Leden',  
        'february' => 'Únor',  
        'march' => 'Březen',  
        'april' => 'Duben',  
        'may' => 'Květen',  
        'june' => 'Červen',  
        'july' => 'Červenec',  
        'august' => 'Srpen',  
        'september' => 'Září',  
        'october' => 'Říjen',  
        'november' => 'Listopad',  
        'december' => 'Prosinec'
    ]);
    
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


    # you can also call ->display(), which handles the echo'ing and adding the stylesheet.
    echo $calendar->display(date('Y-m-d')); # draw this months calendar    
?>