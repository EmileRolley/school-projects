<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Ajouter un nouvel utilisateur</title>
      <link rel="stylesheet" href="../css/style_form.css">
      <link rel="stylesheet" href="../css/style_nav.css">
      <?php
         require_once('../../Controls/f_request.php');
         require_once('../../Controls/f_print.php');
         require_once('../../Controls/f_registration.php');

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
         <h2>Ajouter un nouvel utilisateur</h2>
         <?php
            if (!isset($_POST['auto'])) {
               f_print_formButton('button', 'addUser.php', 'auto', 1, 'Ajouter un propriétaire');
               f_print_formButton('button', 'addUser.php', 'auto', 0, 'Ajouter un acheteur');
            }
            else
               f_print_formSignUp($_POST['auto']);
          ?>
       </main>

   </body>
</html>
