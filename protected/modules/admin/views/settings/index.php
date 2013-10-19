<?php
/**
 * Настройки сайта
 * @var $fields array Настройки полей
 * @var $settings - Настройки
 * @var $this AdminController
 */
?>
<h2>Настройки</h2>
<?php
/** @var $form TbActiveForm */
$form     = $this->beginWidget('bootstrap.widgets.TbActiveForm',
	array(
	     'htmlOptions' => array('class' => 'form-horizontal'),
	));
$save_btn = $this->widget('bootstrap.widgets.TbButton',
	array(
	     'buttonType'  => 'submit',
	     'label'       => Yii::t('app', 'Сохранить'),
	     'type'        => 'success',
	     'htmlOptions' => array('class' => 'btn')
	), 1);
?>
	<fieldset>
		<?php
		if (Yii::app()->user->getFlash('adm_settings_saved', false)) { ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Настройки сохранены
			</div>
		<?php }
		/*if ($model->errors) { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php foreach($model->errors as $error) {
					echo CHtml::encode(current($error)).'<br/>';
				} ?>
			</div>
		<?php } */

		foreach ($fields as $fname => $field) { ?>
			<div class="control-group">
				<?php
				$type = ucfirst($field['field']['type']);
				unset($field['field']['type']);
				$this->widget('LabelWidget', $field['label']);
				$this->widget(
					$type.'FieldWidget',
					array('name' => 'Settings['.$fname.']', 'value' => $settings[$fname])+$field['field']);
				// Здесь обработка поля и вызов виджетов, field пойдет в поле, label пойдет в лейбл
				//$field['model'] = $model;
				/*$label = array(
					'model' => $model,
					'attribute' => $field['attribute'],
				);
				if (isset($field['required'])) {
					$label['required'] = $field['required'];
					unset($field['required']);
				}


				$this->widget(
					'AdmWidgets.AdminField.AdminFieldWidget',
					$field
				);*/
				?>


			</div>
		<?php } ?>

	</fieldset>
	<div class="form-actions"><?=$save_btn?></div>
<?php
$this->endWidget();
?>