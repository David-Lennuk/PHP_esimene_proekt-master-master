<?php
$serverinimi= "d132033.mysql.zonevs.eu";
$kasutaja= "d132033_davidlennuk";
$parool= "***************";
$andmebaas= "d132033_baasphp";

$yhendus= new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");