<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/style_nav.css" type="text/css">
  <link rel="stylesheet" href="../css/style_form.css" type="text/css">
  <link rel="stylesheet" href="../css/affiche_annonce.css" type="text/css">
  <title>Appart'iculier</title>
  <?php
     require_once('../../Controls/f_request.php');
     require_once('../../Controls/f_print.php');
     require_once('../../Controls/f_accueil.php');
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
            if(isset($_GET['id'])) {
               //affiche une annonce seule
               f_print_annonce($_GET['id']);

               // Récupère le login du propriétaire de l'annonce dont l'id est $_GET['id']
               $owner_id = f_request_getOwnerIdOf($_GET['id']);
               // Affiche le bouton pour accéder au profil du propriétaire de l'annonce $_GET|'id']
               f_print_formButton('button', 'profil.php', 'owner_id', $owner_id, 'Voir le profil du propriétaire');
            }
            else if($_POST['passer'] == 0)
               f_print_final_result(); // trie barre de recherche
            else if($_POST['passer'] == 1)
               f_print_final_result2(); //trie par options

         ?>
      </main>

   </body>
</html>
