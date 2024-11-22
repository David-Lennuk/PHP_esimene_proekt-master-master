<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>PHP tunnitööd</title>
    <link rel="stylesheet" href="style/style.css"></link
</head>
<body>
<?php
//päis
include("header.php");
?>

<?php
//navigeeterimismenüü
include("nav.php");
?>
<section>
    <?php
    if(isset($_GET["leht"])){
        include("kontent/".$_GET["leht"]);
    } else {
        include("kontent/kodu.php");
    }
    ?>
</section>
<?php
//jalus
include("footer.php");
?>
</body>
</html>