<?php 
	session_start();

    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom']; 

  include ('include/top.php');
  
  	$repInclude = './include/'; 
	include('include/connexionBase.php');
	$recherche = $bdd->query('SELECT VIS_NOM,VIS_PRENOM from visiteur WHERE VIS_MATRICULE="'.$vis_matri_session.'"');
		$recherche = $recherche-> fetch();
?>

	<div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="lead">
					<?php      
						echo "<h2>".$recherche['VIS_NOM'] . " " . $recherche['VIS_PRENOM'] ."</h2>";
					?>
					<h3>Visiteur médical</h3>
				</p>
                <div class="list-group">
                    <a class="list-group-item active">Accueil</a>
					<a class="list-group-item" href="formSAISIE.php">Saisie</a>
					<a class="list-group-item" href="formRAPPORT_VISITE.php">Rapports</a>
                    <a class="list-group-item" href="formMEDICAMENT.php">Médicaments</a>
                    <a class="list-group-item" href="formPRATICIEN.php">Praticiens</a>
                    <a class="list-group-item" href="formVISITEUR.php">Autres visiteurs</a>
                    <a class="list-group-item" href="deconnexion.php">Quitter</a>
                </div>
            </div>
			<div class="col-md-9">
				<div class="well bs-component" style="min-height:400px;">
					<div class="thumbnail">
						<h2>Bienvenue sur l'intranet GSB</h2>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
</body>
</html>