<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
		<head>
		<title>Rapport de Visite</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link href="bootstrap.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
			<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<img src="logo.jpg" id="logoGSB" alt="Laboratoire Galaxy-Swiss Bourdin" title="Laboratoire Galaxy-Swiss Bourdin" width="30%"/>
							<h1 class="text-center">Identification</h1>
						</div>
						<div class="modal-body">
							<form class="form col-md-12 center-block" action="verifConnection.php" Method="post">
								<div class="form-group">
									<input type="text" class="form-control input-lg" placeholder="Andre..." name="nom" required>
								</div>
								<div class="form-group">
									<input type="password" class="form-control input-lg" placeholder="jj-mmm-aaaa" name="mdp" required>
								</div>
								
								<div class="form-group">
									<label>Région :</label>
									<select  name="REG_NUM" class="form-control" >
										<?php 
											include('include/connexionBase.php');
											$req_region = $bdd->query("SELECT * FROM region order by REG_NOM asc");
											$donnees_region = $req_region-> fetch();
											while ($donnees_region = $req_region-> fetch()){ ?>
										<option  value="<?php echo $donnees_region['REG_CODE']; ?>">
											<?php echo $donnees_region['REG_NOM']; ?>
										</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<button class="btn btn-primary btn-lg btn-block">Valider</button>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<div class="col-md-12">
							</div>	
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>