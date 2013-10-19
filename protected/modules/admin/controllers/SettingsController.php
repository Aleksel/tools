<?php
/**
 * Контролер настроек
 */
class SettingsController extends AdminController
{
	public function actionIndex() {
		$this->vars['fields'] = Settings::getFields();

		if ($_POST && isset($_POST['Settings'])) {
			foreach ($_POST['Settings'] as $fname => $fval) {
				$saved = true;
				if (isset($this->vars['fields'][$fname])) {
					/** @var $field Settings */
					$field = Settings::model()->findByAttributes(array('fkey' => $fname));
					if (!$field) {
						$field = new Settings();
						$field->fkey = $fname;
					}
					$field->value = $fval;
					$saved = $saved && $field->save(false);
				}
			}
			if ($saved) Yii::app()->user->setFlash('adm_settings_saved', true);
		}

		$cond = new CDbCriteria();
		$cond->addInCondition('key', array_keys($this->vars['fields']));

		$this->vars['settings'] = Settings::getSettings();
		$this->render('index', $this->vars);
	}
}