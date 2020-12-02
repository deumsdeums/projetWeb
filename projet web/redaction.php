<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    if($_SESSION['connected']==1){
        $theme=$connection->prepare("SELECT * FROM theme");
        $theme->execute();
    }
    else{
        header('Location:index.php');
    }
?>
<html>

    <head>
        <title>Rédaction</title>
        <link href="styles/redaction.css" rel="stylesheet" type="text/css">
        <link href="styles/style.css" rel="stylesheet" type="text/css">

    <head>
    <header>
        <?php
            include 'modules/header.php';
        ?>
    </header>
    <body>
        <form id="redac" name="redaction" action="" method="post">
            Titre : <input type="text" name="titre"/><br>
            Theme : <select id="theme" name="theme">
                <?php
                    foreach($theme as $t)
                        echo '<option value='.$t['idtheme'].'>'.$t["description"].'</option>';
                ?>
                </select><br>
            Contenu :<br> <textarea name="contenu" rows='5' cols='60'></textarea><br>
            <input type="submit" name="submit" value="Envoyer"/>
            <input type="submit" name="cancel" value="Annuler"/>

        </form> 
    </body>
    <script>   
        var select = document.getElementById('theme');
        select.addEventListener('change', function () {
            var theme = select.options[select.selectedIndex].label;
            if(theme=="Sombre")
                document.getElementById('redac').style.backgroundColor="#e0dd92";
            else
                document.getElementById('redac').style.backgroundColor="#fffbab";

		})
    </script>
</html>
<?php

    if(isset($_POST['cancel'])){
        header("Location:index.php");
    }
    else{
        if(isset($_POST['submit'])){
         if(strlen(trim($_POST['titre']))>0){
            if(strlen(trim($_POST['contenu']))>0){
                $titre=$_POST['titre'];
                $contenu=$_POST['contenu'];
                $theme=$_POST['theme'];
                $req=$connection->prepare("INSERT INTO news(idtheme,titrenews,datenews,textenews,idredacteur) VALUES(?,?,CURDATE(),?,?)");
                $req->bindValue(1,$theme);
                $req->bindValue(2,$titre);
                $req->bindValue(3,$contenu);
                $req->bindValue(4,$_SESSION['info']['idredacteur']);
                $req->execute();
                header("Location:index.php");
        }
        else
            echo "<script>alert('Remplissez la news')</script>";
    }
    else
        echo "<script>alert('Donnez un titre à la news')</script>";
    }
}

?>