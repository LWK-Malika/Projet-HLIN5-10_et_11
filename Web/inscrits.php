<?php
  include "classes.php";
  
  
  $id_event_suppr = 'A';
  
  // $user="e20190012344";
  // $pass="190399";
  $user="root";
  try{

    //$pdo = new PDO('mysql:host=mysql.etu.umontpellier.fr;dbname=e20190012344', $user, $pass);;
  
    $pdo = new PDO('mysql:host=localhost;dbname=bdevenement', $user,$user);
   // $pdo = new PDO('mysql:host=localhost;dbname=bdevenement', $user,$root);
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }


  if (isset($_GET['DECONNEXION'])) {
    setcookie("role", NULL, -1, "/");
    header('Location: index.php');
  }

  if (!isset($_COOKIE['role'])) {
    header('Location: index.php');
  }

  
  
//suppression d'inscrit':
  if (isset($_GET['supprimer_ins'])){
    if(isset($_GET['ins_supp'])){
      echo "supression de l'event d'id: ".$_GET['ins_supp'] ;
      
    
    
    
    $id_pers = $_GET['ins_supp'];
    
    try{
      $pdo->exec("delete from personne where ID_PERS = '$id_pers'");
    }
    catch(PDOException $e){
    echo("erreur");
    }
    }
      header('Location:inscrits.php');
  }
  

  

  // $pro->setFetchMode(PDO::FETCH_CLASS, 'produits');
  // $pro2->setFetchMode(PDO::FETCH_CLASS, 'categorie');
  // $somme->setFetchMode(PDO::FETCH_CLASS, 'produits');
  // $som_cat->setFetchMode(PDO::FETCH_CLASS, 'categorie');


  // $tab_produits = $pro->fetchAll(); 
  // $tab_categories = $pro2->fetchAll();
  // $tab_somme = $somme->fetchAll();
  
  // $tab_somme_categorie = $som_cat->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<title>Projet Web</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v6.0.1/build/ol.js"></script>    
<link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v6.0.1/css/ol.css"/>
<script type="text/javascript" src="style.js"></script>
<style>
html,body,h1,p,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}

.map { width: 100%; }

.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
</style>

<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <p>INDEX</p>
  </div>
    <div class="w3-top w3-right-align">
     <?php 
  if (isset($_COOKIE['role'])) {
    ?>
    <form type="GET" action="">
      <input type="submit" name="DECONNEXION" value="DECONNEXION" class="w3-button w3-blue">
    </form>
  <?php 
    }?>

  </div>
  

</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>PAGES</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="index.php">INDEX</a>
    <a class="w3-bar-item w3-button w3-hover-black" href="evenement.php">EVENEMENTS</a>


</nav>



<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>





<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

      <div class="w3-row w3-padding-64">
      <div class="w3-twothird w3-container">

      <h1 class="w3-text-teal w3-center" >INSCRITS</h1>
        
        <p class="w3-text-teal">Liste des inscrits sur le site</p>
        <br>

    <form method="GET" action="">
              
              <input type="text" style="margin-bottom: 3%;" name="zone_Recherche" id="zone_Recherche" > 
              <input type="submit" style="margin-bottom: 3%;" class="w3-button w3-black" value="rechercher" id="rechercher">
        </form>
    
     <table border='1'>
        
           <tr> <td>Nom</td> <td>Prénom</td> <td>Pseudo</td> <td>Age</td>  <td>Grade</td>  <td>  Administration  </td>
           </tr> 

       
                 
        <?php 
  
    if (isset($_GET['zone_Recherche'])){
          $recherche = '%'.$_GET['zone_Recherche'].'%';
  

      $pers= $pdo->query("SELECT  ID_PERS as id_pers ,PSEUDO as pseudo , MDP as mdp , NOM as nom ,PRENOM as prenom, AGE as  age,
          GRADE as grade FROM PERSONNE WHERE pseudo like '$recherche' or nom like '$recherche' or prenom like '$recherche' or age like '$recherche' or grade like '$recherche'  GROUP BY grade,id_pers ");


        }

    else{
    
        
    

         $pers= $pdo->query("SELECT  ID_PERS as id_pers ,PSEUDO as pseudo , MDP as mdp , NOM as nom ,PRENOM as prenom, AGE as  age,
          GRADE as grade FROM PERSONNE GROUP BY grade,id_pers");
          }
         $pers->setFetchMode(PDO::FETCH_CLASS, 'Personne');
          $tab_pers = $pers->fetchAll();
    



               
            
                for ($i=0; $i < sizeof($tab_pers); $i++) {
                           
                    ?>
                    <tr>
                     <td ><?php echo $tab_pers[$i]->getnom(); ?></td>
                      <td ><?php echo $tab_pers[$i]->getprenom(); ?></td>
                    <td ><?php echo $tab_pers[$i]->getpseudo(); ?></td>
                     <td ><?php echo $tab_pers[$i]->getage(); ?></td>
                    <td ><?php echo $tab_pers[$i]->getgrade(); ?></td>
                       

              <?php 

                  if ($tab_pers[$i]->getgrade() =='CONTRIBUTEUR' ) {  ?>                
                 
              <td> 
                       <form method="GET" action="">
              <input type="hidden" value="<?php echo $tab_pers[$i]->getid_pers();?>"  name= 'ins_supp' ><br>      
              <input type="submit" style="margin-bottom: 0%;" class="w3-button w3-red" name='supprimer_ins'value="supprimer" id="soumettre">
              </form>
                       </td>

                 <?php  }
                 ?>
                



                    </tr>
            <?php }
            ?>

          </table>
   


      </div>



    <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">

  
  


<!-- END MAIN -->
</div>
</div>
</div>



<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>



</body>
</html>
