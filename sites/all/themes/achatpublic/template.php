<?php
	// $Id: template.php,v 1.16.2.3 2010/05/11 09:41:22 goba Exp $

	/**
	 * Sets the body-tag class attribute.
	 *
	 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
	 */
	function phptemplate_body_class($left, $right) {
	  if ($left != '' && $right != '') {
		$class = 'sidebars';
	  }
	  else {
		if ($left != '') {
		  $class = 'sidebar-left';
		}
		if ($right != '') {
		  $class = 'sidebar-right';
		}
	  }

	  if (isset($class)) {
		print ' class="'. $class .'"';
	  }
	}

	/**
	 * Return a themed breadcrumb trail.
	 *
	 * @param $breadcrumb
	 *   An array containing the breadcrumb links.
	 * @return a string containing the breadcrumb output.
	 */
	function phptemplate_breadcrumb($breadcrumb) {
	  if (!empty($breadcrumb)) {
		return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
	  }
	}

	/**
	 * Override or insert PHPTemplate variables into the templates.
	 */
	function phptemplate_preprocess_page(&$vars) {
		$vars['tabs2'] = menu_secondary_local_tasks();

		// Hook into color.module
		if (module_exists('color')) {
			_color_page_alter($vars);
		}
	  
		if ( arg(0) == 'node' && is_numeric(arg(1)) ) {
					   $vars['node_id'] = arg(1);
		}
		//ou
		// $node = menu_get_object();
		// if ( !empty($node) ) {
					   // $vars['node_object'] = $node;
		// }
		
		$menu_in_process = menu_get_active_trail();
		$parent_menu_id = substr($menu_in_process[1]['href'], 5);
		$vars['menu_class'] = "";
		switch($parent_menu_id){
			case 4:{
				$vars['menu_class'] = "achat_public";
			} break;
			case 5:{
				$vars['menu_class'] = "se_former";
			} break;
			case 6:{
				$vars['menu_class'] = "s_informer";
			} break;
		}
		
		
		switch($vars['node_id']){
			case 12:{
				//$vars['menu_class'] = "references";
				$vars['menu_class'] = "achat_public";
			} break;
			case 11:{
				$vars['menu_class'] = "societe";
			} break;
		}
		
		
	}

	/**
	 * Add a "Comments" heading above comments except on forum pages.
	 */
	function garland_preprocess_comment_wrapper(&$vars) {
	  if ($vars['content'] && $vars['node']->type != 'forum') {
		$vars['content'] = '<h2 class="comments">'. t('Comments') .'</h2>'.  $vars['content'];
	  }
	}

	/**
	 * Returns the rendered local tasks. The default implementation renders
	 * them as tabs. Overridden to split the secondary tasks.
	 *
	 * @ingroup themeable
	 */
	function phptemplate_menu_local_tasks() {
	  return menu_primary_local_tasks();
	}

	/**
	 * Returns the themed submitted-by string for the comment.
	 */
	function phptemplate_comment_submitted($comment) {
	  return t('!datetime — !username',
		array(
		  '!username' => theme('username', $comment),
		  '!datetime' => format_date($comment->timestamp)
		));
	}

	/**
	 * Returns the themed submitted-by string for the node.
	 */
	function phptemplate_node_submitted($node) {
	  return t('!datetime — !username',
		array(
		  '!username' => theme('username', $node),
		  '!datetime' => format_date($node->created),
		));
	}

	/**
	 * Generates IE CSS links for LTR and RTL languages.
	 */
	function phptemplate_get_ie_styles() {
	  global $language;

	  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
	  if ($language->direction == LANGUAGE_RTL) {
		$iecss .= '<style type="text/css" media="all">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
	  }

	  return $iecss;
	}

	function achatpublic_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
		$class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
		if (!empty($extra_class)) {
			$class .= ' '. $extra_class;
		}
		if ($in_active_trail) {
			$class .= ' active-trail on';
		}

		if($link['menu_name'] == 'primary-links'){
			$class .= ' ' . str_replace('/', '_', $link['link_path']);
			$link = l($link['title'], $link['href'], $link['localized_options']);
		}
		
		if($has_children){
			return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
		}
		else{
			return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
		}	
	}

	function achatpublic_menu_tree($tree) {
	  return '<div class="top"><ul class="menu">'. $tree .'</ul></div>';
	}

	function achatpublic_menu_item_link($link) {
		if (empty($link['localized_options'])) {
			$link['localized_options'] = array();
		}
		
		if($link['external'] == 1){
			$link['localized_options']['attributes']['target'] = "_blank";
		}
		
		$link['localized_options']['attributes']['title'] = "";
		
		if($link['menu_name'] == 'primary-links'){
			return $link;
		}
		else{
			return l($link['title'], $link['href'], $link['localized_options']);
		}
	}

	function achatpublic_breadcrumb($breadcrumb) {
	  if (!empty($breadcrumb)) {
		return '<p class="compas">'. implode(' » ', $breadcrumb) .'</p>';
	  }
	}

	function achatpublic_image_attach_attached_images($nid, $image_nodes = array(), $options = array()) {
	  // Merge in defaults.
	  $options += array(
		'size' => IMAGE_THUMBNAIL,
		'link' => 'image',
	  );

	  $img_size = $options['size'];
	  $link_destination = $options['link'];

	  // Link images to the attaching node.
	  if ($link_destination == 'node') {
		$link_path = "node/$nid";
	  }

	  $output = '';
	  foreach ($image_nodes as $image) {
		if (!node_access('view', $image)) {
		  // If the image is restricted, don't show it as an attachment.
		  continue;
		}

		// Link images to the image node.
		if ($link_destination == 'image') {
		  $link_path = "node/$image->nid";
		}

		// Get a fresh copy of the attributes for each image node.
		$div_attributes = $options['attributes'];

		// Create CSS classes, beginning with those passed in to the function.
		$classes = array();
		if (isset($div_attributes['class'])) {
		  $classes[] = $div_attributes['class'];
		}
		// replace with base class in DIV
		//$classes[] = 'image-attach-' . $teaser_or_body;
		$classes[] = 'image-attach-node-' . $image->nid;
		if (!$image->status) {
		  $classes[] = 'image-unpublished';
		}
		$div_attributes['class'] = implode(' ', $classes);

		// Add the width as inline CSS.
		$info = image_get_info(file_create_path($image->images[$img_size]));
		if (!isset($div_attributes['style'])) {
		  $div_attributes['style'] = '';
		}
		// $div_attributes['style'] .= 'width: ' . $info['width'] . 'px;';

		$output .= '<div' . drupal_attributes($div_attributes) . '>';
		$image_img = image_display($image, $img_size);
		if ($link_path) {
		  $output .= l($image_img, $link_path, array('html' => TRUE));
		}
		else {
		  $output .= $image_img;
		}
		$output .= "</div>\n";
	  }

	  return $output;
	}

	function achatpublic_aggregator_block_item($item, $feed = 0) {
	  global $user;

	  $output = '';
	  if ($user->uid && module_exists('blog') && user_access('create blog entries')) {
		if ($image = theme('image', 'misc/blog.png', t('blog it'), t('blog it'))) {
		  $output .= '<div class="icon">'. l($image, 'node/add/blog', array('attributes' => array('title' => t('Comment on this news item in your personal blog.'), 'class' => 'blog-it'), 'query' => "iid=$item->iid", 'html' => TRUE)) .'</div>';
		}
	  }
	  // Display the external link to the item.
		if($feed == 2){
			$val = substr($item->title,0, 115);
			if(strlen($item->title)>115) $points_suspensions= "...";
			$output .= '<span class="date">' . date( 'd/m', $item->timestamp) . '</span><a href="'. check_url($item->link) .'" target="_blank">'. trim($val) . $points_suspensions .'</a>';
		}

	
	if($feed == 3){
		//elseif($feed == 1 || $feed == 3){
			// $output .= '<span class="date">' . date( 'd/m', $item->timestamp) . '</span>'. check_plain($item->title) .' <p class="lirelasuite"><a href="'. check_url($item->link) .'" target="_blank" class="nonsouligne"><span class="boutons_left"></span><span class="boutons_milieu">Lire la suite</span><span class="boutons_right"></span></a></p>';
			$countTitle = strlen(strip_tags(html_entity_decode($item->title)));
			if($countTitle > 70){
				$texte = "<span>" . substr(strip_tags(html_entity_decode($item->title)), 0, 70) . " ...</span>";
			}
			else{
				if($item->description){
					$texteDescription = strip_tags(html_entity_decode($item->description));
					$texteDescription = substr($texteDescription, 0, 70-$countTitle);
					$texte = "<span>" . strip_tags(html_entity_decode($item->title)) . "</span><br />" . $texteDescription . "...";
				}
				else{
					$texte = "<span>" . strip_tags(html_entity_decode($item->title)) . "</span>";
				}
			}
			
			$linkItem = $item->link;
				
			if($feed == 3){
				$titleLinkFeed1 = html_entity_decode($item->title);
				$dom = new DOMDocument;
				$dom->loadHTML($titleLinkFeed1);
				
				foreach ($dom->getElementsByTagName('a') as $node) {
					if($node->hasAttribute( 'href' )){
						$getHrefNode = $node->getAttribute( 'href' );
						if($getHrefNode[0] == "/" && $linkItem[strlen($linkItem) -1] == "/"){
							$getHrefNode = substr($getHrefNode, 1);
						}
						
						$linkItem .= $getHrefNode;
						break;
					}
				}
			}
			
			$output .= '<span class="date">' . date( 'd/m', $item->timestamp) . '</span><a href="'. check_url($linkItem) .'" target="_blank">'. trim($texte).'</a>';
		}
		
		
		elseif($feed == 1){
		//elseif($feed == 1 || $feed == 3){
			// $output .= '<span class="date">' . date( 'd/m', $item->timestamp) . '</span>'. check_plain($item->title) .' <p class="lirelasuite"><a href="'. check_url($item->link) .'" target="_blank" class="nonsouligne"><span class="boutons_left"></span><span class="boutons_milieu">Lire la suite</span><span class="boutons_right"></span></a></p>';
			$countTitle = strlen(strip_tags(html_entity_decode($item->title)));
			if($countTitle > 320){
				$texte = "<span>" . substr(strip_tags(html_entity_decode($item->title)), 0, 320) . " ...</span>";
			}
			else{
				if($item->description){
					$texteDescription = strip_tags(html_entity_decode($item->description));
					$texteDescription = substr($texteDescription, 0, 320-$countTitle);
					$texte = "<span>" . strip_tags(html_entity_decode($item->title)) . "</span><br />" . $texteDescription . "...";
				}
				else{
					$texte = "<span>" . strip_tags(html_entity_decode($item->title)) . "</span>";
				}
			}
			
			$linkItem = $item->link;
			
			if($feed == 1){
				$titleLinkFeed1 = html_entity_decode($item->title);
				$dom = new DOMDocument;
				$dom->loadHTML($titleLinkFeed1);
				
				foreach ($dom->getElementsByTagName('a') as $node) {
					if($node->hasAttribute( 'href' )){
						$getHrefNode = $node->getAttribute( 'href' );
						if($getHrefNode[0] == "/" && $linkItem[strlen($linkItem) -1] == "/"){
							$getHrefNode = substr($getHrefNode, 1);
						}
						
						$linkItem .= $getHrefNode;
						break;
					}
				}
			}
			
			$output .= '<span class="date">' . date( 'd/m', $item->timestamp) . '</span><a href="'. check_url($linkItem) .'" target="_blank">'. trim($texte).'</a>';
		}
	//	else{
			//$output .= '<a href="'. check_url($item->link) .'" target="_blank">'. check_plain($item->title) ."</a>\n";
		//}
		
		return $output;
	}

	function achatpublic_more_link($url, $title) {
		if(strpos($url, 'aggregator/sources/') === false){
			return '<div class="more-link">'. t('<a href="@link" title="@title">more</a>', array('@link' => check_url($url), '@title' => $title)) .'</div>';
		}
	}

	function show_footer($node_footer){
		if($node_footer->field_footer[0]['value']){
			return $node_footer->field_footer[0]['value'];
		}
		
		$parent_niv1 = menu_get_active_trail();
		$node_parent_niv1 = node_load(substr($parent_niv1[1]['href'], 5));
		
		if($node_parent_niv1->field_footer[0]['value']){
			return $node_parent_niv1->field_footer[0]['value'];
		}
		
		$node_accueil = node_load(44);
		if($node_accueil->field_footer[0]['value']){
			return $node_accueil->field_footer[0]['value'];
		}
	}

	function display_right($node_right){
		if(arg(0) == 'node' && is_numeric(arg(1))){
			$node_en_cours = arg(1);
		}
		$menu_in_process = menu_get_active_trail();
		$parent_menu_id = substr($menu_in_process[1]['href'], 5);
			
		$array_blocs = return_gestion_blocs($parent_menu_id, $node_en_cours);
		
		if(!$array_blocs){
			$array_blocs_nic1 = return_gestion_blocs($parent_menu_id);
			
			if(!$array_blocs_nic1){
				$gestion_bloc_default = node_load(48);
				return $gestion_bloc_default->field_affichage_blocs;
			}
			else{
				return $array_blocs_nic1;
			}
		}
		else{
			return $array_blocs;
		}
	}

	function return_gestion_blocs($parent, $fils = 0){
		$menu_global = menu_tree_page_data('primary-links');
		$items_menu = array();
		
		foreach ($menu_global as $data) {
			if (!$data['link']['hidden']) {
				$items_menu[] = $data;
			}
		}
		
		foreach($items_menu as $item){
			if($item['below'] && substr($item['link']['link_path'], 5) == $parent){
				foreach($item['below'] as $item_below){
					if($fils != 0){
						if($item_below['below'] && substr($item_below['link']['link_path'], 5) == $fils){
							foreach($item_below['below'] as $subitem_below){
								$subnode_below = node_load(substr($subitem_below['link']['link_path'], 5));
								if($subnode_below->type == 'gestion_blocs'){
									return $subnode_below->field_affichage_blocs;
								}
							}
						}
					}
					else
					{
						$node_below = node_load(substr($item_below['link']['link_path'], 5));
						if($node_below->type == 'gestion_blocs'){
							return $node_below->field_affichage_blocs;
						}
					}
				}
			}
		}
	}

	function achatpublic_site_map_box($title, $content, $class = '') {
	  $output = '';
	  if ($title || $content) {
		$class = $class ? 'site-map-box '. $class : 'site-map-box';
		$output .= '<div class="'. $class .'">';
		if ($content) {
		  $output .= '<div class="content">'. $content .'</div>';
		}
		$output .= '</div>';
	  }

	  return $output;
	}
	
	function achatpublic_site_map_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
	  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
	  if (!empty($extra_class)) {
		$class .= ' '. $extra_class;
	  }
	  if ($in_active_trail) {
		$class .= ' active-trail';
	  }
	  if(is_array($link)){
		$link = l($link['title'], $link['href']);
	  }
	  
	  return '<li class="'. $class .'">'. $link . $menu ."</li>\n";
	}
	
	function achatpublic_radio($element) {
		_form_set_class($element, array('form-radio'));
		$output = '<input type="radio" ';
		$output .= 'id="'. $element['#id'] .'" ';
		$output .= 'name="'. $element['#name'] .'" ';
		$output .= 'value="'. $element['#return_value'] .'" ';
		$output .= (check_plain($element['#value']) == $element['#return_value']) ? ' checked="checked" ' : ' ';
		$output .= drupal_attributes($element['#attributes']) .' />';
		if (!is_null($element['#title'])) {
			$output = '<label class="option" for="'. $element['#id'] .'">'. $output .' '. $element['#title'] .'</label>';
		}

		unset($element['#title']);
		return theme('form_element', $element, $output);
	}

	function achatpublic_form($element) {
		$action = $element['#action'] ? 'action="'. check_url($element['#action']) .'" ' : '';
		return '<form '. $action .' accept-charset="UTF-8" method="'. $element['#method'] .'" id="'. $element['#id'] .'"'. drupal_attributes($element['#attributes']) .">\n<div class=\"content_form\">". $element['#children'] ."\n</div></form>\n";
	}
	
	function achatpublic_textfield($element) {
		$size = empty($element['#size']) ? '' : ' size="'. $element['#size'] .'"';
		$maxlength = empty($element['#maxlength']) ? '' : ' maxlength="'. $element['#maxlength'] .'"';
		$class = array('form-text');
		$extra = '';
		$output = '';
		$value = '';
	
		if ($element['#autocomplete_path'] && menu_valid_path(array('link_path' => $element['#autocomplete_path']))) {
			drupal_add_js('misc/autocomplete.js');
			$class[] = 'form-autocomplete';
			$extra =  '<input class="autocomplete" type="hidden" id="'. $element['#id'] .'-autocomplete" value="'. check_url(url($element['#autocomplete_path'], array('absolute' => TRUE))) .'" disabled="disabled" />';
		}
		_form_set_class($element, $class);

		if (isset($element['#field_prefix'])) {
			$output .= '<span class="field-prefix">'. $element['#field_prefix'] .'</span> ';
		}

		if($element['#name'] == 'nom' || $element['#name'] == 'organisme' || $element['#name'] == 'email' || $element['#name'] == 'telephone' || $element['#name'] == 'cp'){
			if(count(trim($element['#value'])) > 0){
				if($element["#required"]){
					$value = check_plain($element['#value'] . ' *');
				}
				else{
					$value = check_plain($element['#value']);
				}				
			}
		}
		else{
			$value = check_plain($element['#value']);
		}
		
		$output .= '<input type="text"'. $maxlength .' name="'. $element['#name'] .'" id="'. $element['#id'] .'"'. $size .' value="'. $value .'"'. drupal_attributes($element['#attributes']) .' />';

		if (isset($element['#field_suffix'])) {
			$output .= ' <span class="field-suffix">'. $element['#field_suffix'] .'</span>';
		}

		return theme('form_element', $element, $output) . $extra;
	}

	function achatpublic_form_element($element, $value) {
		$required_class = '';
		
		$t = get_t();
		if($element["#name"] != 'civilite' && $element["#name"] != 'secteur'){
			if($element['#required']){
				$required_class = ' div_obligatoire';
			}
			$output = '<div class="block' . $required_class . '"';
			if (!empty($element['#id'])) {
				$output .= ' id="'. $element['#id'] .'-wrapper"';
			}
			$output .= ">\n";
		}
		$required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';
		
		if (!empty($element['#title'])) {
			$title = $element['#title'];
			if (!empty($element['#id'])) {
				$output .= ' <label for="'. $element['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title),
						'!required' => $required)) ."</label>\n";
			}
			else {
				$output .= ' <label>'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
			}
		}

		$output .= " $value\n";
		if($element['#required']){
			$output .= "<span class=\"erreur\"></span>";
		}

		if (!empty($element['#description'])) {
			$output .= ' <div class="description">'. $element['#description'] ."</div>\n";
		}

		if($element["#name"] != 'civilite' && $element["#name"] != 'secteur'){
			$output .= "</div>\n";
		}
		
		
		
		return $output;
	}

	function achatpublic_checkboxes($element) {
		$class = 'form-checkboxes';
		if (isset($element['#attributes']['class'])) {
			$class .= ' '. $element['#attributes']['class'];
		}
		$element['#children'] = '<div class="'. $class .'">'. (!empty($element['#children']) ? $element['#children'] : '') .'</div>';
		if ($element['#title'] || $element['#description']) {
			unset($element['#id']);
			return theme('form_element', $element, $element['#children']);
		}
		else {
			return $element['#children'];
		}
	}
	function achatpublic_button($element) {
		// following lines are copied directly from form.inc core file:

		//Make sure not to overwrite classes
		if (isset($element['#attributes']['class'])) {
			$element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class'];
		}
		else {
			$element['#attributes']['class'] = 'form-'. $element['#button_type'];
		}

		// here the novelty begins: check if #button_type is normal submit button or image button
		$return_string = '<input ';
		if ($element['#button_type'] == 'image') {
			$return_string .= 'type="image" ';
		}
		else {
			$return_string .= 'type="submit" ';
		}
		$return_string .= (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ') .'value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." />\n";;
		return $return_string; 
	}

	function meta_form_contact($form_state) {
	  $form['civilite'] = array(
		'#type' => 'radios',
		'#options' => array('Mme' => t('Mme'), 'M' => t('M')),
		'#required' => FALSE
	  );
	  
	  $form['nom'] = array(
		'#type' => 'textfield',
		'#value' => t('Nom'),
		'#required' => TRUE
	  );
	  
	  $form['prenom'] = array(
		'#type' => 'textfield',
		'#value' => t('Prénom'),
		'#required' => FALSE
	  );
	  
	  $form['secteur'] = array(
	  		'#type' => 'radios',
	  		'#options' => array('public' => t('Secteur public'), 'prive' => t('Secteur privé')),
			'#default_value' => 'public',
	  		'#required' => TRUE
	  );
	  
	  $form['organisme'] = array(
		'#type' => 'textfield',
		'#value' => t('Organisme'),
		'#required' => TRUE
	  );
	  
	  /*$form['fonction'] = array(
		'#type' => 'textfield',
		'#value' => t('Fonction'),
		'#required' => FALSE
	  );*/
	  
	  $form['email'] = array(
		'#type' => 'textfield',
		'#value' => 'E-mail',
		'#required' => TRUE
	  );
	  
	  $form['telephone'] = array(
		'#type' => 'textfield',
		'#value' => t('Téléphone'),
		'#required' => TRUE
	  );
	  
	 /* $form['adresse_1'] = array(
		'#type' => 'textfield',
		'#value' => t('Adresse'),
		'#required' => FALSE
	  );*/
	  
	  $form['cp'] = array(
		'#type' => 'textfield',
		'#value' => t('CP'),
		'#required' => TRUE
	  );
	  
	  /*
	  $form['ville'] = array(
		'#type' => 'textfield',
		'#value' => t('Ville'),
		'#required' => FALSE
	  );*/
	  
	  $form['fieldset_acheteurs_publics'] = array(
		'#type' => 'fieldset',
		'#title' => '<span class="fieldset_texte">Notre offre pour le secteur public</span>',
		'#required' => FALSE
	  );
	  
	  $form['fieldset_acheteurs_publics']['fieldset_solutions'] = array(
		'#type' => '',
		'#title' => '',
		'#required' => FALSE,
		'#attributes' => array("id" => "fieldset_solution")
	  );
	  
	  $form['fieldset_acheteurs_publics']['fieldset_solutions']['checkboxes_solutions'] = array(
		'#type' => 'checkboxes',
		'#options' => array(
			'solutions' => '<span class="display_block">Le portail de l’achat public : Sourcing - Rédaction - Profil acheteur - Procédure - Suivi des actes - Archivage</span>',
			'journal' => '<span class="display_block">Le journal achatpublic.info : l’actualité de la commande publique</span>',
			'formation' => '<span class="display_block">Formations marchés publics</span>'
		  ),
		'#required' => FALSE
	  );
	  
	  $form['fieldset_acheteurs_publics']['fieldset_solutions']['checkbox_newsletter_acheteurs_publics'] = array(
		'#type' => 'checkbox',
		'#title' => '<span class="display_block">Recevoir la Newsletter Secteur Public - RDV Démat\'</span>',
		'#required' => FALSE,
		'#attributes' => array("id" => "checkbox_newsletter_acheteurs_publics")
	  );
	  
	  $form['fieldset_entreprise'] = array(
		'#type' => 'fieldset',
		'#title' => '<span class="fieldset_texte">Notre offre pour le secteur privé</span>',
		'#required' => FALSE,
		'#attributes' => array("id" => "fieldset_entreprise")
	  );
	  
	  $form['fieldset_entreprise']['fieldset_solutions']['checkboxes_entreprise'] = array(
		'#type' => 'checkboxes',
		'#options' => array(
			'formations_cycles_experts' => '<span class="display_block">Formations pour les entreprises souhaitant remporter des appels d’offres</span>',
			'sourcing' =>'<span class="display_block">Solution de sourcing pour être visible auprès des acheteurs publics </span>',
			'dematfacile' => '<span class="display_block">Recevoir la Newsletter La dématérialisation facile</span>'
		  ),
		'#required' => FALSE
	  );
	  
	  $form['message'] = array(
		'#type' => 'textarea',
		'#title' => 'Message',
		'#required' => FALSE
	  );
	  
	  $form['loi_informatiques'] = array(
		'#type' => 'fieldset',
		'#title' => '<p>Conformément à la loi Informatique et Libertés du 6 janvier 1978, vous disposez d’un droit d’accès, de rectification et de retrait des informations vous concernant. Pour ce faire, écrivez à <a href="mailto:contact@achatpublic.com?subject=Site Corporate ">contact@achatpublic.com</a></p>',
		'#required' => FALSE,
		'#attributes' => array("id" => "loi_informatiques")
	  );
	  
	  $form['hidden_type_form'] = array('#type' => 'hidden', '#value' => 'contact');
	  $form['submit'] = array('#type' => 'submit', '#value' => '', '#attributes' => array("class" => "bouton_envoyer"));
	  $form['#action'] = '/node/71';
	  $form['#id'] = 'form_contact';
	  $form['#attributes'] = array('class' => 'contenu_formulaire');
	  return $form;
	}

	
	function achatpublic_form_alter( &$form, &$form_state, $form_id ){
	if (strstr($form_id, 'meta_form_contact')) {
			$form['my_captcha_element'] = array(
				'#type' => 'captcha',
				'#captcha_type' => 'image_captcha/Image',
			);
		}
	}
	
	function show_form_contact() {
	  return drupal_get_form('meta_form_contact');
	}

	function meta_form_actualite($form_state) {
	  $form['civilite'] = array(
		'#type' => 'radios',
		'#options' => array('Mme' => t('Mme'), 'M' => t('M')),
		'#required' => FALSE
	  );
	  
	  $form['nom'] = array(
		'#type' => 'textfield',
		'#value' => t('Nom'),
		'#required' => TRUE
	  );
	  
	  $form['prenom'] = array(
		'#type' => 'textfield',
		'#value' => t('Prénom'),
		'#required' => FALSE
	  );
	  
	  $form['organisme'] = array(
		'#type' => 'textfield',
		'#value' => t('Organisme'),
		'#required' => TRUE
	  );
	  
	  $form['fonction'] = array(
		'#type' => 'textfield',
		'#value' => t('Fonction'),
		'#required' => FALSE
	  );
	  
	  $form['email'] = array(
		'#type' => 'textfield',
		'#value' => 'E-mail',
		'#required' => TRUE,
		'#attributes' => array('class' => 'email_actualite')
	  );
	  
	  $form['telephone'] = array(
		'#type' => 'textfield',
		'#value' => t('Téléphone'),
		'#required' => TRUE
	  );
	  
	  $form['adresse_1'] = array(
		'#type' => 'textfield',
		'#value' => t('Adresse 1'),
		'#required' => FALSE
	  );
	  
	  $form['cp'] = array(
		'#type' => 'textfield',
		'#value' => t('CP'),
		'#required' => TRUE
	  );
	  
	  $form['ville'] = array(
		'#type' => 'textfield',
		'#value' => t('Ville'),
		'#required' => FALSE
	  );
	  
	  $form['pays'] = array(
		'#type' => 'textfield',
		'#value' => t('Pays'),
		'#required' => FALSE
	  );
	  
	  $form['dematerialisation_facile'] = array(
		'#type' => 'checkbox',
		'#title' => '<span class="display_block">Je souhaite recevoir la newsletter <strong>La dématérialisation facile</strong></span>',
		'#required' => FALSE,
		'#attributes' => array("id" => "dematerialisation_facile")
	  );
	  
	  $form['hidden_url_called'] = array('#type' => 'hidden', '#value' => '', '#id' => "hidden_url_called");
	  $form['hidden_type_form'] = array('#type' => 'hidden', '#value' => 'actualite');
	  $form['submit']['#theme'] = 'button';
	  $form['submit']['#button_type'] = 'image';
      $form['submit']['#attributes'] = array(
		'src' => '/sites/all/themes/achatpublic/images/bouton_valider.png',
		'class' => 'bouton_envoyer_image'
	  );
	  $form['#action'] = '/node/71';
	  $form['#attributes'] = array("class" => "form_actualite");

	  return $form;
	}

	function show_form_actualite() {
	  return drupal_get_form('meta_form_actualite');
	}
	
	function meta_form_documentation($form_state) {
	  $form['civilite'] = array(
		'#type' => 'radios',
		'#options' => array('Mme' => t('Mme'), 'M' => t('M')),
		'#required' => FALSE
	  );
	  
	  $form['nom'] = array(
		'#type' => 'textfield',
		'#value' => t('Nom'),
		'#required' => TRUE
	  );
	  
	  $form['prenom'] = array(
		'#type' => 'textfield',
		'#value' => t('Prénom'),
		'#required' => FALSE
	  );
	  
	  $form['organisme'] = array(
		'#type' => 'textfield',
		'#value' => t('Organisme'),
		'#required' => TRUE
	  );
	  
	  $form['fonction'] = array(
		'#type' => 'textfield',
		'#value' => t('Fonction'),
		'#required' => FALSE
	  );
	  
	  $form['email'] = array(
		'#type' => 'textfield',
		'#value' => 'E-mail',
		'#required' => TRUE,
		'#attributes' => array('class' => 'email_documentation')
	  );
	  
	  $form['telephone'] = array(
		'#type' => 'textfield',
		'#value' => t('Téléphone'),
		'#required' => TRUE
	  );
	  
	  $form['adresse_1'] = array(
		'#type' => 'textfield',
		'#value' => t('Adresse 1'),
		'#required' => FALSE
	  );
	  
	  $form['cp'] = array(
		'#type' => 'textfield',
		'#value' => t('CP'),
		'#required' => TRUE
	  );
	  
	  $form['ville'] = array(
		'#type' => 'textfield',
		'#value' => t('Ville'),
		'#required' => FALSE
	  );
	  
	  $form['pays'] = array(
		'#type' => 'textfield',
		'#value' => t('Pays'),
		'#required' => FALSE
	  );
	  
	  $form['dematerialisation_facile'] = array(
		'#type' => 'checkbox',
		'#title' => '<span class="display_block">Je souhaite recevoir la newsletter <strong>La dématérialisation facile</strong></span>',
		'#required' => FALSE,
		'#attributes' => array("id" => "dematerialisation_facile")
	  );
	  
	  $form['hidden_url_called_documentation'] = array('#type' => 'hidden', '#value' => '', '#id' => "hidden_url_called_documentation");
	  $form['hidden_type_form'] = array('#type' => 'hidden', '#value' => 'documentation');
	  $form['submit']['#theme'] = 'button';
	  $form['submit']['#button_type'] = 'image';
      $form['submit']['#attributes'] = array(
		'src' => '/sites/all/themes/achatpublic/images/bouton_valider.png',
		'class' => 'bouton_envoyer_image'
	  );
	  $form['#action'] = '/node/71';
	  $form['#attributes'] = array("class" => "form_documentation");

	  return $form;
	}

	function show_form_documentation() {
	  return drupal_get_form('meta_form_documentation');
	}
	
	function meta_form_newsletter($form_state) {
	  $form['civilite'] = array(
		'#type' => 'radios',
		'#options' => array('Mme' => t('Mme'), 'M' => t('M')),
		'#required' => FALSE
	  );
	  
	  $form['nom'] = array(
		'#type' => 'textfield',
		'#value' => t('Nom'),
		'#required' => TRUE
	  );
	  
	  $form['prenom'] = array(
		'#type' => 'textfield',
		'#value' => t('Prénom'),
		'#required' => FALSE
	  );
	  
	  $form['organisme'] = array(
		'#type' => 'textfield',
		'#value' => t('Organisme'),
		'#required' => TRUE
	  );
	  
	  $form['fonction'] = array(
		'#type' => 'textfield',
		'#value' => t('Fonction'),
		'#required' => FALSE
	  );
	  
	  $form['email'] = array(
		'#type' => 'textfield',
		'#value' => 'E-mail',
		'#required' => TRUE,
		'#attributes' => array('class' => 'email_newsletter')
	  );
	  
	  $form['telephone'] = array(
		'#type' => 'textfield',
		'#value' => t('Téléphone'),
		'#required' => TRUE
	  );
	  
	  $form['adresse_1'] = array(
		'#type' => 'textfield',
		'#value' => t('Adresse 1'),
		'#required' => FALSE
	  );
	  
	  $form['cp'] = array(
		'#type' => 'textfield',
		'#value' => t('CP'),
		'#required' => TRUE
	  );
	  
	  $form['ville'] = array(
		'#type' => 'textfield',
		'#value' => t('Ville'),
		'#required' => FALSE
	  );
	  
	  $form['pays'] = array(
		'#type' => 'textfield',
		'#value' => t('Pays'),
		'#required' => FALSE
	  );
	  
	  $form['fax'] = array(
		'#type' => 'textfield',
		'#value' => t('Fax'),
		'#required' => FALSE
	  );
	  
	  $form['loi_informatiques'] = array(
		'#type' => 'fieldset',
		'#title' => '<p>Conformément à la loi Informatique et Libertés du 6 janvier 1978, vous disposez d’un droit d’accès, de rectification et de retrait des informations vous concernant. Pour ce faire, écrivez à <a href="mailto:contact@achatpublic.com">contact@achatpublic.com</a></p>',
		'#required' => FALSE,
		'#attributes' => array("id" => "loi_informatiques")
	  );
	  
	  $form['hidden_type_form'] = array('#type' => 'hidden', '#value' => 'newsletter');
	  $form['submit']['#theme'] = 'button';
	  $form['submit']['#button_type'] = 'image';
      $form['submit']['#attributes'] = array(
		'src' => '/sites/all/themes/achatpublic/images/bouton_valider.png',
		'class' => 'bouton_envoyer_image'
	  );
	  
	  $form['#action'] = '/node/71';
	  $form['#attributes'] = array("class" => "form_newsletter");

	  return $form;
	}

	function show_form_newsletter() {
	  return drupal_get_form('meta_form_newsletter');
	}
	

?>
