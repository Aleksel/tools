<?php
/**
 * Действие добавления сущности через админку
 * Class AdminListAction
 */
class AdminCreateAction extends CAction {
	public function run($model, $pid = '', $parent = '')
	{
		if (!class_exists($model)) throw new CHttpException(404);
		$model = new $model('adm_create');
		if (!is_subclass_of($model, 'CmsModel')) throw new CHttpException(404);

		if ($_GET && isset($_GET['data'])) {
			$model->attributes = $_GET['data'];
		}

		if ($pid && $parent) {
			if (!$relation = $model->getActiveRelation($parent)) {
				throw new CHttpException(404, 'Указанный родительский элемент неверен.');
			}
			$relation->foreignKey;
			$model[$relation->foreignKey] = $pid;
		}

		if ($_POST && isset($_POST[get_class($model)])) {
			$model->attributes = $_POST[get_class($model)];
			if ($model->save()) {
				if ($pid && $parent) {
					$this->controller->redirect($this->controller->createUrl('default/list',
						array(
						     'model' => get_class($model),
						     'pid' => $pid,
						     'parent' => $parent
						)));
				} else {
					$this->controller->redirect($this->controller->createUrl('default/list', array('model' => get_class($model))));
				}
			} else {

			}
		}

		$this->controller->render('/actions/update', array('model' => $model));
	}
}