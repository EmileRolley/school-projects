<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Création d'une nouvelle conversation</title>
      <link rel="stylesheet" href="../css/style_nav.css" type="text/css">
      <link rel="stylesheet" href="../css/style_chats.css" type="text/css">
      <?php
         require_once('../../Controls/f_request.php');
         require_once('../../Controls/f_print.php');
         require_once('../../Controls/f_accueil.php');
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
         <?php
            if (isset($_SESSION['id'])) {
               // Récupère l'id de la conversation si elle existe déjà
               $chat_id    = f_request_chatIdOf($_SESSION['id'], $_POST['owner_id']);
               $receiv_log = f_request_selectFromUsers('login', 'id', $_POST['owner_id']);

               // Si ce n'est pas le cas
               if (!$chat_id) {
                  // On en créer un nouvelle et on redirige la page vers celle ci
                  if (f_registration_chat($_SESSION['id'], $_POST['owner_id'])) {
                     $chat_id = f_request_chatIdOf($_SESSION['id'], $_POST['owner_id']);

                     header("Location: messages.php?chat_id=". $chat_id ."&receiv=". $receiv_log);
                  }
               }
               else
                  header("Location: messages.php?chat_id=". $chat_id ."&receiv=". $receiv_log);
            }
            else
               echo "<a href=\"signIn.php\">Il faut être connecté pour accéder à cette page</a>";
          ?>
       </main>

   </body>
</html>
