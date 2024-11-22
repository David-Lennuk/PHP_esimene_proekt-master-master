<?php
$autod=simplexml_load_file("autod.xml");
?>
<!Doctype html>
<html lang="et">
<head>
    <title>Autode andmed xml failist</title>
</head>
<body>
<h2>Autode andmed xml failist</h2>
<div>
    Esimene auto andmed:
    <?php
    echo $autod->auto[0]->mark;
    echo ", ";
    echo $autod->auto[0]->autonumber;
    echo ", ";
    echo $autod->auto[0]->omanik;
    echo ", ";
    echo $autod->auto[0]->v_aasta;
    ?>
</div>
</body>
</html>
