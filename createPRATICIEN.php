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
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>	
	<body>
		<?php 
			include('include/connexionBase.php');
			$req = $bdd->query("SELECT * FROM praticien ORDER BY PRA_NUM desc limit 0,1");
			$donnees = $req-> fetch();
			$praNUM = $donnees['PRA_NUM']+1;
			
			$req_type= $bdd->query("SELECT * FROM type_praticien order by TYP_LIBELLE asc");
			$donnees_type = $req_type-> fetch();
						
			/*$req_produit = $bdd->query("SELECT * FROM medicament order by MED_NOMCOMMERCIAL asc");
			$donnees_produit = $req_produit-> fetch();*/
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
							<h2> Remplissez les informations du praticien </h2>
						</div>
						<form  name="createPRATICIEN" method="post" action="recupPRATICIEN.php">
							
								<legend>Informations</legend>
								<label>NUMERO :</label><input type="text" size="10" name="PRA_NUM" class="form-control" style="max-width:80px;" 
										value="<?php echo $praNUM ?>" readonly/>
								<br/>
								<label>Nom :</label>
									<input type="text" size="10" name="PRA_NOM" class="form-control" style="max-width:400px;"  />
								<label>Prénom :</label>
									<input type="text" size="10" name="PRA_PRENOM" class="form-control" style="max-width:400px;"/><br>
								<label>Adresse:</label>
									<input type="text" size="10" name="PRA_ADRESSE" class="form-control" style="max-width:400px;" /><br>
									<input type="text" size="10" name="PRA_CP" class="form-control" style="max-width:80px;float:left;"/>
									<input type="text" size="10" name="PRA_VILLE" class="form-control" style="max-width:320px;" /><BR/>
								<label>Type:</label>
								<select  name="TYP_CODE" class="form-control" style="max-width:400px;" >
								<?php while ($donnees_type = $req_type-> fetch()){ ?>
									<option  value="<?php echo $donnees_type['TYP_CODE']; ?>">
										<?php echo $donnees_type['TYP_LIBELLE']; echo " : "; echo $donnees_type['TYP_LIEU']; ?>
									</option>
									<?php } ?>
								</select>
								<br/>
								<label>Coefficient Notoriété:</label>
									<input type="text" size="10" name="PRA_COEF" class="form-control" style="max-width:80px;"/><BR/>

								
								<br/>
							
							<div class="piedForm">
								<p>
								<label class="titre" style="float:left;margin-left:10px;">SAISIE DEFINITIVE :</label>
								<input name="RAP_LOCK" style="float:left;" type="checkbox" class="zone" checked="false" />
								<br/>
								<label class="titre"></label>
								<div class="zone">
									<input type="reset" value="Annuler"></input>
									<input type="submit" value="Valider"></input>
								</div>
								</p>
							</div>
							
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>