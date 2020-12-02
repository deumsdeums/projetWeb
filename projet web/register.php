<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if($_SESSION['connected']){
        header('Location:index.php');
    }
?>
<html>
    <script language="javascript" type="text/javascript">
        var mail=/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/;
        function Verif(){
                if(mail.test(document.forms.form.mail.value))
                {
                    return true;
                }
                else
                {
                    alert("Email incorrecte");
                    return false;
                }
            }
        
        </script>
    <head>
        <link href="styles/register.css" rel="stylesheet" type="text/css">
        <link href="styles/style.css" rel="stylesheet" type="text/css">

        <title>Inscription</title>
    </head>
    <header>
        <?php
            include 'modules/header.php';
        ?>
    </header>
    <body>
        <div id="register">
        <form name="form" id="register" action="" method="post" onsubmit ='return Verif()'>
            Nom <input name="nom" type="text"/><br>
            Prénom <input name="prenom" type="text"/><br>
            E-Mail <input name="mail" type="text"/><br>
            Mot de passe <input name ="password" type="password"/><br>
            <input type="submit" name="submit" value="S'inscrire"/>
        </form>
        </div>
    </body>
    
</html>

<?php
if(isset($_POST['submit'])){
   if(strlen(trim($_POST['nom']))>0){
        if(strlen(trim($_POST['prenom']))>0){
            if(strlen(trim($_POST['mail']))>0){
                if(strlen(trim($_POST['password']))>0)
                {
                    if(exist($_POST['mail'])){
                        echo "<script>alert('E-Mail déjà utilisée')</script>";
                    }
                    else{
                    $insert=$connection->prepare("INSERT INTO redacteur(nom,prenom,email,motdepasse,isAdmin) VALUES(?,?,?,?,?)");
                    $insert->bindValue(1,$_POST['nom']);
                    $insert->bindValue(2,$_POST['prenom']);
                    $insert->bindValue(3,$_POST['mail']);
                    $insert->bindValue(4,md5($_POST['password']));
                    $insert->bindValue(5,0);

                    $insert->execute();
                    echo "<script>alert('Compte crée avec succès')</script>";
                    header('Location:index.php');

                    }

                }
                else
                    echo "<script>alert('Mot de passe vide')</script>";

            }
            else
                echo "<script>alert('Mail vide')</script>";
        }
        else
            echo "<script>alert('Prénom vide')</script>";
    }
    else
        echo "<script>alert('Nom vide')</script>";
}
    function exist($mail){
        include 'connexion.php';
        $select=$connection->prepare("SELECT * FROM redacteur WHERE email='$mail'");
        $select->execute();
        if($select->rowCount()>0)
            return true;
        else
            return false;
    }
?>