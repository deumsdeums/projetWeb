<?php
    include 'connexion.php';
    error_reporting(E_ALL & ~E_NOTICE);
    session_start();
    require 'newsFunction.php';
    ?>
<html>
    <head>
        <title>News</title>
        <link href="styles/index.css" rel="stylesheet" type="text/css">
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <link href="styles/news.css" rel="stylesheet" type="text/css">



    </head>
    <header>
        <?php
            include 'modules/header.php';
        ?>
    </header>

    <body>
    <div class="actualites">
    <h1>Actualités</h1>
    <br>
        <?php
            $news = $connection->query('SELECT * FROM news');
            echo "<div class='news-grid-container'>";
            foreach($news as $new){
                echo "<div class='news-grid-item' id='",getTheme($new['idnews']),"'>";
                    echo "<img class='profileimg' src='images/profile.png' alt='profile'/>",getNewsRedacteur($new['idredacteur']);
                    echo "<div class='news-date'>",$new['datenews'],"</div>";
                    echo "<div class='separator'></div>";
                    echo "<div class='news-title'>",$new['titrenews'],"</div>";
                    echo "<div class='news-content'><td>",$new['textenews'],"</div>";
                    
                    if(($_SESSION['connected']&&($_SESSION['info'])['idredacteur']==$new['idredacteur'])||$_SESSION['isAdmin']==1){
                        echo '<div class=\'news-delete\'><a href=\'delete.php?idnews='.$new['idnews'].' \' onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette news ?\'))"> Supprimer </a></div>';
                    }
                    if((!$_SESSION['isAdmin']&&$_SESSION['connected'])&&($_SESSION['info']['idredacteur']!=$new['idredacteur']))
                    echo '<div class=\'news-report\'><a href=\'report.php?idnews='.$new['idnews'].' \' onclick="return(confirm(\'Etes-vous sûr de vouloir signaler cette news ?\'))"> Signaler </a></div>';

                echo "</div>";

            }
            echo "</div>";
            ?>
            </div>
            <div class="fonctionnalites">
                <h1>Fonctionnalités</h1>
                <div>
                    <h2>Basiques</h2>
                    <ul class="basicList">
                        <li>Inscription ( Toutes les exceptions gérées )</li>
                        <li>Connexion</li>
                        <li>Apparition d'un bouton rédaction après la connexion</li>
                        <li>Apparition d'un bouton déconnexion après la connexion</li>
                        <li>Rédaction d'une news et affichage sur l'index</li>
                        <li>Affichage de la news : rédacteur/date/titre/contenu</li>
                        <li>Changement du fond de la news en fonction du thème de cette dernière</li>
                    </ul>
                    <h2>Additionnelles</h2>
                    <ul class="advancedList">
                        <li>Possibilité de supprimer la news que l'on a écrit</li>
                        <li>Possibilité de signaler une news écrite par quelqu'un d'autre</li>
                        <li>Limite d'un signalement par news</li>
                        <li>Système d'administration (compte admin = admin@gmail.com pass : pass)</li>
                            <h3>En tant qu'administrateur</h3>
                            <li>Apparition d'un bouton administration</li>
                            <li>Possibilité de supprimer un compte rédacteur</li>
                            <li>Apperçu des signalements des utilisateurs</li>
                            <li>Possibilité de supprimer un signalement</li>
                            <li>Possibilité de supprimer nimporte quelle news</li>
                    </ul>

                </div>
            </div>

    

    </body>
</html>