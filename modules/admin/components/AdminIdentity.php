<?php
/**
 * User: Forgon
 * Date: 10.07.2013 от Рождества Христова
 */

class AdminIdentity extends CUserIdentity {

	protected $_id;

	/**
	 * @inheritdoc
	 */
	public function authenticate()
	{
		/** @var $model AdmUsers */
		$model = AdmUsers::model()->findByAttributes(array('login' => $this->username));
		if (!$model) {
			$this->errorCode    = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = Yii::t('app', 'Не получается авторизоваться. Проверьте правильность ввода логина и пароля.');
		} elseif ($model->password !== $model->createHash($this->password, $model->salt)) {
			$this->errorCode    = self::ERROR_PASSWORD_INVALID;
			$this->errorMessage = Yii::t('app', 'Не получается авторизоваться. Проверьте правильность ввода логина и пароля.');
		} else {
			$this->_id = $model->primaryKey;
			$this->errorCode    = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	/**
	 * Возвращает идентификатор пользователя
	 */
	public function getId()
	{
		return $this->_id;
	}

	public function setId($value) {
		$this->_id = $value;
	}
}