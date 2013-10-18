<?php
/**
 * Шапка Админки
 *
 * @var $this AdminController
 */

?>
<!-- header -->
<div class="page-header">
	<div class="navbar">
		<div class="navbar-inner">
			<a href="<?=Yii::app()->homeUrl ?>"
			   class="brand"><?=CHtml::encode(Yii::app()->name)?></a>

			<?php /* Навигация */ ?>
			<?php $this->renderPartial('/blocks/menu'); ?>

			<?php if ($this->module->adminUser->isGuest) { ?>
				<p class="navbar-text pull-right">
					<a href="<?= $this->createUrl('default/index') ?>"><?=Yii::t('app', 'Войти');?></a>
				</p>
			<?php } else { ?>
				<?php if ($this->module->has_settings) {?>
				<p class="navbar-text pull-right">
					<a href="<?=$this->createUrl('settings/index')?>" class="icon-wrench" title="Настройки"></a>
				</p>
				<?php } ?>
				<p class="navbar-text pull-right">
					<a href="<?=$this->createUrl('default/logout')?>"><?=Yii::t('app', 'Выйти (__name__)', array('__name__' => $this->module->adminUser->data->name));?></a>
				</p>
			<?php } ?>
		</div>
	</div>
</div>
<!-- header -->