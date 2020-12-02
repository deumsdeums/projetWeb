<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if($_SESSION['connected']){
        header('Location:index.php');
    }

?>
<html>
        </script>
    <head>
        <link href="styles/login.css" rel="stylesheet" type="text/css">
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <title>Connexion</title>
    </head>
    <header>
        <?php
            include 'modules/header.php';
        ?>
    </header>
    <body>
        <form name="form" id="login" action="" method="post">
            E-Mail <input name="mail" type="text"/><br>
            Mot de passe <input name ="password" type="password"/><br>
            <input type="submit" name="submit" value="Se connecter"/>
        </form>
    </body>
    
</html>

<?php
if(isset($_POST['submit'])){
     if(strlen(trim($_POST['mail']))>0){
        if(strlen(trim($_POST['password']))>0){
            $mail=$_POST['mail'];
            $password=$_POST['password'];
            if(checkAccount($mail,$password)){
                $_SESSION['info']=getRedacteurInfo($mail);
                $_SESSION['connected']=1;
                if(isAdmin($mail))
                    $_SESSION['isAdmin']=1;
                header('Location:index.php');
            }
            else
                echo "<script>alert('Mail ou mot de passe incorrect')</script>";

        }
        else
            echo "<script>alert('Mot de passe vide')</script>";
     }
     else
        echo "<script>alert('Mail vide')</script>";
    }
     function getRedacteurInfo($mail){
        include 'connexion.php';
        $req=$connection->query("SELECT * FROM redacteur WHERE email='$mail'");
        return $req->fetch();
     }
     function checkAccount($mail,$pass){
        include 'connexion.php';
        $req=$connection->prepare("SELECT motdepasse FROM redacteur WHERE email='$mail'");
        $req->execute();
        if($req->rowCount()==1){
            $password= ($req->fetch())[0];
            if($password==md5($pass))
                return true;
            else
                return false;
        }
        else
            return false;
     }
     function isAdmin($mail){
        include 'connexion.php';
        $req=$connection->prepare("SELECT isAdmin FROM redacteur WHERE email='$mail'");
        $res=$req->execute();
        $isAdmin=($req->fetch())[0];
        if($isAdmin==1)
            return true;
        else
            return false;
     }


?>