<?php
  include "classes.php";
  
  
  
  
  // $user="e20190012344";
  // $pass="190399";
  $user="root";
  try{

    //$pdo = new PDO('mysql:host=mysql.etu.umontpellier.fr;dbname=e20190012344', $user, $pass);;
	
    $pdo = new PDO('mysql:host=localhost;dbname=bdevenement', $user,$user);
    //$pdo = new PDO('mysql:host=localhost;dbname=bdevenement', $user, '');
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }


  if (isset($_GET['DECONNEXION'])) {
    setcookie("role", NULL, -1, "/");
    header('Location: index.php');
  }
/*
  if (!isset($_COOKIE['role'])) {
    header('Location: index.php');
  }
*/
  
  
  //creation d'evenement:
    if (isset($_GET['nom_event']) && isset($_GET['date_event'])
	  && isset($_GET['adresse_event']) && isset($_GET['coordlat_event'])&& isset($_GET['coordlong_event'])
  && isset($_GET['effectif_event']) && isset($_GET['description_event'])){

  
    $nom = $_GET['nom_event'];
    $dates = $_GET['date_event'];
    $adresse = $_GET['adresse_event'];
    $eff_max = $_GET['effectif_event'];
	 $coordlat = $_GET['coordlat_event'];
	 $coordlong = $_GET['coordlong_event'];
    $description = $_GET['description_event'];

		try{
      $pdo->exec("insert into evenement (nom, dates, adresse, COORD_LONG, COORD_LAT, eff_max, description) 
    VALUES ('$nom','$dates','$adresse','$coordlong','$coordlat','$eff_max','$description')");
    }
    catch(PDOException $e){
      echo("test insri");
    }

    //Ajout des thèmes 

    if(isset($_GET['theme1_event'])){
      $id_theme = $_GET['theme1_event'];

      $nom_ev = $pdo->query("SELECT ID_EVENEMENT as id_even from EVENEMENT WHERE NOM='$nom'");
      $nom_ev->setFetchMode(PDO::FETCH_CLASS, 'Evenement');
      $tab_nom_ev = $nom_ev->fetchAll();

      $nom_ev = $tab_nom_ev[0]->getid_even();

      try{
        $pdo->exec("insert into caracterise (ID_THEME, ID_EVENEMENT) VALUES ('$id_theme','$nom_ev')");
      }
      catch(PDOException $e){
        echo("test insri");
      }
      
    }

    if(isset($_GET['theme2_event'])){
      $id_theme = $_GET['theme2_event'];

      $nom_ev = $pdo->query("SELECT ID_EVENEMENT as id_even from EVENEMENT WHERE NOM='$nom'");
      $nom_ev->setFetchMode(PDO::FETCH_CLASS, 'Evenement');
      $tab_nom_ev = $nom_ev->fetchAll();

      $nom_ev = $tab_nom_ev[0]->getid_even();

      try{
        $pdo->exec("insert into caracterise (ID_THEME, ID_EVENEMENT) VALUES ('$id_theme','$nom_ev')");
      }
      catch(PDOException $e){
        echo("test insri");
      }
      
    }

    if(isset($_GET['theme3_event'])){
      $id_theme = $_GET['theme3_event'];

      $nom_ev = $pdo->query("SELECT ID_EVENEMENT as id_even from EVENEMENT WHERE NOM='$nom'");
      $nom_ev->setFetchMode(PDO::FETCH_CLASS, 'Evenement');
      $tab_nom_ev = $nom_ev->fetchAll();

      $nom_ev = $tab_nom_ev[0]->getid_even();

      try{
        $pdo->exec("insert into caracterise (ID_THEME, ID_EVENEMENT) VALUES ('$id_theme','$nom_ev')");
      }
      catch(PDOException $e){
        echo("test insri");
      }
      
    }
     header('Location:evenement.php');  
	}
	
//suppression d'evenement:
	if (isset($_GET['supprimer_event'])){
		if(isset($_GET['event_supp'])){
			echo "supression de l'event d'id: ".$_GET['event_supp'] ;
      
		
		
		
    $id_event = $_GET['event_supp'];
    
		try{
			$pdo->exec("delete from evenement where ID_EVENEMENT = '$id_event'");
		}
		catch(PDOException $e){
		echo("erreur");
		}
		}
			header('Location:evenement.php');
	}
  
  //suppression participe:    

	if (isset($_GET['suppr_participe'])){
		
    $id_event = $_GET['suppr_participe'];
    $id_personne = $_COOKIE['id'];
    echo("id participe : ".$id_personne);
    
		try{
			$pdo->exec("delete from participe where ID_EVENEMENT = '$id_event' and ID_PERS = '$id_personne' ");
		}
		catch(PDOException $e){
		echo("erreur");
		}
		
			 header('Location:evenement.php');
	}
	
//PARTICIPATION EVENEMENT  

  if(isset($_GET['even_particip'])){
    $id_personne = $_COOKIE['id'];
    $id_even = $_GET['even_particip'];

    echo "participation de l'event d'id: ".$id_even;
    echo "participation de l'event d'id: ".$id_personne;
    try{
      $pdo->exec("INSERT INTO PARTICIPE (ID_PERS,ID_EVENEMENT) VALUES ('$id_personne' , '$id_even')");
    }
    catch(PDOEXCEPTION $e){
      echo("erreur");
    }
    header("Location:evenement.php");
  }

  //verification déjà participe ? 

 
  $part=$pdo->query("SELECT ID_PERS as id_pers , ID_EVENEMENT as id_even FROM PARTICIPE");
  $coord=$pdo->query("SELECT COORD_LONG, COORD_LAT, nom  FROM EVENEMENT");
  
  $part->setFetchMode(PDO::FETCH_CLASS, 'Participe');
  $coord->setFetchMode(PDO::FETCH_CLASS, 'Evenement');

  $tab_part = $part->fetchAll();
  $tab_coordonnée = $coord->fetchAll();


  for ($i=0; $i < sizeof($tab_coordonnée) ; $i++) { 
    $tab_coord_long[$i]=$tab_coordonnée[$i]->getCOORD_LONG();
    $tab_coord_lat[$i]=$tab_coordonnée[$i]->getCOORD_LAT();
    $tab_nom_even[$i]=$tab_coordonnée[$i]->getnom();
  }

 // ajout d'une note perso
if(isset($_GET['note-perso'] )  ){
    $note=$_GET['note-perso'];
    $id_event = $_GET['note-modif'];
    $id_personne = $_COOKIE['id'];
    echo("id participe : ".$id_personne);
    
    try{
      $pdo->exec("
        UPDATE PARTICIPE SET NOTE_PERSO = '$note'  WHERE ID_PERS = '$id_personne' AND ID_EVENEMENT = '$id_event' 
       ");
    }
    catch(PDOException $e){
    echo("erreur");
    }
    
       header('Location:evenement.php');

}

  //Edition d'evenement:
    if ( isset($_GET['id_eventEdit']) &&isset($_GET['nom_eventEdit']) && isset($_GET['date_eventEdit'])
    && isset($_GET['adresse_eventEdit']) && isset($_GET['coordlat_eventEdit'])&& isset($_GET['coordlong_eventEdit'])
  && isset($_GET['effectif_eventEdit']) && isset($_GET['description_eventEdit'])){

    $id = $_GET['id_eventEdit'];
    $nom = $_GET['nom_eventEdit'];
    $dates = $_GET['date_eventEdit'];
    $adresse = $_GET['adresse_eventEdit'];
    $eff_max = $_GET['effectif_eventEdit'];
   $coordlat = $_GET['coordlat_eventEdit'];
   $coordlong = $_GET['coordlong_eventEdit'];
    $description = $_GET['description_eventEdit'];

    try{
      $pdo->exec("UPDATE evenement SET nom = '$nom', dates ='$dates'  , adresse = '$adresse' , COORD_LONG = '$coordlong' , COORD_LAT = '$coordlat' , eff_max = '$eff_max' , description = '$description' where ID_EVENEMENT = '$id' ");
    }
    catch(PDOException $e){
      echo("test Edit");
    }
    header('Location:evenement.php');
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
  <?php 

     if (isset($_COOKIE['role']) && $_COOKIE['role']=='ADMINISTRATEUR' ) {  ?>

                  
         <a class="w3-bar-item w3-button w3-hover-black" href="inscrits.php">INSCRITS</a>

    <?php }
          ?>

</nav>



<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>





<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->

<div class="w3-main" style="margin-left:250px">

      <div class="w3-row w3-padding-64">
      <div class="w3-twothird w3-container">

      <h1 class="w3-text-teal w3-center" >MAP</h1>
        
        <p class="w3-text-teal">Liste des évènements</p>
        <br>
		
		<form method="GET" action="">
              
              <input type="text" style="margin-bottom: 3%;" name="zone_Recherche" id="zone_Recherche" > 
              <input type="submit" style="margin-bottom: 3%;" class="w3-button w3-black" value="rechercher" id="rechercher">
        </form>
		
		
     <table border='1'>
         <tr> <td>Identifiant</td>
          <td>Nom</td>
              <td>Date</td>
              <td>Lieu</td>
              <td>Note</td>
              <?php 

                  if (isset($_COOKIE['role']) && ( $_COOKIE['role']=='VISITEUR') ){  ?>
              <td>Ma note</td>  

                <?php 
                  $reqnote=$pdo->query("SELECT ID_PERS as id_pers , ID_EVENEMENT as id_even , NOTE_PERSO as note_perso FROM PARTICIPE");
                    $reqnote ->setFetchMode(PDO::FETCH_CLASS, 'participe');
                    $tab_noteperso = $reqnote-> fetchAll();

                 }?>


              <td>Theme</td>
              <td>Description</td>  
              <?php 

                  if (isset($_COOKIE['role']) &&   $_COOKIE['role']=='ADMINISTRATEUR'){  ?>

                  <td>  Administration  </td>


                <?php }
                 if(isset($_COOKIE['role']) &&  $_COOKIE['role']=='VISITEUR'){?>
                    <td>PARTICIPE</td>

              <?php  }?>
          </tr> 
       
                 
        <?php 
		if (isset($_GET['zone_Recherche'])){
			    $recherche = '%'.$_GET['zone_Recherche'].'%';
	
				
			$ev= $pdo->query("SELECT ID_EVENEMENT as id_even ,nom, dates, adresse as lieux,note,eff_max,description FROM EVENEMENT even
			where nom like '$recherche' or dates like '$recherche' or adresse like '$recherche' 
			or description like '$recherche' or exists (select * from theme natural join caracterise where even.id_evenement = caracterise.id_evenement and nom  like '$recherche')");
				}
		else{
		
         $ev=$pdo->query("SELECT ID_EVENEMENT as id_even ,nom, dates, adresse as lieux,note,eff_max,description FROM EVENEMENT");
		}
         $ev->setFetchMode(PDO::FETCH_CLASS, 'Evenement');
          $tab_ev = $ev->fetchAll();
		    $theme= $pdo->query("SELECT THEME.ID_THEME , nom, ID_EVENEMENT FROM CARACTERISE, THEME
                    WHERE THEME.id_theme= caracterise.id_theme  ");
         $theme ->setFetchMode(PDO::FETCH_CLASS, 'Theme,CARACTERISE');
         $tab_th = $theme-> fetchAll();

               
            
                for ($i=0; $i < sizeof($tab_ev) ; $i++) {
                           
                    ?>
                    <tr>
                      <td ><?php echo $tab_ev[$i]->getid_even(); ?></td>
                      <td ><?php echo $tab_ev[$i]->getnom(); ?></td>
                      <td ><?php echo $tab_ev[$i]->getdates(); ?></td>
                      <td ><?php echo $tab_ev[$i]->getlieux(); ?></td>
                      <td ><?php echo $tab_ev[$i]->getnote(); ?></td>
                      <?php 

                  if (isset($_COOKIE['role']) && ( $_COOKIE['role']=='VISITEUR') ){  ?>

                      <td> <?php 
                         for($j=0; $j < sizeof($tab_noteperso ) ; $j++) { 

                          if($tab_noteperso[$j]->getid_pers() == $_COOKIE['id'] && $tab_noteperso[$j]->getid_even()== $tab_ev[$i]->getid_even()){
                             


                      echo "note actuelle: ".$tab_noteperso[$j]-> getnote_perso(); ?> 
                        <form method="GET" action=""> 
                        <input type="hidden" value="<?php echo $tab_ev[$i]->getid_even();?>"  name= 'note-modif' >
                        <input type="text" style="margin-bottom: 3%;" name="note-perso" >
                        <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" value="Valider" id="soumettre">
                        </form> </td>  


                    <?php }} }?>
                  

                      <?php

                        $bool=0;
                        $chaine="";
                        for ($p=0; $p <sizeof($tab_th) ; $p++) {
                  
                            if($tab_th[$p][2]==$tab_ev[$i]->getid_even()){
                              $chaine=$chaine." ".$tab_th[$p][1]."<br>";
                              
                              $bool=1;

                            }
                          
                        }
                       
                         
                      
                      if($bool==0) {
                      ?>

                        <td> Aucun theme </td>

                        <?php }
                      if ($bool==1){ ?>
                        <td ><?php echo $chaine; ?></td>
                      <?php } ?>




                      <td ><?php echo $tab_ev[$i]->getdescription(); ?></td>
                    <?php 
                    if (isset($_COOKIE['role']) && $_COOKIE['role']=='ADMINISTRATEUR' ) { ?>

                      <td>         
                      <form method="GET" action="">
                        <input type="hidden" value="<?php echo $tab_ev[$i]->getid_even();?>"  name= 'event_supp' ><br>      
                        <input type="submit" style="margin-bottom: 0%;" class="w3-button w3-black" name='supprimer_event'value="supprimer" id="soumettre">
                      </form>
			  
								
                      </td>
                    <?php }
                  
                      
              



                  if(isset($_COOKIE['role']) && $_COOKIE['role']=='VISITEUR'){ ?>
                      <td>
                        <?php
                          $test=0;
                         for($j=0; $j < sizeof($tab_part) ; $j++) { 

                          if($tab_part[$j]->getid_pers() == $_COOKIE['id'] && $tab_part[$j]->getid_even()== $tab_ev[$i]->getid_even()){
                            ?> 
                                <form method="GET" action="">
                                <input type="hidden" value="<?php echo $tab_ev[$i]->getid_even();?>"  name= 'suppr_participe' ><br>
                                <input type="submit" class="w3-button w3-red" name="suppresion_participe" value="NE PLUS PARTICIPER">
                                </form>
                            <?php $test=1;
                          }
                        }
                        
                        if($test==0){?>
                          <form method="GET" action="">
                          <input type="hidden" value="<?php echo $tab_ev[$i]->getid_even();?>"  name= 'even_particip' ><br>
                          <input type="submit" class="w3-button w3-black" name="participe" value="JE PARTICIPE">
                        </form>

                        <?php }?>

                      </td>
              <?php }
              } ?>
            
                    </tr>
          </table>
		 <?php 
		 if (isset($_COOKIE['role']) &&( $_COOKIE['role']=='CONTRIBUTEUR'  || $_COOKIE['role']=='ADMINISTRATEUR' )) { ?>
		<button onclick="document.getElementById('idAjoutEvent').style.display='block'" class="w3-button w3-blue">
            Ajouter évènement</button>
		 <?php }
         ?>

     <?php 
           if (isset($_COOKIE['role']) &&( $_COOKIE['role']=='CONTRIBUTEUR'  ||  $_COOKIE['role']=='ADMINISTRATEUR')) {  ?>

        <form method="GET" action="">
        <p class="w3-center">Editer d'évènement</p>
        Identfiant:         <input type="text" style="margin-bottom: 3%;" name="id_eventEdit" id="id_eventEdit" ><br>  
              Nom:         <input type="text" style="margin-bottom: 3%;" name="nom_eventEdit" id="nom_eventEdit" ><br>  

        Date:        <input type="text" style="margin-bottom: 3%;" name="date_eventEdit" id="date_eventEdit" ><br>  
        Adresse:     <input type="text" style="margin-bottom: 3%;" name="adresse_eventEdit" id="adresse_eventEdit" ><br>
        Coordonnées
         latitude: <input type="text" style="margin-bottom: 3%;" name="coordlat_eventEdit" id="coord_eventEdit" ><br>
        Coordonnées 
         longitude: <input type="text" style="margin-bottom: 3%;" name="coordlong_eventEdit" id="coord_eventEdit" ><br>  
        
        Effectif max:<input type="text" style="margin-bottom: 3%;" name="effectif_eventEdit" id="effectif_eventEdit" ><br>  
        Description: <input type="text" style="margin-bottom: 3%;" name="description_eventEdit" id="description_eventEdit" ><br>  
              
        
              <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" value="Editer" id="soumettre">
              </form>
          <?php }
          ?>

      </div>
      <div id="map" class="map" style="width:800px; height:500px"></div>



    <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">

        <div id="points_interet" class="points_interet" style="width:100%; height:25%"></div>
        <div id="map" class="map" style="width:100%; height:75%"></div>
        <img id="markerProto" class="marker" src="marker.png"  width="50" height="50" onClick="switchMarker();"/>
        <div id="popupProto" style="font-size:18pt; color:black; width:100px; height:100px; display:none"></div>
      </div>
<!--  --------------à enlever normalement, on en a pas besoin ici, il y avait en plus un bug par rapport à la carte -------------------
     
      <h1 class="w3-text-teal w3-center" > Veuillez vous connecter pour accéder au site</h1>
      <div class="w3-twothird w3-container">

  <div id="id01" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <form method="GET" action="">
              <p>CONNEXION</p>
              Pseudo:        <input type="text" style="margin-bottom: 3%;" name="pseudo" id="pseudo" ><br>  

              Mot de passe:  <input type="password" style="margin-bottom: 3%;" name="mdp" id="mdp" ><br>
              <input type="submit" style="margin-bottom: 3%;" class="w3-button w3-black" value="connexion" id="soumettre">
              </form>
          </div>
      </div>
    </div>
  </div>
-->


<!-- pop up evènement supp -->
      <div id="idSupp" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('idSupp').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <form method="GET" action="">
              <p class="w3-center">Suppression d'évènement</p>
                <p> Voulez vous vraiment supprimer l'évènement ? </p>

              <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" name="supprimer" value="Valider" id="supprimer">
			  <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black"  value="annuler" id="annuler">
              </form>

          </div>
      </div>
    </div>
	
	
<!-- pop up evènement ajout -->
      <div id="idAjoutEvent" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('idAjoutEvent').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <form method="GET" action="">
			  <p class="w3-center">Ajout d'évènement</p>
              Nom:         <input type="text" style="margin-bottom: 3%;" name="nom_event" id="nom_event" ><br>  

			  Date:        <input type="text" style="margin-bottom: 3%;" name="date_event" id="date_event" ><br>  
			  Adresse:     <input type="text" style="margin-bottom: 3%;" name="adresse_event" id="adresse_event" ><br>
				Coordonnées
			   latitude: <input type="text" style="margin-bottom: 3%;" name="coordlat_event" id="coord_event" ><br>
			  Coordonnées 
         longitude: <input type="text" style="margin-bottom: 3%;" name="coordlong_event" id="coord_event" ><br>  
			  
			  Effectif max:<input type="text" style="margin-bottom: 3%;" name="effectif_event" id="effectif_event" ><br>  
        Description: <input type="text" style="margin-bottom: 3%;" name="description_event" id="description_event" ><br>  
        Themes 1 (optionnel): <input type="checkbox" style="margin-bottom: 3%;" name="theme1_event" value=1 id="theme1_event" >SPORTIF <br>
        Themes 2 (optionnel): <input type="checkbox" style="margin-bottom: 3%;" name="theme2_event" value=2 id="theme2_event" >CULTUREL <br>
        Themes 3 (optionnel): <input type="checkbox" style="margin-bottom: 3%;" name="theme3_event" value=3 id="theme3_event" >EDUCATIF<br>

              
			  
              <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" value="Valider" id="soumettre">
              </form>

          </div>
      </div>
    </div>	


<!-- pop up evènement éditer
      <div id="idEditerEvent" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
            <span onclick="document.getElementById('idSupp').style.display='none'" class="w3-button w3-display-topright">&times;</span>
              <form method="GET" action="">
        <p class="w3-center">Editer d'évènement</p>
              Nom:         <input type="text" style="margin-bottom: 3%;" name="nom_eventEdit" id="nom_eventEdit" ><br>  

        Date:        <input type="text" style="margin-bottom: 3%;" name="date_eventEdit" id="date_eventEdit" ><br>  
        Adresse:     <input type="text" style="margin-bottom: 3%;" name="adresse_eventEdit" id="adresse_eventEdit" ><br>
        Coordonnées
         latitude: <input type="text" style="margin-bottom: 3%;" name="coordlat_eventEdit" id="coord_eventEdit" ><br>
        Coordonnées 
         longitude: <input type="text" style="margin-bottom: 3%;" name="coordlong_eventEdit" id="coord_eventEdit" ><br>  
        
        Effectif max:<input type="text" style="margin-bottom: 3%;" name="effectif_eventEdit" id="effectif_eventEdit" ><br>  
        Description: <input type="text" style="margin-bottom: 3%;" name="description_eventEdit" id="description_eventEdit" ><br>  
              
        
              <input type="submit" style="margin-bottom: 3%;" class="w3-center w3-button w3-black" value="Valider" id="soumettre">
              </form>

          </div>
      </div>
    </div>  
-->


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

<script src="map.js"></script>
<script>
  var tableau_coord_long = <?php echo json_encode($tab_coord_long); ?>;
  var tableau_coord_lat = <?php echo json_encode($tab_coord_lat); ?>;
  var tableau_nom = <?php echo json_encode($tab_nom_even); ?>;
  
  $(document).ready(start(tableau_coord_long , tableau_coord_lat, tableau_nom));
</script>

</body>
</html>
