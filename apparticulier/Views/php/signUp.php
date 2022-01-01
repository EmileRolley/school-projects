<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page d'inscription vendeur</title>
      <link rel="stylesheet" href="../css/style_form.css">
      <link rel="stylesheet" href="../css/style_nav.css">
      <?php
         require_once("../../Controls/f_print.php");
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
            if (!isset($_POST['auto'])) {
               echo "<h1>Que souhaitez-vous faire ?</h1>";
               f_print_formButton('button', 'signUp.php', 'auto', 1, 'Je souhaite vendre');
               f_print_formButton('button', 'signUp.php', 'auto', 0, 'Je souhaite acheter');
            }
            else
               f_print_formSignUp($_POST['auto']);
          ?>
       </main>

   </body>
</html>
