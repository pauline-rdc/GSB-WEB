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
		<title>formulaire RAPPORT_VISITE</title>
		<link href="boostrap.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="javascript">
			  function checkbox(pSelection,  pObjet, pObjet2) {
			       if (formRAPPORT_VISITE.elements[pSelection].checked) {
					 	formRAPPORT_VISITE.elements[pObjet].disabled=false;
					 	formRAPPORT_VISITE.elements[pObjet2].disabled=true; 
					}
					else { 
						formRAPPORT_VISITE.elements[pObjet].disabled=true; 
						formRAPPORT_VISITE.elements[pObjet2].disabled=false; 
					}
			    }

			function ajoutLigne( pNumero){//ajoute une ligne de produits/qtité la div "lignes"   
				//masque le bouton en cours
				document.getElementById("but"+pNumero).setAttribute("hidden","true");	
				pNumero++;										//incrémente le num�ro de ligne
			
				var laDiv=document.getElementById("lignes");	//récupère l'objet DOM qui contient les donn�es
				//var leParagraphe=document.getElementById("paragraphe");	//récupère l'objet paragraphe qui contient les données
				
				var div=document.createElement("div");    // on crée le paragraphe
				var paragraphe=document.createElement("p");    // on crée le paragraphe
				//document.getElementById("lignes").appendChild(paragraphe);
				paragraphe.setAttribute("class","paragraphe");
				paragraphe.setAttribute("style","float:left;margin:0px;");
				div.appendChild(paragraphe);                 // ajout du paragraphe
				laDiv.appendChild(div);                 // ajout de la div
				
				var titre = document.createElement("label") ;	//crée un label
				paragraphe.appendChild(titre) ;						//l'ajoute à la DIV
				titre.setAttribute("class","titre") ;			//définit les propriétés
				titre.innerHTML= "   Produit : ";
				
				var liste = document.createElement("select");//ajoute une liste pour proposer les produits
				paragraphe.appendChild(liste) ;
				liste.setAttribute("name","PRA_ECH"+pNumero) ;
				liste.setAttribute("class","form-control");
				liste.setAttribute("style","min-width:300px;max-width:300px;margin:0px;");
				//remplit la liste avec les valeurs de la première liste construite en PHP à partir de la base
				liste.innerHTML=formRAPPORT_VISITE.elements["PRA_ECH1"].innerHTML;		
				var espace4 = document.createElement("br");
				div.appendChild(espace4);
				var qte = document.createElement("input");
				div.appendChild(qte);
				qte.setAttribute("name","PRA_QTE"+pNumero);
				qte.setAttribute("size","2"); 
				qte.setAttribute("class","zone");
				qte.setAttribute("style", "min-height:34px;min-width:80px;margin-top:4px;");
				qte.setAttribute("type","text");
			
				var bouton = document.createElement("input");
				div.appendChild(bouton);
				var espace = document.createElement("br");
				div.appendChild(espace) ;		
				var espace2 = document.createElement("br");
				div.appendChild(espace2) ;				
				
				//ajoute une gestion évenementielle en faisant évoluer le numéro de la ligne
				bouton.setAttribute("onClick","ajoutLigne("+ pNumero +");");
				bouton.setAttribute("type","button");
				bouton.setAttribute("value","+");
				bouton.setAttribute("class","zone");	
				bouton.setAttribute("id","but"+ pNumero);
			}
		</script>
	</head>	
	<body>
		<?php 
			include('include/connexionBase.php');
			$req = $bdd->query("SELECT * FROM rapport_visite ORDER BY RAP_NUM desc limit 0,1");
			$donnees = $req-> fetch();
			$rapport = $donnees['RAP_NUM']+1;
			
			$req_praticien = $bdd->query("SELECT * FROM praticien order by PRA_NOM asc");
			$donnees_praticien = $req_praticien-> fetch();
						
			$req_produit = $bdd->query("SELECT * FROM medicament order by MED_NOMCOMMERCIAL asc");
			$donnees_produit = $req_produit-> fetch();
			
			$req_motif = $bdd->query("SELECT * FROM motif order by MOT_LIBELLE asc");
			
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
							<h2> Remplissez votre rapport de visite </h2>
						</div>
						<form  name="formRAPPORT_VISITE" method="post" action="recupRAPPORT_VISITE.php">
							
								<legend>Informations</legend>
								<label>NUMERO :</label><input type="text" size="10" name="RAP_NUM" class="form-control" style="max-width:80px;" 
										value="<?php echo $rapport ?>" readonly/>
								<br/>
								<label>DATE VISITE :</label><input type="date" size="10" name="RAP_DATEVISITE"  class="form-control" style="max-width:150px;" />
								<br/>
								<label>PRATICIEN :</label>
								
								<select  name="PRA_NUM" class="form-control" style="max-width:300px;" >
								<?php while ($donnees_praticien = $req_praticien-> fetch()){ ?>
									<option  value="<?php echo $donnees_praticien['PRA_NOM']; ?>">
										<?php echo $donnees_praticien['PRA_NOM']; echo " "; echo $donnees_praticien['PRA_PRENOM']; ?>
									</option>
									<?php } ?>
								</select>
								<br/>
								
								
								<label>MOTIF :</label><select  name="RAP_MOTIF" class="form-control" style="max-width:300px;" >
								<?php while ($donnees_motif = $req_motif-> fetch()){ ?>
									<option  value="<?php echo $donnees_motif['MOT_LIBELLE']; ?>">
										<?php echo $donnees_motif['MOT_LIBELLE']; ?>
									</option>
									<?php } ?>
								</select>
								
								
								<div class="checkbox">
								    <label>
								      <input type="checkbox" id="checkb" name="AutreMotif"  onClick="checkbox('AutreMotif','RAP_MOTIFAUTRE', 'RAP_MOTIF');" >Autre motif :
								    </label>
								  </div>
								<input id="motif" type="text"  name="RAP_MOTIFAUTRE" class="form-control" style="max-width:300px;" disabled="disabled" />
								<br/>
								<label>BILAN :</label><textarea rows="5" cols="50" name="RAP_BILAN" class="form-control" style="min-width:60%;"></textarea><br/><br/>
								
								
								<legend>Echantillons</legend>
								<div class="titre" id="lignes">
								</p>
									<p class="paragraphe" id="paragraphe" style="float:left;margin:0px;">
										<label class="titre" >Produit : </label>
										<select name="PRA_ECH1" class="form-control" style="max-width:300px;width:300px;margin:0px;" >
											<option>Produits</option>
										<?php  while ($donnees_produit = $req_produit-> fetch()){?>
										<option style="min-width:600px;max-width:600px;" 
											value="<?php echo $donnees_produit['MED_NOMCOMMERCIAL']; ?>">
											<?php echo $donnees_produit['MED_NOMCOMMERCIAL']; ?>
										</option>
										<?php } ?>
										</select>
									</p>
									<br/>
									<input type="text" name="PRA_QTE1" size="2" class="zone" style="min-width:80px;max-width:80px;min-height:34px;margin-top:4px;"/>
									<input type="button" id="but1" value="+" onclick="ajoutLigne(1);" class="zone" /><br/><br/>
								</div>
								<br/>
							
							<div class="piedForm">
								<p>
								<label class="titre" style="float:left;margin-left:10px;">SAISIE DEFINITIVE :</label>
								<input name="RAP_LOCK" style="float:left;" type="checkbox" class="zone" checked="false" />
								<br/>
								<label class="titre"></label>
								<div class="zone">
									<input type="submit" class="btn btn-primary btn-sm" value="Valider"></input>
									<input type="reset" class="btn btn-danger btn-sm" value="Annuler"></input>
									
								</div>
								</p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>