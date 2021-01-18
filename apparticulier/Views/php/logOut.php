<!DOCTYPE html>
<html lang="fr" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Déconnexion</title>
      <link rel="stylesheet" href="../css/style_form.css">
      <!-- Redirection vers la page d'accueil -->
      <meta http-equiv="Refresh" content="2; URL=accueil.php"/>
      <?php session_start(); ?>
   </head>
   <body>

      <h1>A bientôt <?php echo $_SESSION['login']; ?> !</h1>
      
      <?php
         $_SESSION = array();
         session_destroy();
      ?>
   </body>
</html>
