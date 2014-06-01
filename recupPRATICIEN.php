<?php 
	
	session_start();
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom'];
	include('include/connexionBase.php');
		
		if($_POST['PRA_NOM']=="") {
			echo "<script>history.go(-1);alert(\"Vous n'avez pas saisie le nom du praticien.\");</script>";	
		}elseif ($_POST['PRA_PRENOM']==""){
			echo "<script>history.go(-1);alert(\"Vous n'avez pas saisie le prénom du praticien.\");</script>";	
		}else if($_POST['PRA_ADRESSE']=="" || $_POST['PRA_CP']=="" || $_POST['PRA_VILLE']==""){
			echo "<script>history.go(-1);alert(\"Vous n'avez pas saisie l'adresse complète du praticien.\");</script>";	
		}else if($_POST['PRA_COEF']==""){
			echo "<script>history.go(-1);alert(\"Vous n'avez pas saisie le coefficient de notoriété.\");</script>";	
		} 
		else {	//Insertion des données		
			$envoie_donnees = $bdd->prepare('INSERT INTO praticien (PRA_NUM, PRA_NOM, PRA_PRENOM, PRA_ADRESSE, PRA_CP, 
					PRA_VILLE, PRA_COEFNOTORIETE, TYP_CODE) 
					VALUES("'.$_POST['PRA_NUM'].'","'.$_POST['PRA_NOM'].'","'.$_POST['PRA_PRENOM'].'","'.$_POST['PRA_ADRESSE'].'","'.
						$_POST['PRA_CP'].'","'.$_POST['PRA_VILLE'].'","'.$_POST['PRA_COEF'].'","'.$_POST['TYP_CODE'].'")');
			$envoie_donnees -> execute();
			$resultat = $envoie_donnees->fetch();
			
			if(!$resultat){	// la valeur de !$resultat est 1
				echo "<script>history.go(-1);alert(\"Praticien correctement enregistrée.\");</script>";
				header('location:menuCR.php');
			}
			else{
				echo "<script>history.go(-1);alert(\"Données non enregistrées.\");</script>";	
			}
		}
?>