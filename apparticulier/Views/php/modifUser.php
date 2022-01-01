<html lang="fr" dir="ltr">
<!DOCTYPE html>
   <head>
      <?php
         require_once('../../Controls/f_print.php');
         require_once('../../Controls/f_registration.php');
         require_once('../../Controls/f_request.php');

         session_start();
       ?>
      <link rel="stylesheet" href="../css/style_form.css">
      <link rel="stylesheet" href="../css/style_nav.css">
      <meta charset="utf-8">
      <title>Page de modification de l'utilisateur</title>
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
               if (isset($_POST['login']))
                  f_print_formModifUser(f_request_infosInUsersOf($_POST['login']));
            ?>
         </main>

   </body>
</html>
