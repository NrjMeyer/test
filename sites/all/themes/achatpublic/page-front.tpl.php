<?php
// $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
		<?php print $head ?>
		<title><?php print $head_title ?></title>
		<?php print $styles ?>
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/home.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/prettyPhoto.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/formulaire.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo base_path().path_to_theme() ?>/css/iconize.css" />
		<?php print $scripts ?>
		<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/jquery.cycle.home.js"></script>
		<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/home.js"></script>
		<script type="text/javascript" src="<?php echo base_path().path_to_theme() ?>/javascript/jquery.prettyPhoto.js"></script>
		<!--[if lt IE 7]>
		  <?php print phptemplate_get_ie_styles(); ?>
		<![endif]-->
	</head>
	<body<?php print phptemplate_body_class($left, $right); ?>>

		<div id="header-region" class="clear-block"><?php print $header; ?></div>
		
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
			
			<?php if ($leaderboard): ?>
				<div id="leaderboard">
					<div id="leaderboard_pics">
						<?php print $leaderboard ?>
					</div>
					<div id="leaderboard_nav">
						<a href="#" id="leaderboard_nav_prev"></a>
						<div id="leaderboard_nav_selec"></div>
						<a href="#" id="leaderboard_nav_next"></a>
					</div>	
				</div>
			<?php endif; ?>
			
			<div id="bloc_achat_public_info">
				<div id="bloc_achat_public_info_top">
					<!--<span class="ajd_sur">L'info du jour sur</span>-->
				<span class="ajd_sur">A la Une</span> 
                <img src="<?php echo base_path().path_to_theme() ?>/images/logo_achat_public_info_def.jpg" alt="" width="73" height="30" />		
                </div>
                
				<div id="bloc_achat_public_info_left">
		
             <img src="<?php echo base_path().path_to_theme() ?>/images/point_achat_public_info.png" alt="" /> 
					  <span class="titre_breves">L'info du jour</span>
                      <?php if ($flux_rss_info): ?>
					<?php print $flux_rss_info ?>				        
                        
					<?php endif; ?>
				</div>
					<div id="bloc_achat_public_info_right">
					<img src="<?php echo base_path().path_to_theme() ?>/images/point_achat_public_info.png" alt="" />
					<span class="titre_breves">Brèves</span>
					<?php if ($flux_rss_breve): ?>
						<?php print $flux_rss_breve ?>
					<?php endif; ?>
				</div>
			</div>
			<div id="bloc_actualites">
				<div class="bloc_actualites_top">
					<img src="<?php echo base_path().path_to_theme() ?>/images/point_actualites.png" alt="" /> 
					<span class="titre_actualites">Actualités</span>
				</div>
				<div class="actualites">
					<?php if ($actualite): ?>
						<?php print $actualite ?>
					<?php endif; ?>
					<div id="toutelactu">
						<a class="nonsouligne" href="/actualites"><span class="boutons_left"></span><span class="boutons_milieu">Toute l'actu</span><span class="boutons_right"></span></a>
					</div>
				</div>
			</div>
			<div id="bloc_salle_des_marches">
				<div id="bloc_salle_des_marches_acheteur">
					<div id="bloc_salle_des_marches_acheteur_top">
						<p class="bloc_salle_des_marches_acheteur_top"><b>Vous êtes un acheteur</b>
					</div>	
					<div id="bloc_salle_des_marches_acheteur_bottom"><b><a href="https://www.achatpublic.com/snglogin/do/back/accueil" target="_blank">Portail de l'achat public</a></b></div>
					<div id="bloc_salle_des_marches_acheteur_bottom"><b><a href="https://e-redac.achatpublic.com/e-redac/login/pageLogin.action" target="_blank">e-redac</a></b></div>
				</div>	
				<div id="bloc_salle_des_marches_entreprise">
					<div id="bloc_salle_des_marches_entreprise_top">
						<p class="bloc_salle_des_marches_entreprise_top"><b>Vous êtes une entreprise</b>
					</div>	
					<div id="bloc_salle_des_marches_entreprise_premium"><b><a href="https://www.achatpublic.com/sdm/ent/gen/index.do" target="_blank">Répondez aux consultations</a></b></div>
					<div id="bloc_salle_des_marches_entreprise_g"><div id="bloc_salle_des_marches_entreprise_bottom"><b><a href="https://www.achatpublic.com/actualites/soyez-visibles-par-les-acheteurs-publics" target="_blank">Référencez-vous</a></b></div>&nbsp;<div id="bloc_salle_des_marches_entreprise_bottom2"><b><a href="http://www.achatpublic.com/apc3/avis_pub.php" target="_blank">avis</a></b></div>	
					</div>
				</div>
			</div>
			<div id="footer">
				<div id="footer_top">
					<?php print $footer_message . $footer ?>
				</div>
				<div id="footer_bottom">
					<?php $node_accueil = node_load(44); ?>
					<?php print show_footer($node_accueil); ?>
				</div>
			</div>
		<?php print $closure ?>
		</div>
	</body>
</html>
