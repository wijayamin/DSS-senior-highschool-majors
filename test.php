<?php
    include 'pdo.php';
    $query = "select * from murid where id_walikelas='6'";
    foreach($pdo->query($query) as $row){
        echo $row[0];
        echo "<br>";
    }
?>
