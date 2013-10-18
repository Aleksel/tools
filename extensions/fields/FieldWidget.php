<?php
/**
 * База для виджетов полей
 */
abstract class FieldWidget extends CWidget {
	/** @var null|CActiveRecord Модель */
	public $model = null;
	/** @var null|string Атрибут */
	public $attribute = null;

	/** @var string Имя поля */
	public $name = '';
	/** @var mixed Значение */
	public $value = null;
	/** @var string Placeholder */
	public $placeholder = '';

	/** @var bool Представление или поле для ввода */
	public $display = false;

	/** @var array Разная вспомогательная информация, отличается от поля к полю */
	public $data = array();

	/**
	 * @inheritdoc
	 */
	public function init() {
		if ($this->model && $this->attribute) {
			if (!$this->name) $this->name = get_class($this->model).'['.$this->attribute.']';
			if ($this->value === null) $this->value = $this->model[$this->attribute];
		}
	}

	public function run() {
		if ($this->display) $this->display();
		else $this->input();
	}

	/**
	 * Вывести инпут для формы
	 *
	 * @return mixed
	 */
	public abstract function input();

	/**
	 * Вывести представление значения
	 *
	 * @return mixed
	 */
	public abstract function display();
}