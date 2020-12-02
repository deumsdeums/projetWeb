<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if(($_SESSION['connected']&&($_SESSION['info'])['idredacteur']==$new['idredacteur'])||$_SESSION['isAdmin']==1){
        $id=$_GET['idnews'];
        $delete=$connection->prepare("DELETE FROM news WHERE idnews='$id'");
        $delete->execute();
        $deletereport=$connection->prepare("DELETE FROM report WHERE idnews='$id'");
        $deletereport->execute();
    }
    header("Location:index.php");

?>