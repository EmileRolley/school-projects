<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title><?php echo $_GET['receiv'];?></title>
      <link rel="stylesheet" href="../css/style_nav.css">
      <link rel="stylesheet" href="../css/style_messages.css">
      <?php
         require_once('../../Controls/f_print.php');
         require_once('../../Controls/f_request.php');
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
            // Enregistre le message
            if (isset($_POST['content'])) {
               if (!f_registration_message($_POST['content'], $_POST['chat_id'], $_SESSION['id']))
                  echo "<p class=\"error\">Une erreure est survenue lors le l'envoi du message</p>";
            }

            // Supprime le message ayant pour id $_POST['id']
            if (isset($_POST['delete'])) {
               if (!f_request_deleteMessage($_POST['delete']))
                  echo "<p class=\"error\">Une erreure est survenue lors de la suppression du message</p>";
            }

            // Affiche les messages de la conversation si conn
            if (isset($_SESSION['login']) && f_request_isInChats($_SESSION['id'], $_GET['chat_id'])) {
               echo "<article>";
               echo "   <h1>". $_GET['receiv'] ."</h1>";
               // Affiche les messages
               f_print_messagesOf($_GET['chat_id'], $_SESSION['id'], $_GET['receiv']);
               // Affiche la barre d'envois pour ecrire un nouveau message
               f_print_formMessages($_SESSION['login'], $_GET['chat_id'], $_GET['receiv']);
               echo "</article>";
            }
            else
               echo "<h1><a class=\"error\" href=\"accueil.php\">Vous n'êtes pas autorisé à accéder à cette page</a></h1>";

          ?>
       </main>
   </body>
</html>
