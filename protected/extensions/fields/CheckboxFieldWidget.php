<?php
class CheckboxFieldWidget extends FieldWidget {
	/**
	 * Вывести представление значения
	 *
	 * @return mixed
	 */
	public function display()
	{
		// TODO: Implement display() method.
	}

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
		$data = CMap::mergeArray($data, $this->data);
		echo CHtml::tag('div', $data['divOptions'],
			CHtml::checkBox($this->name, $this->value, $data['htmlOptions'])
		);
	}
}