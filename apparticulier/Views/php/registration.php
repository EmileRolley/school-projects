<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Page d'enregistrement</title>
      <link rel="stylesheet" href="../css/style_form.css">
      <meta http-equiv="refresh" content="2; URL=accueil.php">
      <?php
         require_once('../../Controls/f_registration.php');
         require_once('../../Controls/f_print.php');
      ?>
   </head>
   <body>

      <!-- Contenu principal -->
      <?php
         // Verification de la validité des entrées
         $error = f_registration_isValid($_POST);

         // Si les données sont valides
         if ($error == 1) {
            // Et que l'enregistrement est réussi
            if (f_registration_user($_POST))
               echo "<h2>Enregistrement réussi</h2>";
            else {
               echo "<p class =\"error\">*Une erreur est survenue pendant l'enregistrement*</p>";
               // Réaffichage du formulaire
               f_print_formSignUp($_POST['auto']);
            }
         }
         // Sinon
         else {
            // Traitement des erreurs
            switch ($error) {
               case 'err_pwd'  : echo "<p class =\"error\">*Les mots de passes ne correspondent pas*</p>";break;
               case 'err_login': echo "<p class =\"error\">*Pseudo déjà utilisé*</p>";break;
               case 'err_mail' : echo "<p class =\"error\">*Adresse mail déjà utilisée*</p>";break;
            }
            // Réaffichage du formulaire
            f_print_formSignUp($_POST['auto']);
         }
       ?>

   </body>
</html>
