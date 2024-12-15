<?php
try{
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=AUTO', 'IMAD', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die( "Erreur: ".$e->getMessage()."<br>");
}