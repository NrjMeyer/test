<?php

$civilite = '';
$news_acheteurs = '';
$secteur ='';

if(isset($_POST)){
	extract($_POST);
}
if(isset($_GET)){
	extract($_GET);
}

$trimNom = trim($nom);
$trimOrga = trim($organisme);
$trimTel = trim($telephone);
$trimMail = trim($email);
$trimCp=trim($cp);

if($trimNom != '' && $trimOrga != '' && $trimTel != '' && $trimMail != '' && $trimCp != ''){
	/*($prenom = "Prénom") ? $prenom = $prenom : $prenom = '';
	($fonction = "Fonction") ? $fonction = $fonction : $fonction = '';
	($adresse_1 = "Adresse 1") ? $adresse_1 = $adresse_1 : $adresse_1 = '';
	($ville = "Ville") ? $ville = $ville : $ville = '';*/
	if($hidden_type_form == 'newsletter'){
		$dematerialisation_facile = 'Oui';
	}
	else{
		($dematerialisation_facile = 0) ? $dematerialisation_facile = 'Oui' : $dematerialisation_facile = 'Non';
	}
	
	$dateFormulaire = date( 'd-m-Y H:i:s' );
	
	if($hidden_type_form == 'documentation'){
		$hidden_url_called = $hidden_url_called_documentation;
	}
	
	if($hidden_type_form == 'contact'){
		(isset($checkboxes_solutions["eredac"])) ? $eredac = "Oui" : $eredac = "Non";
		(isset($checkboxes_solutions["solutions"])) ? $solutions = "Oui" : $solutions = "Non";
		(isset($checkboxes_solutions["journal"])) ? $journal = "Oui" : $journal = "Non";
		(isset($checkboxes_solutions["formation"])) ? $formation = "Oui" : $formation = "Non";
		
		($checkbox_newsletter_acheteurs_publics == "1") ? $news_acheteurs = 'Oui' : $news_acheteurs = 'Non';

		$entp_veille = "";
		(isset($checkboxes_entreprise["formations_cycles_experts"])) ? $entp_formations_cycles = "Oui" : $entp_formations_cycles = "Non";
		(isset($checkboxes_entreprise["dematfacile"])) ? $dematerialisation_facile = "Oui" : $dematerialisation_facile = "Non";
		(isset($checkboxes_entreprise["sourcing"])) ? $sourcing = "Oui" : $sourcing = "Non";
		
		$message = ereg_replace("</?[^>]+>", "", addslashes($message));
		
		$insert = db_query('INSERT INTO {reach_all_forms}(type, date_formulaire, url_demande, civilite, nom, prenom, secteur, organisme, fonction, email, telephone, adresse_1, adresse_2, cp, ville, pays, fax, newsletter_dematerialisation_facile, solutions_preparer, solutions_gerer, solutions_suivre, sinformer_le_journal, sinformer_espace_pros, se_former_formations, entreprise_veille, entreprise_formations_cycle, message, news_acheteurs) VALUES("'.$hidden_type_form.'","'. $dateFormulaire .'", "' . $hidden_url_called . '", "' . $civilite . '", "' . $nom . '", "' . $prenom . '", "' . $secteur . '", "' . $organisme . '", "' . $fonction . '", "' . $email . '", "' . $telephone . '", "' . $adresse_1 . '", "' . $adresse_2 . '", "' . $cp . '", "' . $ville . '", "' . $pays . '", "' . $fax . '", "' . $dematerialisation_facile . '", "' . $eredac . '", "' . $solutions . '", "' . $sourcing . '", "' . $journal . '", "' . $journal_espace_pro . '", "' . $formation . '", "' . $entp_veille . '", "' . $entp_formations_cycles . '", "' . $message . '", "' . $news_acheteurs . '")');
	}
	else{
		$insert = db_query('INSERT INTO {reach_all_forms}(type, date_formulaire, url_demande, civilite, nom, prenom, secteur, organisme, fonction, email, telephone, adresse_1, adresse_2, cp, ville, pays, fax, newsletter_dematerialisation_facile, news_acheteurs) VALUES("'.$hidden_type_form.'","'. $dateFormulaire .'", "' . $hidden_url_called . '", "' . $civilite . '", "' . $nom . '", "' . $prenom . '", "' . $secteur . '", "' . $organisme . '", "' . $fonction . '", "' . $email . '", "' . $telephone . '", "' . $adresse_1 . '", "' . $adresse_2 . '", "' . $cp . '", "' . $ville . '", "' . $pays . '", "' . $fax . '", "' . $dematerialisation_facile . '", "' . $news_acheteurs . '")');
	}
	
	if($insert){
		if($hidden_type_form == "actualite"){
			$type_form = "actualités";
			$subject = "[AchatPublic.com] Site Corporate : Un internaute a complété le formulaire Actualités";
		}
		elseif($hidden_type_form == "newsletter"){
			$type_form = "newsletter";
			$subject = "[AchatPublic.com] Site Corporate : Un internaute a complété le formulaire Newsletter";
		}
		elseif($hidden_type_form == "documentation"){
			$type_form = "documentation";
			$subject = "[AchatPublic.com] Site Corporate : Un internaute a complété le formulaire Documentation";
		}
		elseif($hidden_type_form == "contact"){
			$type_form = "contact";
			$subject = "[AchatPublic.com] Site Corporate : Un internaute a complete le formulaire Contact";
		}
		$messageHTML = "<html><head><title>$subject</title></head><body>";
		$messageHTML .= "<p>Bonjour,</p><p>Un internaute a rempli le formulaire : $type_form";
		
		$messageHTML .= ".</p>";
		$messageHTML .= "<p>Voici les informations que l'internaute a saisi : </p>";
		$messageHTML .= "<table>";
		$messageHTML .= "<tr><td>Civilité : </td><td>".$civilite."</td></tr>";
		$messageHTML .= "<tr><td>Nom : </td><td>".$nom."</td></tr>";
		$messageHTML .= "<tr><td>Prénom : </td><td>".$prenom."</td></tr>";
		$messageHTML .= "<tr><td>Secteur : </td><td>".$secteur."</td></tr>";
		$messageHTML .= "<tr><td>Organisme : </td><td>".$organisme."</td></tr>";
		$messageHTML .= "<tr><td>Fonction : </td><td>".$fonction."</td></tr>";
		$messageHTML .= "<tr><td>Adresse email : </td><td>".$email."</td></tr>";
		$messageHTML .= "<tr><td>Téléphone : </td><td>".$telephone."</td></tr>";
		$messageHTML .= "<tr><td>Adresse 1 : </td><td>".$adresse_1."</td></tr>";
		$messageHTML .= "<tr><td>Code Postal : </td><td>".$cp."</td></tr>";
		$messageHTML .= "<tr><td>Ville : </td><td>".$ville."</td></tr><br>";
		
		if($hidden_type_form == "contact"){
			$messageHTML .= "<tr><td>Acheteurs publics: </td><td></td></tr>";
			$messageHTML .= "<tr><td>Solution e-redac pour rédiger vos pièces de marchés : </td><td>".$eredac."</td></tr>";
			$messageHTML .= "<tr><td>Les solutions de l’achat public de la dématérialisation au suivi d’exécution : </td><td>".$solutions."</td></tr>";
			$messageHTML .= "<tr><td>Le journal achatpublic.info: l’actualité de la commande publique : </td><td>".$journal."</td></tr>";
			$messageHTML .= "<tr><td>Formations marchés publics : </td><td>".$formation."</td></tr>";
			$messageHTML .= "<tr><td>Recevoir la Newsletter achatpublic.com : </td><td>".$news_acheteurs."</td></tr>";
			$messageHTML .= "<tr><td>Entreprises : </td><td></td></tr>";
			$messageHTML .= "<tr><td>Formations pour les entreprises souhaitant remporter des appels d’offres : </td><td>".$entp_formations_cycles."</td></tr>";
			$messageHTML .= "<tr><td>Solution de sourcing pour être visible auprès des acheteurs publics : </td><td>".$sourcing."</td></tr>";
			$messageHTML .= "<tr><td>Recevoir la Newsletter La dématérialisation facile : </td><td>".$dematerialisation_facile."</td></tr><br>";
		}
		elseif($hidden_type_form == "documentation"){
			$arrayFichier = explode('/', $hidden_url_called);
			$nameFichier = $arrayFichier[5];
			$messageHTML .= "<tr><td>Document téléchargé </td><td>".$nameFichier."</td></tr>";
		}
		if(strlen($message) > 1){
			$messageHTML .= "<tr><td>Cet internaute vous a laissé un message :  </td><td>".stripslashes($message)."</td></tr>";
		}
		
		$messageHTML .= "</table></body></html>";
	}
	
	$message = array(
	  'to' => 'contact@achatpublic.com',
	  'subject' => $subject,
	  'body' => $messageHTML,
	  'from' => 'contact@achatpublic.com',
	  'headers' => array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=UTF-8;', 'Content-Transfer-Encoding' => '8Bit' )
	);
	
	drupal_mail_send($message);
	$headers = 'From: contact@achatpublic.com' . "\r\n" .
     'Reply-To: contact@achatpublic.com' . "\r\n" ;
	$headers .='Content-Type: text/html; charset="utf-8"'."\r\n"; 
	$headers .='Content-Transfer-Encoding: 8bit';
	mail('contact@achatpublic.com', $subject, $messageHTML, $headers);
	
	$time = time()+ 60 * 60 * 24 * 365;
	
	if($hidden_type_form == "actualite"){
		setcookie("read_actualite", "1", $time , "/");
		echo('<a href="'.$hidden_url_called.'">Lien vers l\'actualité</a>');
	}
	elseif($hidden_type_form == "contact"){
		header('Location:/contact?valid=1');
	}
	elseif($hidden_type_form == "documentation"){
		setcookie("read_documentation", "1", $time , "/");
		echo('<a href="'.$hidden_url_called.'">Télécharger le document</a>');
	}
}
?>
