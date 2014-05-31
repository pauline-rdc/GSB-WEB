<?php 
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom']; 
?>

<div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="lead">
					<?php      
						$recherche = $bdd->query('SELECT VIS_NOM,VIS_PRENOM from visiteur WHERE VIS_MATRICULE="'.$vis_matri_session.'"');
						$recherche = $recherche-> fetch();
						echo "<h2>".$recherche['VIS_NOM'] . " " . $recherche['VIS_PRENOM'] ."</h2>";
					?>
					<h3>Visiteur m&eacute;dical</h3>
				</p>
                <div class="list-group">
                    <a class="list-group-item active">Comptes-Rendus</a>
					<a class="list-group-item" href="formSAISIE.php" >Nouveaux</a>
					<a class="list-group-item" href="formRAPPORT_VISITE.php">Consulter</a>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" >Consulter</a>
					<a class="list-group-item" href="menuCR.php" >Accueil</a>
					<a class="list-group-item" href="formMEDICAMENT.php" >M&eacute;dicaments</a>
					<a class="list-group-item" href="formPRATICIEN.php" >Praticiens</a>
                    <a class="list-group-item" href="formVISITEUR.php" >Autres visiteurs</a>
                    <a class="list-group-item" href="deconnexion.php">Quitter</a>
                </div>
            </div>
        </div>

    </div>