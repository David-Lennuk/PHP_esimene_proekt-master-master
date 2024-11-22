<?php
require  ('conf.php');

//tabeli sisu kuvamine
global $yhendus;
$paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pild FROM loomad");
$paring->bind_result($id, $loomanimi, $omanik, $varv, $pild);
$paring->execute();
?>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
    <link rel="stylesheet" href="tabel1.css"></link
</head>
<body>
<h1>Loomad andmebaasist</h1>
<table>
    <tr>
        <th>id</th>
        <th>loomanimi</th>
        <th>varv</th>
        <th>omanik</th>
        <th>loomapild</th>
    </tr>
    <?php

    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$id."</td>";
        echo "<td>".htmlspecialchars($loomanimi)."</td>";
        //htmlspecialchars - ei käivita sisestatud koodi <>
        echo "<td bgcolor='$varv'>".htmlspecialchars($varv)."</td>";
        echo "<td>".htmlspecialchars($omanik)."</td>";
        echo "<td><img src='$pild' alt='pilt' width='100px'></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>
<?php
$yhendus->close();

