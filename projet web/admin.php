<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    require 'newsFunction.php';
    if($_SESSION['connected']==1&&$_SESSION['isAdmin']==1){
        $redacteur=$connection->prepare("SELECT * FROM redacteur");
        $redacteur->execute();    

        $report=$connection->prepare("SELECT * FROM report");
        $report->execute();    
    }
    else
        header('Location:index.php');

?>
<html>
    <head>
        <title>Compte</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <link href="styles/admin.css" rel="stylesheet" type="text/css">
        <link href="styles/news.css" rel="stylesheet" type="text/css">



    </head>
    <header>
        <?php
            include 'modules/header.php';
        ?>
    </header>

    <body>
    <div class="grid-container">
        <div class="grid-item">
            <h1>Gestion des rédacteurs</h1>
            <div class="separator"></div>
            <form action="" method="post">
            <div class="redacteur-select">
            Redacteur : <select id="redacteur" name="redacteur">
                <?php
                    foreach($redacteur as $r)
                    if($r['idredacteur']!=$_SESSION['info']['idredacteur'])
                        echo '<option value='.$r['idredacteur'].'>',$r["nom"],"  ",$r["prenom"],'</option>';
                ?>
                </select><br>
            </div>
            <div class="redacteur-buttons">
                    <input id="deleteButton" type="submit" name="delete" value="Supprimer le compte"/>
                    <input id="adminButton" type="submit" name="admin" value="Promouvoir administrateur"/>
            </div>
            </form>
        </div>
        <div class="grid-item">
            <h1>Gestion des reports</h1>
            <?php
            $news = $connection->query('SELECT * FROM report');
            echo "<div class='news-grid-container'>";
            foreach($news as $new){
                displayNews($new['idnews']);
               
            }
            echo "</div>";
            ?>
        </div>

    </div>
    </body>
</hmtl>
<?php
    if(isset($_POST['delete'])){
        deleteRedacteur($_POST['redacteur']);
        header("Refresh:0");
        echo "<script>alert('Compte supprimé !')</script>";
    }
    if(isset($_POST['admin'])){
        setAdmin($_POST['redacteur']);
        echo "<script>alert('Le rédacteur est maintenant administrateur !')</script>";

    }
    
    function deleteRedacteur($idredacteur){
        include 'connexion.php';
        $req=$connection->prepare("DELETE FROM redacteur where idredacteur='$idredacteur'");
        $req->execute();
    }
    function setAdmin($idredacteur){
        include 'connexion.php';
        $req=$connection->prepare("UPDATE redacteur SET isAdmin='1' WHERE idredacteur='$idredacteur'");
        $req->execute();
    }
    function displayNews($idnews){
        include 'connexion.php';
        $req=$connection->prepare("SELECT * FROM news WHERE idnews='$idnews'");
        $req->execute();
        $n=$req->fetch();
        echo "<div class='news-grid-item' id='",getTheme($n['idnews']),"'>";
        echo "<img class='profileimg' src='images/profile.png' alt='profile'/>",getNewsRedacteur($n['idredacteur']);
        echo "<div class='news-date'>",$n['datenews'],"</div>";
        echo "<div class='separator'></div>";
        echo "<div class='news-title'>",$n['titrenews'],"</div>";
        echo "<div class='news-content'><td>",$n['textenews'],"</div>";
        
        if(($_SESSION['connected']&&$_SESSION['isAdmin']==1)){
            echo '<div class=\'news-delete\'><a href=\'delete.php?idnews='.$n['idnews'].' \' onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette news ?\'))"> Supprimer </a></div>';
            echo '<div class=\'news-deletereport\'><a href=\'deletereport.php?idnews='.$n['idnews'].' \' onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer le signalement ?\'))"> Supprimer le signalement </a></div>';

        }
        
    echo "</div>";
                    
    }
?>