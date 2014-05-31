<?php 
	

include('include/connexionBase.php');

$login = $_POST['nom'];
$mdp = $_POST['mdp'];
$numReg= $_POST['REG_NUM'];
$regValide=false;

// Vérification des identifiants
$req = $bdd->query("SELECT * FROM visiteur WHERE VIS_NOM='$login'");
$donnees = $req->fetch();
$req2 = $bdd->query("SELECT substring(VIS_DATEEMBAUCHE,1,10) AS DATEEMBAUCHE FROM visiteur WHERE VIS_NOM='$login'");
$donnees2 = $req2->fetch();
$mdp2 = $donnees2['DATEEMBAUCHE'];

//Vérification de la région 
$regCode= $bdd->query("SELECT REG_CODE FROM travailler WHERE VIS_MATRICULE= '".$donnees['VIS_MATRICULE']."' ");
while($donneesRegC = $regCode -> fetch()){
	if ($numReg==$donneesRegC['REG_CODE']){
		$regValide=true;
	}
}

	
//on fait un tableau en décomposant par rapport à -
if (isset($mdp2)){
$date=explode("-",$mdp2);
$jour = $date[2];
$mois = $date[1];
$annee = $date[0];

if ($mois == '01')	$mois = 'jan';
if ($mois == '02')	$mois = 'feb';
if ($mois == '03')	$mois = 'mar';
if ($mois == '04')	$mois = 'apr';
if ($mois == '05')	$mois = 'may';
if ($mois == '06')	$mois = 'jun';
if ($mois == '07')	$mois = 'jul';
if ($mois == '08')	$mois = 'aug';
if ($mois == '09')	$mois = 'sep';
if ($mois == '10')	$mois = 'oct';
if ($mois == '11')	$mois = 'nov';
if ($mois == '12')	$mois = 'dec';
//on met au format voulu
$date_emb= $jour."-".$mois."-".$annee;

		if($mdp <> $date_emb) {
			echo "<script>history.go(-1);alert(\"Le login ou le mot de passe est incorect.\");</script>";	
		}elseif ($regValide==false){
			echo utf8_decode("<script>history.go(-1);alert(\"La région sélectionnée ne correspont pas au login.\");</script>");
		}
		else{
			if ($mdp == $date_emb && $regValide==true && $login != "" )
			{ 
				session_start();
			    $_SESSION['id'] = $donnees['VIS_MATRICULE'];
			    $_SESSION['nom'] = $login; 
			 	header('location:menuCR.php');
			}
			else
			{
				header('location:Accueil.php');
			}
}
}else{
	echo "<script>history.go(-1);alert(\"Le login n'existe pas .\");</script>";
}
?>