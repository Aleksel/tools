<?php
/**
 * Шаблон создания/обновление сущности
 *
 * @var $this  AdminController
 * @var $model CmsModel
 */
$action = $model->isNewRecord ? 'create' : 'modify';
$action = $model->adm_actions[$action];
?>

<h2><?=$action['title']?></h2>
<?php if (isset($action['form_view'])) {
	$this->renderPartial($action['form_view'], array('model' => $model));
} elseif (!empty($action['fields'])) {
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
		<legend><?=$action['form_title']?></legend>

	<?php
		if ($model->errors) { ?>
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php foreach($model->errors as $error) {
					echo CHtml::encode(current($error)).'<br/>';
				} ?>
			</div>
		<?php }

		foreach ($action['fields'] as $field) {
		$attrs = array('class' => 'span6');
		if (array_key_exists($field['attribute'], $model->attributes)) { ?>
			<div class="control-group">
				<?php
				// Здесь обработка поля и вызов виджетов, field пойдет в поле, label пойдет в лейбл
				$field['model'] = $model;
				$type = $field['type'];
				unset($field['type']);

				$label = array(
					'model' => $model,
					'attribute' => $field['attribute'],
				);
				if (isset($field['required'])) {
					$label['required'] = $field['required'];
					unset($field['required']);
				}
				$this->widget('LabelWidget',$label);

				$this->widget(ucfirst($type).'FieldWidget', $field);
				?>


			</div>
		<?php }
		}
		?>

		</fieldset>
		<div class="form-actions"><?=$save_btn?></div>
	<?php
	$this->endWidget();
} ?>