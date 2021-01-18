<?php
   require_once('f_request.php');
   require_once('f_accueil.php');

   // Affiche la barre de navigation en fonction du niveau d'autorisation de l'utilisateur $login
   function f_print_menu($auto, $login) {
      echo "<nav>";
      echo "   <ul>";
      echo "      <li><a id=\"logo\" href=\"accueil.php\">Appart'iculier</a></li>";

      // Si l'utilisateur n'est pas connecté
      if ($auto === false) {
         echo "   <li id=\"signUp\" class=\"floatR\"><a href=\"signUp.php\">Inscription</a></li>";
         echo "   <li class=\"floatR\"><a href=\"signIn.php\">Connexion</a></li>";
      }
      else {
         // Si l'utilisateur est connecté est administrateur
         if ($auto == 2)
            echo "<li><a href=\"admin.php\">Gérer les utilisateurs</a></li>";

         // Si l'utilisateur est connecté est propriétaire
         if ($auto == 1)
            echo "<li><a href=\"form_post.php\">Poster une annonce</a></li>";

         // Sous menu déroulant contenant les liens vers les pages propres à l'utilisateur
         echo "   <li class=\"dropdown\">";
         echo "      <button class=\"dropdownButton\">". $login ."</button>";
         echo "      <ul class=\"dropdownContent\">";
         echo "         <li><a href=\"profil.php\">Profil</a></li>";
         echo "         <li><a href=\"chats.php\">Messages</a></li>";
         echo "         <li><a href=\"logOut.php\">Déconnexion</a></li>";
         echo "      </ul>";
         echo "   </li>";
      }

      echo "   </ul>";
      echo "</nav>";
   }

  // FORMULAIRES

   function f_print_FormPostannonce($res){ //affiche le formulaire pour poster une annonce à l'utilisateur
     if(!isset($_GET['visit'])){ //permet de savoir si l'utilisateur souhaite modifier le formulaire ou le remplir
       echo "<form action=\"valide.php\" method=\"post\">";
       echo "<label for=\"titre\">Titre de votre annonce : </label>";
       echo "<input type=\"text\" placeholder=\"Veuillez écrire le titre de votre annonce\" name=\"titre\" ><br><br>";
       echo "<label for=\"prix\">Prix de votre bien immobilier en euro: </label>";
       echo "<input type=\"number\" name =\"prix\" placeholder=\"100000\" ><br><br>";
       echo "<label for=\"sup\">Superficie du bien immobilier en m²: </label>";
       echo "<input type=\"number\" name =\"sup\" placeholder=\"75\"><br><br>";
       echo "<label for=\"image\">Lien vers une photo avantageuse de votre bien immobilier : </label>";
       echo "<input type=\"url\" name =\"image\"><br><br>";
       echo "<label for=\"description\">Description de votre bien immobilier : </label>";
       echo "<textarea name =\"description\" placeholder=\"Veuillez écrire votre description\"></textarea><br><br>";
       echo "<label for=\"Ville\">Ville de votre bien immobilier : </label>";
       echo "<input type=\"text\" name =\"Ville\" placeholder=\"Veuillez indiquez la ville de votre bien immobilier\"><br><br>";
       echo "<label for=\"adresse\">adresse de votre bien immobilier : </label>";
       echo "<input type=\"text\" name =\"adresse\" placeholder=\"Veuillez écrire l'adresse de votre bien immobilier\"><br><br>";
       echo "<label for=\"nb_rooms\">nombre de pièce de votre bien immobilier : </label>";
       echo "<input type=\"number\" name =\"nb_rooms\" placeholder=\"Veuillez écrire le nombre de pièce de votre bien immobilier\"><br><br>";
       echo "<label for=\"type\">Votre bien est-il un appartement(écrivez 1) ou une maison(écrivez 2) ? </label>";
       echo "<input type=\"number\" name =\"type\" placeholder=\"taper 1 ou 2 ? \"><br><br>";
       echo "<input type=\"submit\" value=\"Poster mon annonce !\">";
       echo "</form>";
     }else{ //on préremplit le formulaire avec ce qu'avait marqué l'utilisateur pour lui faire gagner du temps si il décide de revenir en arrière
       echo "<form action=\"valide.php\" method=\"post\">";
       echo "<label for=\"titre\">Titre de votre annonce : </label>";
       echo "<input type=\"text\" value=\"".$_GET['titre']."\" name=\"titre\"><br><br>";
       echo "<label for=\"prix\">Prix de votre bien immobilier en euro: </label>";
       echo "<input type=\"number\" name =\"prix\" value=\"".$_GET['prix']."\"><br><br>";
       echo "<label for=\"sup\">Superficie du bien immobilier en m²: </label>";
       echo "<input type=\"number\" name =\"sup\" value=\"".$_GET['sup']."\"><br><br>";
       echo "<label for=\"image\">Lien vers une photo avantageuse de votre bien immobilier : </label>";
       echo "<input type=\"url\" name =\"image\" value=\"".$_GET['image']."\"><br><br>";
       echo "<label for=\"description\">Description de votre bien immobilier : </label>";
       echo "<textarea name =\"description\">".$_GET['description']."</textarea><br><br>";
       echo "<label for=\"Ville\">Ville de votre bien immobilier : </label>";
       echo "<input type=\"text\" name =\"Ville\" value=\"".$_GET['Ville']."\"><br><br>";
       echo "<label for=\"adresse\">adresse de votre bien immobilier : </label>";
       echo "<input type=\"text\" name =\"adresse\" value=\"".$_GET['adresse']."\"><br><br>";
       echo "<label for=\"nb_rooms\">nombre de pièces de votre bien immobilier : </label>";
       echo "<input type=\"number\" name =\"nb_rooms\" value=\"".$_GET['nb_rooms']."\"><br><br>";
       echo "<label for=\"type\">Votre bien est-il un appartement(écrivez 1) ou une maison(écrivez 2) ? </label>";
       if($_GET['type']==1){
         echo "<input type=\"number\" name=\"type\" value=\"1\"><br><br>";
       }else{
         echo "<input type=\"number\" name=\"type\" value=\"2\"><br><br>";
       }
       echo "<input type=\"submit\" value=\"Poster votre annonce !\">";
       echo "</form>";
     }
   }

   function f_print_validerForm($res){ //affiche les informations de l'annonce a poster et demande à l'utilisateur si il souhaite la poster telle quelle
     //$res contient les informations transmit par POST par le formulaire
     echo "<div class=\"div-clem\"><br>";
     echo "<h2> Etes vous bien certain de vouloir poster cette annonce ?</h2>";
     echo "<h4>Récapitulatif de votre annonce :</h4><br>";
     echo "Titre de votre annonce : ".$res[0]."<br>";
     echo "Prix de votre bien immmobilier en euro: ".$res[1]."<br>";
     echo "Superficie de votre bien immobilier en m² : ".$res[2]."<br>";
     echo "nom de votre image :" ;
     echo "<img src=\"".$res[3]."\" alt=\"le lien ne marche pas, votre image ne s'affichera pas, veuillez le changer\" /><br>";
     echo "Description de votre bien immobilier : ".$res[4]."<br>";
     echo "Ville de votre bien immobilier : ".$res[5]."<br>";
     echo "Adresse de votre bien immobilier : ".$res[6]."<br>";
     echo "Nombre de pièce de votre bien immobilier : ".$res[7]."<br>";
     if($res[8]==1){
       echo "Votre bien immobilier est un appartement<br><br>";
     }else{
       echo "Votre bien immobilier est une maison<br><br>";
     }
     echo "<a href=\"http://localhost/IO2-Projet/Views/php/form_post.php?visit=1&titre=".$res[0]."&prix=".$res[1]."&sup=".$res[2]."&image=".$res[3]."&description=".$res[4]."&Ville=".$res[5]."&adresse=".$res[6]."&nb_rooms=".$res[7]."&type=".$res[8]."\"</a>Non, je veux modifier mon annonce";
     //lien contenant toute les informations du fomulaire et les transmet par GET
     echo "<form action=\"verif.php\" method=\"post\">";
     echo "<input type=\"hidden\" value=\"".$res[0]."\" name=\"titre\">";
     echo "<input type=\"hidden\" value=\"".$res[1]."\" name=\"prix\">";
     echo "<input type=\"hidden\" value=\"".$res[2]."\" name=\"sup\">";
     echo "<input type=\"hidden\" value=\"".$res[3]."\" name=\"image\">";
     echo "<input type=\"hidden\" value=\"".$res[4]."\" name=\"descr\">";
     echo "<input type=\"hidden\" value=\"".$res[5]."\" name=\"Ville\">";
     echo "<input type=\"hidden\" value=\"".$res[6]."\" name=\"adresse\">";
     echo "<input type=\"hidden\" value=\"".$res[7]."\" name=\"nb_rooms\">";
     echo "<input type=\"hidden\" value=\"".$res[8]."\" name=\"type\">";
     echo "<input type=\"submit\" value=\"Poster mon annonce !\">"; //valide le formulaire
     echo "</form>";
     echo "</div>";
   }


   // Fonction qui affiche le formulaire d'inscription
   // $auto est l'entier définissant si l'utilisateur est un vendeur ou un acheteur
   function f_print_formSignUp($auto) {
      echo "<form action=\"registration.php\" method=\"post\">";
      echo "   <label for=\"login\">Pseudo </label>";
      echo "   <input type=\"text\" name=\"login\" placeholder=\"Ex : dupont34\" required>";
      echo "   <label for=\"fname\">Prénom </label>";
      echo "   <input type=\"text\" name=\"fname\" placeholder=\"Ex : Dupont\" required>";
      echo "   <label for=\"lname\">Nom </label>";
      echo "   <input type=\"text\" name=\"lname\" placeholder=\"Ex : Dupont\" required>";
      echo "   <label for=\"mail\">Adresse mail </label>";
      echo "   <input type=\"email\" name=\"mail\" placeholder=\"Ex : dupont@gmail.com\" required>";
      echo "   <label for=\"phone\">Numéro de téléphone </label>";
      echo "   <input type=\"tel\" name=\"phone\" placeholder=\"Ex : 0600980908\" required>";
      echo "   <label for=\"mdp1\">Mot de passe </label>";
      echo "   <input type=\"password\" name=\"pwd1\" placeholder=\"Mot de passe\" required>";
      echo "   <label for=\"mdp2\">Confirmer le mot de passe </label>";
      echo "   <input type=\"password\" name=\"pwd2\" placeholder=\"Mot de passe\" required>";
      echo "   <input type=\"hidden\" name=\"auto\" value=\"".$auto."\">";
      echo "   <input type=\"submit\" value=\"Enregistrer\">";
      echo "</form>";
   }

   // Affiche le formulaire de connexion
   function f_print_formSignIn() {
      echo "<form action=\"signIn.php\" method=\"post\">";
      echo "   <label for=\"login\">Pseudo </label>";
      echo "   <input type=\"text\" name=\"login\" placeholder=\"Ex : dupont34\" required>";
      echo "   <label for=\"mdp1\">Mot de passe </label>";
      echo "   <input type=\"password\" name=\"pwd\" placeholder=\"Mot de passe\" required>";
      echo "   <input type=\"submit\" value=\"Se connecter\">";
      echo "</form>";
   }

   // Affiche un formulaire faisant office de bouton et permetant de faire passer l'attribut $nameHidden
   // par la method post à la page $action
   function f_print_formButton($id, $action, $nameHidden, $valHidden, $valSubmit) {
      echo "<form action=\"".$action."\" method=\"post\">";
      echo "   <input type=\"hidden\" name=\"".$nameHidden."\" value=".$valHidden.">";
      echo "   <input class=\"".$id."\" type=\"submit\" name=\"send\" value=\"".$valSubmit."\">";
      echo "</form>";
   }

   function f_print_formSearchOptions(){ //affiche les possibilités de filtre par options
    echo "<form action=\"affiche_annonce.php\" method=\"post\">";//formulaire
    echo "  <label for=\"prix\">prix : 0 </label>";
    echo "  <input type=\"range\" min=\"0\" max=\"750000\" name=\"prix\" id=\"range-prix\" value=\"0\"> 750.000<br>"; //options 1 : prix
    echo "  <label for=\"sup\">Superficie : 25 m²</label>";
    echo "  <input type=\"range\" name=\"superficie\" min=\"0\" max=\"130\" value=\"0\" id=\"range-sperficie\"> 130 m²<br>";//option 2 : Superficie

    f_print_listeVille(); // option 3 : Ville

    echo "  <input type=\"hidden\" name=\"passer\" value=\"1\">";
    echo "  <input type=\"submit\" value=\"lancer la recherche\" id=\"pour-tri\">";
    echo "</form>";
   }

   // Affiche le formulaire pour modifier les informations d'un utilisateur
   function f_print_formModifUser($datas) {
      echo "<form action=\"registration_modifUser.php\" method=\"post\">";
      echo "   <label for=\"login\">Votre pseudo </label>";
      echo "   <input type=\"text\" name=\"login\" value=\"". $datas['login'] ."\" required>\n";
      echo "   <label for=\"fname\">Votre prénom </label>";
      echo "   <input type=\"text\" name=\"fname\" value=\"". $datas['firstname'] ."\" required>\n";
      echo "   <label for=\"lname\">Votre nom </label>";
      echo "   <input type=\"text\" name=\"lname\" value=\"". $datas['lastname'] ."\" required>\n";
      echo "   <label for=\"mail\">Votre adresse mail </label>";
      echo "   <input type=\"email\" name=\"mail\" value=\"". $datas['mail'] ."\" required>\n";
      echo "   <label for=\"phone\">Votre numéro de téléphone </label>";
      echo "   <input type=\"tel\" name=\"phone\" value=\"". $datas['phone'] ."\" required>\n";
      echo "   <input type=\"hidden\" name=\"pwd1\" value=\"". $datas['pwd'] ."\">\n";
      echo "   <input type=\"hidden\" name=\"auto\" value=\"". $datas['auto'] ."\">\n";
      echo "   <input type=\"hidden\" name=\"id\" value=\"". f_request_selectFromUsers('id', 'login', $datas['login']) ."\">\n";
      echo "   <input type=\"submit\" name=\"modif\" value=\"Modifier\">";
      echo "</form>";
   }

   function f_print_formMessages($login, $chat_id, $receiv_log) {
      echo "<form action=\"messages.php?chat_id=". $chat_id ."&receiv=". $receiv_log ."\" method=\"post\">";
      echo "   <input class=\"textInput\" type=\"text\" name=\"content\" placeholder=\"Ecrivez un message...\">";
      echo "   <input type=\"hidden\" name=\"chat_id\" value=\"". $chat_id ."\">";
      echo "   <input id=\"submit\" type=\"submit\" name=\"send\" value=\"Envoyer\">";
      echo "</form>";
   }

   // LISTES

   function f_print_listeVille(){ //affiche une liste déroulante avec toutes les villes où se trouve des annonces
      $res = f_request_listeVilleBD(); //$res contient les villes qui se trouvent dans la base de donnée sans doublon

      echo "<select name=\"ville\">";//on les affiches dans une liste déroulante
      echo "  <option selected=\"selected\">Choissez une Ville</option>";

      for ($i = 0; $i < sizeof($res); $i++) {
         echo "<option>";
         echo $res[$i];
         echo "</option>";
      }
      echo "</select>";
   }

   // Affiche une lise déroulante avec le login de tous les utilisateurs de la table Users
   function f_print_listAllUsers() {
      $logins = f_request_allLogins();

      echo "<form action=\"admin.php\" method=\"post\">";
      echo "   <div id=\"list\">";
      echo "      <label name=\"login\">Choisissez un utilisateur</label>";
      echo "      <select name=\"login\">";

      if ($logins) {
         foreach ($logins as $l)
            echo "   <option value=\"".$l."\">". $l ."</option>\n";
      }

      echo "      </select>";
      echo "   </div>";
      echo "   <input type=\"submit\" name=\"infos\" value=\"Visualiser cet utilisateur\">";
      echo "</form>";
   }

   // MESSAGES

   // Affiches l'ensemble des messages de la conversation $chat_id
   function f_print_messagesOf($chat_id, $user_id, $receiv_log) {
      $messages = f_request_getMessagesOf($chat_id);

      if ($messages) {
         foreach ($messages as $msg) {
            if ($msg['user_id'] == $user_id)
               $class = "msgUser";
            else
               $class = "msgReceiv";

            echo "<div class=\"". $class ."\">";
            echo "   <p class=\"content\">". $msg['content'] ."</p>";
            echo "   <p class=\"date\">". $msg['date'] ."</p>";
            // Affiche le bouton permetant de supprimer le message ayant pour id $msg['id']
            echo "   <form class=\"button\" action=\"messages.php?chat_id=". $chat_id ."&receiv=". $receiv_log ."\" method=\"post\">";
            echo "      <input type=\"hidden\" name=\"delete\" value=\"". $msg['id'] ."\">";
            echo "      <input type=\"hidden\" name=\"chat_id\" value=\"". $chat_id ."\">";
            echo "      <input id=\"delete\" type=\"submit\" name=\"send\" value=\"&#10060; \">";
            echo "   </form>";
            echo "</div>";
         }
      }
   }

   // Affiche la liste des conversations de l'utilisateur $login
   function f_print_chatsOf($login) {
      // Récupération sous forme de tableau de tableau les informations des conversations :
      //    l'id de la conversation = $chat['id']
      //    le login du destinataire = $chat['receiv']
      $chats = f_request_allChatsOf($login);

      if ($chats) {
         foreach ($chats as $chat)
            echo "<div><a class=\"chat\" href=\"messages.php?chat_id=".$chat['id'] ."&receiv=". $chat['receiv'] ."\">". $chat['receiv'] ."</a></div>";
      }
   }

   // INFOS

   function f_print_infosUser($login) {
      $infos = f_request_infosInUsersOf($login);

      echo "<table>";
      echo "   <tr><td>Nom : </td><td>". $infos['lastname'] ."</td></tr>";
      echo "   <tr><td>Prenom : </td><td>". $infos['firstname'] ."</td></tr>";
      echo "   <tr><td>Pseudo : </td><td>". $infos['login'] ."</td></tr>";
      echo "   <tr><td>Adresse mail : </td><td>". $infos['mail'] ."</td></tr>";
      echo "   <tr><td>Numéro de téléphone : </td><td>". $infos['phone'] ."</td></tr>";
      echo "</table>";
   }

   function f_print_final_result2(){
     $ville     = $_POST['ville']; //la chaine de characère rentrée par l'utilisateur dans la barre de recherche via un formulaire
     $tab       = array();
     $tab       = recupInfo_From_POST(); //récupère les autres informations contenue dans $_POST après vérification
     $posts_id  = f_request_attrFromDB($tab[0], $tab[1]); //effectue un tri par le prix
     $res       = array();
     $fin       = array();

     for ($i = 0; $i < sizeof($posts_id); $i++) {
       if (f_request_testville($posts_id[$i], $ville)) { // test si la ville de l'annonce correspondant à un des id stockés dans $inter correspondant à la ville cherché par l'utilisateur
         $fin[] = $posts_id[$i]; // si oui on l'ajoute dans $fin
       }
     }

     print_r($fin);
     if (sizeof($fin) == 0) {
        echo "<div class=\"div-clem\"><br><br>";
        echo "Nous ne possédons pas d'annonce correspondant à votre recherche"; //si aucune annonce ne correspondait à ce que cherchait l'utilisateur, c'est à dire $fin est vide
     }
     for ($i = 0; $i < sizeof($fin); $i++) { //on print un message pour en avertir l'utilisateur
       f_print_annonce($fin[$i]); //on boucle sur chacun des id contenu dans $fin pour les afficher grâce à une fonction d'affichage
     }
   }

   function f_print_final_result(){
      $etape = result_barre_recherche($_POST['test']); //$etape est remplis des id d'annonces dont la description contient la recherche de l'utilisateur
      $res = array();
      for($i = 0; $i<sizeof($etape); $i = $i +1){
         $res[] = f_request_caseclick($etape[$i]); //$res contient le titre et l'image des annonces
      }

      //tout ce qui est en dessous permet l'affichage des annonces
      echo "<div class=\"div-clem\">";
      if(sizeof($res) == 0){ //message pour prévenir l'utilisateur si nous n'avons aucune annonce correspondant à sa recherche
        echo "Nous n'avons pas d'annonce correspondant a votre recherche";
      }
      for($i = 0; $i<sizeof($res); $i = $i + 1){
        echo "<div class=\"div_post\">";
        echo "  <img src=\"".$res[$i][1][0]."\" alt=\"Photo du bien\" width=150 height=150 >";
        echo "  <div class=\"div_infos\">";
        echo "    <strong class=\"titre\">".$res[$i][0][0]."</strong><br>";
        echo "    <a href=\"affiche_annonce.php?id=$etape[$i]\">Voir le détail de l'offre</a>";
        echo "  </div>";
        echo "</div>";
      }
      echo "</div>";
    }


   function f_print_annonce($id){ //affiche une annonce
     $res = f_request_allinfo($id); //$res contient toutes les informations concernant l'annonce qui a pour id $id
     $exp = array("Titre :", "Image  du site :","Description :", "Nombre de pièces :", "Nombre de m² carré :", "Type d'habitation :", "Prix : ", "Adresse :", "Ville :");

     echo "<div class=\"div-clem\">"; //affichage de l'annonce, traitement different si l'attribut est une image ou le type d'habitation
     for($i = 0; $i<sizeof($res); $i = $i + 1){
       if($i!=1 && $i != 5){
         echo $exp[$i];
         echo "<div class=\"mini_div\">";
         echo $res[$i];
         echo "</div>";
       }if($i == 5){
          if($res[$i]==1){
            echo $exp[$i];
            echo "<div class=\"mini_div\">";
            echo "Appartement";
            echo "</div>";
          }else{
            echo $exp[$i];
            echo "<div class=\"mini_div\">";
            echo "Maison";
            echo "</div>";
          }
       }if($i==1){
         echo $exp[$i];
         echo "<div class=\"mini_div\">";
         echo "<img src=\"".$res[$i]."\" alt=\"Photo du bien\" width=\"150\" height=\"150\" />";
         echo "</div>";
       }
     }
     echo "</div>";
   }



 ?>
