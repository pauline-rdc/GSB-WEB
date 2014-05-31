<html>
<head>
	<title>formulaire VISITEUR</title>
	<style type="text/css">
		<!-- body {background-color: white; color:5599EE; } 
			.titre { width : 180 ;  clear:left; float:left; } 
			.zone { width : 30car ; float : left; color:7091BB } -->
	</style>
</head>
<body>
<div name="haut" style="margin: 2 2 2 2 ;height:6%;"><h1><img src="logo.jpg" width="100" height="60"/>Gestion des visites</h1></div>
<div name="gauche" style="float:left;width:18%; background-color:white; height:100%;">
	<h2>Outils</h2>
	<ul><li>Comptes-Rendus</li>
		<ul>
			<li><a href="formRAPPORT_VISITE.htm" >Nouveaux</a></li>
			<li>Consulter</li>
		</ul>
		<li>Consulter</li>
		<ul><li><a href="formMEDICAMENT.htm" >Médicaments</a></li>
			<li><a href="formPRATICIEN.php" >Praticiens</a></li>
			<li><a href="formVISITEUR.htm" >Autres visiteurs</a></li>
		</ul>
	</ul>
</div>
<div name="droite" style="float:left;width:80%;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">


	<?php
	include('include/connexionBase.php');
	$req = $bdd->query("SELECT * FROM visiteur ORDER BY VIS_VILLE ASC");
	?>


	<form name="formVISITEUR" method="post" action="visiteur.php">
		<h1> Visiteurs </h1>
		<table>
			<tr>
				<td><select name="lstDept" class="titre" onSubmit="document.forms.formVISITEUR.submit()">
						<option>Département</option>
							<?php 
								while ($donnees = $req-> fetch()){?>
									<option  value="<?php echo $donnees['VIS_VILLE']; ?>" 
										<?php if ((isset($_POST['lstDept'])) && ($donnees['VIS_NOM']==$_POST['lstDept'])) { ?> selected='selected'<?php } ?> >
										<?php	echo $donnees['VIS_VILLE'];?><br>
									</option>
								<?php	} ;
								?>
				</select></td>
				<td><input type='submit' value='Valider' /></td>
			</tr>
		</table>






		<?php 
	 	if(isset($_POST['lstDept'])){
	 		$departement=$_POST['lstDept'];
	 		$req = $bdd->query("SELECT * FROM visiteur WHERE VIS_VILLE='$departement' ORDER BY VIS_NOM ASC");
	 	?>
	 		<table>
			<tr>
				<td><select name="lstVisiteur" class="titre" onSubmit="document.forms.formVISITEUR.submit()">
							<?php 
								while ($donnees = $req-> fetch()){?>
									<option  value="<?php echo $donnees['VIS_MATRICULE']; ?>" 
										<?php if ((isset($_POST['lstVisiteur'])) && ($donnees['VIS_NOM']==$_POST['lstVisiteur'])) { ?> selected='selected'<?php } ?> >
										<?php	echo $donnees['VIS_NOM'];?><br>
									</option>
								<?php	} ;
								?>
				</select></td>
				<td><input type='submit' value='Valider' /></td>
			</tr>
		</table><br><br>
		<?php
	 	}

	 	



	 	if(isset($_POST['lstVisiteur'])){ 
	 		$matricule=$_POST['lstVisiteur'];
	 		$req = $bdd->query("SELECT * FROM visiteur WHERE VIS_MATRICULE='$matricule' ORDER BY VIS_NOM ASC");
	 		$donnees = $req-> fetch();
	 	?>
			<table>
				<tr>
					<td style="color:#fff; ">NOM</td>
					<td style="color:#fff;">:</td>
					<td><input type="text" value="<?php echo $donnees['VIS_NOM']; ?>" readonly></td>
				</tr>
				<tr>
					<td style="color:#fff; ">PRENOM</td>
					<td style="color:#fff;">:</td>
					<td><input type="text" value="<?php echo $donnees['Vis_PRENOM']; ?>" readonly></td>
				</tr>
				<tr>
					<td style="color:#fff; ">ADRESSE</td>
					<td style="color:#fff;">:</td>
					<td><input type="text" value="<?php echo $donnees['VIS_ADRESSE']; ?>" readonly></td>
				</tr>
				<tr>
					<td style="color:#fff; ">CP</td>
					<td style="color:#fff;">:</td>
					<td><input type="text" value="<?php echo $donnees['VIS_CP']; ?>" readonly></td>
				</tr>
				<tr>
					<td style="color:#fff; ">VILLE</td>
					<td style="color:#fff;">:</td>
					<td><input type="text" value="<?php echo $donnees['VIS_VILLE']; ?>" readonly></td>
				</tr>
				<tr>
					<td style="color:#fff; ">SECTEUR</td>
					<td style="color:#fff;">:</td>
					<td><input type="text" value="<?php echo $donnees['LAB_CODE']; ?>" readonly></td>
				</tr>
			</table><br>
		<?php
	}
		  echo "<a href='menuCR.php'><input type='button' value='Fermer' /></a>";
	?>



	</form>
	</div>
</div>
</body>
</html>