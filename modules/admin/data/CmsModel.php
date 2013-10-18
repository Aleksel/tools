<?php
/**
 * Class CmsModel - Модель, подготовленная для административной панели
 *
 * @property $adm_actions                 Список действий
 * @property $adm_listButtons             Разрешить вывод действий в списке
 * @property $adm_default_list_attributes Значения для поиска в админке по умолчанию
 */
abstract class CmsModel extends CActiveRecord
{
	/**
	 * Настройки действий в админке
	 * @return mixed
	 */
	public abstract function getAdm_actions();

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->scenario == 'adm_list') {
			$this->setAttributes($this->adm_default_list_attributes, false);
		}
		parent::init();
	}

	/**
	 * Возвращает список атрибутов по умолчанию для поиска
	 * @return array
	 */
	public function getAdm_default_list_attributes() {
		return array();
	}
}