<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page des conversations</title>
      <link rel="stylesheet" href="../css/style_nav.css">
      <link rel="stylesheet" href="../css/style_chats.css">
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
            if (isset($_SESSION['login'])) {
               echo "<article>";
               echo "   <h1>Vos conversations</h1>";
               f_print_chatsOf($_SESSION['login']);
               echo "</article>";
            }
            else
               echo "<h1><a href=\"signIn.php\">Veuillez vous connecter pour accéder à cette page</a></h1>";
          ?>
      </main>

   </body>
</html>
