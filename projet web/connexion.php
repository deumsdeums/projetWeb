<?php
    $config = require 'config.php';
    $host=$config['host'];
    $port=$config['port'];
    $dbname=$config['dbname'];
    $username=$config['username'];
    $password=$config['password'];

    $connection=new PDO('mysql:host=devbdd.iutmetz.univ-lorraine.fr;port=3306;dbname=rossi62u_projetweb',$username,$password);
?>