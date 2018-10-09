<?php
// $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
		<?php print $head ?>
		<title><?php print $head_title ?></title>
		<?php print $styles ?>
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/prettyPhoto.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/formulaire.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/iconize.css" />
		<?php print $scripts ?>
		<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/jquery.prettyPhoto.js"></script>
		<?php if(getenv('HTTP_HOST') == 'achatpublic-dev.com'): ?>
			<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAxSkLeKwHc1UpjajtYLH_4BTOgFTTzIE0jEnoTQHSo2oqiBWD9RTOVjLnqyQCQQJJSZHvJ0Pwsq7nLQ"></script>
		<?php elseif(getenv('HTTP_HOST') == 'achatpublic.reachthefirst.com'): ?>
			<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAxSkLeKwHc1UpjajtYLH_4BQdBFlOtW9i_22ySZfH-8GJLG6ovBS9wyViRvN2Vv1Id2AT_Z040mkmJA"></script>
		<?php elseif(getenv('HTTP_HOST') == 'achatpublic.irm-agency.biz'): ?>
			<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAxSkLeKwHc1UpjajtYLH_4BSjKGpoQZA7OTLU8RIAjNNSpPpsOxQoZtgoPCmFB-GQUyuYQ93KhRjLxw"></script>
		<?php else: ?>
			<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAxSkLeKwHc1UpjajtYLH_4BRGIXLzGwDoRCGGEJHpzIHYstGWSBT-r0pzj9R_uBI2dolE1mlwG7b2cg"></script>
		<?php endif; ?>
		<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/script.js"></script>
		<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/script_newsletter.js"></script>
		<?php if($_COOKIE['read_actualite'] != "1"): ?>
			<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/script_actualite.js"></script>
		<?php endif; ?>
		<!--[if lt IE 7]>
		  <?php print phptemplate_get_ie_styles(); ?>
		<![endif]-->
	</head>
	<body<?php print phptemplate_body_class($left, $right); ?>>

<!-- Layout -->
		<div id="global">
			<div id="header">
				<div id="header_left">
					<a href="/"><img src="<?php echo base_path().path_to_theme() ?>/images/logo_achat_public.png" alt="" /></a>
				</div>
				<div id="header_right">
					<a href="/contact"><img src="<?php echo base_path().path_to_theme() ?>/images/contact.png" alt=""/></a>
				</div>	
			</div>
			
			<div id="menu_nav">
				<?php if ($primary_links): ?>
					<?php print menu_tree($menu_name = 'primary-links'); ?>
				<?php endif; ?>
			</div>

			<div id="left" class="<?php echo($menu_class); ?>">
				<div id="left_top">
					<?php print $breadcrumb; ?>
				</div>
				<div id="left_centre">
					<?php if ($title): print '<h1>'; ?><?php if (!$node->field_sous_titre[0]['value']): print '<p style="margin-top:17px;">'; else: print '<p style="margin:5px 0 6px 0;">'; endif; ?> <?php print $title .'</p>'; endif; ?>
					<?php if ($node->field_sous_titre[0]['value']): print '<p style="margin:5px 0 6px 0;">'. $node->field_sous_titre[0]['value'] .'</p>'; endif; ?>
					<?php if ($title): print '</h1>'; endif; ?>
					<div class="pointilles"></div>
					<div class="contenu_generic">
						<?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
						<?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
						<?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
						<?php if ($show_messages && $messages): print $messages; endif; ?>
						<?php print $help; ?>
						<?php print $content ?>
						<div id="map_gmap"></div>
						<script type="text/javascript">
							google.load("maps", "2");
							google.setOnLoadCallback(initialize);
						</script>
						<div class="moyen_espace_bottom_pointilles"></div>
					</div>				
				</div>
				<div id="left_bottom"></div>
			</div>
			
			<div id="right" class="<?php echo($menu_class); ?>">
				<?php $blocs_right = array(); ?>
				<?php $blocs_right = display_right($node) ?>
				<?php foreach($blocs_right as $bloc): ?>
					<?php $load_bloc = node_load($bloc['nid']); ?>
					<?php if($load_bloc->type == 'bloc_navigation'): ?>
						<div id="bloc_navigation">
							<?php print $load_bloc->body; ?>
						</div>
					<?php elseif($load_bloc->type == 'bloc_statique'): ?>
						<?php if($load_bloc->nid == '46') : //newsletter ?>
							<div class="bloc_blanc">
								<div class="bloc_blanc_top"></div>
									<div class="bloc_blanc_centre">				
										<h2 class="titre_newsletter couleur_newsletter"><span class="espace"><img src="<?php echo base_path().path_to_theme() ?>/images/point_newsletter.png" alt="" /></span>Newsletter</h2>
										<div class="newsletter">
											<p><span class="noir_fonce2">Recevez chaque mois l'essentiel de l'actu </span><span style="color:#D51A18;font-weight:bold;">achatpublic.com</span></p>
										</div>
										<div class="boutons">
											<form name="newsletter" action="#" id="form_newsletter_before">
												<input type="text" value="Votre email" id="input_newsletter_right" /> <input type="submit" id="bouton_ok_newsletter" value="OK">
												<a href="#newsletter_form" id="show_newsletter_form_overlay" class="hide" rel="prettyPhoto"></a>
											</form>	
										</div>
									</div>	
								<div class="bloc_blanc_bottom"></div>
							</div>
						<?php elseif($load_bloc->nid == '47'): // actualites ?>
							<div class="bloc_blanc">
								<div class="bloc_blanc_top"></div>
								<div class="bloc_blanc_centre">
									<h2 class="actualite"><span class="espace"><img src="<?php echo base_path().path_to_theme() ?>/images/point_actualites.png" alt="" /></span>Actualités</h2>
									<?php print $right; ?>
									<div class="boutons">
										<a class="nonsouligne" href="/actualites">
											<span class="boutons_actualites_left"></span>
											<span class="boutons_actualites_milieu">Toute l'actu</span>
											<span class="boutons_actualites_right"></span>
										</a>
									</div>
								</div>
								<div class="bloc_blanc_bottom"></div>
							</div>
						<?php endif; ?>
					<?php elseif($load_bloc->type == 'bloc_libre'): ?>
						<div class="bloc_blanc">
							<div class="bloc_blanc_top"></div>
							<div class="bloc_blanc_centre">
								<?php if($load_bloc->field_bloc_titre_affiche[0]['value'] != ""): ?><h2 class="actualite"><span class="espace_petit_retrait_haut"><img src="<?php echo base_path().path_to_theme() ?>/images/point_actualites.png" alt="" /></span><?php print $load_bloc->field_bloc_titre_affiche[0]['value']; ?></h2><?php endif; ?>
								<?php print $load_bloc->body; ?>
							</div>
							<div class="bloc_blanc_bottom"></div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

			<div id="footer">
				<div id="footer_top">
					<?php print $footer_message . $footer ?>
				</div>
				<div id="footer_bottom">
					<?php print show_footer($node); ?>
				</div>
			</div>
		</div>
		<?php print $closure ?>
		<div id="newsletter_form" class="hide">
			<div class="contenu_generic overlay">
				<h1 class="actualite"><img src="<?php echo base_path().path_to_theme() ?>/images/point_actualites.png" alt="" title="" /> Inscription à la newsletter</h1>
				<div class="form_newsletter_visible">
					<div class="bouton_remplir_formulaire">
						<img src="<?php echo base_path().path_to_theme() ?>/images/bouton_remplir_formulaire.png" alt="" title="" />
					</div>	
					<div class="intro">
						<p>Pour recevoir la newsletter La dématérialisation facile par email et être informé de toutes les actualités,  il vous suffit de remplir le formulaire suivant.</p>
						<p class="obligatoire">* Les champs marqués d'une astérisque sont obligatoires.</p>
					</div>
					<?php print show_form_newsletter(); ?>
				</div>
				<div class="form_newsletter_result hide">
					<div class="intro">
						<p>Merci pour votre inscription à la newsletter La dématérialisation facile. Vous recevrez cette dernière par email chaque mois. Bonne lecture !</p>
					</div>
				</div>
			</div>
		</div>
		<div id="actualite_form" class="hide">
			<div class="contenu_generic overlay">
				<h1 class="actualite"><img src="<?php echo base_path().path_to_theme() ?>/images/point_actualites.png" alt="" title="" /> Accès à l'actualité</h1>
				<div class="form_actualite_visible">
					<div class="bouton_remplir_formulaire">
						<img src="<?php echo base_path().path_to_theme() ?>/images/bouton_remplir_formulaire.png" alt="" title="" />
					</div>	
					<div class="intro">
						<p>Pour accéder à l’information souhaitée, il vous suffit de remplir le formulaire suivant. Cette inscription ne vous sera demandée qu’une seule fois.  Après l’envoi du formulaire, vous pourrez  télécharger tous les documents répertoriés sur notre site et visualiser toute l'actualité.</p>
						<p class="obligatoire">* Les champs marqués d'une astérisque sont obligatoires.</p>
					</div>
					<?php print show_form_actualite(); ?>
				</div>
				<div class="form_actualite_result hide">
					<div class="intro">
						<p>Utilisez le lien qui suit pour charger la page souhaitée. Vous pouvez désormais télécharger tous les documents répertoriés sur notre site et visualiser toute l'actualité. Merci de l'intérêt que vous portez à achatpublic.com et bonne lecture.</p>
						<p class="url_return_actualite"></p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
