<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page de l'administrateur</title>
      <link rel="stylesheet" href="../css/style_form.css">
      <link rel="stylesheet" href="../css/style_nav.css">
      <link rel="stylesheet" href="../css/style_table.css">

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
            // Si l'utilisateur est connecté
            if (isset($_SESSION['auto'])) {
               // Si il est administrateur (auto == 2)
               if ($_SESSION['auto'] == 2) {
                  echo "<h1>Modifier ou supprimer un utilisateur</h1>";
                  f_print_listAllUsers();

                  // Si un utilisateur a été séléctionné
                  if (isset($_POST['login'])) {
                     f_print_infosUser($_POST['login']);
                     // Bouton pour modifier les données de l'utilisateur séléctionné
                     f_print_formButton('modif', 'modifUser.php', 'login', $_POST['login'], 'Modifier');
                     // Bouton pour supprimer l'utilisateur séléctionné de la table Users
                     f_print_formButton('del', 'deleteUser.php', 'login', $_POST['login'], 'Supprimer');
                  }
                  echo "<a href=\"addUser.php\">Ajouter un utilisateur >></a>";
               }
               else
                  echo "<h1 class=\"error\">Vous n'êtes pas autorisé à accéder à cette page</h1>";
            }
            else
               echo "<h1><a href=\"signIn.php\">Veuillez vous connecter pour accéder à cette page</a></h1>";
         ?>
      </main>

   </body>
</html>
