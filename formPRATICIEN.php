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
		<title>formulaire PRATICIEN</title>
		<link href="boostrap.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language = "javascript">
			function chercher($pNumero) {  
				var xhr_object = null; 	    
				if(window.XMLHttpRequest) // Firefox 
					xhr_object = new XMLHttpRequest(); 
				else if(window.ActiveXObject) // Internet Explorer 
						xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
					else { // XMLHttpRequest non supporté par le navigateur 
						alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
						return; 
					}   
				//traitement à la réception des données
			   xhr_object.onreadystatechange = function() { 
				if(xhr_object.readyState == 4 && xhr_object.status == 200) { 
					 var formulaire = document.getElementById("formPraticien");
					formulaire.innerHTML=xhr_object.responseText;			} 
			   }
			   //communication vers le serveur
			   xhr_object.open("POST", "cherchePraticien.php", true); 
			   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
			   var data = "pratNum=" + $pNumero ;
			   xhr_object.send(data); 
			   
		   }
		</script>
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
						$req = $bdd->query("SELECT * FROM praticien ORDER BY PRA_NOM ASC");
						$donnees = $req-> fetch();
					?>
				</div>
				<div class="col-md-9" class="form col-md-12 center-block" >
					<div class="well bs-component">
						<div class="thumbnail">
							<h2>Praticiens</h2>
						</div>
						<form name="formListeRecherche"  method="post" action="formPRATICIEN.php" >
							<legend>Choisissez un praticien :</legend>
									<tr>
										<td>
											<select name="lstPrat" class="form-control" style="max-width:300px;float:left;" onSubmit="document.forms.formListeRecherche.submit()">
												<option>Choisissez un praticien</option>
													<?php 
														while ($donnees = $req-> fetch()){?>
														<option  value="<?php echo $donnees['PRA_NUM']; ?>" 
															<?php if ((isset($_POST['lstPrat'])) && ($donnees['PRA_NOM']==$_POST['lstPrat'])) { ?> selected='selected'<?php } ?> >
															<?php	echo $donnees['PRA_NOM'];?><br>
														</option>
													<?php
														} ;
													?>
											</select>
										</td>
										<td>
											<input type='submit' value='Valider' style="margin-top:8px;" />
										</td>
									</tr>
							<br><br>
							<?php
								if(isset($_GET['praticien'])) {
									$praticien=$_GET['praticien'];
								}else if(isset($_POST['lstPrat'])){
									$praticien=$_POST['lstPrat'];
								}	
								if (isset($praticien)){
									$afficherPraticien = $bdd->query("SELECT * FROM praticien WHERE PRA_NUM = $praticien");
									$donneesPra = $afficherPraticien -> fetch(); 
							?>
							
							
									<legend>Informations</legend>
								
										<label>NUMERO :</label><br/>
										<input type="text" class="form-control" style="max-width:80px;float:left;" 
										value="<?php echo $donneesPra['PRA_NUM']; ?>" readonly /><br/><br/>

										<label>NOM :</label><br/>
										<input type="text" class="form-control" style="max-width:300px;float:left;" 
										value="<?php echo $donneesPra['PRA_NOM']; ?>" readonly /><br/><br/>

										<label>PRENOM :</label><br/>
										<input type="text" class="form-control" style="max-width:300px;float:left;" 
										value="<?php echo $donneesPra['PRA_PRENOM']; ?>" readonly /><br/><br/>
									
										<label>ADRESSE :</label><br/>
										<input type="text" class="form-control" style="max-width:300px;float:left;" 
										value="<?php echo $donneesPra['PRA_ADRESSE']; ?>" readonly /><br/><br/>
								
										<label>VILLE :</label><br/>
										
											<input type="text" class="form-control" style="max-width:80px;float:left;" 
											value="<?php echo $donneesPra['PRA_CP'];?>" readonly />
											<input type="text" class="form-control" style="max-width:300px;float:left;" 
											value="<?php echo $donneesPra['PRA_VILLE'];  ?>" readonly /><br/><br/>
									
										<label>COEF. NOTORIETE :</label><br/>
										<input type="text" class="form-control" style="max-width:300px;float:left;" 
										value="<?php echo $donneesPra['PRA_COEFNOTORIETE']; ?>" readonly /><br/><br/>
										
									<?php 
										$type = $bdd->query("SELECT * FROM type_praticien WHERE  TYP_CODE= '".$donneesPra['TYP_CODE']."'");
										$donneesType = $type -> fetch();
									?>	
										<label>TYPE:</label><br/>
										<input type="text" class="form-control" style="max-width:300px;float:left;" 
										value="<?php echo $donneesType['TYP_LIBELLE']; ?>" readonly /><br/><br/>
										
										<label>LIEU </label><br/>
										<input type="text" class="form-control" style="max-width:300px;float:left;" 
										value="<?php echo $donneesType['TYP_LIEU']; ?>" readonly /><br/><br/>
							
							
							
							<?php 
									$reqBtn = $bdd->query("SELECT * FROM praticien ORDER BY PRA_NOM ASC");
									$valide=false;
									while ($donneesBtn = $reqBtn -> fetch()) {
										if ($valide == true) {
											$prat = $donneesBtn['PRA_NUM'];
											$valide = false;
										}
										if ($donneesBtn['PRA_NUM'] == $praticien) {
											$valide = true;
										}
									}
									$reqBtn2 = $bdd->query("SELECT * FROM praticien ORDER BY PRA_NOM DESC");
									while ($donneesBtn2 = $reqBtn2 -> fetch()) {
										if ($valide == true) {
											$prat2 = $donneesBtn2['PRA_NUM'];
											$valide = false;
										}
										if ($donneesBtn2['PRA_NUM'] == $praticien) {
											$valide = true;
										}
									}
							?>
								<div class="piedForm">
									<p>
									<div class="zone">
							<?php
								if (isset($prat2)){
									echo "<a href='formPRATICIEN.php?praticien=$prat2'>";
									echo "<input type='button' value='Precedent' /></a>";
								}
								if (isset($prat)){
									echo "<a href='formPRATICIEN.php?praticien=$prat'>";
									echo "<input type='button' value='Suivant' /></a>";
								}
								echo "<a href='menuCR.php'><input type='button' value='Fermer' /></a>";
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