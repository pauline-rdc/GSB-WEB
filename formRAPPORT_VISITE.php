<?php
session_start();
if (empty($_SESSION)) {
	header('location:Accueil.php');
}

$repInclude = './include/';
include ('include/top.php');
$vis_matri_session = $_SESSION['id'];
$nom_session = $_SESSION['nom'];
?>
<html>
	<head>
		<title>formulaire RAPPORT_VISITE</title>
	</head>
	<body>
		<?php
		$vist = $_SESSION['id'];
		include ('include/connexionBase.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php
					include ('include/menuVertical.php');
					?>
				</div>
				<div class="col-md-9" class="form col-md-12 center-block" >
					<div class="well bs-component">
						<div class="thumbnail">
							<h2>Rapport de visite</h2>
						</div>
						<form name="formRAPPORT_VISITE" method="post" action="formRAPPORT_VISITE.php">
							<legend>
								Rapport &agrave; s&eacute;lectionner :
							</legend>
							<div>

								<select name="lstmnt"  class="form-control" style="max-width:300px;float:left;" >
									<!--option value="0">Choisir la date du rendez-vous</option-->
									<?php
$req3 = $bdd->query("SELECT RAP_NUM as numRapport, SUBSTRING(RAP_DATE,1,10) as dateRapport
FROM rapport_visite WHERE VIS_MATRICULE = '".$vist."'");
while ($donnees3 = $req3-> fetch()){
									?>
									<option value="<?php echo $donnees3['numRapport']; ?>"
									<?php if ((isset($_POST['lstmnt'])) && ($donnees3['dateRapport']==$_POST['lstmnt'])) { ?> selected='selected'<?php } ?> >
										<?php
										if ($donnees3['numRapport'] >= 10) {
											echo $donnees3['numRapport'] . "  &nbsp; &nbsp; : &nbsp;&nbsp;   " . $donnees3['dateRapport'];
										} else {
											echo $donnees3['numRapport'] . "  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; " . $donnees3['dateRapport'];
										}
										}
										?></option>
								</select>
								&nbsp; &nbsp; 
								<input type='submit' class="btn btn-primary btn-sm" value='Valider' >
								</td>
							</div>
							<br/>
							<br/>
							<?php

							if(isset($_GET['rapport'])) {
									$rapport=$_GET['rapport'];
								}else if(isset($_POST['lstmnt'])) {
									$rapport=$_POST['lstmnt'];
								}
							
							if(isset($rapport)) {

$req = $bdd->query("SELECT * FROM rapport_visite WHERE RAP_NUM='".$rapport."'");
$donnees = $req-> fetch();
$praticien = $donnees['PRA_NUM'];

$req2 = $bdd->query("SELECT * FROM praticien WHERE PRA_NUM = '".$praticien."'");
$donnees2 = $req2-> fetch();
$nomPraticien = $donnees2['PRA_NOM']." ".$donnees2['PRA_PRENOM'];
							?>
							<div class="corpsForm">
								<legend>
									Informations
								</legend>
								<label>NUMERO :</label>
								<input type="text" size="10" name="RAP_NUM"
								value="<?php echo $rapport; ?>" class="form-control" style="max-width:80px;"  readonly/>
								<br/>
								<label>PRATICIEN :</label>
								<button data-toggle="modal" href="#myModal" type="button" class=" btn-sm btn btn-primary">
									Détail
								</button><br/><br/>
								<input type="text" size="25" name="RAP_NUM" class="form-control" style="max-width:300px;"
								readonly value="<?php echo $nomPraticien; ?>" />

								<br/>
								<label>BILAN :</label><br/>
								<textarea rows="5" cols="50" name="MED_EFFETS" class="form-control" style="max-width:600px;" 
										readonly ><?php echo $donnees['RAP_BILAN']; ?></textarea>								
									<br/>
									<label>MOTIF :</label><br/>
																		<textarea rows="5" cols="50" name="MED_EFFETS" class="form-control" style="max-width:600px;" 
										readonly ><?php echo $donnees['RAP_MOTIF']; ?></textarea>
								
									<legend>Echantillons Ouvert</legend>
									<?php
$req4 = $bdd->query("SELECT * FROM offrir WHERE VIS_MATRICULE = '".$vist."' AND RAP_NUM= '".$rapport."'");
while ($donnees4 = $req4-> fetch()){
$medicament = $donnees4['MED_DEPOTLEGAL'];
$quantite = $donnees4['OFF_QTE'];
								?>
								<label class="titre" >PRODUIT : </label><br/>
								<input type="text" size="10" name="RAP_NUM" style="max-width:150px;float:left"
								value="<?php echo $medicament; ?>" class="form-control" readonly />
								<input type="text" size="5" name="RAP_NUM" style="max-width:150px;"
								value="<?php echo $quantite; ?>" class="form-control" readonly />
								<br/><br/>
								<?php
								}
								?>
							</div>
							<div class="piedForm">
							<p>
							<div class="zone">
							<?php
							$valide = false;
							$reqBtn = $bdd -> query("SELECT * FROM rapport_visite WHERE VIS_MATRICULE = '" . $vist . "' order by RAP_NUM");
							while ($donneesBtn = $reqBtn -> fetch()) {
								if ($valide == true) {
									$rapp = $donneesBtn['RAP_NUM'];
									$valide = false;
								}
								if ($donneesBtn['RAP_NUM'] == $rapport) {
									$valide = true;
								}
							}
							$valide = false;
							$reqBtn2 = $bdd -> query("SELECT * FROM rapport_visite WHERE VIS_MATRICULE = '" . $vist . "' order by RAP_NUM DESC");
							while ($donneesBtn2 = $reqBtn2 -> fetch()) {
								if ($valide == true) {
									$rapp2 = $donneesBtn2['RAP_NUM'];
									$valide = false;
								}
								if ($donneesBtn2['RAP_NUM'] == $rapport) {
									$valide = true;
								}
							}
							?>

							<?php
	if (isset($rapp2)) {
		echo "<a href='formRAPPORT_VISITE.php?rapport=$rapp2'>";
		echo "<input class='btn btn-primary btn-sm' type='button' value='Précédent'></input></a>";
	}
	if (isset($rapp)) {
		echo "<a href='formRAPPORT_VISITE.php?rapport=$rapp'>";
		echo "<input class='btn btn-primary btn-sm' type='button' value='Suivant'></input></a>";

	}
							?>
							<a href='menuCR.php'><input class="btn btn-danger btn-sm" type='button' value='Fermer' /></a>
							</div>
							</p>
							</div>
							<?php
							}
							?>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>

		<!--	Fenêtre Modal -->

		<!-- Button trigger modal -->

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Détail du praticien</h4>
					</div>
					<div class="modal-body">
						<!-- Corps Modal   -->
						<?php
						echo '<h4>' . $donnees2['PRA_NOM'] . " " . $donnees2['PRA_PRENOM'] . '</h4>';
						echo '<p> Adresse : ' . $donnees2['PRA_ADRESSE'] . '</p>';
						echo '<p> CP et Ville :' . $donnees2['PRA_CP'] . ' ' . $donnees2['PRA_VILLE'] . '</p>';
						echo '<p> Coefficient de notoriété :' . $donnees2['PRA_COEFNOTORIETE'] . '</p>';
						?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Fermer
						</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
</html>