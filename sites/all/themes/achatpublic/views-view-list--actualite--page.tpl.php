<?php
// $Id: views-view-list.tpl.php,v 1.3 2008/09/30 19:47:11 merlinofchaos Exp $
/**
 * @file views-view-list.tpl.php
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<div class="item-list">
<ul>
	<?php foreach ($rows as $num => $row): ?>
		<?php if ($num!=0): ?>
		<li><div class="pointilles"></div></li>
		<?php endif; ?>
		<li><?php print $row;?></li>
	<?php endforeach; ?>
	</ul>
</div>