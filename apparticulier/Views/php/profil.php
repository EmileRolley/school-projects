<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Profil</title>
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
            // Affiche la barre de navigation
            if (isset($_SESSION['auto']) && isset($_SESSION['login']))
               f_print_menu($_SESSION['auto'], $_SESSION['login']);
            else
               f_print_menu(false, false);;
         ?>


  <main>

    <?php
    // Si l'utilisateur arrive sur cette page depuis la page affiche_annonce.php
    if (isset($_POST['owner_id'])) {
      $owner_log = f_request_selectFromUsers('login', 'id', $_POST['owner_id']);
      // Récupère les informations de l'utilisatuer $_SESSION['login']
      $infos     = f_request_infosInUsersOf($owner_log);
      echo "<h1>". $owner_log ."</h1>";
    }
    else {
      $infos = f_request_infosInUsersOf($_SESSION['login']);
      echo "<h1>". $_SESSION['login'] ."</h1>";
    }
    ?>

    <table id="tableInfo">
      <caption>Informations personnelles</caption>

      <tr>
        <td class="etiquette">Prénom</td>
        <td class="output"><?php echo $infos['firstname']; ?></td>
      </tr>
      <tr>
        <td class="etiquette">Nom</td>
        <td class="output"><?php echo $infos['lastname']; ?></td>
      </tr>
      <tr>
        <td class="etiquette">Pseudo</td>
        <td class="output"><?php echo $infos['login']; ?></td>
      </tr>
    </table>

    <table id="tableContact">
      <caption>Contact</caption>

      <tr>
        <td class="etiquette">Mail</td>
        <td class="output"><?php echo $infos['mail']; ?></td>
      </tr>
      <tr>
        <td class="etiquette">Numéro de téléphone</td>
        <td class="output"><?php echo $infos['phone']; ?></td>
      </tr>
    </table>

    <?php
    if (isset($_POST['owner_id'])) {
      // Permet d'envoyer le login de l'utilisateur à contacter à la page de création d'un nouveau chat
      f_print_formButton('button', 'newChat.php', 'owner_id', $_POST['owner_id'], 'Envoyer un message');
      f_print_formButton('button', 'posts_owner.php', 'owner_id', $_POST['owner_id'], 'Voir annonces');
    }
    else {
      // Permet à l'utilisateur connecté d'accéder à la page pour modifier ses informations
      f_print_formButton('button', 'modifUser.php', 'login', $_SESSION['login'], 'Modifier mes informations');
      f_print_formButton('button', 'posts_owner.php', 'owner_id', $_SESSION['id'], 'Voir annonces');
      f_print_formButton('del', 'deleteUser.php', 'login', $_SESSION['login'], 'Supprimer mon compte');
    }

    ?>
  </main>

</body>
</html>
