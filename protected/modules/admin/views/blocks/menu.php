<?php
/**
 * Меню админки
 *
 * @var $this AdminController
 */
?>
<ul class="nav">
	<?php
	$menu = $this->module->menu;
	$is_guest = $this->module->adminUser->isGuest;
	if ($menu) foreach($menu as $menuitem) {
		if (!$is_guest || $menuitem['allow_guest']) {
			$params = $this->getActionParams();
			$options = array();
			if (isset($params['model']) && $params['model'] == $menuitem['model']) $options['class'] = 'active';
			echo CHtml::tag(
				'li', $options,
				CHtml::link($menuitem['title'], $this->createUrl('default/list', array('model' => $menuitem['model'])))
			);
		}
	}
	?>
</ul>