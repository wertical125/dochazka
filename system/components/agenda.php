<?php
require("connection.php");
$id = $_SESSION['id'];
$sql = 'SELECT * FROM event';
$sql2 = 'SELECT * FROM uzivatel';
$result = $conn->query($sql);
$users = $conn->query($sql2);

?>

<ul class="list-group">
    <?php for ($i = 01; $i < 32; $i++) : ?>
        <?php if ($i < 10) :
            //$i_format = str_pad($i, 2, '0', STR_PAD_LEFT);
            $cis = date("Y-0$i-m");
        else :
            $cis = date("Y-$i-m")?>
            <?php endif; ?>
        <?php $x = 0; ?>
        <?php foreach ($result as $row) : ?>
            <?php if ($cis === $row['e_datumZac'] || $cis === $row['e_datumKon']) : ?>
                <?php if ($x == 0) : ?>
                    <li class="list-group-item list-group-item-dark"><?php echo $cis ?></li>
                    <?php $x = 1; ?>
                <?php endif; ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <?php echo $row['e_casZac'] . ' - ' . $row['e_casKon'] ?>
                        </div>
                        <div class="col-4">
                            <?php foreach ($users as $user) {
                                if ($user['u_id'] == $row['u_id']) {
                                    $jmeno = $user['u_jmeno'] . ' ' . $user['u_prijmeni'];
                                }
                            } ?>
                            <?php echo $row['e_nazev'] . ' - ' . $row['e_popis'] . ' - ' . $jmeno; ?>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php $x = 0; ?>
    <?php endfor; ?>
</ul>