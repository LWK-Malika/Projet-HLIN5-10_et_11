<?php
  include "classes.php";
  
  // $user="e20190012344";
  // $pass="190399";
  $user="root";
  try{
    // $pdo = new PDO('mysql:host=mysql.etu.umontpellier.fr;dbname=e20190012344', $user, $pass);;

    //$pdo = new PDO('mysql:host=localhost;dbname=ma_base', $user, "");
//	$pdo = new PDO('mysql:host=localhost;dbname=bdevenement', $user, "");

    $pdo = new PDO('mysql:host=localhost;dbname=bdevenement', $user, '');

  }
  
  catch(PDOException $e){
    echo $e->getMessage();
  }

  $con=$pdo->query("SELECT ID_PERS as id_pers , pseudo, mdp, grade  FROM PERSONNE");


  $con->setFetchMode(PDO::FETCH_CLASS, 'Personne');

  
  $tab_con = $con->fetchAll();




  

  if (isset($_GET['pseudo']) && isset($_GET['mdp'])) {
    for ($i=0; $i < sizeof($tab_con) ; $i++) { 
      if ($_GET['pseudo'] == $tab_con[$i]->getpseudo() && $_GET['mdp'] == $tab_con[$i]->getmdp()) {
       
        setcookie("role", '', time()-1, "/");
        setcookie("id", NULL, -1, "/");
        if ($tab_con[$i]->getgrade() =='ADMINISTRATEUR' ) {
          setcookie("role", "ADMINISTRATEUR" , time()+3600, "/");
        }
        else if ($tab_con[$i]->getgrade() =='CONTRIBUTEUR' ) {
          setcookie("role", "CONTRIBUTEUR" , time()+3600, "/");
        }
        else if ($tab_con[$i]->getgrade() =='VISITEUR' ) {
          
          setcookie("role", "VISITEUR" , time()+3600, "/");
          setcookie("id", $tab_con[$i]->getid_pers(), time()+3600, "/");
        }
        else{
          echo("ERROR !");
        }
        header('Location: index.php');
      }
     
      
    }
  }

  if (isset($_GET['DECONNEXION'])) {
    setcookie("role", NULL, -1, "/");
    setcookie("id", NULL, -1, "/");
    header('Location: index.php');
  }
  if (isset($_GET['pseudo_inscription']) && isset($_GET['mdp_inscription'])
	  && isset($_GET['nom_inscription']) && isset($_GET['prenom_inscription'])
  && isset($_GET['age_inscription'])) {

    $pseudo = $_GET['pseudo_inscription'];
    $mdp = $_GET['mdp_inscription'];
    $nom = $_GET['nom_inscription'];
    $prenom = $_GET['prenom_inscription'];
    $age = $_GET['age_inscription'];

		try{
      $pdo->exec("insert into personne (PSEUDO, MDP, NOM, PRENOM, AGE, GRADE) 
    VALUES ('$pseudo','$mdp','$nom','$prenom','$age','VISITEUR')");
    }
    catch(PDOException $e){
      echo("test insri");
    }
    
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
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a> 
    <div class="w3-right-align">
     <?php 
  if (isset($_COOKIE['role'])) {
    ?>
    <form type="GET" action="">
      <input type="submit" name="DECONNEXION" value="DECONNEXION" class="w3-button w3-blue">
    </form>
  <?php 
    }
  else{
    ?> <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-blue">CONNEXION</button>
		<button onclick="document.getElementById('id02').style.display='block'" class="w3-button w3-blue">INSCRIPTION</button>
  <?php }?> 
    </div>
    </div>

</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>PAGES</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="evenement.php">EVENEMENTS</a>
<?php 

                  if (isset($_COOKIE['role']) && $_COOKIE['role']=='ADMINISTRATEUR' ) {  ?>

                  
                      <a class="w3-bar-item w3-button w3-hover-black" href="inscrits.php">INSCRITS</a>


                <?php }
                 ?>
</nav>



<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>





<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<!-- CONTENU  CONNECTE -->
<div class="w3-main" style="margin-left:250px">
<?php 
  if (isset($_COOKIE['role'])) {
    ?>
 
      <div class="w3-row w3-padding-64">
      <div class="w3-twothird w3-container">

      <h1 class="w3-text-teal w3-center" >BIENVENUE VOUS ÊTES CONNECTES !</h1>
        
  
      </div>


<?php
  }

  else{ ?>
 <!-- CONTENU NON CONNECTE -->
    <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container w3-col" style="width:100%">

      <h1 class="w3-text-teal w3-center " > Veuillez vous connecter pour accéder au site pour continuer merci !</h1>

    </div>

	 <!-- pop up connexion -->
      <div id="id01" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <form method="GET" action="">
              <p class="w3-center">CONNEXION</p>
              <label for="Pseudo" style="width:25%">Pseudo</label><input type="text" style="margin-bottom: 3%; " name="pseudo" id="pseudo"><br>  
              <label for="MDP">Mot de passe</label><input type="password" style="margin-bottom: 3%;" name="mdp" id="mdp"><br>
              <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" value="connexion" id="soumettre">
              </form>

          </div>
      </div>
    </div>
	<!-- pop up inscription -->
	  <div id="id02" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <form method="GET" action="">
              <p class="w3-center">INSCRIPTION</p>
              
              <label for="Pseudo">Nom</label><input type="text" style="margin-bottom: 3%;" name="nom_inscription" id="nom_inscription"><br>
			  <label for="Pseudo">Prenom</label><input type="text" style="margin-bottom: 3%;" name="prenom_inscription" id="prenom_inscription"><br>
			  <label for="Pseudo">Age</label><input type="text" style="margin-bottom: 3%;" name="age_inscription" id="age_inscription"><br> <label for="Pseudo" style="width:25%">Pseudo</label><input type="text" style="margin-bottom: 3%; " name="pseudo_inscription" id="pseudo_inscription"><br>  
              <label for="MDP">Mot de passe</label><input type="password" style="margin-bottom: 3%;" name="mdp_inscription" id="mdp_inscription"><br>
																	  
			  <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" value="inscription" id="inscri">
              </form>

          </div>
      </div>
    </div>
  </div>
  <?php
  }
 ?>




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
