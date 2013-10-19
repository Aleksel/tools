<?php
/**
 * Действие вывода списка сущностей из админки
 *
 * Class AdminListAction
 */
class AdminListAction extends CAction {
	public function run($model, $pid='', $parent='')
    {
	    if (!class_exists($model)) throw new CHttpException(404, 'Класс модели не найден.');
	    /** @var $model CmsModel */
	    $model = new $model('adm_list');
	    if (!is_subclass_of($model, 'CmsModel')) throw new CHttpException(404, 'Модель не является наследником от CmsModel.');
	    if ($pid && $parent) {
		    if (!$relation = $model->getActiveRelation($parent)) {
			    throw new CHttpException(404, 'Указанный родительский элемент неверен.');
		    }
		    $relation->foreignKey;
		    $model[$relation->foreignKey] = $pid;
	    }

	    if (!empty($_GET[get_class($model)])) $model->attributes = $_GET[get_class($model)];

	    $this->controller->render('/actions/list', array('model' => $model));
	}
}