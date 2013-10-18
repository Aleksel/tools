<?php
/**
 * Виджет названия
 *
 * Class LabelWidget
 */
class LabelWidget extends CWidget
{
	/** @var null|CActiveRecord Модель */
	public $model = null;
	/** @var null|string Название поля у модели */
	public $attribute = null;

	/** @var string Название поля (атрибут name у инпута) */
	public $name = '';
	/** @var null|string Текст у лейбла */
	public $title = null;
	/** @var bool Обязательное поле */
	public $required = null;

	/** @var array Массив опций тега label */
	public $htmlOptions = array();

	/**
	 * Подготавливает виджет.
	 * Если переданы model и attribute - установить что можно из модели
	 * @throws InvalidArgumentException
	 */
	public function init()
	{
		if ($this->model && $this->attribute) {
			if (!$this->name) $this->name = get_class($this->model).'['.$this->attribute.']';
			if ($this->required === null) $this->required = $this->model->isAttributeRequired($this->attribute);
			if (!$this->title) $this->title = $this->model->getAttributeLabel($this->attribute);
		} elseif (!$this->name || !$this->title) {
			throw new InvalidArgumentException('Укажите или $model с $attribute или $name с $title');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		echo CHtml::tag('label',
			CMap::mergeArray(
				array(
				     'for'   => CHtml::getIdByName($this->name),
				     'class' => 'control-label'.($this->required ? ' required' : '')
				),
				$this->htmlOptions
			),
			$this->title.($this->required ? (' '.CHtml::tag('span', array('class' => 'required'), '*')) : '')
		);
	}
}