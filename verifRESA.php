<?php 
	
	session_start();
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom'];


		include('include/connexionBase.php');

		
		if($_POST['dateDEBUT']=="") {
			echo "<script>history.go(-1);alert(\"Merci de saisir une date de début.\");</script>";	
			
		}elseif ($_POST['dateFIN']==""){
			echo "<script>history.go(-1);alert(\"Merci de saisir une date de fin.\");</script>";	
			
		}else if($_POST['nbrePERSO']==""){
			echo "<script>history.go(-1);alert(\"Merci de saisir un nombre de personne pour la chambre .\");</script>";	
			
		}
		else {	// récupération des données
			
			$num=$_POST['resaNUM'];
			$matricule=$vis_matri_session;
			$identif=$_POST['idHOTEL'];
			$dateD=$_POST['dateDEBUT'];
			$dateF=$_POST['dateFIN'];
			$nbre=$_POST['nbrePERSO'];
		
		
			/*$envoie_donnees = $bdd->prepare('INSERT INTO reservation(RES_CODE, dateDEB,dateFIN,nbrePerso,VIS_MATRICULE,identifiant) 
				VALUES("'.$num.'","'.$dateD.'","'.$dateF.'","'.$nbre.'","'.$matricule.'","'.$identif.'")"');*/
			
			$envoie_donnees = $bdd->prepare("INSERT INTO reservation (RES_CODE, dateDEB,dateFIN, nbrPerso ,VIS_MATRICULE,identifiant) 
			VALUES('".$num."','".$dateD."','".$dateF."','".$nbre."','".$matricule."','".$identif."')");	
			
			$envoie_donnees -> execute();
			$resultat = $envoie_donnees->fetch();
			
			if(!$resultat){	
				echo "<script>history.go(-1);alert(\"Visite correctement enregistrée.\");</script>";
				header('location:menuCR.php');
			}
			else{
				echo $num." num ";
				echo $matricule." matric ";
				echo $identif." id ";
				echo $dateD." deb ";
				echo $dateF." fin ";
				echo $nbre." nbre ";
			}
		}
?>