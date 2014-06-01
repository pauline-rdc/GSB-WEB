<?php
	session_start(); 
	if(empty($_SESSION)){ 
		header('location:Accueil.php'); 
	}
	$repInclude = './include/';
	 include ('include/top.php');
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom']; 
?>
<html>
	<head>
		<title>formulaire VISITEUR</title>
		<link href="boostrap.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>
		<?php  
			include('include/connexionBase.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php 
						include('include/menuVertical.php');
					?>
				</div>
				<div class="col-md-9" class="form col-md-12 center-block" >
					<div class="well bs-component">
						<div class="thumbnail">
							<h2>Autres visiteurs</h2>
						</div>
						<form name="formVISITEUR" method="post" action="formVISITEUR.php">
							<legend>Choisissez une région :</legend>
								<div>
									<select name="lstDept" class="form-control" style="max-width:300px;float:left;" >
										<option>Choisissez une région</option>
										<?php 
											$req = $bdd->query("SELECT * FROM region order by REG_NOM asc");
											while ($donnees = $req-> fetch()){?>
											<option  value="<?php echo $donnees['REG_CODE']; ?>" 
												<?php if ((isset($_POST['lstDept'])) && ($donnees['REG_NOM']==$_POST['lstDept'])) { ?> selected='selected'<?php } ?> >
												<?php	echo $donnees['REG_NOM'];?><br/>
											</option>
											<?php } ?>	
									</select>
										&nbsp; &nbsp; 
										<input type='submit' class="btn btn-primary btn-sm" value='Valider'  />
								</div>
								<br/>
								<?php 
								if (isset($_GET['visiteur'])) {		// si bouton suivant ou précédent sélectionné
										$visiteur=$_GET['visiteur'];
										$req = $bdd->query("SELECT * FROM visiteur WHERE COMPTEUR ='".$visiteur."'"); 
								}
								

								if(isset($_POST['lstDept'])) {		// si sélectionné une région 
									$ville = $_POST['lstDept'];?>
									<div>
										<select name="lstVisiteur" class="form-control" style="max-width:300px;float:left;" >
											<?php 
												$req = $bdd->query("SELECT * FROM travailler WHERE REG_CODE='".$ville."' order by VIS_MATRICULE	asc");
												while ($donnees = $req-> fetch()){
													echo $visite = $donnees['VIS_MATRICULE'];
													$req2 = $bdd->query("SELECT * FROM visiteur WHERE VIS_MATRICULE='".$visite."' order by VIS_NOM");
													while ($donnees1 = $req2-> fetch()){?>
														<option  value="<?php echo $donnees1['VIS_NOM'];  ?>"
															<?php if ((isset($_POST['lstVisiteur'])) && ($donnees1['VIS_NOM']==$_POST['lstVisiteur'])) { ?> 
																selected='selected'<?php } ?> >
															<?php echo $donnees1['VIS_NOM'];?>
														</option>
											<?php }} ?>
											
										</select>&nbsp; &nbsp; <input type='submit' value='Valider' class="btn btn-primary btn-sm"" /><br/><br/>
									</div>
								<?php 
								} 
								
								if(isset($_POST['lstVisiteur'])) {	// si selectionné un visiteur selon les régions
									$visiteur = $_POST['lstVisiteur'];
									$req = $bdd->query("SELECT * FROM visiteur WHERE VIS_NOM ='".$visiteur."'"); 
									
								}

								if ((isset($visiteur)) ){
									//affichage des donnes si visiteur existe
									$donnees = $req-> fetch();
									$compt=$donnees['VIS_MATRICULE'];
								?>
								<div>
									<fieldset>
										<legend>Informations</legend>
										<label>NOM :</label><br/>
											<input type="text" size="25" name="VIS_NOM" class="form-control" style="max-width:300px;float:left;" 
											readonly value="<?php echo $donnees['VIS_NOM']; ?>"/><br/><br/>
										<label>PRENOM :</label><br/>
											<input type="text" size="25" name="Vis_PRENOM" class="form-control" style="max-width:300px;float:left;" 
											readonly value="<?php echo $donnees['Vis_PRENOM']; ?>"/><br/><br/>
										<label>ADRESSE :</label><br/>
											<input type="text" size="35" name="VIS_ADRESSE" class="form-control" style="max-width:300px;float:left;" 
											readonly value="<?php echo $donnees['VIS_ADRESSE']; ?>"/><br/><br/>
										<label>CP :</label><br/>
											<input type="text" size="5" name="VIS_CP" class="form-control" style="max-width:80px;float:left;" 
											readonly value="<?php echo $donnees['VIS_CP']; ?>"/><br/><br/>
										<label>VILLE :</label><br/>
											<input type="text" size="30" name="VIS_VILLE" class="form-control" style="max-width:300px;float:left;" 
											readonly value="<?php echo $donnees['VIS_VILLE']; ?>"/><br/><br/>
										
										<?php 
											$sect = $bdd->query("SELECT SEC_LIBELLE FROM secteur WHERE  SEC_CODE= '".$donnees['SEC_CODE']."'");
											$donneesSect = $sect  -> fetch();
										?>	
											
										<label>SECTEUR :</label><br/>
											<input type="text" name="SEC_CODE" class="form-control" style="max-width:300px;float:left;" 
											readonly value="<?php echo $donneesSect['SEC_LIBELLE']; ?>"/>
										<br/><br/>
										
										<?php 
											$regions="";
											$regCode= $bdd->query("SELECT travailler.REG_CODE FROM travailler WHERE travailler.VIS_MATRICULE= '".$donnees['VIS_MATRICULE']."' ");
											while($donneesRegC = $regCode -> fetch()){
												$region = $bdd->query("SELECT * from region where region.REG_CODE='".$donneesRegC['REG_CODE']."'");
												$donneesReg = $region -> fetch();
												if ($regions==""){
													$regions=$donneesReg['REG_NOM'];
												}else{
													$regions.= "; ".$donneesReg['REG_NOM'];
												}
											}
											?>	
										<label>REGION:</label><br/>
											<textarea rows="5" cols="20" name="MED_CONTREINDIC" class="form-control" style="max-width:300px;max-height:75px;float:left;" 											
											readonly ><?php echo $regions; ?>
											</textarea><br/><br/>
										<br/>
										
										
										
									</fieldset>
								</div>
								
								<?php 
									$reqBtn = $bdd->query("SELECT * FROM travailler ORDER BY REG_CODE ASC");
									
									$valide=false;
									while ($donneesBtn = $reqBtn -> fetch()) {
										if ($valide == true) {
											$reqVis = $bdd->query("SELECT * FROM visiteur WHERE VIS_MATRICULE='".$donneesBtn['VIS_MATRICULE']."'");
												$donneesVis = $reqVis-> fetch();
												$visit2 = $donneesVis['compteur'];
											$valide = false;
										}
										if ($donneesBtn['VIS_MATRICULE'] ==$compt) {
											$valide = true;
										}
									}
									$reqBtn2 = $bdd->query("SELECT * FROM travailler ORDER BY REG_CODE DESC");
									while ($donneesBtn2 = $reqBtn2 -> fetch()) {
										if ($valide == true) {
											$reqVis2 = $bdd->query("SELECT * FROM visiteur WHERE VIS_MATRICULE='".$donneesBtn2['VIS_MATRICULE']."'");
												$donneesVis2 = $reqVis2-> fetch();
												$visit = $donneesVis2['compteur'];
											$valide = false;
										}
										if ($donneesBtn2['VIS_MATRICULE'] == $compt) {
											$valide = true;
										}
									}
							?>
								
								<div class="piedForm">
									<p>
										<div class="zone">
											<?php
												if (isset($visit2)){
													echo "<a href='formVISITEUR.php?visiteur=$visit2'>";
													echo "<input class='btn btn-primary btn-sm' type='button' value='Precedent' /></a>";
												}
												if (isset($visit)){
													echo "<a href='formVISITEUR.php?visiteur=$visit'>";
													echo "<input  class='btn btn-primary btn-sm'type='button' value='Suivant' /></a>";
												}
												echo "<a href='menuCR.php'><input class='btn btn-danger btn-sm zone'  type='button' value='Fermer' /></a>";
											?>
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
	</body>
</html>