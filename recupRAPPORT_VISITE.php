<?php 
	
	session_start();
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom'];


		include('include/connexionBase.php');
				
		$rechercherNumPraticien = $bdd->query('SELECT PRA_NUM AS NUM_PRATICIEN FROM praticien WHERE PRA_NOM="'.$_POST["PRA_NUM"].'"');
		$rechercherNumPraticien2 = $rechercherNumPraticien-> fetch();
		
		//Pour le motif
		if ($_POST['AutreMotif']==true){
			$rapMotif= $_POST['RAP_MOTIFAUTRE'];
			$envoie_donnee = $bdd->prepare('INSERT INTO motif (MOT_LIBELLE) VALUES ("'. $_POST['RAP_MOTIFAUTRE'].'")');
			$envoie_donnee -> execute();
			$resultat = $envoie_donnee->fetch();
		}else{
			$rapMotif=$_POST['RAP_MOTIF'];
		}

		//Pour les produits
		$nbPost = count($_POST);
		$tableauPost = array();
		$resultat = 0;
		$resultat2 = 0;
		$nbPost2 = $nbPost-1;
		$nomProduit = "";
		$nomQuantite = "";
		$quantiteVoulue = 0;
		$j = 0;
		
		if($_POST['RAP_DATEVISITE']=="") {
			echo "<script>history.go(-1);alert(\"Vous n'avez pas saisie de date de visite.\");</script>";	
		}elseif ($_POST['RAP_BILAN']==""){
			echo "<script>history.go(-1);alert(\"Vous n'avez pas saisie de bilan.\");</script>";	
		}else if(empty($rapMotif)){
			echo "<script>history.go(-1);alert(\"Merci de remplir le motif de la visite.\");</script>";	
		}else if(empty($_POST['RAP_LOCK'])){
			echo "<script>history.go(-1);alert(\"Merci de coché la case saisie définitive.\");</script>";	
		} 
		else {	//Insertion des données
			$envoie_donnees = $bdd->prepare('INSERT INTO rapport_visite(VIS_MATRICULE,RAP_NUM,PRA_NUM,RAP_DATE,RAP_BILAN,RAP_MOTIF) 
				VALUES("'.$vis_matri_session.'","'.$_POST['RAP_NUM'].'",'.$rechercherNumPraticien2[0].',"'.$_POST['RAP_DATEVISITE'].
				'","'.$_POST['RAP_BILAN'].'","'.$rapMotif.'")');
			$envoie_donnees -> execute();
			$resultat = $envoie_donnees->fetch();
			
			if(!$resultat){	// la valeur de !$resultat est 1
							// insertion des produits
				foreach ($_POST as $key => $value) {	//créé d'abbord un tableau avec toutes les données à récupérer
				$tableauPost[] = "$key";
				}
				for($j=5;$j<$nbPost2;$j++){
					if($j%2!=0){
						$suivant = $j+1;
						$nomProduit = $_POST[''.$tableauPost[$j].''];
						if($nomProduit!="Produits"){
						$rechercheNomDepotLegal = $bdd->query('SELECT MED_DEPOTLEGAL FROM medicament 
							WHERE MED_NOMCOMMERCIAL="'.$_POST[''.$tableauPost[$j].''].'"');
						$rechercheNomDepotLegal = $rechercheNomDepotLegal-> fetch();
						$quantiteVoulue = $_POST[''.$tableauPost[$suivant].''];
						$envoie_produits = $bdd->prepare('INSERT INTO offrir(VIS_MATRICULE, RAP_NUM, MED_DEPOTLEGAL,OFF_QTE) 
							VALUES("'.$vis_matri_session.'","'.$_POST['RAP_NUM'].'","'.$rechercheNomDepotLegal[0].'","'.$quantiteVoulue.'")');
						$envoie_produits -> execute();
						$resultat2 = $envoie_produits->fetch();
						}
					}
					$j++;
				}			//	fin de l'insertion des produits

				if($resultat2){	// si une erreur est détectée lors de l'insertion des produits, on supprime le rapport
					$bdd2 = new PDO('mysql:host=localhost;dbname=gsb_ppe2et4', 'root', '');
					$suppression_rapport = $bdd2->query('delete from rapport_visite WHERE RAP_NUM='.$_POST["RAP_NUM"].';');
					$suppression_rapport = $suppression_rapport->fetch();
					echo "<script>history.go(-1);alert(\"Produits non enregistrées.\");</script>";
				}
				echo "<script>history.go(-1);alert(\"Visite correctement enregistrée.\");</script>";
				header('location:menuCR.php');
			}
			else{
				echo "<script>history.go(-1);alert(\"Données non enregistrées.\");</script>";	
			}
		}
?>