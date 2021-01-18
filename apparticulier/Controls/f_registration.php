<?php
   require_once('f_request.php');

   // Vérifie si les données d'inscritpion sont valides
   function f_registration_isValid($datas) {
      if (f_request_isInUsers('login', $datas['login']))
         return ('err_login');
      if ($datas['pwd1'] != $datas['pwd2'])
         return ('err_pwd');
      if (f_request_isInUsers('mail', $datas['mail']))
         return ('err_mail');
      return (true);
   }

   // Vérifie si le nouveau login ou mail n'est pas déjà utilisé par un autre utilisateur
   function f_registration_isValidForModif($datas) {
      $tab  = mysqli_fetch_assoc(f_request("SELECT id FROM Users WHERE login ='". $datas['login'] ."' AND id<>". $datas['id'] .";"));
      $tab2 = mysqli_fetch_assoc(f_request("SELECT id FROM Users WHERE mail  ='". $datas['mail'] ."' AND id<>". $datas['id'] .";"));

      if (isset($tab['id']))
         return ('err_login');
      if (isset($tab2['id']))
         return ('err_mail');
      return (true);
   }

   // Enregistre le nouvel utilisateur dans la table Users
   function f_registration_user($datas) {
      // Sécurisation de la requête
      $sec = f_request_secureForRegistration($datas);

      $req = "INSERT INTO Users (auto, login, firstname, lastname, mail, pwd, phone)";
      $req .= "VALUES (".$sec['auto'].",'".$sec['login']."','".$sec['fname']."','".$sec['lname']."','".$sec['mail']."','".$sec['pwd']."','".$sec['phone']."');";
      $res = f_request($req);

      return ($res);
   }

   // Modifie les données de l'utilisateur $sec['id']
   function f_registration_modifUser($datas) {
      // Sécurisation de la requête
      $sec = f_request_secureForRegistration($datas);

      $req = "UPDATE Users SET auto=".$sec['auto'].", login='".$sec['login']."', firstname='".$sec['fname']."', lastname='".$sec['lname']."', mail='".$sec['mail']."',";
      $req .= "phone='".$sec['phone']."', pwd='".$sec['pwd']."' WHERE id=".$sec['id'].";";
      $res = f_request($req);

      return ($res);
   }

   // Ajout un nouveau message à la base de donnée
   function f_registration_message($content, $chat_id, $user_id) {
      $link    = f_request_connection();
      $content = mysqli_real_escape_string($link, $content);

      mysqli_close($link);
      return (f_request("INSERT INTO Messages(chat_id, user_id, content, datime) VALUES (".$chat_id.", ".$user_id.",'".$content."', NOW());"));
   }
   
   // Ajout d'une nouvelle conversation
   function f_registration_chat($user1_id, $user2_id) {
      return (f_request("INSERT INTO Chats(user1_id, user2_id) VALUES (". $user1_id .", ". $user2_id .");"));
   }

 ?>
