<?php
/**
 * Форма логина
 * @var $this AdminController
 * @var $model AdmUsers
 */
$this->pageTitle = 'Вход в систему управления сайтом';
?>
<div class="container-fluid">
	<?php
	/**
	 * @var CActiveForm $form
	 */
	$form = $this->beginWidget('CActiveForm',
		array(
		     'htmlOptions' => array(
			     'class' => 'form-horizontal login well'
		     )
		));
	?>
	<fieldset>
		<legend>Введите регистрационные данные</legend>
		<div
			class="control-group<?php if ($model->hasErrors('login')) echo ' error' ?>">
			<?=$form->label($model, 'login', array('class' => 'control-label'))?>
			<div class="controls">
				<?=$form->textField($model, 'login', array('class' => 'input-medium')); ?>
			</div>
		</div>

		<div
			class="control-group<?php if ($model->hasErrors('password')) echo ' error' ?>">
			<?=$form->label($model, 'password', array('class' => 'control-label'))?>
			<div class="controls">
				<?=$form->passwordField($model, 'password', array('class' => 'input-medium'))?>
			</div>
		</div>
		<!--<div class="control-group">

			<?php /*echo $form->label($model, 'rememberMe', array('class' => 'control-label')); */?>

			<div class="controls">
				<?php /*echo $form->checkBox($model, 'rememberMe'); */?>
			</div>
		</div>-->

		<div class="form-actions" style="margin-bottom: 0; padding-bottom: 0">
			<button type="submit" class="btn btn-large btn-primary">Вход
			</button>
		</div>
	</fieldset>
	<?php
	$this->endWidget();
	?>
</div>