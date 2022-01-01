<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page d'autentification</title>
      <link rel="stylesheet" href="../css/style_nav.css">
      <link rel="stylesheet" href="../css/style_form.css">
      <?php
         require_once('../../Controls/f_print.php');
         require_once('../../Controls/f_request.php');

         session_start();
       ?>
   </head>
   <body>

      <?php
         if (isset($_SESSION['auto']) && isset($_SESSION['login']))
            f_print_menu($_SESSION['auto'], $_SESSION['login']);
         else
            f_print_menu(false, false);
      ?>

      <main>
         <?php
            // Si l'utilisateur n'est pas connecté
            if (!isset($_SESSION['login'])) {
               // Et n'a pas encore fait de tentatives
               if (!isset($_POST['login'])) {
                  echo "<h1>Veuillez vous connecter</h1>";
                  f_print_formSignIn();
               }
               else {
                  $error = f_request_signIn($_POST['login'], $_POST['pwd']);

                  if ($error == 'false') {
                     echo "<h1>Bienvenue ". $_POST['login'] ." !</h1>";
                     // On créer les variables de sections
                     $_SESSION['auto']  = f_request_selectFromUsers('auto', 'login', $_POST['login']);
                     $_SESSION['login'] = $_POST['login'];
                     $_SESSION['id']    = f_request_selectFromUsers('id', 'login', $_POST['login']);
                     // Redirection vers la page d'accueil
                     header('Location: accueil.php');
                  }
                  else {
                     echo "<h1>Veuillez vous connecter</h1>";
                     switch ($error) {
                        case 'err_pwd'  : echo "<p class =\"error\">*Mot de passe erroné*</p>";break;
                        case 'err_login': echo "<p class =\"error\">*Pseudo inconnu*</p>";break;
                     }
                     f_print_formSignIn();
                  }
               }
            }
            else {
               echo "<h1>Vous êtes déjà connecté</h1>";
               // Redirection vers la page d'accueil
               header('Location: accueil.php');
            }
      ?>
      </main>

   </body>
</html>
