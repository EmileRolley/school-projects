<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page de suppression</title>
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
            if (f_request_deleteFromUsers($_POST['login'])) {
               echo "<h2> L'utilisateur ". $_POST['login'] ." à bien été supprimé</h2>";
               // Si l'utilisateur supprime sont prorpre compte il faut également supprimer sa session
               if ($_POST['login'] == $_SESSION['login'])
                  header('Location: logOut.php');
            }
            else
               echo "<h2 class=\"error\">Une erreur est survenue lors de la suppression de l'utilisateur ".$_POST['login']."</h2>";
          ?>
       </main>

   </body>
</html>
