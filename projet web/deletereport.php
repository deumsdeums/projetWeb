<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if(($_SESSION['connected']&&$_SESSION['isAdmin']==1)){
        $id=$_GET['idnews'];
        $deletereport=$connection->prepare("DELETE FROM report WHERE idnews='$id'");
        $deletereport->execute();
    }
    header("Location:admin.php");

?>