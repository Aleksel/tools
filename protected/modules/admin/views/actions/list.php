<?php
/**
 * Шаблон списка в админке.
 * @var $this  AdminController
 * @var $model CmsModel
 */
if (!empty($model->adm_actions['list'])) {
	$action  = $model->adm_actions['list'];
	$columns = $action['columns'];
	if (!empty($columns)) {
		foreach ($columns as &$column) {
			if (is_array($column)) {
				if (!empty($column['type'])) {
					switch ($column['type']) {
						case 'boolean';
							$column['filter'] = CHtml::dropDownList(
								get_class($model)."[{$column['name']}]",
								(isset($_GET[get_class($model)][$column['name']]))
									? $_GET[get_class($model)][$column['name']]
									: null,
								array('' => '-', 0 => 'No', 1 => 'Yes'),
								array("class" => "sort_field")
							);
							unset($column['values']);
							break;
					}
				}
			}
		}
		unset($column);
	}
	if (isset($action['row_actions'])) {
		$tmp = array(
			'header'      => Yii::t('app', 'Действие'),
			'class'       => 'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('style' => 'width: 50px'),
		);
		$tmp = CMap::mergeArray($tmp, $action['row_actions']);
		$columns[] = $tmp;
	}
	?>
	<h2><?=$action['title']?></h2>
	<br/>
	<?php
	if ($action['top_actions']) foreach ($action['top_actions'] as $act) {
		$this->widget('bootstrap.widgets.TbButton',
			array(
			     'label' => $act['title'],
			     'type'  => $act['btn_type'],
			     'url'   => $this->createUrl($act['url'], $act['url_data']),
			     'size'  => 'small',
			)
		);
	}

	$this->widget('bootstrap.widgets.TbGridView',
		array(
		     'type'         => 'striped bordered condensed',
		     'dataProvider' => $model->search(),
		     'filter'       => $model,
		     'columns'      => $columns,
		     'pager'        => array('class' => 'bootstrap.widgets.TbPager'),
		));

	if ($action['top_actions']) foreach ($action['top_actions'] as $act) {
		$this->widget('bootstrap.widgets.TbButton',
			array(
			     'label' => $act['title'],
			     'type'  => $act['btn_type'],
			     'url'   => $this->createUrl($act['url'], $act['url_data']),
			     'size'  => 'small',
			)
		);
	}
}?>