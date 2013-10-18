<?php
/**
 * Контролер адсинки
 * Class AdminController
 *
 * @property AdminModule $module
 * @property string $static
 */
class AdminController extends Controller {
	public $layout = '/layouts/default';
	public $vars;
	protected $_static_assets = null;

	public function getStatic() {
		if ($this->_static_assets === null) {
			$this->_static_assets = Yii::app()->assetManager->publish(
				Yii::app()->modulePath.'/admin/static',
				false,
				-1,
				YII_DEBUG
			);
		}
		return $this->_static_assets;
	}

	public function getViewPath()
	{
		if ($this->module->site_views_path === null)
			return parent::getViewPath();
		else {
			return Yii::app()->getViewPath().DIRECTORY_SEPARATOR.$this->module->site_views_path.DIRECTORY_SEPARATOR.$this->id;
		}
	}
}