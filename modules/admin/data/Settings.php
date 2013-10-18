<?php

/**
 * Модель настроек
 *
 * Поля
 * @property integer $id    Идентификатор
 * @property string  $fkey   Ключ
 * @property string  $value Значение
 */
class Settings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @param string $className active record class name.
	 *
	 * @return Settings the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('fkey, value', 'required'),
			array('fkey', 'length', 'max' => 255),
			array('value', 'safe'),
			// Поиск
			array('id, fkey, value', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'    => 'ID',
			'fkey'   => 'Настройка',
			'value' => 'Значение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('fkey', $this->fkey, true);
		$criteria->compare('value', $this->value, true);

		return new CActiveDataProvider($this,
			array(
			     'criteria' => $criteria,
			));
	}

	/**
	 * Получить настройки типов полей для аминки
	 */
	public static function getFields()
	{
		return array(
			'form_version' => array(
				'field' => array('type' => 'text', 'placeholder' => 'Версия опроса'),
				'label' => array('name' => 'Settings[form_version]', 'title' => 'Версия опроса'),
				'default' => ''
			)
		);
	}

	/**
	 * Список настроек в виде (key => value) массива
	 *
	 * @return array
	 */
	public static function getSettings()
	{
		$ret    = array();
		$fields = self::getFields();

		// Значения по умолчанию
		foreach ($fields as $fname => $fsetings) {
			$ret[$fname] = isset($fsetings['default']) ? $fsetings['default'] : '';
		}

		// Значения из БД
		$cond   = new CDbCriteria();
		$cond->addInCondition('fkey', array_keys($fields));
		/** @var $tmp Settings[] */
		$tmp = self::model()->findAll($cond);
		if ($tmp) foreach($tmp as $sett) {
			$ret[$sett->fkey] = $sett->value;
		}
		return $ret;
	}
}