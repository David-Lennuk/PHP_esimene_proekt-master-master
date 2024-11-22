<?php
$serverinimi= "localhost";
$kasutaja= "David";
$parool= "123456";
$andmebaas= "david";


$yhendus= new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");