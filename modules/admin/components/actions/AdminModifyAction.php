<?php
class AdminModifyAction extends CAction {
	public function run($model, $id)
	{
		if (!class_exists($model)) throw new CHttpException(404);
		/** @var $model CmsModel */
		$model = $model::model();
		if (!is_subclass_of($model, 'CmsModel')) throw new CHttpException(404);

		$model = $model->findByPk($id);
		if (!$model) throw new CHttpException(404);

		$model->setScenario('adm_modify');
		if ($_POST && isset($_POST[get_class($model)])) {
			$model->attributes = $_POST[get_class($model)];
			if ($model->save()) {
				$this->controller->redirect($this->controller->createUrl('default/list', array('model' => get_class($model))));
			} else {

			}
		}

		$this->controller->render('/actions/update', array('model' => $model));
	}
}