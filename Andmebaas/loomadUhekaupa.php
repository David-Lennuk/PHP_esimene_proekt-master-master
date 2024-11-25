<?php
require ('conf.php');

global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["uusloom"]) && !empty($_REQUEST["loomanimi"])){
    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, varv, omanik, pild)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"],$_REQUEST["varv"], $_REQUEST["omanik"], $_REQUEST["pild"]);
    $paring->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <title>Table sisu, mida võetakse  andmebaasist</title>
    <link rel="stylesheet" href="LoomaUhe.css">
</head>
<body>
<h1>Loomad 1 kaupu</h1>
<div id="meny">
<ul>
    <?php
    //loomade nimed andmebaasist
    global $yhendus;
    $paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pild FROM loomad");
    $paring->bind_result($id, $loomanimi, $omanik, $varv, $pild);
    $paring->execute();

    while($paring->fetch()){

        echo "<li><a href='?looma_id=$id'>".$loomanimi."</a></li>";
    }

    ?>

</ul>
    <?php
    echo "<a href='?Lisamine=jah'>Lisa loom</a>"
    ?>


</div>
<div id="sisu">
    <?php
    //kui klik looma nimele, siis näitame loome info
    if(isset($_REQUEST["looma_id"])){
        $paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pild 
FROM loomad WHERE id = ?");
        $paring->bind_result($id, $loomanimi, $omanik, $varv, $pild);
        $paring->bind_param("i", $_REQUEST["looma_id"]);
        $paring->execute();
        //näitame ühe kaupa
        if($paring->fetch()){
            echo "<div style='background-color: $varv'>Loomanimi: ".$loomanimi;
            echo "<br>Tõug: ".$varv;

            echo "<br><img src='$pild' width='100px' alt='pilt'>";
            echo "<br>Omanik: ".$omanik;
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
        <input type="hidden" value="jah" name="uusloom">
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
 <?php
}
 ?>
</body>
</html>