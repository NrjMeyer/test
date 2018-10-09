<?php

$civilite = '';
$dematerialisation_facile = '';

if(isset($_POST)){
	extract($_POST);
}
if(isset($_GET)){
	extract($_GET);
}

if(trim($nom) != '' && trim($organisme) != '' && trim($telephone) != '' && trim($email) != '' && trim($cp) != ''){
	($prenom != "Prénom") ? $prenom = $prenom : $prenom = '';
	($fonction != "Fonction") ? $fonction = $fonction : $fonction = '';
	($adresse_1 != "Adresse 1") ? $adresse_1 = $adresse_1 : $adresse_1 = '';
	($adresse_2 != "Adresse 2") ? $adresse_2 = $adresse_2 : $adresse_2 = '';
	($ville != "Ville") ? $ville = $ville : $ville = '';
	($pays != "Pays") ? $pays = $pays : $pays = '';
	($fax != "Fax") ? $fax = $fax : $fax = '';
	if($hidden_type_form == 'newsletter'){
		$dematerialisation_facile = 'Oui';
	}
	else{
		($dematerialisation_facile != 0) ? $dematerialisation_facile = 'Oui' : $dematerialisation_facile = 'Non';
	}
	
	$dateFormulaire = date( 'd-m-Y H:i:s' );
	
	if($hidden_type_form == 'documentation'){
		$hidden_url_called = $hidden_url_called_documentation;
	}
	
	if($hidden_type_form == 'contact'){
		(isset($checkboxes_solutions["preparer"])) ? $preparer = "Oui" : $preparer = "Non";
		(isset($checkboxes_solutions["gerer"])) ? $gerer = "Oui" : $gerer = "Non";
		(isset($checkboxes_solutions["suivre"])) ? $suivre = "Oui" : $suivre = "Non";
		
		($checkbox_newsletter_acheteurs_publics == "1" || $checkbox_newsletter_entreprise == "1") ? $dematerialisation_facile = 'Oui' : $dematerialisation_facile = 'Non';
		
		(isset($checkboxes_sinformer["journal"])) ? $journal_sinformer = "Oui" : $journal_sinformer = "Non";
		(isset($checkboxes_sinformer["espace_pro"])) ? $journal_espace_pro = "Oui" : $journal_espace_pro = "Non";
		
		(isset($checkboxes_se_former["journal"])) ? $seformer_journal = "Oui" : $seformer_journal = "Non";
		
		(isset($checkboxes_entreprise["veille"])) ? $entp_veille = "Oui" : $entp_veille = "Non";
		(isset($checkboxes_entreprise["formations_cycles_experts"])) ? $entp_formations_cycles = "Oui" : $entp_formations_cycles = "Non";
		
		$message = ereg_replace("</?[^>]+>", "", addslashes($message));
		
		$insert = db_query('INSERT INTO {reach_all_forms}(type, date_formulaire, url_demande, civilite, nom, prenom, organisme, fonction, email, telephone, adresse_1, adresse_2, cp, ville, pays, fax, newsletter_dematerialisation_facile, solutions_preparer, solutions_gerer, solutions_suivre, sinformer_le_journal, sinformer_espace_pros, se_former_formations, entreprise_veille, entreprise_formations_cycle, message) VALUES("'.$hidden_type_form.'","'. $dateFormulaire .'", "' . $hidden_url_called . '", "' . $civilite . '", "' . $nom . '", "' . $prenom . '", "' . $organisme . '", "' . $fonction . '", "' . $email . '", "' . $telephone . '", "' . $adresse_1 . '", "' . $adresse_2 . '", "' . $cp . '", "' . $ville . '", "' . $pays . '", "' . $fax . '", "' . $dematerialisation_facile . '", "' . $preparer . '", "' . $gerer . '", "' . $suivre . '", "' . $journal_sinformer . '", "' . $journal_espace_pro . '", "' . $seformer_journal . '", "' . $entp_veille . '", "' . $entp_formations_cycles . '", "' . $message . '")');
	}
	else{
		$insert = db_query('INSERT INTO {reach_all_forms}(type, date_formulaire, url_demande, civilite, nom, prenom, organisme, fonction, email, telephone, adresse_1, adresse_2, cp, ville, pays, fax, newsletter_dematerialisation_facile) VALUES("'.$hidden_type_form.'","'. $dateFormulaire .'", "' . $hidden_url_called . '", "' . $civilite . '", "' . $nom . '", "' . $prenom . '", "' . $organisme . '", "' . $fonction . '", "' . $email . '", "' . $telephone . '", "' . $adresse_1 . '", "' . $adresse_2 . '", "' . $cp . '", "' . $ville . '", "' . $pays . '", "' . $fax . '", "' . $dematerialisation_facile . '")');
	}
	
	if($insert){
		if($hidden_type_form == "actualite"){
			$type_form = "actualités";
			$subject = "[AchatPublic.com] Un internaute a complété le formulaire Actualités";
		}
		elseif($hidden_type_form == "newsletter"){
			$type_form = "newsletter";
			$subject = "[AchatPublic.com] Un internaute a complété le formulaire Newsletter";
		}
		elseif($hidden_type_form == "documentation"){
			$type_form = "documentation";
			$subject = "[AchatPublic.com] Un internaute a complété le formulaire Documentation";
		}
		elseif($hidden_type_form == "contact"){
			$type_form = "contact";
			$subject = "[AchatPublic.com] Un internaute a complété le formulaire Contact";
		}
		$messageHTML = "<html><head><title>$subject</title></head><body>";
		$messageHTML .= "<p>Bonjour,</p><p>Un internaute a rempli le formulaire : $type_form";
		
		$messageHTML .= ".</p>";
		$messageHTML .= "<p>Voici les informations que l'internaute a saisi : </p>";
		$messageHTML .= "<table>";
		$messageHTML .= "<tr><td>Civilité : </td><td>".$civilite."</td></tr>";
		$messageHTML .= "<tr><td>Nom : </td><td>".$nom."</td></tr>";
		$messageHTML .= "<tr><td>Prénom : </td><td>".$prenom."</td></tr>";
		$messageHTML .= "<tr><td>Organisme : </td><td>".$organisme."</td></tr>";
		$messageHTML .= "<tr><td>Fonction : </td><td>".$fonction."</td></tr>";
		$messageHTML .= "<tr><td>Adresse email : </td><td>".$email."</td></tr>";
		$messageHTML .= "<tr><td>Téléphone : </td><td>".$telephone."</td></tr>";
		$messageHTML .= "<tr><td>Adresse 1 : </td><td>".$adresse_1."</td></tr>";
		$messageHTML .= "<tr><td>Adresse 2 : </td><td>".$adresse_2."</td></tr>";
		$messageHTML .= "<tr><td>Code Postal : </td><td>".$cp."</td></tr>";
		$messageHTML .= "<tr><td>Ville : </td><td>".$ville."</td></tr>";
		$messageHTML .= "<tr><td>Pays : </td><td>".$pays."</td></tr>";
		$messageHTML .= "<tr><td>Fax : </td><td>".$fax."</td></tr>";
		if($dematerialisation_facile == "Oui"){
			$messageHTML .= "<tr><td colspan=\"2\">Cet internaute souhaite recevoir la newsletter <strong>La dématérialisation facile</stong></td></tr>";
		}
		
		if($hidden_type_form == "contact"){
			$messageHTML .= "<tr><td>Préparer avec e-Rédac : rédaction des pièces de marchés publics : </td><td>".$preparer."</td></tr>";
			$messageHTML .= "<tr><td>Gérer avec la salle des marchés : Dématérialisation des procédures de marchés publics : </td><td>".$gerer."</td></tr>";
			$messageHTML .= "<tr><td>Suivre : Contrôle de légalité et Archivage à valeur probante : </td><td>".$suivre."</td></tr>";
			$messageHTML .= "<tr><td>Le journal achatpublic.info : </td><td>".$journal_sinformer."</td></tr>";
			$messageHTML .= "<tr><td>Espace pros : </td><td>".$journal_espace_pro."</td></tr>";
			$messageHTML .= "<tr><td>Formations pour les acheteurs publics : </td><td>".$seformer_journal."</td></tr>";
			$messageHTML .= "<tr><td>Veille sur les appels d'offres : </td><td>".$entp_veille."</td></tr>";
			$messageHTML .= "<tr><td>Formations Cycles Experts pour maximiser ses chances de remporter des marchés publics : </td><td>".$entp_formations_cycles."</td></tr>";
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
	  'to' => 'arnaud.pevrier@achatpublic.com',
	  'subject' => $subject,
	  'body' => $messageHTML,
	  'from' => 'contact@achatpublic.com',
	  'headers' => array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=UTF-8;', 'Content-Transfer-Encoding' => '8Bit' )

	);

	drupal_mail_send($message);
	
	$message2 = array(
	  'to' => 'arnaud.pevrier@achatpublic.com',
	  'subject' => $subject,
	  'body' => $messageHTML,
	  'from' => 'contact@achatpublic.com',
	  'headers' => array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=UTF-8;', 'Content-Transfer-Encoding' => '8Bit' )

	);

	drupal_mail_send($message2);

	$message3 = array(
	  'to' => 'arnaud.pevrier@achatpublic.com',
	  'subject' => $subject,
	  'body' => $messageHTML,
	  'from' => 'contact@achatpublic.com',
	  'headers' => array('MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=UTF-8;', 'Content-Transfer-Encoding' => '8Bit' )

	);

	drupal_mail_send($message3);
	
	$time = time()+ 60 * 60 * 24 * 365;
	
	if($hidden_type_form == "actualite"){
		setcookie("read_actualite", "1", $time , "/");
		echo('<a href="'.$hidden_url_called.'">Lien vers l\'actualité</a>');
	}
	elseif($hidden_type_form == "contact"){
		header('Location: /contact?valid=1');
	}
	elseif($hidden_type_form == "documentation"){
		setcookie("read_documentation", "1", $time , "/");
		echo('<a href="'.$hidden_url_called.'">Télécharger le document</a>');
	}
}

?>
