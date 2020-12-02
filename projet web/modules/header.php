<html>
    <head>
        <link href="styles/header.css" rel="stylesheet" type="text/css">
    </head>
    <header>
        <div id ="nav">
            <ul class="left">

            </ul>
            <ul class="center">
                <li><a href ="index.php">News</a></li>
            <?php
                error_reporting(E_ALL & ~E_NOTICE);
                session_start();
                if($_SESSION['connected']==1){
                    echo '<li><a href=\'redaction.php\'> Rédaction</a></li>';
            echo '</ul>';
            echo '<ul class="right">';
                    echo '<li><a href=\'deconnexion.php\' onclick="return(confirm(\'Etes-vous sûr de vouloir vous déconnecter ?\'))">Se deconnecter</a></li>';
                    if($_SESSION['isAdmin']==1) 
                        echo '<li><a href="admin.php">Administration</a></li>';
                        
                echo ' </ul>';
                }
                else
                {   
                    echo "<ul class='right'>";
                            echo "<li><a href='login.php'>Se connecter</a></li>";
                            echo "<li><a href='register.php'>S'inscrire</a></li>";
                    echo "</ul>";
                }
            ?>
        </div>
    </header>
</html>