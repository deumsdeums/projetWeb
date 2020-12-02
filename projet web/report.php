<?php
    include 'connexion.php';
    require 'newsFunction.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if($_SESSION['connected']){
        $idnews=$_GET['idnews'];
        if(!isAlreadyReported($idnews)){
            $req=$connection->prepare("INSERT INTO report(idnews,idredacteur) VALUES(:idnews,:idredacteur)");
            $req->bindParam(':idnews',$idnews);
            $req->bindParam(':idredacteur',$_SESSION['info']['idredacteur']);
            $req->execute();
            }
    }
        header('Location:index.php')
?>