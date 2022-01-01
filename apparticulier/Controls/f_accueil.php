  <?php
    require_once('f_request.php');

    //retourne le le tableaue le plus petit
    function minimum($tab1,$tab2){
      if(sizeof($tab1)<=sizeof($tab2)){
        return sizeof($tab1);
      }
      return sizeof($tab2);
    }

    //retourne le tableau le plus grand
    function maximum($tab1,$tab2){
      if(sizeof($tab1)>=sizeof($tab2)){
        return sizeof($tab1);
      }
      return sizeof($tab2);
    }

  //VALIDE.PHP
  function recupInfo_From_POSTBIS(){ //se charge de vérifier et de charger les infos transmit par le formulaire par méthode POST
      $res = array();
      if(isset($_POST['titre']) && isset($_POST['prix']) && isset($_POST['sup']) && isset($_POST['image']) && isset($_POST['description']) && isset($_POST['Ville']) && isset($_POST['adresse']) && isset($_POST['nb_rooms']) && isset($_POST['type'])){
      $res = array ($_POST['titre'],$_POST['prix'],$_POST['sup'],$_POST['image'],$_POST['description'],$_POST['Ville'],$_POST['adresse'],$_POST['nb_rooms'],$_POST['type']);
    }
    return $res;
  }

  //TRI.PHP
  function recupInfo_From_POST(){ //se charge de vérifier et de charger les infos transmit par le formulaire par méthode POST
      $res = array();
     if(isset($_POST['prix']) && isset($_POST['superficie'])){
       $res = array ($_POST['prix'],$_POST['superficie']);
       return $res;
     }else{
       return false;
     }
   }

   //AFFICHE_ANNONCE.PHP
   //recupere l'id transmit par $_GET
   function recupID(){
     if(isset($_GET['id'])){
     return $_GET['id'];
     }
     return -1;
   }
?>
