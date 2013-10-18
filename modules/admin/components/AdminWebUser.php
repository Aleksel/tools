<?php
/**
 * User: Forgon
 * Date: 10.07.2013 от Рождества Христова
 *
 * @property AdmUsers $data
 */
class AdminWebUser extends CWebUser{
	public $allowAutoLogin = true;
	public $loginUrl = 'admin';
	public $autoRenewCookie = true;

	protected $_data = null;

	public function getData() {
		if (!$this->_data && $this->id) {
			$this->_data = AdmUsers::model()->with()->findByPk($this->id);
			if (!$this->_data) $this->logout();
		}
		return $this->_data;
	}
}