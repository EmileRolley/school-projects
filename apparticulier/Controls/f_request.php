<?php
   require_once('f_print.php');

   // Retourne le lien de connexion avec la base de donnée $db
   function f_request_connection() {
      // Variables à modifier suivant l'utilisateur
      $login = 'cblera92';
      $pwd   = 'k0M(lJ2T';
      $serv  = 'pams.script.univ-paris-diderot.fr';
      $db    = 'test';

      return (mysqli_connect($serv, $login, $pwd, $db));
   }


   // FONCTIONS TABLE USERS

   // Retourne le resultat de la requête $req
   function f_request($req) {
      $link = f_request_connection();
      mysqli_set_charset($link, "utf8");
      $res  = mysqli_query($link, $req);

      mysqli_close($link);
      return ($res);
   }

   // Retourne true si la valeure $val de l'attribut $attr est présent dans la table Users
   function f_request_isInUsers($attr, $val) {
      $res = f_request("SELECT login FROM Users WHERE ". $attr ."='". $val ."';");
      $tab = mysqli_fetch_assoc($res);

      return (isset($tab['login']));
   }

   // Renvoie la valeure de l'attribut $attrRes de l'utilisateur dont la valeure de son attribut $attr
   // est égal à $val
   function f_request_selectFromUsers($attrRes, $attr, $val) {
      $res = f_request("SELECT ". $attrRes ." FROM Users WHERE ". $attr ."='". $val ."';");
      $tab = mysqli_fetch_assoc($res);

      return ($tab[$attrRes]);
   }

   // Vérifie que le login est dans la table Users et que le mot de passe correspond
   // Sinon, renvoie l'erreur correspondante
   function f_request_signIn($login, $pwd) {
      $link  = f_request_connection();
      $login = mysqli_real_escape_string($link, $login);
      $pwd   = mysqli_real_escape_string($link, $pwd);
      mysqli_close($link);

      if (!f_request_isInUsers('login', $login))
         return ("err_login");

      $pwdHash = f_request_selectFromUsers('pwd', 'login', $login);

      if (!$pwd === $pwdHash)
         return ("err_pwd");
      return ('false');
   }

   // Renvois tous les logins des utilisateurs de la table Users
   function f_request_allLogins() {
      $res = f_request("SELECT login FROM Users;");

      if ($res) {
         while ($row = mysqli_fetch_row($res))
            $logins[] = $row[0];
         return ($logins);
      }

      return (false);
   }

   // Renvois les informations de l'utilisateur $login
   function f_request_infosInUsersOf($login) {
      $res = f_request("SELECT * FROM Users WHERE login='". $login ."';");
      return (mysqli_fetch_assoc($res));
   }

   // Supprime l'utilisateur $login de la bd après avoir supprimé ses annonces et conversations (si il en a)
   function f_request_deleteFromUsers($login) {
      f_request_deletePostsOf($login);
      f_request_deleteChatsOf($login);

      echo "DELETE FROM Users WHERE login='".$login ."';";
      return (f_request("DELETE FROM Users WHERE login='".$login ."';"));
   }

   // Sécurise les données pour les requêtes
   function f_request_secureForRegistration($datas) {
      $link  = f_request_connection();

      foreach ($datas as $key => $value)
         $secure[$key] = mysqli_real_escape_string($link, $value);
      // hachage du mot de passe
      $secure['pwd'] = md5($secure['pwd1']);

      mysqli_close($link);
      return ($secure);
   }

   // function f_request_getInfosOf($login) {
   //    return (mysqli_fetch_assoc(f_request("SELECT login,firstname,lastname,mail,phone FROM Users WHERE login='". $login ."';")));
   // }

   // FONCTIONS TABLE Chats

   // Supprime toutes les conversations de l'utilisateur $login
   function f_request_deleteChatsOf($login) {
      $chats   = f_request_allChatsOf($login);

      if ($chats) {
         foreach ($chats as $chat) {
            f_request_deleteMessagesOf($chat['id']);
            f_request_deleteChat($chat['id']);
         }
      }
   }

   // Supprime la conversation $id
   function f_request_deleteChat($id) {
      return (f_request("DELETE FROM Chats WHERE id=". $id .";"));
   }

   // Vérifie que l'utilisateur $user_id fait bien partie de la conversation $chat_id
   function f_request_isInChats($user_id, $chat_id) {
      return (f_request("SELECT id FROM Chats WHERE user1_id=". $user_id ." OR user2_id=". $user_id .";"));
   }

   // Récupère l'id de la conversation entre $user_id et $onwner_id
   function f_request_chatIdOf($user_id, $owner_id) {
      $res = f_request("SELECT id FROM Chats WHERE (user1_id=". $user_id ." AND user2_id=". $owner_id .") OR (user1_id=". $owner_id ." AND user2_id=". $user_id .");");
      $res = mysqli_fetch_assoc($res);

      return ($res['id']);
   }

   // Récupère dans $res[][] toutes les combinaisons id/receiv_log, soit toutes les conversations
   // dans les quelles se trouvent l'utilisateur $login
   function f_request_allChatsOf($login) {
      $userId = f_request_selectFromUsers('id', 'login', $login);
      $chats  = f_request("SELECT id, user1_id, user2_id FROM Chats WHERE user1_id=". $userId ." OR user2_id=". $userId .";");

      if ($chats) {
         $i = 0;

         while ($row = mysqli_fetch_assoc($chats)) {
            $res[$i]['id'] = $row['id'];

            if ($row['user1_id'] != $userId)
               $res[$i]['receiv'] = f_request_selectFromUsers('login', 'id', $row['user1_id']);
            else
               $res[$i]['receiv'] = f_request_selectFromUsers('login', 'id', $row['user2_id']);
            $i++;
         }
         return ($res);
      }

      return (false);
   }

   // Renvoie sous forme de double tableau les informations des messages de la conversation $chat_id
   function f_request_getMessagesOf($chat_id) {
      $messages = f_request("SELECT id,user_id, content, DATE_FORMAT(datime, '%d/%m/%Y %H:%i') AS day FROM Messages WHERE chat_id=". $chat_id .";");

      $res = array();

      if ($messages) {
         $i = 0;

         while ($row = mysqli_fetch_assoc($messages)) {
            $res[$i]['id']      = $row['id'];
            $res[$i]['user_id'] = $row['user_id'];
            $res[$i]['content'] = $row['content'];
            $res[$i]['date']    = $row['day'];
            $i++;
         }
         return ($res);
      }

      return (false);
   }

   // Supprime le message dont l'id vaut $id
   function f_request_deleteMessage($id) {
      return (f_request("DELETE FROM Messages WHERE id=". $id .";"));
   }

   // Supprime tous les messages de la conversation $chat_id
   function f_request_deleteMessagesOf($chat_id) {
      return (f_request("DELETE FROM Messages WHERE chat_id=". $chat_id .";"));
   }

   // FONCTIONS TABLE POSTS

   // Supprime les annonces de l'utilisateur $login
   function f_request_deletePostsOf($login) {
      $owner_id = f_request_selectFromUsers('id', 'login', $login);

      return (f_request("DELETE FROM Posts WHERE owner_id=". $owner_id .";"));
   }

   // Renvoie l'id du propriétaire de l'annonce $post_id
   function f_request_getOwnerIdOf($post_id) {
      $res      = f_request("SELECT owner_id FROM Posts WHERE id =". $post_id .";");
      $owner_id = mysqli_fetch_row($res);

      mysqli_free_result($res);
      return ($owner_id[0]);
   }

   function f_request_allinfo($id){//renvoie une annonce complète
      $test = recupID();

      if ($test == -1)
         $test = $id;

      $res = f_request("SELECT title,img,descr,nb_rooms,area,type,price,adr,city From Posts WHERE id = '".$test."';");

      if(!$res)
         return false;
      return mysqli_fetch_row($res);
   }

   // Insert une nouvelle annonce dans la table Posts
   function f_insert_annonce(){
     $link = f_request_connection();

     foreach ($_POST as $key => $value)
        $_POST[$key] = mysqli_real_escape_string($link,$_POST[$key]);

     $res = f_request("INSERT INTO Posts (owner_id,title,price,area,img,descr,city,adr,nb_rooms,type) VALUES(".$_SESSION['id'].",'".$_POST['titre']."',".$_POST['prix'].",".$_POST['sup'].",'".$_POST['image']."','".$_POST['descr']."','".$_POST['Ville']."','".$_POST['adresse']."',".$_POST['nb_rooms'].",".$_POST['type'].");");

     if ($res) {
       echo "<div class=\"div-clem\">";
       echo "Votre annonce a bien été posté !";
       echo "</div>";
     }
     else {
       echo "<div class=\"div-clem\">";
       echo "Aïe, votre annonce n'as pas pu être poster, réessayez plus tard.";
       echo "</div>";
     }
   }

   // Supprime l'annonce $id de la table Posts
   function f_delete_annonce($id) {
     $res = f_request("DELETE FROM Posts WHERE id = ".$id." ;");

     if ($res) {
       echo "<div>";
       echo "Votre annonce a bien été supprimé ! Veuillez recharger la page";
       echo "</div>";
     }
      else {
       echo "<div>";
       echo "Aïe, votre annonce n'as pas pu être supprimé, réessayez plus tard.";
       echo "</div>";
     }
   }

   function f_request_allanonceFromID($id) {
      $res = f_request("SELECT id From Posts WHERE owner_id = '".$id."';");

      if(!$res)
         return false;

      $fin = array();
      $i = 0;

      while($ligne = mysqli_fetch_row($res)){ //a chaque tour de boucle on recupère 1 attributs donc nos ligne ont donc 1 cases (title,img...)
         $fin[$i] = $ligne[0]; //on se sait a piori pas le nombre de colonne sauf si l'on a acces a la bases de donnés
         $i = $i + 1;
      }

      return $fin; //on un tableau d'ID
   }

   //fonction intermédiaire pour barre_recherche dans triVille.php
   function f_request_allID() {
      $res = f_request("SELECT descr,id FROM Posts;"); //me donne toutes les descriptions et tout les id des annonces
      if (!$res) {
         return false;
      }
      else{
         $fin = array();
         $i = 0;
         while ($ligne = mysqli_fetch_row($res)){
            $fin[0][$i] = $ligne[0];
            $fin[1][$i] = $ligne[1];
            $i = $i + 1;
         }
         return $fin; //renvoie un tableau a deux dimensions : chaque ligne est une annonce different et une colonne est les ID et l'autre les descriptions
      }
   }

   //dérivé de celle d'avant
   function f_request_caseclick($id){ //renvoie le titre est l'image d'une annonce grâce a un id
      $res = f_request("SELECT title,img FROM Posts WHERE id = '".$id."';");

      if(!$res){
         return false;
      }else{
         $fin = array();
         $i = 0;
         while ($ligne = mysqli_fetch_row($res)){
            $fin[0][$i] = $ligne[0];
            $fin[1][$i] = $ligne[1];
            $i = $i + 1;
         }
      }
      return $fin; //renvoie un tableau a deux dimensions : chaque ligne est une annonce et chaque colonne est un titre et l'autre un chemin jusqu'a une image
   }
   //fonction pour trouver les ID des annonces ou la recherche est dans la descriptions longue de celle-ci

 function result_barre_recherche($recherche){ //$recherche correspond a la recherche entré par l'utilisateur dans la barre de recherche
   $tabannonces = f_request_allID();
   $realtab = $tabannonces[0];//recupère les descriptions des annonces
   $res = array();

   for($i = 0; $i<sizeof($realtab); $i = $i + 1){
     $tmp = strstr($realtab[$i],$recherche); //si strstr renvoie une chaine vide alors il n'as pas trouver la recherche dans une description sinon il est non vide
     if($tmp!="")  array_push($res, $tabannonces[1][$i]);//si tmp est non vide alors on ajoute l'id correspond a la description qui match avec recherche
   }
   return $res;
 }

 function f_request_testville($id, $ville) {//id est l'id d'une annonce et $ville est le nom de la ville rentrée par l'utilisateur lors de sa recherche par options
   $res = f_request("SELECT city FROM Posts WHERE id=".$id.";");

   if ($res) {
     while ($ligne = mysqli_fetch_row($res))
        $city = $ligne[0]; //$city contient la ville de l'annonce recherché
   }
   else
     return (false);
   if($city == $ville){ //si $city est le même que $ville on return true, cette fonction teste si une annonce est dans la ville recherché par l'utilisateur
     return true;
   }
   return false;
 }

 function f_request_listeVilleBD(){//cette fonction renvoie toutes les Villes ou sont disponibles des annonces
   $etape = f_request("SELECT city FROM Posts;");

   if ($etape) {
      while ($ligne = mysqli_fetch_row($etape))
         $city[] = $ligne[0]; //$city contient autant de ville que d'annonce est donc beaucoup de double
      }else{
         return (false);
      }
      $test = 0;
      $res[] = $city[0];
      for($i = 1 ; $i<sizeof($city); $i = $i + 1){
         for($j = 0; $j<sizeof($res); $j = $j + 1){
            if($city[$i]==$res[$j]){
               $test = $test + 1; //test permet de savoir le nombre de fois que l'on a rencontré une ville
            }
         }if($test==0){
            $res[] = $city[$i]; //on ajoute dans le tableau final une ville que si on ne l'as jamais vu dans le tableau final avant
         }
         $test = 0;
      }
      return $res; //on retourne un tableau sans doublon de toute les villes
   }

   function f_request_attrFromDB($prix, $sup) { //$prix est le prix, sup le nombre de m² et attr lequel on choisit pour filtrer
      $mPrix = $prix - 100000;
      $MPrix = $prix + 100000;
      $mSup = $sup - 20;
      $MSup = $sup + 20;
      $posts_id = array();

      $req = "SELECT id FROM Posts WHERE (price BETWEEN '". $mPrix ."' AND  '". $MPrix ."')";
      $req .= " AND (area BETWEEN '". $mSup ."' AND '". $MSup ."');";

      $res = f_request($req);

      if ($res) {
         while ($row = mysqli_fetch_assoc($res))
            $posts_id[] = $row['id'];
         return ($posts_id);
      }
      return (false);
   }
 ?>
