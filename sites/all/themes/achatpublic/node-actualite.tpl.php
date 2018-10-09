<div class="sous_titre_actu actualite"></div>

<?php if($node->field_date_publication[0]['value']){ print '<div class="date_actu">' . substr($node->field_date_publication[0]['view'],38) . '</div>';} ?>

<?php if($node->field_intro_actu[0]['value']){ print '<div class="introduction">' . $node->field_intro_actu[0]['value'] . '</div>';} ?>

<?php if($node->content['body']['#value']){print '<div class="contenu_actu">' . $node->content['body']['#value'] . '</div>';} ?>
