<?php
   require_once('../../Controls/f_print.php');
   require_once('../../Controls/f_accueil.php');

   session_start();
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../css/style_nav.css" type="text/css">
      <link rel="stylesheet" href="../css/style_form.css" type="text/css">
      <link rel="stylesheet" href="../css/affiche_annonce.css" type="text/css">
      <title>Appart'iculier</title>
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
            $infopost = recupInfo_From_POSTBIS();
            f_print_FormPostannonce($infopost);
         ?>

      </main>
   </body>
</html>
