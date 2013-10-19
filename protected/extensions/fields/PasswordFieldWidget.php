<?php
class PasswordFieldWidget extends FieldWidget {
	/**
	 * Вывести инпут для формы
	 *
	 * @return mixed
	 */
	public function input()
	{
		$data = array(
			'divOptions' => array('class' => 'controls'),
			'htmlOptions' => array()
		);
		if ($this->placeholder) $data['htmlOptions']['placeholder'] = $this->placeholder;
		$data = CMap::mergeArray($data, $this->data);
		echo CHtml::tag('div', $data['divOptions'],
			CHtml::passwordField($this->name, '', $data['htmlOptions'])
		);
	}

	/**
	 * Вывести представление значения
	 *
	 * @return mixed
	 */
	public function display()
	{
		// TODO: Implement display() method.
	}
}