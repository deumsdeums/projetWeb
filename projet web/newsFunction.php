<?php
            function getNewsRedacteur($id){
                include 'connexion.php';
                $req=$connection->prepare("SELECT prenom FROM redacteur WHERE idredacteur='$id'");
                $req->execute();
                return ($req->fetch())[0]; 
            }
            function getTheme($id){
                include 'connexion.php';
                $req=$connection->prepare("SELECT description 
                                           FROM theme,news
                                            WHERE theme.idtheme=news.idtheme
                                            AND news.idnews='$id'");
                $req->execute();
                return ($req->fetch())[0];  
            }
            function isAlreadyReported($id){
                include 'connexion.php';
                $req=$connection->prepare("SELECT COUNT(*) FROM report WHERE idnews='$id'");
                $req->execute();
                if(($req->fetch())[0]=='0')
                    return false;
                else
                    return true;

            }
        ?>