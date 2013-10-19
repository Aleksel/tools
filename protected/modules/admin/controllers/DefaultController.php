<?php
class DefaultController extends AdminController
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return array(
			'list' => 'actions.AdminListAction',
			'create' => 'actions.AdminCreateAction',
			'modify' => 'actions.AdminModifyAction'
		);
	}

	/**
	 * Авторизация администратора
	 */
	public function actionIndex()
	{
		if ($this->module->adminUser->isGuest) {
			$model = new AdmUsers('login');
			if (isset($_POST['AdmUsers'])) {
				$model->attributes = $_POST['AdmUsers'];
				$identity = new AdminIdentity($model->login, $model->password);
				if ($identity->authenticate()) {
					$this->module->adminUser->login($identity);
					$route = $this->module->default_route;
					$this->redirect($this->createUrl($route['url'], $route['params']));
				} else {
					switch ($identity->errorCode) {
						case AdminIdentity::ERROR_USERNAME_INVALID:
						case AdminIdentity::ERROR_PASSWORD_INVALID:
							$model->addError('login', 'Проверьте введённые логин и пароль.');
							break;
					}
				}
			}
			$this->render('login', array('model' => $model));
		} else {
			$route = $this->module->default_route;
			$this->redirect($this->createUrl($route['url'], $route['params']));
		}
	}
	public function actionLogout() {
		$this->module->adminUser->logout();
		Yii::app()->session->close();
		$this->redirect($this->createUrl('index'));
	}

	protected function beforeAction($action)
	{
		if ($action->id != 'index') {
			if ($this->module->adminUser->isGuest) {
				$this->redirect($this->createUrl('index'));
			}
			return true;
		}
		return parent::beforeAction($action);
	}


	/**
	 * Переопределенный метод, вызывается при попытке найти действия - классы.
	 * Проверяет настройки роутинга модуля для использования действий приложения
	 *
	 * @param array  $actionMap
	 * @param string $actionID
	 * @param string $requestActionID
	 * @param array  $config
	 *
	 * @return CAction
	 */
	protected function createActionFromMap($actionMap, $actionID, $requestActionID, $config = array())
	{
		if ($map = $this->module->actions_map) {
			$a_params = $this->getActionParams();
			foreach ($map as $data) {
				$redirect = true;
				if (isset($data['condition']) && $cond = $data['condition']) {
					if (isset($cond['params'])) {
						foreach ($cond['params'] as $param => $value) {
							$redirect = $redirect && (isset($a_params[$param]) && $a_params[$param] == $value);
						}
					}
					if (isset($cond['action'])) {
						$redirect = $redirect && $actionID == $cond['action'];
					}
				}
				if ($redirect) {
					return parent::createActionFromMap(
						array($actionID => $data['action']),
						$actionID, $requestActionID, $config
					);
				}
			}
		}
		return parent::createActionFromMap($actionMap, $actionID, $requestActionID, $config);
	}


}