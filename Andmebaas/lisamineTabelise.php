<?php
require  ('conf.php');
global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["loomanimi"]) && !empty($_REQUEST["loomanimi"])){
    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, varv, omanik, pild)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"],$_REQUEST["varv"], $_REQUEST["omanik"], $_REQUEST["pild"]);
    $paring->execute();
}


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
        <th></th>
        <th>id</th>
        <th>loomanimi</th>
        <th>varv</th>
        <th>omanik</th>
        <th>loomapild</th>
    </tr>
    <?php

    while($paring->fetch()){
        echo "<tr>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
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
    <!--table lisamisVorm-->
    <h2>Uue looma lisamine</h2>
    <form action="?" method="post">
        <label for="loomanimi">Loomanimi</label>
        <input type="text" id="loomanimi" name="loomanimi">
        <br>
        <label for="varv">Varv</label>
        <input type="color" id="varv" name="varv">
        <br>
        <label for="omanik">Omanik</label>
        <input type="text" id="omanik" name="omanik">
        <br>
        <label for="pild">Pilt:</label>
        <textarea name="pild" id="pild" cols="30" rows="10">
            sisesta pildi link
        </textarea>
        <br>
        <input type="submit" value="OK">
    </form>
</body>
</html>
<?php
$yhendus->close();

