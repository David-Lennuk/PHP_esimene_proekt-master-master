<?php
// Laadime XML faili, kus on õpilaste andmed
$ruhm = simplexml_load_file("TARpv23_ruhmaleht.xml");

if (isset($_GET['code'])) {
    die(highlight_file(__FILE__));
}

// Meetod õpilaste andmete salvestamiseks XML-sse
function saveOpilaneData() {
    global $ruhm;
    $ruhm->asXML("TARpv23_ruhmaleht.xml");
}

// Funktsioon õpilaste otsinguks
function koikotsing($paring) {
    global $ruhm;
    $paringVastus = array();
    $paring = strtolower($paring);

    foreach ($ruhm->opilane as $nimi) {
        if (strpos(strtolower($nimi->nimi), $paring) !== false ||
            strpos(strtolower($nimi->perenimi), $paring) !== false ||
            strpos(strtolower($nimi->vanus), $paring) !== false ||
            strpos(strtolower($nimi->hobbi), $paring) !== false) {
            array_push($paringVastus, $nimi);
        }
    }
    return $paringVastus;
}

// Uue õpilase lisamise vormi töötlemine
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nimi']) && isset($_POST['koduleht']) && isset($_POST['perenimi']) && isset($_POST['vanus']) && isset($_POST['hobbi'])) {
    $new_name = htmlspecialchars($_POST['nimi']);
    $new_sait = htmlspecialchars($_POST['koduleht']);
    $new_perenimi = htmlspecialchars($_POST['perenimi']);
    $new_vanus = htmlspecialchars($_POST['vanus']);
    $new_hobbi = htmlspecialchars($_POST['hobbi']);

    // Uue õpilase lisamine XML-sse
    $new_opilane = $ruhm->addChild('opilane');
    $new_opilane->addChild('nimi', $new_name);
    $new_opilane->addChild('perenimi', $new_perenimi);
    $new_opilane->addChild('hobi', $new_hobbi);
    $new_opilane->addChild('vanus', $new_vanus);
    $new_opilane->nimi->addAttribute('href', $new_sait);

    // Salvestame muudatused XML faili
    saveOpilaneData();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rühmaleht</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>TARpv23 Rühmaleht</h1>

<!-- Õpilaste otsingu vorm -->
<form action="?" method="post">
    <label for="otsing">Otsing</label>
    <input type="text" id="otsing" name="otsing" placeholder="nimi, perenimi, vanus, hobbi">
    <input type="submit" value="Otsi">
</form>

<?php
// Õpilaste otsingu töötlemine
if (!empty($_POST["otsing"])) {
    $paringVastus = koikotsing($_POST["otsing"]);
    echo "<table>";
    echo "<tr><th>ID</th><th>Nimi</th><th>Perenimi</th><th>Vanus</th><th>Hobbi</th></tr>";

    $id = 1;
    foreach ($paringVastus as $r) {
        echo "<tr>";
        echo "<td>" . $id++ . "</td>";
        echo "<td>";
        if (isset($r->nimi['href'])) {
            // Kui href atribuut on olemas, kuvame lingi otse
            echo "<a href='" . htmlspecialchars($r->nimi['href']) . "'>" . htmlspecialchars($r->nimi) . "</a>";
        } else {
            // Kui linki pole, kuvatakse nimi lihtsalt
            echo htmlspecialchars($r->nimi);
        }
        echo "</td>";
        echo "<td>" . htmlspecialchars($r->perenimi) . "</td>";
        echo "<td>" . htmlspecialchars($r->vanus) . "</td>";
        echo "<td>" . htmlspecialchars($r->hobi) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nimi</th><th>Perenimi</th><th>Vanus</th><th>Hobbi</th></tr>";

    $id = 1;
    foreach ($ruhm->opilane as $r) {
        echo "<tr>";
        echo "<td>" . $id++ . "</td>";
        echo "<td>";
        if (isset($r->nimi['href'])) {
            // Kui href atribuut on olemas, kuvame lingi otse
            echo "<a href='" . htmlspecialchars($r->nimi['href']) . "'>" . htmlspecialchars($r->nimi) . "</a>";
        } else {
            // Kui linki pole, kuvatakse nimi lihtsalt
            echo htmlspecialchars($r->nimi);
        }
        echo "</td>";
        echo "<td>" . htmlspecialchars($r->perenimi) . "</td>";
        echo "<td>" . htmlspecialchars($r->vanus) . "</td>";
        echo "<td>" . htmlspecialchars($r->hobi) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<form action="?code" method="post">
    <input type="submit" name="Click" value="Vaata lehe koodi">
</form>

<!-- Uue õpilase lisamise vorm -->
<h2>Lisa uus õpilane</h2>
<form method="post" action="">
    <label for="nimi">Nimi: </label>
    <input type="text" name="nimi" id="nimi" required><br><br>
    <label for="koduleht">Koduleht: </label>
    <input type="text" name="koduleht" id="koduleht" required><br><br>
    <label for="perenimi">Perenimi: </label>
    <input type="text" name="perenimi" id="perenimi" required><br><br>
    <label for="vanus">Vanus: </label>
    <input type="number" name="vanus" id="vanus" value="0" required><br><br>
    <label for="hobbi">Hobbi: </label>
    <input type="text" name="hobbi" id="hobbi" required><br><br>
    <input type="submit" value="Lisa">
</form>

<footer>
    <p>2024 TARpv23 Rühmaleht</p>
</footer>

</body>
</html>
