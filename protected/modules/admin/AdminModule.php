<?php
/**
 * Модуль админки
 *
 * Class AdminModule
 */
class AdminModule extends CWebModule
{
	/** @var null Объект пользователя админки */
	protected $adminUser = null;

	/** @var string Соль паролей пользователей админки */
	public $globalsalt = 'Default admin module salt';
	/** @var null Переопределенный путь до шаблонов админки */
	public $site_views_path = null;
	/** @var array дефолтный УРЛ для авторизованного пользователя админки */
	public $default_route = array();
	/** @var array Список переопределенных действий */
	public $actions_map = array();
	/** @var array Меню */
	public $menu = array();
	/** @var bool Глобально - настройки включены */
	public $has_settings = false;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setAliases(array('actions' => 'application.modules.admin.components.actions'));
		$this->setAliases(array('AdmWidgets' => 'admin.extensions.widgets'));
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		    'admin.extensions.*',
		));
	}

	/**
	 * @inheritdoc
	 */
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	/**
	 * @inheritdoc
	 */
	public function getViewPath() {
		if ($this->site_views_path === null)
			return parent::getViewPath();
		else {
			return Yii::app()->getViewPath().DIRECTORY_SEPARATOR.$this->site_views_path;
		}
	}
}
