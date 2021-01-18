<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Profil</title>
        <link rel="stylesheet" href="../css/affiche_annonce.css" type="text/css">
        <link rel="stylesheet" href="../css/style_nav.css" type="text/css">
        <link rel="stylesheet" href="../css/style_form.css" type="text/css">
      <?php
         require_once('../../Controls/f_print.php');
         require_once('../../Controls/f_request.php');

         session_start();
       ?>
   </head>
   <body>

      <?php
         // Affiche la barre de navigation
         if (isset($_SESSION['auto']) && isset($_SESSION['login']))
            f_print_menu($_SESSION['auto'], $_SESSION['login']);
         else
            f_print_menu(false, false);
      ?>

         <main>
         <?php
            if (isset($_SESSION['auto']) && isset($_POST['owner_id']) && ($_SESSION['id'] == $_POST['owner_id'] || $_SESSION['auto'] == 2)) {
              echo "<form action=\"posts_owner.php\" method=\"post\">";
              echo "<input type=\"hidden\" name=\"owner_id\" value=\"".$_POST['owner_id']."\">";
              $tabID = f_request_allanonceFromID($_POST['owner_id']);

              for($i = 0; $i < sizeof($tabID); $i = $i + 1 ) {
                f_print_annonce($tabID[$i]);
                echo "<label for=\"".$tabID[$i]."\">supprimer cette annonce : </label>";
                echo "<input type=\"checkbox\" name=\"". $tabID[$i] ."\">";
              }
              if(sizeof($tabID) == 0) {
                echo "<div class =\"div-clem\">";
                echo "Vous n'avez pas encore poster d'annonce";
                echo "</div>";
              }else{
              echo "<input id=\"delete\" type=\"submit\" value=\"Supprimer les annonces sélectionné\">";
              }
              echo "</form>";
              foreach ($_POST as $key => $value) {
                if($_POST[$key] == "on") {
                   f_delete_annonce($key);
                }
              }
            }
            else {
              $tabID = f_request_allanonceFromID($_POST['owner_id']);

              for($i = 0; $i < sizeof($tabID); $i = $i + 1 ) {
                f_print_annonce($tabID[$i]);
              }
            }
         ?>
      </main>

   </body>
</html>
