<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Appart'iculier</title>
      <link rel="stylesheet" href="../css/style_nav.css" type="text/css">
      <link rel="stylesheet" href="../css/accueil.css" type="text/css">
      <link rel="stylesheet" href="../css/style_form.css" type="text/css">
      <?php
         require_once('../../Controls/f_accueil.php');
         require_once('../../Controls/f_print.php');

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
        <div id="titre_principale">
            <h1>Appart'iculier</h1>
          </div>

         <div id="bloc_principale">
         <form action="affiche_annonce.php" method="post">
            <input type ="search" name="test" id="barre_recherche" placeholder="Veuillez écrire votre recherche ...">
            <input type="hidden" name="passer" value="0">
            <input type="submit" value="Rechercher">

         </form>

         <?php
            if (isset($_POST['showOptions']))
               f_print_formSearchOptions();
            else
               f_print_formButton('button', 'accueil.php', 'showOptions', 1, 'Options de recherches');
         ?>
       </div>
      </main>

    </body>
</html>
