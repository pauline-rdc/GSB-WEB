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
		<title>formulaire RESERVATION</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>	
	<body>
		<?php 
			include('include/connexionBase.php');
			$req = $bdd->query("SELECT * FROM reservation ORDER BY RES_CODE desc limit 0,1");
			$donnees = $req-> fetch();
			$resaNum = $donnees['RES_CODE']+1;
			 if (empty($resaNum)){
			 	$resaNum=1;
			 }
			$req_type= $bdd->query("SELECT * FROM hotel order by nom");
			$donnees_type = $req_type-> fetch();
					
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
							<h2> Remplissez les informations de votre réservation </h2>
						</div>
						<form  name="verifRESA" method="post" action="verifRESA.php">
							<label>Hotel: </label>
								<select  name="idHOTEL" class="form-control" style="max-width:400px;" >
								<?php while ($donnees_type = $req_type-> fetch()){ ?>
									<option  value="<?php echo $donnees_type['identifiant']; ?>">
										<?php echo $donnees_type['nom'];  ?>
									</option>
									<?php } ?>
								</select>
								<br/>
								<legend>Informations de la réservation :</legend>
								<label>NUMERO :</label><input type="text" size="10" name="resaNUM" class="form-control" style="max-width:80px;" 
										value="<?php echo $resaNum ?>" readonly/>
								<br/>
								<label>Date de début :</label><input type="date" size="10" name="dateDEBUT"  class="form-control" style="max-width:150px;" />
								<br/>
								<label>Date de fin :</label><input type="date" size="10" name="dateFIN"  class="form-control" style="max-width:150px;" />
								</br>
								<label>Nombre de personnes :</label>
									<input type="text" size="10" name="nbrePERSO" class="form-control" style="max-width:50px;"/><br>
								

							<div class="piedForm">
								<p>
								<br/>
								<label class="titre"></label>
								<div class="zone">
									<input  class='btn btn-primary btn-sm' type="reset" value="Annuler"></input>
									<input  class='btn btn-primary btn-sm' type="submit" value="Valider"></input>
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