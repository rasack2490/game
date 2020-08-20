<?php  
    $bdd = new PDO('mysql:host=localhost; dbname=espace_membre', 'root', '');

    if(isset($_POST['forminscription'])){

        $speudo = htmlspecialchars($_POST['speudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
        
        if(!empty($_POST['speudo'])&& !empty($_POST['mail'])&& !empty($_POST['mail2'])&& !empty($_POST['mdp'])&& !empty($_POST['mdp2'])){

            $speudolenght = strlen($_POST['speudo']);
            if($speudolenght <= 255){

                if($mail == $mail2){

                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

                        $reqmail = $bdd -> prepare("SELECT * FROM membres WHERE mail = ?");
                        $reqmail->execute(array($mail));
                        $mailexist = $reqmail->rowCount();
                        if($mailexist == 0){

                            if($mdp == $mdp2){
                          
                                $insertmbr =$bdd->prepare ("INSERT INTO membres(speudo, mail, motdepasse) VALUES(?, ?, ?)");
                                $insertmbr->execute(array($speudo, $mail, $mdp));
                                $_SESSION['comptecree'] = 'Votre ocmpte a bien ete cree';
                                header('Location: index.php');
                                
                            }
                            else{
        
                                $erreur = 'Vos deux mot de passes ne sont pas correct !';
                            }
                        }
                        else{

                            $erreur = 'Adresse mail deja utiliser';
                        }

                        

                        
                    }
                    else{

                        $erreur = "Votre adresse mail n'est pas valide";
                    }
                }
                else{

                    $erreur = 'Vos deux adresses mail ne correspondent pas !';
                }
            }
            else{

                $erreur = 'Votre speudo ne doit pas depasser 255 caracteres';
            }
        }
        else{

            $erreur = 'Tous les champs doivent etre completer';
        }
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    
  </head>
  <body>
    <div class="container">
        <div align="center">
            <form method="post" action="">
                <h1>INSCRIPTION</h1> <br> <br>
                <table>
                    <tr>
                        <td align="right">
                            <label for="speudo" >Speudo :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="votre speudo" name="speudo" <?php if(isset($speudo)){echo $speudo;} ?> />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mail" >Mail :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="votre mail" name="mail"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mail2" >Confirmation mail :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="votre mail de confirmation" name="mail2"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mdp" >Mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="votre mot de passe" name="mdp"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="mdp2" >Confirmation du mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="votre mot de passe de confirmation" name="mdp2"/>
                        </td>
                    </tr>
                </table> <br>
                <input type="submit" value="je m'inscris" name="forminscription" >
            </form>
            <?php
                if(isset($erreur)){

                    echo '<font color="red">'.$erreur.'</font>';
                }
            ?>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>