<?php
class DropdownFieldWidget extends FieldWidget {
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
			CHtml::dropDownList($this->name, $this->value, $data['values'],$data['htmlOptions'])
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