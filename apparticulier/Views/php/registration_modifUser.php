
<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page d'enregistrement</title>
      <link rel="stylesheet" href="../css/style_form.css">
      <link rel="stylesheet" href="../css/style_nav.css">
      <?php
         require_once('../../Controls/f_registration.php');
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
            // Verification de la validité des entrées
            $error = f_registration_isValidForModif($_POST);

            // Si les données sont valides
            if ($error == 1) {
               // Et que l'enregistrement est réussi
               if (f_registration_modifUser($_POST))
                  echo "<h2>Modification réussi</h2>";
               else {
                  echo "<p class =\"error\">*Une erreur est survenue pendant l'enregistrement*</p>";
                  // Réaffichage du formulaire
                  f_print_formModifUser(f_request_infosInUsersOf($_POST['login']));
               }
            }
            // Sinon
            else {
               // Traitement des erreurs
               switch ($error) {
                  case 'err_login': echo "<p class =\"error\">*Pseudo déjà utilisé*</p>";break;
                  case 'err_mail' : echo "<p class =\"error\">*Adresse mail déjà utilisée*</p>";break;
               }
               // Réaffichage du formulaire
               f_print_formModifUser(f_request_infosInUsersOf($_POST['login']));
            }
         ?>
       </main>
   </body>
</html>
