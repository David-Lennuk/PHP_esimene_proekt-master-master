<div id="vihje">
<?php
echo '<h2>Mõistatus</h2>';

$tekst = 'Cyprus ja Luxembourg';
$sona = str_word_count($tekst, 1);

echo '<ol>';
echo '<li>Esimene täht on - '.substr($tekst, 0, 1).'</li>';
echo '<li>Teine täht on - '.$tekst[1];
echo '<li>Tähed 3-5 - '.substr($tekst, 2, 5).'</li>';
echo '<li>Teine sõna - '.substr($tekst, 6, 4).'</li>';
echo '<li>Viimane vihje - ' . strrev('Luxembourg') . '</li>';

echo '</ol>';
?>
</div>
<div class="vastud">
    <form method="post" action="">
        Sisestage riigi nimi

        <input type="text" placeholder="Sisestage siia" name="moist">
        <input type="submit" value="OK">
    </form>

    <?php
    if (isset($_POST['moist'])) {
        $userInput = $_POST['moist'];
        if (empty($userInput)) {
            echo "Sisestage riigi nimi";
        } else {
            if (strtolower($userInput) == 'cyprus ja luxembourg') {
                echo "Õige! Cyprus ja Luxembourg";
            } else {
                echo "Vale sisend!";
            }
        }
    }
    highlight_file("mõistatus.php");
    echo "<br>"
    ?>
</div>