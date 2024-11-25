<?php
require ('conf.php');

global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["nimi"]) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare("INSERT INTO osalejad(nimi, telefon, synniaeg, pild)
    VALUES (?, ?, ?, ?)");
    // i - integer, s - string
    $paring->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["synniaeg"], $_REQUEST["pild"]);
    $paring->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <title>Table sisu, mida võetakse  andmebaasist</title>
    <link rel="stylesheet" href="tabeluhe.css">
</head>
<body>
<h1>Matka 1 kaupu</h1>
<div id="meny">
    <table>
        <?php
        //loomade nimed andmebaasist
        global $yhendus;
        $paring=$yhendus->prepare("SELECT id, nimi, telefon, synniaeg, pild FROM osalejad");
        $paring->bind_result($id, $nimi, $telefon, $synniaeg, $pild);
        $paring->execute();

        while($paring->fetch()){

            echo "<table><a href='?nimi_id=$id'><img src='$pild' alt='MatkaOsalejad' width='150' height='125'>";
        }

        ?>

    </table>
    <?php
    echo "<a href='?Lisamine=jah'>Lisa osaleja</a>"
    ?>


</div>
<div id="sisu">
    <?php
    //kui klik looma nimele, siis näitame loome info
    if(isset($_REQUEST["nimi_id"])){
        $paring=$yhendus->prepare("SELECT id, nimi, telefon, synniaeg, pild 
FROM osalejad WHERE id = ?");
        $paring->bind_result($id, $nimi, $telefon, $synniaeg, $pild);
        $paring->bind_param("i", $_REQUEST["nimi_id"]);
        $paring->execute();
        //näitame ühe kaupa
        if($paring->fetch()){
            echo "<div>Nimi: ".$nimi;
            echo "<br>Telefon: ".$telefon;

            echo "<br><img src='$pild' width='100px' alt='pilt'>";
            echo "<br>Synniaeg: ".$synniaeg;
            echo "<br><a href='?kustuta=$id'>Kustuta</a>";
            echo "</div>";

        }

    }
    ?>
</div>



<?php
//Lisamisvorm, mis avatakse kui vajutatud
if(isset($_REQUEST["Lisamine"])){
    ?>
        <form action="?" method="post">
            <input type="hidden" value="jah" name="uusnimi">
            <label for="nimi">Nimi</label>
            <input type="text" id="nimi" name="nimi">
            <br>
            <label for="telefon">Telefon</label>
            <input type="text" id="telefon" name="telefon">
            <br>
            <label for="synniaeg">Sünniaeg</label>
            <input type="date" id="synniaeg" name="synniaeg">
            <br>
            <label for="pild">Pilt:</label>
            <textarea name="pild" id="pild" cols="30" rows="10"></textarea>
            <br>
            <input type="submit" value="OK">
        </form>
    <?php
}
?>
</body>
</html>