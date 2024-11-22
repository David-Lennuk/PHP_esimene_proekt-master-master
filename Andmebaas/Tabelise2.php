<?php
require ('conf.php');
//require ('conf2zone.php');
global $yhendus;

// Удаление записи
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

// Добавление новой записи
if(isset($_REQUEST["nimi"]) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare("INSERT INTO osalejad(nimi, telefon, synniaeg, pild)
    VALUES (?, ?, ?, ?)");
    // i - integer, s - string
    $paring->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["synniaeg"], $_REQUEST["pild"]);
    $paring->execute();
}

// Получение данных из базы данных
global $yhendus;
$paring=$yhendus->prepare("SELECT id, nimi, telefon, synniaeg, pild FROM osalejad");
$paring->bind_result($id, $nimi, $telefon, $synniaeg, $pild);
$paring->execute();
?>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
    <link rel="stylesheet" href="tabel2.css">
</head>
<body>
<h1>Osalejad</h1>
<table>
    <tr>
        <th></th>
        <th>id</th>
        <th>nimi</th>
        <th>telefon</th>
        <th>vanus</th>
        <th>pild</th>
    </tr>
    <?php
    while($paring->fetch()){
        $birthdate = new DateTime($synniaeg);
        $today = new DateTime();
        $vanus = $today->diff($birthdate)->y;

        echo "<tr>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "<td>".$id."</td>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".htmlspecialchars($telefon)."</td>";
        echo "<td>".$vanus."</td>";
        echo "<td><img src='$pild' alt='pild' width='100px'></td>";
        echo "</tr>";
    }
    ?>
</table>

<h2>Uue osaleja lisamine</h2>
<form action="?" method="post">
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
<footer>
    <?php
    echo "David Lennuk &copy; ";
    echo date("Y");
    ?>
    <a href="https://davidlennuk23.thkit.ee/wp/">konspekt wirdoress´is</a>
</footer>
</body>
</html>
<?php
$yhendus->close();
?>